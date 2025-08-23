<?php

namespace Barn2\Plugin\WC_Product_Table\Util;

/**
 * Utility functions for the product table columns.
 *
 * @package   Barn2\woocommerce-product-table
 * @author    Barn2 Plugins <support@barn2.com>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 */
class Columns {


	/**
	 * Some column replacements used for correcting misspelled columns.
	 *
	 * @var array $column_replacements
	 */
	public static $column_replacements = [
		'ID'                => 'id',
		'SKU'               => 'sku',
		'title'             => 'name',
		'content'           => 'description',
		'excerpt'           => 'summary',
		'short-description' => 'summary', // back compat: old column name
		'category'          => 'categories',
		'rating'            => 'reviews',
		'add-to-cart'       => 'buy', // back compat: old column name
		'modified'          => 'date_modified',
	];

	/**
	 * Global column defaults.
	 *
	 * @var array
	 */
	private static $column_defaults = false;

	/**
	 * Get the default column headings and responsive priorities.
	 *
	 * @return array The column defaults
	 */
	public static function column_defaults() {

		if ( empty( self::$column_defaults ) ) {
			// Priority values are used to determine visiblity at small screen sizes (1 = highest priority).
			self::$column_defaults = apply_filters(
				'wc_product_table_column_defaults',
				[
					'id'            => [
						'heading'  => __( 'ID', 'woocommerce-product-table' ),
						'priority' => 8,
					],
					'sku'           => [
						'heading'  => __( 'SKU', 'woocommerce-product-table' ),
						'priority' => 6,
					],
					'name'          => [
						'heading'  => __( 'Name', 'woocommerce-product-table' ),
						'priority' => 1,
					],
					'description'   => [
						'heading'  => __( 'Description', 'woocommerce-product-table' ),
						'priority' => 12,
					],
					'summary'       => [
						'heading'  => __( 'Summary', 'woocommerce-product-table' ),
						'priority' => 11,
					],
					'date'          => [
						'heading'  => __( 'Date', 'woocommerce-product-table' ),
						'priority' => 14,
					],
					'date_modified' => [
						'heading'  => __( 'Updated', 'woocommerce-product-table' ),
						'priority' => 15,
					],
					'categories'    => [
						'heading'  => __( 'Categories', 'woocommerce-product-table' ),
						'priority' => 9,
					],
					'tags'          => [
						'heading'  => __( 'Tags', 'woocommerce-product-table' ),
						'priority' => 10,
					],
					'image'         => [
						'heading'  => __( 'Image', 'woocommerce-product-table' ),
						'priority' => 4,
					],
					'stock'         => [
						'heading'  => __( 'Stock', 'woocommerce-product-table' ),
						'priority' => 7,
					],
					'reviews'       => [
						'heading'  => __( 'Reviews', 'woocommerce-product-table' ),
						'priority' => 13,
					],
					'weight'        => [
						'heading'  => __( 'Weight', 'woocommerce-product-table' ),
						'priority' => 16,
					],
					'dimensions'    => [
						'heading'  => __( 'Dimensions', 'woocommerce-product-table' ),
						'priority' => 17,
					],
					'price'         => [
						'heading'  => __( 'Price', 'woocommerce-product-table' ),
						'priority' => 3,
					],
					'buy'           => [
						'heading'  => __( 'Buy', 'woocommerce-product-table' ),
						'priority' => 2,
					],
					'button'        => [
						'heading'  => __( 'Details', 'woocommerce-product-table' ),
						'priority' => 5,
					],
					'total'         => [
						'heading'  => __( 'Total', 'woocommerce-product-table' ),
						'priority' => 16,
					],
					'author'        => [
						'heading'  => __( 'Author', 'woocommerce-product-table' ),
						'priority' => 17,
					],
				]
			);
		}

		return self::$column_defaults;
	}

	/**
	 * Get the column heading given a column slug.
	 *
	 * @param  mixed $column
	 * @return string
	 */
	public static function get_column_heading( $column ) {
		$heading       = '';
		$standard_cols = self::column_defaults();
		$column_arr    = explode( ':', $column );

		if ( in_array( $column_arr[0], [ 'cf', 'att', 'tax' ], true ) ) {
			if ( isset( $column_arr[2] ) && trim( $column_arr[2] ) !== '' ) {
				if ( trim( $column_arr[2] ) !== 'blank' ) {
					$heading = trim( $column_arr[2] );
				}
			} elseif ( $column_arr[0] === 'tax' && $tax_obj = get_taxonomy( $column_arr[1] ) ) {
					$heading = $tax_obj->label;
			} elseif ( $column_arr[0] === 'att' && $att = self::get_product_attribute( $column_arr[0] . ':' . $column_arr[1] ) ) {
				$heading = ucfirst( Util::get_attribute_label( $att ) );
			} elseif ( $column_arr[0] === 'cf' && $cf = self::get_custom_field( $column_arr[0] . ':' . $column_arr[1] ) ) {
				$heading = ucfirst( $cf );
			}
		} elseif ( isset( $column_arr[1] ) && trim( $column_arr[1] ) !== '' ) {
			if ( trim( $column_arr[1] ) !== 'blank' ) {
				$heading = trim( $column_arr[1] );
			}
		} elseif ( isset( $standard_cols[ $column_arr[0] ]['heading'] ) ) {
			$heading = $standard_cols[ $column_arr[0] ]['heading'];
		} else {
			$heading = trim( ucwords( str_replace( [ '_', '-' ], ' ', $column_arr[0] ) ) );
		}
		return $heading;
	}

	/**
	 * Get the column slug given a column slug.
	 *
	 * @param  mixed $column
	 * @return string
	 */
	public static function get_column_slug( $column ) {
		$column_arr = explode( ':', $column );
		if ( in_array( $column_arr[0], [ 'cf', 'tax' ], true ) ) {
			$slug = ! empty( $column_arr[1] ) ? $column_arr[0] . ':' . trim( $column_arr[1] ) : '';
		} elseif ( in_array( $column_arr[0], [ 'att' ], true ) ) {
			$slug = 'tax:pa_' . str_replace( 'pa_', '', trim( $column_arr[1] ) );
		} elseif ( $column_arr[0] === 'categories' ) {
			$slug = 'tax:product_cat';
		} elseif ( $column_arr[0] === 'tags' ) {
			$slug = 'tax:product_tag';
		} else {
			$slug = trim( $column_arr[0] );
		}
		return $slug;
	}

	/**
	 * If the heading equals the keyword 'blank', returns an empty string.
	 *
	 * @param  string $heading
	 * @return string
	 */
	public static function check_blank_heading( $heading ) {
		return 'blank' === $heading ? '' : $heading;
	}

	/**
	 * Get the taxonomy for the specified column name.
	 *
	 * @param  string $column
	 * @return false|string
	 */
	public static function get_column_taxonomy( $column ) {
		if ( 'categories' === $column ) {
			return 'product_cat';
		} elseif ( 'tags' === $column ) {
			return 'product_tag';
		} elseif ( $att = self::get_product_attribute( $column ) ) {
			if ( taxonomy_is_product_attribute( $att ) ) {
				return $att;
			}
		} elseif ( $tax = self::get_custom_taxonomy( $column ) ) {
			return $tax;
		}
		return false;
	}

	/**
	 * Is the column a custom field?
	 *
	 * @param  string $column
	 * @return bool
	 */
	public static function is_custom_field( $column ) {
		return $column && 'cf:' === substr( $column, 0, 3 ) && strlen( $column ) > 3;
	}

	/**
	 * Get the custom field from the column name - so 'cf:thing' becomes 'thing'. Returns false if not a custom field column.
	 *
	 * @param  string $column
	 * @return false|string
	 */
	public static function get_custom_field( $column ) {
		if ( self::is_custom_field( $column ) ) {
			return substr( $column, 3 );
		}
		return false;
	}

	/**
	 * Is the column a custom taxonomy?
	 *
	 * @param  string $column
	 * @return bool
	 */
	public static function is_custom_taxonomy( $column ) {
		$is_tax = $column && 'tax:' === substr( $column, 0, 4 ) && strlen( $column ) > 4;
		return $is_tax && taxonomy_exists( substr( $column, 4 ) );
	}

	/**
	 * Get the product attribute from the column name - so 'att:colour' becomes 'colour'. Returns false if not an attribute column.
	 *
	 * @param  string $column
	 * @return false|string
	 */
	public static function get_custom_taxonomy( $column ) {
		if ( self::is_custom_taxonomy( $column ) ) {
			return substr( $column, 4 );
		}
		return false;
	}

	/**
	 * Is the column a hidden filter column?
	 *
	 * @param  string $column
	 * @return bool
	 */
	public static function is_hidden_filter_column( $column ) {
		return $column && 'hf:' === substr( $column, 0, 3 ) && strlen( $column ) > 3;
	}

	/**
	 * Get the hidden filter from the column name - so 'hf:colour' becomes 'colour'. Returns false if not a hidden filter column.
	 *
	 * @param  string $column
	 * @return false|string
	 */
	public static function get_hidden_filter_column( $column ) {
		if ( self::is_hidden_filter_column( $column ) ) {
			return substr( $column, 3 );
		}
		return false;
	}

	/**
	 * Is the column a product attribute?
	 * Checks for both 'att:' prefix and 'tax:pa_' prefix.
	 *
	 * @param  string $column
	 * @return bool
	 */
	public static function is_product_attribute( $column ) {
		return $column && ( 'att:' === substr( $column, 0, 4 ) || 'tax:pa_' === substr( $column, 0, 7 ) );
	}

	/**
	 * Get the product attribute from the column name.
	 * Handles both 'att:' prefix and 'tax:pa_' prefix formats.
	 * Returns false if not an attribute column.
	 *
	 * @param  string $column
	 * @return false|string
	 */
	public static function get_product_attribute( $column ) {
		if ( self::is_product_attribute( $column ) ) {
			return substr( $column, 4 );
		} elseif ( strpos( $column, 'tax:pa_' ) === 0 ) {
			return substr( $column, 7 );
		}
		return false;
	}

	/**
	 * Parse the supplied columns into an array, whose keys are the column names, and values are the column headings (if specified).
	 *
	 * Invalid taxonomies are removed, but non-standard columns are kept as they could be custom columns. Custom field keys are not validated.
	 *
	 * E.g. parse_columns( 'name,summary,price:Cost,tax:product_region:Region,cf:my_field,buy:Order' );
	 *
	 * Returns:
	 *
	 * [ 'name' => '', 'summary' => '', 'price' => 'Cost', 'tax:product_region' => 'Region', 'cf:my_field' => '', 'buy' => 'Order' ];
	 *
	 * @param  string|string[] $columns The columns to parse as a string or array of strings.
	 * @return array The parsed columns.
	 */
	public static function parse_columns( $columns ) {
		if ( ! is_array( $columns ) ) {
			$columns = str_replace( '\,', '{comma}', str_replace( '\;', '{semicolon}', $columns ) );
			$columns = Util::string_list_to_array( $columns );
		}

		$combined    = '';
		$is_combined = false;

		$parsed = [];

		foreach ( $columns as $column ) {
			$prefix = sanitize_key( strtok( $column, ':' ) );
			$col    = false;
			$label  = null;

			if ( $column[0] === '(' && strpos( $column, ')' ) !== false ) {
				$col_label = explode( ')', $column );
				$col       = substr( $col_label[0], 1 );
				if ( ! empty( $col_label[1][0] ) ) {
					$label = $col_label[1][0] === ':' ? substr( $col_label[1], 1 ) : '';
				} else {
					$label = '';
				}
			} elseif ( $column[0] === '(' ) {
				$combined   .= substr( $column, 1 );
				$is_combined = true;
			} elseif ( $is_combined ) {
				$combined .= ',' . $column;
				if ( strpos( $column, ')' ) !== false && $is_combined ) {
					$col_label   = explode( ')', $combined );
					$col         = $col_label[0];
					$label       = isset( $col_label[1][0] ) && $col_label[1][0] === ':' ? substr( $col_label[1], 1 ) : '';
					$is_combined = false;
					$combined    = '';
				}
			} elseif ( in_array( $prefix, [ 'cf', 'att', 'tax' ], true ) ) {
				// Custom field, product attribute or taxonomy.
				$suffix = trim( strtok( ':' ) );

				if ( ! $suffix ) {
					continue; // no custom field, attribute, or taxonomy specified
				} elseif ( 'att' === $prefix ) {
					$suffix = Util::get_attribute_name( $suffix );
				} elseif ( 'tax' === $prefix && ! taxonomy_exists( $suffix ) ) {
					continue; // invalid taxonomy
				}

				$col = $prefix . ':' . $suffix;
			} else {
				// Standard or custom column.
				$col = $prefix;

				// Check for common typos in column names.
				if ( array_key_exists( $col, self::$column_replacements ) ) {
					$col = self::$column_replacements[ $col ];
				}
			}

			// Only add column if valid and not added already.
			if ( $col && ! array_key_exists( $col, $parsed ) && ! $is_combined ) {
				// $parsed[ $col ] = self::sanitize_heading( strtok( '' ) );
				$parsed[ $col ] = self::sanitize_heading( $label ?? strtok( '' ) );
			}
		}

		return $parsed;
	}

	/**
	 * Parse the supplied filters into an array, whose keys are the filter names, and values are the filter headings (if specified).
	 *
	 * Invalid filter columns and taxonomies are removed. When $filters = true, the filters are based on the table contents and this
	 * is specified by passing the columns in the $table_columns arg.
	 *
	 * $filters supports the keyword 'attributes' on its own, or alongside other standard filter columns. When present 'attributes' will be
	 * replaced by all global attributes and is there a shorthand way to specify all store attributes without listing them individually.
	 *
	 * E.g. parse_filters( 'categories:Category,invalid,tags,tax:product_region:Region' );
	 *
	 * Returns:
	 *
	 * [ 'categories' => 'Category', 'tags' => '', 'tax:product_region' => 'Region' ];
	 *
	 * @param  bool|string|string[] $filters       The filters to parse as a bool, string or array of strings.
	 * @param  string[]             $table_columns The columns to base the filters on when $filters = true.
	 * @return array The parsed filters, or an empty array if the filters are invalid.
	 */
	public static function parse_filters( $filters, array $table_columns = [] ) {
		$parsed         = [];
		$filter_columns = Util::maybe_parse_bool( $filters );

		if ( true === $filter_columns ) {
			// If filters is true, set filters based on table columns.
			$filter_columns = $table_columns;
		} elseif ( empty( $filter_columns ) ) {
			$filter_columns = [];
		}

		if ( ! is_array( $filter_columns ) ) {
			$filter_columns = Util::string_list_to_array( $filter_columns );
		}

		// If the 'attributes' keyword is specified, replace it with all attribute taxonomies.
		if ( false !== ( $attributes_index = array_search( 'attributes', $filter_columns, true ) ) ) {
			// 'attributes' keyword found - replace with all global product attributes.
			$attribute_filters = preg_replace( '/^/', 'att:', wc_get_attribute_taxonomy_names() );
			$before            = array_slice( $filter_columns, 0, $attributes_index );
			$after             = array_slice( $filter_columns, $attributes_index + 1 );
			$filter_columns    = array_merge( $before, $attribute_filters, $after );
		}

		foreach ( $filter_columns as $filter ) {
			$f                  = false;
			$prefix             = strtok( $filter, ':' );
			$filterable_columns = apply_filters( 'wc_product_table_standard_filterable_columns', [ 'categories', 'tags' ] );

			if ( in_array( $prefix, $filterable_columns, true ) ) {
				// Categories or tags filter.
				$f = $prefix;
			} elseif ( 'tax' === $prefix ) {
				// Custom taxonomy filter.
				$taxonomy = trim( strtok( ':' ) );

				if ( taxonomy_exists( $taxonomy ) ) {
					$f = 'tax:' . $taxonomy;
				}
			} elseif ( 'att' === $prefix ) {
				// Attribute filter.
				$attribute = Util::get_attribute_name( trim( strtok( ':' ) ) );

				// Only global attributes (i.e. taxonomies) are allowed as a filter
				if ( taxonomy_is_product_attribute( $attribute ) ) {
					$f = 'att:' . $attribute;
				}
			}

			if ( $f && ! array_key_exists( $f, $parsed ) ) {
				$parsed[ $f ] = self::sanitize_heading( strtok( '' ) );
			}
		}

		return $parsed;
	}

	/**
	 * Converts an array of columns in the form [ column => heading ] to a comma-separated string.
	 *
	 * E.g.
	 * parsed_columns_to_string( [ 'name' => 'Title', 'price' => 'Cost per unit', 'stock' => '', 'buy' => '' );
	 * Returns: 'name:Title,price:Cost per unit,stock,buy'
	 *
	 * @param  array $columns The columns and headings array.
	 * @return string The columns combined to a string.
	 */
	public static function parsed_columns_to_string( array $columns ) {
		if ( empty( $columns ) ) {
			return '';
		}

		$columns_combined = [];

		foreach ( $columns as $column => $heading ) {
			$columns_combined[] = $heading ? $column . ':' . $heading : $column;
		}

		return implode( ',', $columns_combined );
	}

	/**
	 * Sanitizes a column heading.
	 *
	 * @param  string $heading
	 * @return string
	 */
	public static function sanitize_heading( $heading ) {
		return esc_html( $heading );
	}

	/**
	 * Unprefix a column, removing the 'cf:', 'att:', or 'tax:' prefix from the column name.
	 *
	 * @param  string $column
	 * @return string
	 */
	public static function unprefix_column( $column ) {
		if ( false !== ( $str = strstr( $column, ':' ) ) ) {
			$column = str_replace( 'pa_', '', substr( $str, 1 ) );
		}
		return $column;
	}

	/**
	 * Get column type for a specific provided column
	 *
	 * @param array $columnns
	 * @param string $type
	 * @return string|void
	 */
	public static function get_column_type( $columnns, $type ) {
		foreach ( $columnns as $column ) {
			$column = explode( '::', $column );
			if ( $column[0] === $type ) {
				return $column[1];
			}
		}

		return;
	}

	/**
	 * Get the CSS class for a column - will return 'col-<column>' where <column> is the unprefixed column name.
	 *
	 * @param  string $column
	 * @return string
	 */
	public static function get_column_class( $column ) {
		$column_class_suffix = self::unprefix_column( $column );

		// Certain classes are reserved for use by DataTables Responsive, so we need to strip these to prevent conflicts.
		$column_class_suffix = trim( str_replace( [ 'mobile', 'tablet', 'desktop' ], '', $column_class_suffix ), '_- ' );

		return $column_class_suffix ? sanitize_html_class( 'col-' . $column_class_suffix ) : '';
	}

	/**
	 * Get the data source value to use in the internal DataTables data.
	 *
	 * @param  string $column
	 * @return string
	 */
	public static function get_column_data_source( $column ) {
		// '.' not allowed in data source
		return str_replace( '.', '', $column );
	}

	/**
	 * Get the column name to use in the 'data-name' value used by DataTables.
	 *
	 * @param  string $column
	 * @return string
	 */
	public static function get_column_name( $column ) {
		// ':' not allowed in column name as not compatible with DataTables API.
		return str_replace( ':', '_', $column );
	}


	/**
	 * Retrieves the combined column name if it is a combined column.
	 *
	 * A combined column is identified by the presence of either a comma (',')
	 * or a semicolon (';') in the column name.
	 *
	 * @param string $column The column name to check.
	 * @return string|false The combined column name if it is a combined column, false otherwise.
	 */
	public static function get_combined_column( $column ) {
		if ( self::is_combined_column( $column ) ) {
			return $column;
		}
		return false;
	}

	/**
	 * Checks if the given column name is a combined column.
	 *
	 * A combined column is identified by the presence of either a comma (',')
	 * or a semicolon (';') in the column name.
	 *
	 * @param string $column The column name to check.
	 * @return bool True if the column is a combined column, false otherwise.
	 */
	public static function is_combined_column( $column ) {
		return strpos( $column, ',' ) !== false || strpos( $column, ';' ) !== false;
	}

	/**
	 * Checks if a specific custom field is being used to retrieve specific posts for custom fields.
	 *
	 * Determines whether the current custom field matches the field name in the filter data.
	 * This is used to verify if posts are being filtered by a specific custom field.
	 *
	 * @param string $cf_field      The custom field name to check.
	 * @param string $cf_filter_data The filter data string to compare against.
	 * @return bool Returns true if the custom field matches the filter, false if no filter data.
	 */
	public static function is_retreiving_specific_cf_field_posts( $cf_field, $cf_filter_data ) {
		if ( ! $cf_filter_data ) {
			return false;
		}

		$cf_field_name = explode( ':', $cf_filter_data );

		if ( isset( $cf_field_name[0] ) && $cf_field === $cf_field_name[0] ) {
			return true;
		}

		return false;
	}
}
