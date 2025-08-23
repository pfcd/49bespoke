<?php
ini_set("max_execution_time", -1);
require_once('wp-load.php');
global $wpdb;  


$servername = "localhost";
$username = "pfcd_49b2";
$password = "giIi^h&^5!%%3XYH";
$dbname = "pfcd_49b4";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sel_prod = "SELECT A.ID, B.meta_value FROM wp_posts A JOIN wp_postmeta B ON A.ID=B.post_id WHERE A.post_type IN ('product','product_variation') AND B.meta_key = '_sku' AND B.meta_value !='' AND A.ID = '246856'";
$res_prod = $conn->query($sel_prod);
while($row_prod = $res_prod->fetch_assoc()){
    

	$servername1 = "localhost";
	$username1 = "pfcd_49b2";
	$password1 = "giIi^h&^5!%%3XYH";
	$dbname1 = "pfcd_49b2";
	$conn1 = new mysqli($servername1, $username1, $password1, $dbname1);
	if ($conn1->connect_error) {
		die("Connection failed: " . $conn1->connect_error);
	}
	
	$selb2_prod = "SELECT A.ID FROM wp_posts A JOIN wp_postmeta B ON A.ID=B.post_id WHERE A.post_type IN ('product','product_variation') AND B.meta_key = '_sku' AND B.meta_value ='".$row_prod['meta_value']."'";
	$resb2_sku1 = $conn1->query($selb2_prod);
	$rowb2_sku_prod = $resb2_sku1->fetch_assoc();
	
	
	$sel_imgurl = "SELECT ID, guid FROM wp_posts WHERE post_parent = '".$rowb2_sku_prod['ID']."' AND post_type = 'attachment'";
    $resb2_imgurl = $conn1->query($sel_imgurl);
	$rowb2_imgurl = $resb2_imgurl->fetch_assoc();
    
	if(!empty($rowb2_imgurl['guid'])){	
		$filename = basename($rowb2_imgurl['guid']);
		
		$results = $wpdb->get_results( "SELECT ID FROM wp_posts WHERE post_title = '".$filename."' AND post_type = 'attachment'");
		$image_id = json_decode(json_encode($results),true);
	
		if(empty($image_id[0]['ID'])){
		    
			$image_data = file_get_contents($rowb2_imgurl['guid']);
			
            $upload_dir = wp_upload_dir();
			if(wp_mkdir_p($upload_dir['path']))     $file = $upload_dir['path'] . '/' . $filename;
			else                                    $file = $upload_dir['basedir'] . '/' . $filename;
			file_put_contents($file, $image_data);

			$wp_filetype = wp_check_filetype($filename, null );
			$attachment = array(
				'post_mime_type' => $wp_filetype['type'],
				'post_title' => sanitize_file_name($filename),
				'post_content' => '',
				'post_status' => 'inherit'
			);
			$attach_id = wp_insert_attachment( $attachment, $file, $row_prod['ID'] );
			require_once(ABSPATH . 'wp-admin/includes/image.php');
			$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
			$res1= wp_update_attachment_metadata( $attach_id, $attach_data );
			$res2= set_post_thumbnail( $row_prod['ID'], $attach_id );
		}else{
		    $res2= set_post_thumbnail( $row_prod['ID'], $image_id[0]['ID'] );
		}
	}
}

echo 'DONE';