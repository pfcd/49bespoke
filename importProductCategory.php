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

/* $get_wpslug = $wpdb->get_results( "SELECT slug FROM wp_terms" );
$get_slug = array_merge(...array_map(function($obj) {
				return explode(',', $obj->slug);
			}, $get_wpslug));
$imp_slug = implode("','", $get_slug); */

$sql_cate = "SELECT * FROM test_virtuemart_categories_en_gb WHERE slug IN ('28-624')";
$res_cate = $conn->query($sql_cate);
while($row_cate = $res_cate->fetch_assoc()){
	//get parent category
	$get_parentcat = "SELECT category_parent_id FROM test_virtuemart_category_categories WHERE category_child_id = '".$row_cate['virtuemart_category_id']."'";
	$get_parentcat_res = $conn->query($get_parentcat);
	$get_parentcat_row = $get_parentcat_res->fetch_assoc();
	
	if(empty($get_parentcat_row['category_parent_id'])){
		$parent = 0;
		$img_cat_id = $row_cat['virtuemart_category_id'];
	}else{
		$parent = $get_parentcat_row['category_parent_id'];
		$img_cat_id = $get_parentcat_row['category_parent_id'];
	}
	
	$term_data = wp_insert_term(
		$row_cate['category_name'],
		'product_cat',
		array(
			'description'=> $row_cate['category_description'],
			'slug' => $row_cate['slug'],
			'parent'=> $parent  
		)
	);
	/*$cat_id = $term_data->term_id;
	$get_imageid = create_image('category', $img_cat_id, $cat_id, $conn);
	if(!empty($get_imageid)){
		add_term_meta( $cat_id, 'thumbnail_id', $get_imageid );
		update_term_meta( $cat_id, 'thumbnail_id', $get_imageid) ;
	}*/
}

/*function create_image($type, $joomla_id, $id, $conn){
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
}*/
echo 'DONE';