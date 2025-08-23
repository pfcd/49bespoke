<?php
/**
 * Importer Class
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Brands\Classes
 */

if ( ! defined( 'YITH_WCBR' ) ) {
	exit;
} // Exit if accessed directly.

if ( ! class_exists( 'YITH_WCBR_CSV_Importer' ) ) {
	/**
	 * YITH_WCBR_CSV_Importer class
	 *
	 * @since 2.0.0
	 */
	class YITH_WCBR_CSV_Importer {
		/**
		 * Single instance of the class
		 *
		 * @var \YITH_WCBR_CSV_Importer
		 * @since 2.0.0
		 */
		protected static $instance;

		/**
		 * Admin notices
		 *
		 * @var array
		 */
		public $admin_notices = array();

		/**
		 * Constructor method
		 *
		 * @since 2.0.0
		 */
		public function __construct() {
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'admin_init', array( $this, 'import_brands' ) );
			add_action( 'admin_notices', array( $this, 'show_import_errors' ) );
		}

		/** Enqueue importer scripts */
		public function enqueue_scripts() {
			$path   = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? 'unminified/' : '';
			$suffix = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? '' : '.min';

			wp_register_script( 'yith-wcbr-importer', YITH_WCBR_URL . 'assets/js/admin/' . $path . 'importer' . $suffix . '.js', array( 'jquery' ), YITH_WCBR_VERSION, true );

			if ( isset( $_GET['page'] ) && 'yith_wcbr_panel' === $_GET['page'] && isset( $_GET['tab'] ) && 'import' === $_GET['tab'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				wp_enqueue_script( 'yith-wcbr-importer' );
			}
		}

		/**
		 * Start import
		 *
		 * @return void
		 * @since 2.0.0
		 */
		private function import_start() {
			if ( function_exists( 'gc_enable' ) ) {
				gc_enable();
			}

			// phpcs:disable WordPress.PHP.NoSilencedErrors.Discouraged
			@set_time_limit( 0 );
			@ob_flush();
			@flush();
			@ini_set( 'auto_detect_line_endings', '1' );
			// phpcs:enable WordPress.PHP.NoSilencedErrors.Discouraged
		}

		/**
		 * Import terms from CSV
		 *
		 * @param mixed  $file      File.
		 * @param string $delimiter Delimiter.
		 *
		 * @return void
		 * @since 2.0.0
		 */
		public function import_from_csv( $file, $delimiter ) {
			if ( ! is_file( $file ) ) {
				$this->admin_notices[] = array(
					'class'   => 'yith_wcbr_import_result error notice-error',
					/* translators: %s: term */
					'message' => esc_html__( 'The file does not exist, please try again.', 'yith-woocommerce-brands-add-on' ),
				);
			}

			$this->import_start();

			$loop = 0;

			if ( ( $handle = fopen( $file, 'r' ) ) !== false ) { //phpcs:ignore WordPress.CodeAnalysis.AssignmentInCondition,Squiz.PHP.DisallowMultipleAssignments.FoundInControlStructure,WordPress.WP.AlternativeFunctions.file_system_read_fopen
				$header = fgetcsv( $handle, 0, $delimiter );

				if ( 9 <= count( $header ) ) {
					while ( ( $row = fgetcsv( $handle, 0, $delimiter ) ) !== false ) { //phpcs:ignore WordPress.CodeAnalysis.AssignmentInCondition
						list( $term_id, $term_name, $term_slug, $term_description, $term_parent, $base_url, $term_thumbnail, $term_banner, $term_custom_url ) = $row;

						// if the term already exists in the correct taxonomy leave it alone.
						$id = term_exists( $term_slug, YITH_WCBR::$brands_taxonomy );

						if ( $id ) {
							$loop ++;
							continue;
						}

						if ( empty( $term_parent ) ) {
							$parent = 0;
						} else {
							$parent = term_exists( $term_parent, YITH_WCBR::$brands_taxonomy );

							if ( is_array( $parent ) ) {
								$parent = $parent['term_id'];
							}
						}

						$description = isset( $term_description ) ? $term_description : '';
						$termarr     = array(
							'slug'        => $term_slug,
							'description' => $description,
							'parent'      => intval( $parent ),
						);

						$id = wp_insert_term( $term_name, YITH_WCBR::$brands_taxonomy, $termarr );

						if ( ! is_wp_error( $id ) ) {
							$loop ++;

							if ( ! empty( $term_thumbnail ) ) {
								$attachment_id = $this->process_attachment( $term_thumbnail, $base_url );

								if ( ! is_wp_error( $attachment_id ) ) {
									yith_wcbr_update_term_meta( $id['term_id'], 'thumbnail_id', absint( $attachment_id ) );
								} else {
									$this->admin_notices[] = array(
										'class'   => 'yith_wcbr_import_result error notice-error',
										/* translators: %s: term */
										'message' => sprintf( esc_html__( 'Failed to import attachment %s.', 'yith-woocommerce-brands-add-on' ), esc_html( $term_thumbnail ) ),
									);
								}
							}

							if ( ! empty( $term_banner ) ) {
								$attachment_id = $this->process_attachment( $term_banner, $base_url );

								if ( ! is_wp_error( $attachment_id ) ) {
									yith_wcbr_update_term_meta( $id['term_id'], 'banner_id', absint( $attachment_id ) );
								} else {
									$this->admin_notices[] = array(
										'class'   => 'yith_wcbr_import_result error notice-error',
										/* translators: %s: term */
										'message' => sprintf( esc_html__( 'Failed to import attachment %s.', 'yith-woocommerce-brands-add-on' ), esc_html( $term_thumbnail ) ),
									);
								}
							}

							if ( ! empty( $term_custom_url ) ) {
								yith_wcbr_update_term_meta( $id['term_id'], 'custom_url', $term_custom_url );
							}

							if ( 9 < count( $header ) ) {
								for ( $i = 9; $i < count( $header ); $i ++ ) { // phpcs:ignore Generic.CodeAnalysis.ForLoopWithTestFunctionCall.NotAllowed,Squiz.PHP.DisallowSizeFunctionsInLoops.Found
									/**
									 * DO_ACTION: yith_wcbr_csv_importer_extra_field
									 *
									 * Allows to manage some extra fields in the CSV import.
									 *
									 * @param string $row    Import row
									 * @param string $header Import header
									 * @param array  $id     Term data
									 */
									do_action( 'yith_wcbr_csv_importer_extra_field', $row[ $i ], $header[ $i ], $id );
								}
							}
						} else {
							$this->admin_notices[] = array(
								'class'   => 'yith_wcbr_import_result error notice-error',
								/* translators: %1$s: Brand taxonomy %2s: Term */
								'message' => sprintf( esc_html__( 'Failed to import %1$s %2$s.', 'yith-woocommerce-brands-add-on' ), esc_html( YITH_WCBR::$brands_taxonomy ), esc_html( $term_name ) ),
							);
						}
					}
				} else {
					$this->admin_notices[] = array(
						'class'   => 'yith_wcbr_import_result error notice-error',
						'message' => __( 'The CSV is invalid.', 'yith-woocommerce-brands-add-on' ),
					);
				}

				fclose( $handle ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_fclose
			}

			// Show Result.
			$this->admin_notices[] = array(
				'class'   => 'yith_wcbr_import_result sucess notice-sucess',
				/* translators: %s: loop counter */
				'message' => sprintf( esc_html__( 'Import complete - Imported %s new brand(s).', 'yith-woocommerce-brands-add-on' ), esc_html( $loop ) ),
			);
		}

		/**
		 * Import brands from csv file
		 *
		 * @since 2.0.0
		 */
		public function import_brands() {
			if ( ! isset( $_REQUEST['page'] ) || 'yith_wcbr_panel' !== $_REQUEST['page'] || ! isset( $_REQUEST['ywcbr_safe_submit_field'] ) || ! isset( $_REQUEST['delimiter'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				return;
			}

			if ( 'importing_brands' === $_REQUEST['ywcbr_safe_submit_field'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				$file_type = isset( $_FILES['file_import_csv'], $_FILES['file_import_csv']['type'] ) ? sanitize_text_field( wp_unslash( $_FILES['file_import_csv']['type'] ) ) : '';

				if ( 'text/csv' !== $file_type ) {
					$this->admin_notices[] = array(
						'class'   => 'yith_wcbr_import_result error notice-error',
						'message' => esc_html__( 'The uploaded file is not a valid CSV file.', 'yith-woocommerce-brands-add-on' ),
					);
					return;
				}

				if ( ! isset( $_FILES['file_import_csv'] ) || ! is_uploaded_file( $_FILES['file_import_csv']['tmp_name'] ) ) { // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
					$this->admin_notices[] = array(
						'class'   => 'yith_wcbr_import_result error notice-error',
						'message' => esc_html__( 'The CSV cannot be imported.', 'yith-woocommerce-brands-add-on' ),
					);

					return;
				}

				$uploaddir = wp_upload_dir();

				$temp_name = $_FILES['file_import_csv']['tmp_name']; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
				$file_name = 'brands-import-' . uniqid() . '.csv';

				if ( ! move_uploaded_file( $temp_name, $uploaddir['basedir'] . '/' . $file_name ) ) {
					$this->admin_notices[] = array(
						'class'   => 'yith_wcbr_import_result error notice-error',
						'message' => esc_html__( 'The CSV cannot be imported.', 'yith-woocommerce-brands-add-on' ),
					);

					return;
				}

				$this->import_from_csv( $uploaddir['basedir'] . '/' . $file_name, $_REQUEST['delimiter'] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput, WordPress.Security.NonceVerification.Recommended
			}
		}

		/**
		 * Shows messages if there are update errors
		 *
		 * @since 2.0.0
		 */
		public function show_import_errors() {
			if ( ! $this->admin_notices ) {
				return;
			}

			foreach ( $this->admin_notices as $admin_notice ) {
				?>
				<div id="message" class="yith_wcbr_notices updated notice notice-success is-dismissible yith-plugin-fw-animate__appear-from-top inline <?php echo esc_attr( $admin_notice['class'] ); ?>" style="display: block;">
					<p><?php echo wp_kses_post( $admin_notice['message'] ); ?></p>
					<button type="button" class="notice-dismiss">
						<span class="screen-reader-text">Dismiss this notice.</span>
					</button>
				</div>
				<?php
			}
		}

		/**
		 * Attempt to create a new attachment from csv url
		 *
		 * @param string $url      URL to fetch attachment from.
		 * @param string $base_url External site base url.
		 *
		 * @return int|WP_Error Post ID on success, WP_Error otherwise
		 * @since 2.0.0
		 */
		public function process_attachment( $url, $base_url ) {
			$post = array();

			// if the URL is absolute, but does not contain address, then upload it assuming base_site_url.
			if ( preg_match( '|^/[\w\W]+$|', $url ) ) {
				$url = rtrim( $base_url, '/' ) . $url;
			}

			$upload = $this->fetch_remote_file( $url );
			if ( is_wp_error( $upload ) ) {
				return $upload;
			}

			if ( $info = wp_check_filetype( $upload['file'] ) ) { //phpcs:ignore WordPress.CodeAnalysis.AssignmentInCondition,Squiz.PHP.DisallowMultipleAssignments.FoundInControlStructure
				$post['post_mime_type'] = $info['type'];
			} else {
				return new WP_Error( 'attachment_processing_error', __( 'Invalid file type.', 'wordpress-importer' ) );
			}

			$post['guid'] = $upload['url'];

			// as per wp-admin/includes/upload.php .
			$post_id = wp_insert_attachment( $post, $upload['file'] );
			wp_update_attachment_metadata( $post_id, wp_generate_attachment_metadata( $post_id, $upload['file'] ) );

			// remap resized image URLs, works by stripping the extension and remapping the URL stub.
			if ( preg_match( '!^image/!', $info['type'] ) ) {
				$parts = pathinfo( $url );
				$name  = basename( $parts['basename'], ".{$parts['extension']}" ); // PATHINFO_FILENAME in PHP 5.2.

				$parts_new = pathinfo( $upload['url'] );
				$name_new  = basename( $parts_new['basename'], ".{$parts_new['extension']}" );

				$this->url_remap[ $parts['dirname'] . '/' . $name ] = $parts_new['dirname'] . '/' . $name_new;
			}

			return $post_id;
		}

		/**
		 * Attempt to download a remote file attachment
		 *
		 * @param string $url URL of item to fetch.
		 *
		 * @return array|WP_Error Local file location details on success, WP_Error otherwise
		 * @since 2.0.0
		 */
		public function fetch_remote_file( $url ) {
			// extract the file name and extension from the url.
			$file_name = basename( $url );

			// get placeholder file in the upload dir with a unique, sanitized filename.
			$upload = wp_upload_bits( $file_name, null, '' );

			if ( $upload['error'] ) {
				return new WP_Error( 'upload_dir_error', $upload['error'] );
			}

			// fetch the remote url and write it to the placeholder file.
			$wp_http = new WP_Http();
			$result  = $wp_http->get( $url );

			// request failed.
			if ( is_wp_error( $result ) ) {
				@unlink( $upload['file'] ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged

				return new WP_Error( 'import_file_error', __( 'Remote server did not respond.', 'wordpress-importer' ) );
			}

			// make sure the fetch was successful.
			if ( 200 !== $result['response']['code'] ) {
				@unlink( $upload['file'] ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged

				/* translators: %1$s: Response code %2s: Response message */
				return new WP_Error( 'import_file_error', sprintf( esc_html__( 'Remote server returned error response %1$d %2$s.', 'wordpress-importer' ), esc_html( $result['response']['code'] ), $result['response']['message'] ) );
			}

			$out_fp = fopen( $upload['file'], 'w' ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_fopen
			if ( $out_fp ) {
				fwrite( $out_fp, $result['body'] ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_fwrite
				fclose( $out_fp ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_fclose
				clearstatcache();
			}

			$filesize = filesize( $upload['file'] );

			if ( isset( $headers['content-length'] ) && $filesize !== $headers['content-length'] ) {
				@unlink( $upload['file'] );// phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged

				return new WP_Error( 'import_file_error', __( 'Remote file is incorrect size.', 'wordpress-importer' ) );
			}

			if ( 0 === $filesize ) {
				@unlink( $upload['file'] );// phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged

				return new WP_Error( 'import_file_error', __( 'Zero size file downloaded.', 'wordpress-importer' ) );
			}

			/**
			 * APPLY_FILTERS: yith_wcbr_import_attachment_size_limit
			 *
			 * Filter the attachment size limit for the CSV file to be importe.
			 *
			 * @param int $size Size limit
			 *
			 * @return int
			 */
			$max_size = apply_filters( 'yith_wcbr_import_attachment_size_limit', 0 );
			if ( ! empty( $max_size ) && $filesize > $max_size ) {
				@unlink( $upload['file'] );// phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged

				/* translators: %s: Maximum file size */
				return new WP_Error( 'import_file_error', sprintf( __( 'Remote file is too large, limit is %s.', 'wordpress-importer' ), size_format( $max_size ) ) );
			}

			// keep track of the old and new urls so we can substitute them later.
			$this->url_remap[ $url ] = $upload['url'];
			// keep track of the destination if the remote url is redirected somewhere else.
			if ( isset( $headers['x-final-location'] ) && $headers['x-final-location'] !== $url ) {
				$this->url_remap[ $headers['x-final-location'] ] = $upload['url'];
			}

			return $upload;
		}

		/**
		 * Returns single instance of the class
		 *
		 * @return \YITH_WCBR_CSV_Importer
		 * @since 2.0.0
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}
}

/**
 * Unique access to instance of YITH_WCBR_CSV_Importer class
 *
 * @return \YITH_WCBR_CSV_Importer
 * @since 2.0.0
 */
function YITH_WCBR_CSV_Importer() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
	return YITH_WCBR_CSV_Importer::get_instance();
}
