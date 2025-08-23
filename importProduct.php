<?php
//ini_set('display_errors',1);
ini_set("max_execution_time", 1000);
require_once('wp-load.php');
global $wpdb;  

$servername = "localhost";
$username = "pfcd_49b2";
$password = "giIi^h&^5!%%3XYH";
$dbname = "pfcd_49joomdev";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//$product_ids = array('2241','2091','2096','2312','2320','2335','2341','2349','2355','1702','1712','1722','1732','1743','1753','1771','1787','1804','1820','1837','1838','1839','1841','1842','1844','1924','1929','1935','1970','1971','1979','1980','1988','1989','1891','1892','1893','1895','1900','1905','2039','2058','2071','2079','2083','2259','2262','2265','2276','2278','2283','2299','2332','2674','2867','2744','2761','2776','2784','2814','2877','2886','2895','2913','2966','3111','3121','3131','3141','3151','3269','3173','3176','3180','3185','3194','3197','3200','3205','3207','3209','3211','3213','3216','3219','3226','3230','3236','3239','3251','3295','3302','3306','3337','3318','3321','3327','3329','3333','3339','3422','3352','3355','3360','3363','3366','3368','3370','3372','3377','3379','3405','3410','3400','3415','3424','3452','3460','3481','3482','3483','3509','3503','3506','3512','3535');

//foreach ($product_ids AS $product_id){
// SELECT Parent - Parent
	$sel_prod = "SELECT * FROM test_virtuemart_products A JOIN test_virtuemart_products_en_gb B ON A.virtuemart_product_id=B.virtuemart_product_id WHERE A.virtuemart_product_id IN ('286')";
	$res_prod = $conn->query($sel_prod);
	while($row_prod = $res_prod->fetch_assoc()){
	// Select params
	$sel_param = "SELECT * FROM test_virtuemart_product_customfields WHERE virtuemart_product_id = '".$row_prod['virtuemart_product_id']."'";
	$res_param = $conn->query($sel_param);
	$row_param = $res_param->fetch_assoc();
	if(!empty($row_param['customfield_params'])){
		
		$search = array('selectoptions=', '|');
		$replace = '';
		$param_values = str_replace($search, $replace, $row_param['customfield_params']);
		$param_val = json_encode($param_values, true);
		$param_val = json_decode($param_val);
		$get_options = explode('options=', $param_val);
		$variations = json_decode($get_options[1]);
		$titles = json_decode($get_options[0]);
		$desc = '';
		if(!empty($row_prod['product_s_desc'])){
			$desc .= $row_prod['product_s_desc'];
		}
		if(!empty($row_prod['product_desc'])){
			$desc .= '<br>'. $row_prod['product_desc'];
		}
		if(empty($desc)){
			$sel_parent="SELECT * FROM  test_virtuemart_products_en_gb WHERE virtuemart_product_id = (SELECT product_parent_id FROM `test_virtuemart_products` WHERE virtuemart_product_id = '".$row_prod['virtuemart_product_id']."')";
			$res_parent = $conn->query($sel_parent);
			$row_parent = $res_parent->fetch_assoc();
			if(!empty($row_parent['product_s_desc'])){
				$desc .= $row_parent['product_s_desc'];
			}
			if(!empty($row_parent['product_desc'])){
				$desc .= '<br>'. $row_parent['product_desc'];
			}
		}
		
		$sel_price = "SELECT product_price FROM test_virtuemart_product_prices WHERE virtuemart_product_id = '".$row_prod['virtuemart_product_id']."'";
		$res_price = $conn->query($sel_price);
		$row_price = $res_price->fetch_assoc();
	
		// category
		$sel_cat = "SELECT virtuemart_category_id FROM test_virtuemart_product_categories WHERE virtuemart_product_id = '".$row_prod['virtuemart_product_id']."'";
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
			$img_cat_id = $row_cat['virtuemart_category_id'];
		}else{
			$parent = $get_parentcat_row['category_parent_id'];
			$img_cat_id = $get_parentcat_row['category_parent_id'];
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
			$get_imageid = create_image('category', $img_cat_id, $cat_id, $conn);
			if(!empty($get_imageid)){
				add_term_meta( $cat_id, 'thumbnail_id', $get_imageid );
				update_term_meta( $cat_id, 'thumbnail_id', $get_imageid) ;
			}
		}else{
			if(!empty($category->term_id)){
				$cat_id = $category->term_id;
			}
		}
		
		$product_id = wc_get_product_id_by_sku( $row_prod['product_sku'] );
		print_r($product_id);
		exit;
		if($product_id <= 0){
			
			$product_id = wp_insert_post( 
				array(
					'post_title' => $row_prod['product_name'],
					'post_type' => 'product',
					'post_status' => 'publish',
					//'post_content' => $desc
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
			
		}else{
			$product_id = $product_id;
			$product = wc_get_product( $product_id );
			$product->set_sku($row_prod['product_sku']);
			$product->set_regular_price($row_price['product_price']);
			$product->set_price($row_price['product_price']);
			$product->set_stock_quantity( $row_prod_items['product_quantity'] );
			$tag = array( $cat_id );
			wp_set_post_terms( $product_id, $tag, 'product_cat');
		}
		$get_imageid = create_image('product', $row_prod['virtuemart_product_id'], $product_id, $conn);	
		$res2= set_post_thumbnail( $product_id, $get_imageid );
		$i=0;
		$first_title='';
		$second_title='';
		$third_title='';
		
		foreach($titles AS $title){
			if($i==0){
				if(!empty($title->clabel)){
					$first_title = $title->clabel;
				}else{
					$first_title = 'Product Width';
				}
			}else if($i==1){
				if(!empty($title->clabel)){
					$second_title = $title->clabel;
				}else{
					$second_title = 'Product Width';
				}
			}else if($i==2){
				if(!empty($title->clabel)){
					$third_title = $title->clabel;
				}else{
					$third_title = 'Product Width';
				}
			}
			$i++;
		}
		
		$fir_opt = array();
		$sec_opt = array();
		$thir_opt = array();
		
		foreach($variations as $key => $val) {
			if(!empty($key)){
				$sel_prod1 = "SELECT * FROM test_virtuemart_products A JOIN test_virtuemart_products_en_gb B ON A.virtuemart_product_id=B.virtuemart_product_id WHERE  A.virtuemart_product_id = '".$key."'";
				$res_prod1 = $conn->query($sel_prod1);
				$row_prod1 = $res_prod1->fetch_assoc();
				$desc = '';
				if(!empty($row_prod['product_s_desc'])){
					$desc .= $row_prod['product_s_desc'];
				}
				if(!empty($row_prod['product_desc'])){
					$desc .= '<br>'. $row_prod['product_desc'];
				}		
				$sel_price1 = "SELECT product_price FROM test_virtuemart_product_prices WHERE virtuemart_product_id = '".$key."'";
				$res_price1 = $conn->query($sel_price1);
				$row_price1 = $res_price1->fetch_assoc();
				
				$parent_id = $product_id;
				$variation = array(
					'post_title'  => $row_prod['product_name'],
					'post_name'   => sanitize_title($row_prod['product_name']),
					'post_content'=> '',
					'post_status' => 'publish',
					'post_parent' => $parent_id,
					'post_type'   => 'product_variation'
				);
				$variation_id = wp_insert_post( $variation );
				update_post_meta( $variation_id, '_regular_price', $row_price['product_price'] );
				update_post_meta( $variation_id, '_price', $row_price['product_price'] );
				update_post_meta( $variation_id, '_stock_qty', $row_subprod_items['product_quantity'] );
				update_post_meta( $variation_id, '_thumbnail_id', $get_imageid );
				update_post_meta( $variation_id, '_sku', $row_prod1['product_sku'] );
				if($first_title !='' && $val[0] !=''){
					$first_slug = sanitize_title($first_title);
					update_post_meta( $variation_id, 'attribute_' . $first_slug, strtolower($val[0]) );
					$fir_opt[] = $val[0];
				}
				if($second_title !='' && $val[1] !=''){
					$second_slug = sanitize_title($second_title);
					update_post_meta( $variation_id, 'attribute_'. $second_slug, strtolower($val[1]) );
					$sec_opt[] = $val[1];
				}
				if($third_title !='' && $val[2] !=''){
					$third_slug = sanitize_title($third_title);
					update_post_meta( $variation_id, 'attribute_pa_'. $third_slug, strtolower($val[2]) );
					$thir_opt[] = $val[2];
				}
				update_post_meta( $variation_id, '_variation_description', '' );
				update_post_meta( $variation_id, 'total_sales', '0' );
				update_post_meta( $variation_id, '_tax_status', 'taxable' );
				update_post_meta( $variation_id, '_tax_class', 'parent' );
				update_post_meta( $variation_id, '_manage_stock', 'no' );
				update_post_meta( $variation_id, '_backorders', 'no' );
				update_post_meta( $variation_id, '_sold_individually', 'no' );
				update_post_meta( $variation_id, '_virtual', 'no' );
				update_post_meta( $variation_id, '_downloadable', 'no' );
				update_post_meta( $variation_id, '_download_limit', '-1' );
				update_post_meta( $variation_id, '_download_expiry', '-1' );
				update_post_meta( $variation_id, '_stock', 'NULL' );
				update_post_meta( $variation_id, '_stock_status', 'instock' );
				update_post_meta( $variation_id, '_wc_average_rating', '0' );
				update_post_meta( $variation_id, '_wc_review_count', '0' ); 
				update_post_meta( $variation_id, '_product_version', '8.3.0' );
				WC_Product_Variable::sync( $parent_id );
			}
		}
		if(!empty($fir_opt)){
			$attr_slug = sanitize_title($first_title);
			$attr_name = implode("|",array_unique($fir_opt));
			$attributes_array[$attr_slug] = array(
				'name' => $first_title,
				'value' => $attr_name,
				'is_visible' => '1',
				'is_variation' => '1',
				'is_taxonomy' => '0'       
			);
		}
		if(!empty($sec_opt)){
			$attr_slug = sanitize_title($second_title);
			$attr_name = implode("|",array_unique($sec_opt));
			$attributes_array[$attr_slug] = array(
				'name' => $second_title,
				'value' => $attr_name,
				'is_visible' => '1',
				'is_variation' => '1',
				'is_taxonomy' => '0'       
			);
		}
		if(!empty($thir_opt)){
			$attr_slug = sanitize_title($third_title);
			$attr_name = implode("|",array_unique($thir_opt));
			$attributes_array[$attr_slug] = array(
				'name' => $third_title,
				'value' => $attr_name,
				'is_visible' => '1',
				'is_variation' => '1',
				'is_taxonomy' => '0'       
			);
		}
		update_post_meta( $product_id, '_product_attributes', $attributes_array );
	}
}
function create_image($type, $joomla_id, $id, $conn){
	global $wpdb; 
	if($type == 'category'){
		$get_image_url = "SELECT A.file_url, A.file_title FROM test_virtuemart_medias A JOIN test_virtuemart_category_medias B ON A.virtuemart_media_id=B.virtuemart_media_id WHERE B.virtuemart_category_id = '".$joomla_id."' AND A.file_type='category'";
		$res_image_url = $conn->query($get_image_url);
		$row_image_url = $res_image_url->fetch_assoc();
		if(!empty($row_image_url['file_url'])){
			$image_url = 'https://www.49bespoke.com/'.$row_image_url['file_url'];
		}else{
			$get_parentcat = "SELECT category_parent_id FROM test_virtuemart_category_categories WHERE category_child_id = '".$row_cat['virtuemart_category_id']."'";
			$get_parentcat_res = $conn->query($get_parentcat);
			$get_parentcat_row = $get_parentcat_res->fetch_assoc();
			
			$get_image_url = "SELECT A.file_url, A.file_title FROM test_virtuemart_medias A JOIN test_virtuemart_category_medias B ON A.virtuemart_media_id=B.virtuemart_media_id WHERE B.virtuemart_category_id = '".$get_parentcat_row['category_parent_id']."' AND A.file_type='category'";
			$res_image_url = $conn->query($get_image_url);
			$row_image_url = $res_image_url->fetch_assoc();
			if(!empty($row_image_url['file_url'])){
				$image_url = 'https://www.49bespoke.com/'.$row_image_url['file_url'];
			}else{
				$image_url = '';
			}
		}
	}else if($type == 'product'){
		$get_image_url = "SELECT A.file_url, A.file_title FROM test_virtuemart_medias A JOIN test_virtuemart_product_medias B ON A.virtuemart_media_id=B.virtuemart_media_id WHERE B.virtuemart_product_id = '".$joomla_id."' AND A.file_type='product'";
		$res_image_url = $conn->query($get_image_url);
		$row_image_url = $res_image_url->fetch_assoc();
		if(!empty($row_image_url['file_url'])){
			$image_url = 'https://www.49bespoke.com/'.$row_image_url['file_url'];
		}else{
			
			$sel_prod = "SELECT product_parent_id FROM test_virtuemart_products A JOIN test_virtuemart_products_en_gb B ON A.virtuemart_product_id=B.virtuemart_product_id WHERE A.virtuemart_product_id = '".$joomla_id."'";
			$res_prod = $conn->query($sel_prod);
			$row_prod = $res_prod->fetch_assoc();
			
			$get_image_url = "SELECT A.file_url, A.file_title FROM test_virtuemart_medias A JOIN test_virtuemart_product_medias B ON A.virtuemart_media_id=B.virtuemart_media_id WHERE B.virtuemart_product_id = '".$row_prod['product_parent_id']."' AND A.file_type='product'";
			$res_image_url = $conn->query($get_image_url);
			$row_image_url = $res_image_url->fetch_assoc();
			if(!empty($row_image_url['file_url'])){
				$image_url = 'https://www.49bespoke.com/'.$row_image_url['file_url'];
			}else{
				$image_url = '';
			}
		}
	}
	
	if(!empty($image_url)){	
		
		$filename = basename($image_url);
		
		$results = $wpdb->get_results( "SELECT ID FROM wp_posts WHERE post_title = '".$filename."' AND post_type = 'attachment'");
		$image_id = json_decode(json_encode($results),true);
		
		if(empty($image_id[0]['ID'])){
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
			return $image_id[0]['ID'];
		}
	}
}
echo 'DONE';