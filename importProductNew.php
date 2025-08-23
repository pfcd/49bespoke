<?php
ini_set('display_errors',1);
ini_set("max_execution_time", 1000);
require_once('wp-load.php');
global $wpdb;  

$servername = "localhost";
$username = "bpfcd_bespoke";
$password = "G6w3m95Rktt%Q!1qtz9AAcsd";
$dbname = "bpfcd_joomla";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// SELECT Parent - Parent

$sel_prod = "SELECT * FROM test_virtuemart_products A JOIN test_virtuemart_products_en_gb B ON A.virtuemart_product_id=B.virtuemart_product_id WHERE A.product_parent_id=0";
$res_prod = $conn->query($sel_prod);
$row_prod = $res_prod->fetch_assoc();

	// Select params
	$sel_param = "SELECT * FROM test_virtuemart_product_customfields WHERE virtuemart_product_id = '3252'";
	$res_param = $conn->query($sel_param);
	$row_param = $res_param->fetch_assoc();
	if(!empty($row_param['customfield_params'])){
		$parms = $row_param['customfield_params'];
		$create_product = createProduct($row_prod['virtuemart_product_id'], $row_prod['virtuemart_product_id'], $parms, $conn);
	}else{
		$sel_parent1 = "SELECT * FROM test_virtuemart_products A JOIN test_virtuemart_products_en_gb B ON A.virtuemart_product_id=B.virtuemart_product_id WHERE A.product_parent_id = '".$row_prod['virtuemart_product_id']."'";
		$res_parent1 = $conn->query($sel_parent1);
		while($row_parent1 = $res_parent1->fetch_assoc()){
			$sel_param1 = "SELECT * FROM test_virtuemart_product_customfields WHERE virtuemart_product_id = '".$row_parent1['virtuemart_product_id']."'";
			$res_param1 = $conn->query($sel_param1);
			$row_param1 = $res_param1->fetch_assoc();
			$parms = $row_param1['customfield_params'];
			$create_product = createProduct($row_prod['virtuemart_product_id'], $row_parent1['virtuemart_product_id'], $parms, $conn);
		}
	}
	
	function create_image($type, $id, $conn){
		global $wpdb; 
		if($type == 'category'){
			$get_image_url = "SELECT A.file_url, A.file_title FROM test_virtuemart_medias A JOIN test_virtuemart_category_medias B ON A.virtuemart_media_id=B.virtuemart_media_id WHERE B.virtuemart_category_id = '".$id."' AND A.file_type='category'";
		}else if($type == 'category'){
			$get_image_url = "SELECT A.file_url, A.file_title FROM test_virtuemart_medias A JOIN test_virtuemart_product_medias B ON A.virtuemart_media_id=B.virtuemart_media_id WHERE B.virtuemart_product_id = '".$id."' AND A.file_type='product'";
		}
		$res_image_url = $conn->query($get_image_url);
		$row_image_url = $res_image_url->fetch_assoc();
		if(!empty($row_image_url['file_url'])){	
			$image_url = 'https://www.49bespoke.com/'.$row_image_url['file_url'];
			$filename = basename($image_url);
			
			$results = $wpdb->get_results( "SELECT ID FROM wp_posts WHERE post_title = '".$filename."' AND post_type = 'attachment'");
			
			$php_array = json_decode(json_encode($results),true);
			if(($filename != $row_image_url['file_title']) && empty($php_array[0]['ID'])){
				$image_data = file_get_contents($image_url);
				$upload_dir = wp_upload_dir();
				
				if(wp_mkdir_p($upload_dir['path']))     $file = $upload_dir['path'] . '/' . $row_image_url['file_title'];
				else                                    $file = $upload_dir['basedir'] . '/' . $row_image_url['file_title'];
				file_put_contents($file, $image_data);

				$wp_filetype = wp_check_filetype($filename, null );
				$attachment = array(
					'post_mime_type' => $wp_filetype['type'],
					'post_title' => sanitize_file_name($filename),
					'post_content' => '',
					'post_status' => 'inherit'
				);
				$attach_id = wp_insert_attachment( $attachment, $file, $id );
				require_once(ABSPATH . 'wp-admin/includes/image.php');
				$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
				$res1= wp_update_attachment_metadata( $attach_id, $attach_data );
				$res2= set_post_thumbnail( $id, $attach_id );
				return $attach_id;
			}else{
				return $php_array[0]['ID'];
			}
		}
	}
	function createProduct($parent_product_id, $id, $param, $conn){
		global $wpdb;
		
		
		$search = array('selectoptions=', '[', ']', '|');
		$replace = '';
		$param_values = str_replace($search, $replace, $param);
		$param_val = json_encode($param_values, true);
		$param_val = json_decode($param_val);
		$get_options = explode('options=', $param_val);
		$title = json_decode($get_options[0]);
		$attr_label =  str_replace(" ", "-" ,strtolower($title->clabel));
		$variations = explode(',',$get_options[1]);
		foreach($variations as $val){
			$os1 = explode(':',$val);
			echo 'Product ID : '.$os1[0]. 'Value : '.$os1[1];echo "</br>";
			
		}
		/* $sel_price = "SELECT product_price FROM test_virtuemart_product_prices WHERE virtuemart_product_id = '".$id."'";
		$res_price = $conn->query($sel_price);
		$row_price = $res_price->fetch_assoc();
		
		// category
		$sel_cat = "SELECT virtuemart_category_id FROM test_virtuemart_product_categories WHERE virtuemart_product_id = '".$id."'";
		$res_cat = $conn->query($sel_cat);
		$row_cat = $res_cat->fetch_assoc();

		$get_cat = "SELECT * FROM test_virtuemart_categories_en_gb WHERE virtuemart_category_id = '".$row_cat['virtuemart_category_id']."'";
		$get_cat_res = $conn->query($get_cat);
		$get_cat_row = $get_cat_res->fetch_assoc();

		$category = get_term_by( 'slug', $get_cat_row['slug'], 'product_cat' );
		
		//get parent category
		$get_parentcat = "SELECT category_parent_id FROM test_virtuemart_category_categories WHERE category_child_id = '".$row_cat['virtuemart_category_id']."'";
		$get_parentcat_res = $conn->query($get_parentcat);
		$get_parentcat_row = $get_parentcat_res->fetch_assoc();
		
		if(empty($get_parentcat_row['category_parent_id'])){
			$parent = 0;
		}else{
			$parent = $get_parentcat_row['category_parent_id'];
		}
		if(empty($category)){
			$term_data = wp_insert_term(
				$get_cat_row['category_name'],
				'product_cat',
				array(
					'description'=> $get_cat_row['category_description'],
					'slug' => $get_cat_row['slug'],
					'parent'=> $parent  
				)
			);
			$cat_id = $term_data->term_id;
			$get_imageid = create_image('category', $cat_id, $conn);
			if(!empty($get_imageid)){
				add_term_meta( $cat_id, 'thumbnail_id', $attach_id );
				update_term_meta( $cat_id, 'thumbnail_id', $attach_id) ;
			}
		}else{
			if(!empty($category->term_id)){
				$cat_id = $category->term_id;
			}
		}
		$product_id = wp_insert_post( 
			array(
				'post_title' => $row_prod['product_name'],
				'post_type' => 'product',
				'post_status' => 'publish',
			)
		);
		$product = wc_get_product( $product_id );
		$product->set_sku($row_prod['product_sku']);
		$product->set_regular_price($row_price['product_price']);
		$product->set_price($row_price['product_price']);
		$product->set_stock_quantity( $row_prod_items['product_quantity'] );
		$tag = array( $cat_id );
		wp_set_post_terms( $product_id, $tag, 'product_cat');
		$product->save();
		$get_imageid = create_image('product', $product_id, $conn); */
				
		/* $opt = array();
		foreach($options as $key => $val) {
			
			$opt[] = $val;
			if(!empty($key)){
				
				$sel_prod1 = "SELECT * FROM test_virtuemart_products WHERE virtuemart_product_id = '".$key."'";
				$res_prod1 = $conn->query($sel_prod1);
				$row_prod1 = $res_prod1->fetch_assoc();
								
				$attr_slug = sanitize_title($attr_label);
				$parent_id = $id;
				$variation = array(
					'post_title'   => $val,
					'post_name'   => 'auto-draft-'.strtolower($val),
					'post_content' => $row_details['product_desc'],
					'post_status'  => 'publish',
					'post_parent'  => $parent_id,
					'post_type'    => 'product_variation'
				);
				$variation_id = wp_insert_post( $variation );
				update_post_meta( $variation_id, '_regular_price', $row_subprod_items['product_subtotal_with_tax'] );
				update_post_meta( $variation_id, '_price', $row_subprod_items['product_final_price'] );
				update_post_meta( $variation_id, '_stock_qty', $row_subprod_items['product_quantity'] );
				update_post_meta( $variation_id, '_thumbnail_id', $get_imageid );
				update_post_meta( $variation_id, '_sku', $row_prod1['product_sku'] );
				update_post_meta( $variation_id, 'attribute_pa_' . $attr_slug.'-1', strtolower($val) );
				WC_Product_Variable::sync( $parent_id );
			}
		}
		if(!empty($opt)){
			$attr_slug = sanitize_title($attr_label);
			$attr_name = implode("|",$opt); 
			$attributes_array[$attr_slug] = array(
				'name' => $attr_label,
				'value' => $attr_name,
				'is_visible' => '1',
				'is_variation' => '1',
				'is_taxonomy' => '0'       
			);
			update_post_meta( $product_id, '_product_attributes', $attributes_array );
		} */
	} 

echo 'DONE';