<?php
namespace DiviPixel;

class DIPI_Metabox_Init {

	function __construct(){
		add_action('admin_init', [$this, 'dipi_metabox']);
	}

	function dipi_metabox() {
	    
	    $meta_fields = [
	        'meta_box_id'   =>  'testimonial_metabox_id',
	        'label'         =>  __( 'Testimonial Info', 'dipi-divi-pixel'),
	        'post_type'     =>  "dipi_testimonial",
	        'context'       =>  'normal',
	        'priority'      =>  'high',
	        'hook_priority' =>  5,
	        'fields'        =>  [
				[
					'name'	=>  'profile_image',
					'label'	=>  esc_html__('Profile Image', 'dipi-divi-pixel'),
					'type'	=>  'file',
					'upload_button'	=>  __( 'Choose File' ),
					'select_button'	=>  __( 'Select File' ),
				],
	            [
	                'name'	=>  'testimonial_name',
					'label'	=>  esc_html__('Testimonial Name', 'dipi-divi-pixel'),
	                'type'	=>  'text',
	            ],
	            [
	                'name'	=>  'company_name',
					'label'	=>  esc_html__('Company Name', 'dipi-divi-pixel'),
	                'type'	=>  'text',
	            ],
	            [
	                'name'	=>  'company_link',
					'label'	=>  esc_html__('Company Website', 'dipi-divi-pixel'),
	                'type'	=>  'text',
	            ],
	            [
	                'name'	=>  'testimonial_star',
					'label'	=>  esc_html__('Testimonial Rating', 'dipi-divi-pixel'),
	                'type'	=>  'text',
	            ],
	            [
	                'name'	=>  'testimonial_type',
					'label'	=>  esc_html__('Type', 'dipi-divi-pixel'),
	                'type'	=>  'text',
	                'default' =>  'default',
	                'readonly' => true
	            ],
	            [
	                'name'	=>  'facebook_id',
					'label'	=>  esc_html__('Facebook ID', 'dipi-divi-pixel'),
	                'type'	=>  'text',
	                'readonly' => true
	            ],
	            [
	                'name'	=>  'created_time_stamp',
					'label'	=>  esc_html__('Time Stamp', 'dipi-divi-pixel'),
	                'type'	=>  'text',
	                'readonly' => true
	            ]
	        ]
	    ];

	    $post_types = [];
		
		if ('on' != DIPI_Settings::get_option('footer_reveal_posts_type')) {
			$post_types[] = 'post';
		}

		if ('on' != DIPI_Settings::get_option('footer_reveal_pages_type')) {
			$post_types[] = 'page';
		}

		if ('on' != DIPI_Settings::get_option('footer_reveal_projects_type')) {
			$post_types[] = 'project';
		}

		if ('on' != DIPI_Settings::get_option('footer_reveal_testimonials_type')) {
			$post_types[] = 'dipi_testimonial';
		}

			
	    dipi_meta_box($meta_fields);
		
		if ('on' === DIPI_Settings::get_option('reveal_footer')){
			$meta_fields2 = [
				'meta_box_id'   => 'reveal_footer_metabox_id',
				'label'         => __( 'Revealing Footer Settings.', 'dipi-divi-pixel'),
				'post_type'     => $post_types,
				'priority'      => 'high',
				'fields'        => [
					[
						'name'      =>  'dipi_revealing_footer_enable_desktop',
						'label'     =>  __( 'Enable on Desktop', 'dipi-divi-pixel'),
						'type'      =>  'select',
						'options'   => [
							'default'  	=> 'Default',
							'yes'  		=> 'Yes',
							'no'  		=> 'No',
						],
						'default'   =>  'default'
					],
					[
						'name'      =>  'dipi_revealing_footer_enable_tablet',
						'label'     =>  __( 'Enable on Tablet', 'dipi-divi-pixel'),
						'type'      =>  'select',
						'options'   => [
							'default'  	=> 'Default',
							'yes'  		=> 'Yes',
							'no'  		=> 'No',
						],
						'default'   =>  'default'
					],
					[
						'name'      =>  'dipi_revealing_footer_enable_phone',
						'label'     =>  __( 'Enable on Phone', 'dipi-divi-pixel'),
						'type'      =>  'select',
						'options'   => [
							'default'  	=> 'Default',
							'yes'  		=> 'Yes',
							'no'  		=> 'No',
						],
						'default'   =>  'default'
					],
				]
			];
			dipi_meta_box($meta_fields2);
		}
	}
}

new DIPI_Metabox_Init();