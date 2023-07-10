<?php 
add_action("wp_ajax_get_search_page_content", "get_search_page_content");
add_action("wp_ajax_nopriv_get_search_page_content", "get_search_page_content");

function get_search_page_content(){
	global $wpdb;
	$response = array("valid"=>false,"msg"=>"");

    ob_start();
     get_template_part("ajax_template/search_page_template");
   $data = ob_get_clean();
    $response['result'] = $data;
	wp_send_json( $response );
 die;
}

// get category item

add_action("wp_ajax_get_cat_item", "get_cat_item");
add_action("wp_ajax_nopriv_get_cat_item", "get_cat_item");

function get_cat_item(){
	global $wpdb;
	$response = array("valid"=>false,"msg"=>"");
    
    $response['post'] = $_POST;

    $cat = $_POST['cat_name'];

     ob_start();
     $shortcode_cat = '[yidpod_category category_slug="'.$cat.'" horizontal="false"]';
	 echo '<div class="one_cat">';
     echo do_shortcode($shortcode_cat);
	 echo '</div>';
   $data = ob_get_clean();
    $response['result'] = $data;
	wp_send_json( $response );
 die;
}

// get single podcast detail
add_action("wp_ajax_get_single_item_podcast", "get_single_item_podcast");
add_action("wp_ajax_nopriv_get_single_item_podcast", "get_single_item_podcast");
function get_single_item_podcast(){
	global $wpdb;
	$response = array("valid"=>false,"msg"=>"");
    
    $response['post'] = $_POST;

    $podcasturl = $_POST['podcasturl'];
 
     $ID = url_to_postid( $podcasturl );


    global $post; 
$post = get_post( $ID, OBJECT );
//print_r($post);
setup_postdata( $post );
ob_start();
set_query_var( 'post_id', $post->ID );
 get_template_part("ajax_template/single_podcast_item");
$data = ob_get_clean();
wp_reset_postdata();
$response['result'] = $data;
	wp_send_json( $response );
 die;
}

// get my show page content
add_action("wp_ajax_get_myshow_page_content", "get_myshow_page_content");
add_action("wp_ajax_nopriv_get_myshow_page_content", "get_myshow_page_content");
function get_myshow_page_content(){
	global $wpdb;
	$response = array("valid"=>false,"msg"=>""); 
    $response['post'] = $_POST;
ob_start();

 get_template_part("ajax_template/my_show_content_template");
$data = ob_get_clean();

$response['result'] = $data;
	wp_send_json( $response );
 die;
}



// get my feed page content
add_action("wp_ajax_get_mysfeed_page_content", "get_mysfeed_page_content");
add_action("wp_ajax_nopriv_get_mysfeed_page_content", "get_mysfeed_page_content");
function get_mysfeed_page_content(){
	global $wpdb;
	$response = array("valid"=>false,"msg"=>""); 
    $response['post'] = $_POST;
	ob_start();

 	get_template_part("ajax_template/my_feed_content_template");
	$data = ob_get_clean();

	$response['result'] = $data;
	wp_send_json( $response );
 die;
}


// get listen page content
add_action("wp_ajax_get_listen_page_content", "get_listen_page_content");
add_action("wp_ajax_nopriv_get_listen_page_content", "get_listen_page_content");
function get_listen_page_content(){
	global $wpdb;
	$response = array("valid"=>false,"msg"=>""); 
    $response['post'] = $_POST;
	ob_start();

	 get_template_part("ajax_template/listen_page_content");
	$data = ob_get_clean();

	$response['result'] = $data;
	wp_send_json( $response );
 die;
}





add_action("wp_ajax_singlelistrecord", "singlelistrecord");
add_action("wp_ajax_nopriv_singlelistrecord", "singlelistrecord");


function singlelistrecord(){

	global $wpdb;

	$response = array('valid'=>false,'msg'=>'');
	$post_id = $_POST['post_id'];

	$data = array();

	$list = array();

	if(isset($post_id)){

		$data = unserialize( base64_decode( $listenHistory) );
		$implode = implode(",", $data);

        $table_name = $wpdb->prefix."episode";
		$limit = 15;
		$offset = 0;
		 $sql = "SELECT * from  $table_name WHERE podcast_id='$post_id' order by published_date DESC ";
	  $results = $wpdb->get_results($sql);
		foreach ($results as $key => $value) {

			  
			   $time = timeDurationFormat2($value->duration);

			   $formatted_date = date('m/d/Y', $value->published_date);



			   $titlename = str_replace("'","",$value->title);

			   $shows_name = get_the_title($value->podcast_id);

			   $shows_name = str_replace("'","",$shows_name);

			    $fileurl  = str_replace("'","",$value->url);

			    $listItem = array("name"=>$titlename,"file"=>$fileurl,"duration"=>$time,"image"=>$value->image_uri,"shows_name"=>$shows_name,"formatted_date"=>$formatted_date,"eid"=>$value->id);

			    $list[] = $listItem;
	 }


	}
	

	$response['sql'] = $sql;
	$response['data'] = $list;

wp_send_json( $response );
 die;

}

// my feeds latest episodes
add_action("wp_ajax_singlelistrecordle", "singlelistrecordle");
add_action("wp_ajax_nopriv_singlelistrecordle", "singlelistrecordle");
function singlelistrecordle(){

	global $wpdb;

	$response = array('valid'=>false,'msg'=>'');
	$latestepisodes = $_POST['latestepisodes'];

	$data = array();

	$list = array();

	if(isset($latestepisodes)){

		$data = unserialize( base64_decode( $listenHistory) );
		$implode = implode(",", $data);

        $table_name = $wpdb->prefix."episode";
		$limit = 300;
		$offset = 0;
		$user_id = get_current_user_id();
		$episode_table = $wpdb->prefix.'episode';
		$subscribe_table = $wpdb->prefix.'yp_subscribe';
			if(!is_user_logged_in()){
				$getdata = $_COOKIE['subscribe_show'];
				$unserializeData= unserialize( base64_decode( $getdata) );
				$implodeData = implode(",",$unserializeData);
				$query = "SELECT *,DATE_FORMAT(FROM_UNIXTIME(`published_date`), '%m/%d/%Y') AS formatted_date from ".$episode_table." WHERE podcast_id in (".$implodeData.") order by published_date DESC  ";
			}
			else{
				$query = "SELECT *,DATE_FORMAT(FROM_UNIXTIME(`published_date`), '%m/%d/%Y') AS formatted_date from ".$episode_table." WHERE podcast_id in (SELECT podcast_id from ".$subscribe_table." where user_id = '".$user_id."') order by published_date DESC  LIMIT ".$limit." OFFSET ".$offset;
			}
		$results = $wpdb->get_results($query);
		foreach ($results as $key => $value) {

			   

			   $time = timeDurationFormat2($value->duration);

			   $formatted_date = date('m/d/Y', $value->published_date);



			   $titlename = str_replace("'","",$value->title);

			   $shows_name = get_the_title($value->podcast_id);

			   $shows_name = str_replace("'","",$shows_name);

			    $fileurl  = str_replace("'","",$value->url);

			    $listItem = array("name"=>$titlename,"file"=>$fileurl,"duration"=>$time,"image"=>$value->image_uri,"shows_name"=>$shows_name,"formatted_date"=>$formatted_date,"eid"=>$value->id);

			    $list[] = $listItem;
	 }


	}
	

	$response['sql'] = $sql;
	$response['data'] = $list;

wp_send_json( $response );
 die;

}

// single description play

add_action("wp_ajax_singleplay", "singleplay");
add_action("wp_ajax_nopriv_singleplay", "singleplay");

function singleplay(){

	global $wpdb;

	$response = array('valid'=>false,'msg'=>'');
	$episode_id = $_POST['episode_id'];

	$data = array();

	$list = array();

	if(isset($episode_id)){

        $table_name = $wpdb->prefix."episode";
		$limit = 15;
		$offset = 0;
		 $sql = "SELECT * from  $table_name WHERE id='$episode_id'";
	  $results = $wpdb->get_results($sql);
	  $podcast_id1 = $results[0]->podcast_id;

		foreach ($results as $key => $value) {

			    $time = timeDurationFormat2($value->duration);

			   $formatted_date = date('m/d/Y', $value->published_date);



			   $titlename = str_replace("'","",$value->title);

			   $shows_name = get_the_title($value->podcast_id);

			   $shows_name = str_replace("'","",$shows_name);

			    $fileurl  = str_replace("'","",$value->url);

			    $listItem = array("name"=>$titlename,"file"=>$fileurl,"duration"=>$time,"image"=>$value->image_uri,"shows_name"=>$shows_name,"formatted_date"=>$formatted_date,"eid"=>$value->id);

			    $list[] = $listItem;
	 }


	}
	

	$response['sql'] = $sql;
	$response['data'] = $list;

wp_send_json( $response );
 die;

}

// get single podcast detail
add_action("wp_ajax_get_single_item_podcast_description", "get_single_item_podcast_description");
add_action("wp_ajax_nopriv_get_single_item_podcast_description", "get_single_item_podcast_description");
function get_single_item_podcast_description(){
		global $wpdb;
		$response = array("valid"=>false,"msg"=>"");

		$response['post'] = $_POST;

		$episode_id = $_POST['episode_id'];
		$single_page_id = $_POST['single_page_id'];
		// $data = $episode_id.",".$single_page_id;

		ob_start();
		// set_query_var( 'data', $data );
		include "ajax_template/single_description.php";
		$data = ob_get_clean();
		wp_reset_postdata();
		$response['result'] = $data;
		wp_send_json( $response );
		die;
}


// get single podcast detail by back button
add_action("wp_ajax_backbutton", "backbutton");
add_action("wp_ajax_nopriv_backbutton", "backbutton");
function backbutton(){
		global $wpdb;
		$response = array("valid"=>false,"msg"=>"");
		$response['post'] = $_POST;
		$episode_id = $_POST['value'];
		$table_name = $wpdb->prefix."episode";
		$limit = 15;
		$offset = 0;
		$sql = "SELECT podcast_id from  $table_name WHERE id='$episode_id'";
		$results = $wpdb->get_results($sql);
		$ID = $results[0]->podcast_id;
		$response['ID'] = $ID; 
		$post = get_post( $ID, OBJECT );

		setup_postdata( $post );
		ob_start();
		set_query_var( 'post_id', $post->ID );
		get_template_part("ajax_template/single_podcast_item");
		$data = ob_get_clean();
		wp_reset_postdata();
		$response['result'] = $data;
		wp_send_json( $response );
		die;
}

// common function 

function timeDurationFormat2($duration){

	$myArray = explode(":",$duration);
	$length = count($myArray);

    if($length == 1){
       $duration1 = ((int)($duration/60));
       $duration2  = ($duration%60);
       return $duration1.":".$duration2;
    }
    
     if($length == 3 && strpos($duration, '::') !== true)
     {
       $time1 = $myArray[0];
       $time2 = $myArray[1];
       $time3 = $time1 * 60;
       $time4 = $time3 + $time2;

       $duration = $time4.":".$myArray[2];
       $duration = str_replace(":0",":",$duration);
     }


     if($length == 2 && ($myArray[1] == "" || $myArray[1] == "00")){
       $time1 = $myArray[0];      
       $duration = $time1.":0";
     }elseif($length == 2 && ($myArray[1] != "" || $myArray[1] != "00"))
     {
     
		$time1 = $myArray[0];
		$time2 = $myArray[1];

		$duration = $time1.":".$time2;

		if($time2.length > 1)
		$duration = str_replace(":0",":",$duration);
       
     }
     
     return $duration;
     
   }






// Go to show page via episode on mini player or single description title cickable.
add_action("wp_ajax_go_to_show_page", "go_to_show_page_func");
add_action("wp_ajax_nopriv_go_to_show_page", "go_to_show_page_func");
function go_to_show_page_func(){
	global $wpdb;
	$response = array("valid"=>false,"msg"=>"");
     
    $episode_id = $_POST['episode_id'];
    global $wpdb;
	$table_name = $wpdb->prefix."episode";
	$sql = "SELECT * from  $table_name WHERE id='$episode_id' ";
	$results = $wpdb->get_results($sql);
	 


     $ID = $results[0]->podcast_id;


    global $post; 
$post = get_post( $ID, OBJECT );
//print_r($post);
setup_postdata( $post );
ob_start();
set_query_var( 'post_id', $post->ID );
 get_template_part("ajax_template/single_podcast_item");
$data = ob_get_clean();
wp_reset_postdata();

// get permalink()....
$podcasturl = get_the_permalink($post->ID);
$response['result'] = $data;
$response['podcasturl'] = $podcasturl;
	wp_send_json( $response );
 die;
}



add_action("wp_ajax_get_browse_episodes_content", "get_browse_episodes_content_func");
add_action("wp_ajax_nopriv_get_browse_episodes_content", "get_browse_episodes_content_func");
function get_browse_episodes_content_func(){

	global $wpdb;
	$response = array("valid"=>false,"msg"=>""); 
    $response['post'] = $_POST;
	ob_start();

	 get_template_part("ajax_template/browse_episodes_content");
	$data = ob_get_clean();

	$response['result'] = $data;
	wp_send_json( $response );
 	die;


}



add_action("wp_ajax_get_single_episode_item", "get_single_episode_item_function");
add_action("wp_ajax_nopriv_get_single_episode_item", "get_single_episode_item_function");
function get_single_episode_item_function(){
	global $wpdb;
	$response = array("valid"=>false,"msg"=>"");
    
    $response['post'] = $_POST;

    $podcasturl = $_POST['podcasturl'];
 
     $ID = url_to_postid( $podcasturl );


    global $post; 
$post = get_post( $ID, OBJECT );
//print_r($post);
setup_postdata( $post );
ob_start();
set_query_var( 'post_id', $post->ID );
 //get_template_part("ajax_template/get_single_episode_item");
 get_template_part("ajax_template/single_podcast_item",null,array('podcast_slug'=>$post->post_name,'episode_index'=>''));
$data = ob_get_clean();
wp_reset_postdata();
$response['result'] = $data;
	wp_send_json( $response );
 die;
 
}


