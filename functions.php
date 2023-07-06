<?php

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );}



/** Rename "Returning Customer?" @ Checkout Page - WooCommerce  */
 
add_filter( 'woocommerce_checkout_login_message', 'bbloomer_return_customer_message' );
 
function bbloomer_return_customer_message() {
return 'Already have a YidPod account? Log in with your YidPod credentials.';
}

	

//======================================================================
// CUSTOM DASHBOARD
//======================================================================
// ADMIN FOOTER TEXT
function remove_footer_admin () {
    echo "Divi Child Theme";
} 

add_filter('admin_footer_text', 'remove_footer_admin');

include 'ajax_functions.php';
include 'misc_functions.php';
include 'helpers.php';


add_action("wp_ajax_get_podcast_detail", "get_podcast_detail");
add_action("wp_ajax_nopriv_get_podcast_detail", "get_podcast_detail");

function get_podcast_detail(){

	global $wpdb;
	$table = $wpdb->prefix."posts";

	$podcast_title = $_POST['podcast_title'];
    $response = array("valid"=>false,"msg"=>"Something went wrong");

$results = $wpdb->get_results("SELECT ID FROM $table WHERE post_title = '$podcast_title'");

if(isset($results[0]->ID)){
    
    $response['podcastid'] = $results[0]->ID;

    saveRecentPodcast($results[0]->ID);

	$table_name = $wpdb->prefix."episode";
 $sql = "SELECT * from  $table_name WHERE podcast_id='".$results[0]->ID."'";
	  $results = $wpdb->get_results($sql);
	 $list = "";
	foreach ($results as $key => $value) {
       $strlength = strlen($value->duration);
	 	if($strlength < 5)
       	      $time = substr($value->duration, 0, 2).":".substr($value->duration, 2, 3);	     
       else
       	$time = $value->duration;
	 	
           $list .= "{ name:'Artist ".$value->author." - Audio ".$value->title."',file:'".$value->url."',duration:'".$time."',image:'".$value->image_uri."'},";
	 }
       

    $slist = '';

	 $response['list'] = $list;
	 $response['valid'] = true;
	 $response['msg'] = "Successfully";


}


 
 

  wp_send_json( $response );
 die;

}


add_action("wp_ajax_get_podcast_search", "get_podcast_search");
add_action("wp_ajax_nopriv_get_podcast_search", "get_podcast_search");

function get_podcast_search(){

    global $wpdb;

	$seachTitle = $_POST['podcast_title'];

	$response = array("valid"=>false,"msg"=>"Something went wrong");

	
    $sql = "(SELECT MATCH (title) AGAINST ('$seachTitle' IN BOOLEAN MODE) as exact, MATCH (title) AGAINST ('$seachTitle*' IN BOOLEAN MODE) as almost,id,author,title,image_uri,published_date,duration,podcast_id,'episode' as type,e_index,'' as post_status,'t' as post_type,'' as 'tags',url from wp_episode WHERE 1=1 AND (MATCH (title) AGAINST ('$seachTitle' IN BOOLEAN MODE) OR MATCH (title) AGAINST ('$seachTitle*' IN BOOLEAN MODE))) ORDER BY exact desc,almost desc,INSTR(title,'$seachTitle'),title, published_date DESC";
  // $results = $wpdb->get_results($sql);

   $seachTitle =  urlencode($seachTitle);

$dataurl = site_url().'/wp-json/yidpod/v1/searches?type=shows&search='.$seachTitle;



//echo $dataurl;

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $dataurl,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);
//echo " response ".$response."end <br>";
$response = json_decode($response);
//print_r($response);

$results = $response;


   if(count($results) > 0 )
   $data = "<h1>Search results</h1><div class='podcasts_list'>";

   foreach ($results as $key => $value) {
            $id1 = $value->id;
            $data .= '<div class="podcast">
                      <a href="'.get_the_permalink($id1).'">
						<div class="podcast_img">
						
							<img width="200" height="200" src="'.$value->image_uri.'" class="attachment-large size-large wp-post-image" alt="" loading="lazy" >						 </div>
						 <div class="podcast_title">'.$value->title.'</div>
						 </a>
			 		</div>';
   }

   if(count($results) > 0 )
   $data .= '</div>';

   $response['data'] = $data;

  wp_send_json( $response );
 die;

}

// search page results
add_action("wp_ajax_get_podcast_search_page", "get_podcast_search_page");
add_action("wp_ajax_nopriv_get_podcast_search_page", "get_podcast_search_page");

function get_podcast_search_page(){

    global $wpdb;

	$seachTitle = $_POST['podcast_title'];

	$podcats_elect = $_POST['podcats_elect'];

	$response = array("valid"=>false,"msg"=>"Something went wrong");

	/*if($podcats_elect == 'shows'){
    $table_name = $wpdb->prefix."yp_subscribe";
    $results = $wpdb->get_results("SELECT count(*) as total,podcast_id, b.post_title as title from $table_name INNER JOIN $wpdb->posts as b ON podcast_id = b.ID where b.post_title LIKE '%$seachTitle%' OR b.post_content LIKE '%$seachTitle%'  GROUP BY podcast_id ORDER BY total desc ");
	}
	else{
    $sql = "(SELECT MATCH (title) AGAINST ('$seachTitle' IN BOOLEAN MODE) as exact, MATCH (title) AGAINST ('$seachTitle*' IN BOOLEAN MODE) as almost,id,author,title,image_uri,published_date,duration,podcast_id,'episode' as type,e_index,'' as post_status,'t' as post_type,'' as 'tags',url from wp_episode WHERE 1=1 AND (MATCH (title) AGAINST ('$seachTitle' IN BOOLEAN MODE) OR MATCH (title) AGAINST ('$seachTitle*' IN BOOLEAN MODE))) ORDER BY exact desc,almost desc,INSTR(title,'$seachTitle'),title, published_date DESC LIMIT 50 OFFSET 0";
    $results = $wpdb->get_results($sql);
}
*/

$results = searchForPodcastsAndEpisodes2($podcats_elect,$seachTitle);



   

   if(count($results) > 0){
   	    $response['valid'] = true;
   	    $response['msg'] = "Search results of podcasts";

   }

   $data = "<h1>Search results</h1><div class='podcasts_lists'>";

   foreach ($results as $key => $value) {

   	$id = (isset($value->podcast_id) && $value->podcast_id != '0')?$value->podcast_id:$value->id;

   	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'single-post-thumbnail' );
            
            $data .= '<div class="podcast">
                      <a href="'.get_the_permalink($id).'">
						<div class="podcast_image">
						
							<img width="200" height="200" src="'.$image[0].'" class="attachment-large size-large wp-post-image" alt="" loading="lazy" >						 </div>
						 <div class="podcast_title">'.$value->title.'</div>
						 </a>
			 		</div>';
   }


   $data .= '</div>';

   $response['data'] = $data;

  wp_send_json( $response );
 die;

}


// save recently view of podcasts

function saveRecentPodcast($id){

	$current_user_id = get_current_user_id(); // Alternative for getting current user ID
    $key = 'recently_view';
	$data = array();
	

	$getdata = get_user_meta( $current_user_id, $key, true );

	if(isset($getdata) && !empty($getdata)){
		$unserialize = unserialize($getdata);
		$data = $unserialize;
		$data[] = $id;
		$data =  array_unique($data);
	}
	else{
       $data[] = $id;
	
	}

	$serialize = serialize($data);

// Update current user's first name
update_user_meta( $current_user_id, $key, $serialize );

} 



function saveRecentPodcastCookies($id){

	$current_user_id = get_current_user_id(); // Alternative for getting current user ID
    $key = 'recently_view';
	$data = array();

	$getdata = $_COOKIE['recently_view'];
    	
	if(isset($getdata) && !empty($getdata)){
		$data = unserialize( base64_decode( $getdata) );
		$data[] = $id;
		$data =  array_unique($data);
	}
	else{
       $data[] = $id;
	
	}

	$serialize = base64_encode(serialize($data));

	if(!is_user_logged_in()){

		$cookiesRecently_view = setcookie( 'recently_view', $serialize, time() + 360000, COOKIEPATH, COOKIE_DOMAIN   );

	}

}

// pre tag
function printr($data) {
   echo "<pre>";
      print_r($data);
   echo "</pre>";
}



add_filter('woocommerce_login_redirect', 'login_redirect');

function login_redirect($redirect_to) {
    return home_url('listen');
}


// search result of podcasts

function searchForPodcastsAndEpisodes2($type="shows",$term=""){
	global $wpdb;
	$episode_table_name = $wpdb->prefix . "episode"; 
	$podcast_table_name = $wpdb->prefix . "posts"; 
	$episodewhere = "1=1";
	$podcastwhere = "post_type = 'podcasts' AND post_status = 'publish'";
	// if(isset($type)){

	// return ['type'=>$type,'term'=>$term];
	// }
	$limit = $_GET['limit'] ?? 50;
	if(!isset($type)){
		$type = 'shows';
	}
	if(isset($_GET['type'])){
		$type = $_GET['type'];
	} 
	if(isset($_GET['search']) || $term){
		$term = $_GET['search'] ?? $term;
		// if(isset($_GET['debug'])){

			$terms = get_option('yidpod_search_term');
			if(isset($terms[$term])){
				$special = true;
				$terms = str_replace(","," ",$terms[$term]);

				$episode_select = "MATCH (title) AGAINST ('$term $terms' IN BOOLEAN MODE) as almost,";
				$podcast_select = "MATCH (p.post_title) AGAINST ('$term $terms' IN BOOLEAN MODE) as almost,";
				$episodewhere .= " AND (MATCH (title) AGAINST ('$term $terms' IN BOOLEAN MODE))";
				$podcastwhere .= " AND (MATCH (p.post_title) AGAINST ('$term $terms' IN BOOLEAN MODE))";
				
			}else{
				$episode_select = "MATCH (title) AGAINST ('".'"'.$term.'"'."' IN BOOLEAN MODE) as exact, MATCH (title) AGAINST ('$term*' IN BOOLEAN MODE) as almost,";
				$podcast_select = "MATCH (p.post_title) AGAINST ('".'"'.$term.'"'."' IN BOOLEAN MODE) as exact, MATCH (p.post_title) AGAINST ('$term*' IN BOOLEAN MODE) almost,";
				$episodewhere .= " AND (MATCH (title) AGAINST ('".'"'.$term.'"'."' IN BOOLEAN MODE) OR MATCH (title) AGAINST ('$term*' IN BOOLEAN MODE))";
				$podcastwhere .= " AND (MATCH (p.post_title) AGAINST ('".'"'.$term.'"'."' IN BOOLEAN MODE) OR MATCH (p.post_title) AGAINST ('$term*' IN BOOLEAN MODE))";
			}
			
	}
	
	
	$podcast_select .= "p.id AS id,CASE WHEN pm3.meta_value is NULL then '' ELSE pm3.meta_value END as author,p.post_title as title, concat('https://yidpod.com','/wp-content/uploads/',pm2.meta_value) AS image_uri,p.post_date as published_date,'0' as duration,'0' as podcast_id,'podcast' as type,'' as e_index,p.post_status, p.post_type";
	$episode_select .= "id,author,title,image_uri,published_date,duration,podcast_id";
	$episodequery = "(SELECT $episode_select,'episode' as type,e_index,'' as post_status,'t' as post_type,'' as 'tags',url from $episode_table_name WHERE ".$episodewhere.')';
	$podcastquery = "(SELECT $podcast_select,GROUP_CONCAT(t.`name`) as tags,'' as url from $podcast_table_name as p LEFT JOIN `wp_postmeta` AS pm1 ON p.id = pm1.post_id".
	" INNER JOIN `wp_postmeta` AS pm2 ON pm1.meta_value = pm2.post_id".
	" AND pm2.meta_key = '_wp_attached_file'".
	" AND pm1.meta_key = '_thumbnail_id' LEFT OUTER JOIN `wp_postmeta` as pm3 on pm3.post_id = id AND pm3.meta_key = 'podcast_author' LEFT JOIN wp_term_relationships tr
    on (p.id=tr.object_id)
LEFT JOIN wp_term_taxonomy tt
    on (tt.term_taxonomy_id=tr.term_taxonomy_id
    and tt.taxonomy='post_tag')
LEFT JOIN wp_terms t
    on (tt.term_id=t.term_id) WHERE $podcastwhere GROUP BY p.id)";
	$query = "";
	if($type == 'shows'){
		$query = $podcastquery;
	}
	if($type == 'episodes'){
		$query = $episodequery;
	}
	if($type == 'showsandepisodes'){
		$query = $podcastquery.' UNION '.$episodequery;
	}
	$offset = 0;
	if(isset($_GET['offset'])){
		$offset = $_GET['offset'];
	}

	if(isset($special)){
		$query.=' ORDER BY almost desc,INSTR(title,"'.$term.'"),title, published_date DESC LIMIT '.$limit.' OFFSET '.$offset;

	}else{
		$query.=' ORDER BY exact desc,almost desc,INSTR(title,"'.$term.'"),title, published_date DESC LIMIT '.$limit.' OFFSET '.$offset;

	}
	if(isset($_GET['debug'])){
		

	echo ($query);
	$episodes = $wpdb->get_results($query);
	return $episodes;
	die();
	}

	$episodes = $wpdb->get_results($query);

	return($episodes);
	die();
}



add_action("wp_ajax_subscribe_podcasts2", "subscribe_podcasts2");
add_action("wp_ajax_nopriv_subscribe_podcasts2", "subscribe_podcasts2");

function subscribe_podcasts2(){

	$response = array("valid"=>false,"msg"=>"","message"=>"");
    global $wpdb;
	$id = $_POST['subscribe'];
	$text = $_POST['text'];

	$table_name = $wpdb->prefix."yp_subscribe";



	$current_user_id = get_current_user_id(); // Alternative for getting current user ID
    $key = 'subscribe_show';
	$data = array();


	if(!is_user_logged_in()){

	
			$getdata = $_COOKIE['subscribe_show'];


			if(isset($getdata) && !empty($getdata)){
		
		$unserialize= unserialize( base64_decode( $getdata) );
     	$data = $unserialize;
		$data[] = $id;
		$data =  array_unique($data);
           
           if($text == "unsubscribe"){
				$key1 = array_search($id, $data, true);
				if ($key1 !== false) {
				unset($data[$key1]);
				}
			}

	}
	else{
       $data[] = $id;
	
	}


	 $serialize = base64_encode(serialize($data));

	$response['data'] = $serialize;

	$response['data1'] = $data;

			
		

	}
	else{

		// subscribe by user ID
		$subscribed = get_user_meta($current_user_id,'yidpod_subscribed',true);

        $result = $wpdb->get_row($wpdb->prepare( "SELECT * FROM $table_name WHERE user_id = $current_user_id AND podcast_id = $id" ));

		if ($result === FALSE || $result < 1) {
			$wpdb->insert($table_name, array('user_id'=>$current_user_id,'podcast_id'=>$id,'subscribed'=>time()));

			if($subscribed != ""){
			$subscribed = explode(',',$subscribed);
			}else{
			$subscribed = [];
			}

			array_push($subscribed,$id);
			update_user_meta($current_user_id,'yidpod_subscribed',implode(",",$subscribed));
		}
		elseif($result > 0 && $text == "unsubscribe" ){


            if($subscribed != ""){
				$subscribed = explode(',',$subscribed);

				$key1 = array_search($id, $subscribed, true);
				if ($key1 !== false) {
				unset($subscribed[$key1]);
				}

				update_user_meta($current_user_id,'yidpod_subscribed',implode(",",$subscribed));

                 $resultresponse = $wpdb->query( "DELETE FROM $table_name WHERE podcast_id = '$id' AND user_id = '$current_user_id'" );

                 if($resultresponse)
                 $response['msg'] = "Deleted successfully";


			}


		}

		
	// End subscribe by user ID


	}

	if($text == "subscribe"){
		$response['valid'] = true;
		$response['message'] = "unsubscribe";
	}
	else{
		$response['message'] = "subscribe";
		$response['valid'] = true;
	}

// Update current user's first name
	if(!is_user_logged_in()){

		$cookies = setcookie( 'subscribe_show', $serialize, time() + 360000, COOKIEPATH, COOKIE_DOMAIN   );

	}
		else{
			//update_user_meta( $current_user_id, $key, $serialize );
		}



  wp_send_json( $response );
 die;

}


add_action("wp_ajax_sign_up_letter_ajx", "sign_up_letter_ajx");
add_action("wp_ajax_nopriv_sign_up_letter_ajx", "sign_up_letter_ajx");


function sign_up_letter_ajx(){

	$response = array('valid'=>false,'msg'=>'');
	$temp_user_id = $_POST['temp_user_id'];
	$response['COOKIEPATH'] = COOKIEPATH;
	$response['COOKIE_DOMAIN'] = COOKIE_DOMAIN;
$cookies = setcookie( 'sign_up_letter1', $temp_user_id, time() + 36000000,'/');

$response['cookies'] = $cookies;
$response['temp_user_id'] = $temp_user_id;

wp_send_json( $response );
 die;

}


/*add_action( 'init', 'my_setcookie' );
function my_setcookie() {
setcookie( 'my-name', 'my-value', time() + 3600, COOKIEPATH, COOKIE_DOMAIN   );
}
*/

// for ip address

function start_session() {
	// start session if not start
    if( !session_id() ) {
        session_start();
    }
    // setup cookies by default 
	setcookie( TEST_COOKIE, 'WP Cookie check', 0, SITECOOKIEPATH, COOKIE_DOMAIN, 1 );
	setcookie( 'wp_lang', 'en_US ', 0, COOKIEPATH, COOKIE_DOMAIN, 1 );

}
add_action('init', 'start_session', 1);


// update cookies for podcast

add_action("wp_ajax_cookie_update_time", "cookie_update_time");
add_action("wp_ajax_nopriv_cookie_update_time", "cookie_update_time");


function cookie_update_time(){

	$response = array('valid'=>false,'msg'=>'');
	$data = $_POST['data'];
   
	$serialize = base64_encode(serialize($data));

	$cookies = setcookie( 'podcast_last_play_id', $serialize, time() + 3600, COOKIEPATH, COOKIE_DOMAIN   );

	$results = unserialize( base64_decode( $serialize) );


	$response['cookies'] = $cookies;

	$response['data'] = $data;
	

wp_send_json( $response );
 die;

}

// update listen history for podcast

add_action("wp_ajax_listenhistoryupdate", "listenhistoryupdate");
add_action("wp_ajax_nopriv_listenhistoryupdate", "listenhistoryupdate");


function listenhistoryupdate(){

	$response = array('valid'=>false,'msg'=>'');
	$episodeid = $_POST['episodeid'];


	if(is_user_logged_in()){
        $current_user_id = get_current_user_id();
		$listenHistory = get_user_meta($current_user_id,'listen_history',true);
		$data = array();

		if(isset($listenHistory) && !empty($listenHistory)){

				$data = unserialize( base64_decode( $listenHistory) );

				if(!in_array($episodeid, $data)){
					$data[] = $episodeid;
		 		}

			}
			else{
				$data[] = $episodeid;
			}

             $response['before'] = $data;
			$serialize = base64_encode(serialize($data));

			$cookies = update_user_meta($current_user_id,'listen_history',$serialize);

			$response['cookies'] = $cookies;



	}else{


		    $listenHistory = $_COOKIE['listen_history'];

			$data = array();

			if(isset($listenHistory) && !empty($listenHistory)){

				$data = unserialize( base64_decode( $listenHistory) );

				if(!in_array($episodeid, $data)){
					$data[] = $episodeid;
		 		}

			}
			else{
				$data[] = $episodeid;
			}

			$response['before'] = $data;
		     
			$serialize = base64_encode(serialize($data));

			$cookies = setcookie( 'listen_history', $serialize, time() + 36000000, COOKIEPATH, COOKIE_DOMAIN   );

			$response['cookies'] = $cookies;

	}

	

	$response['data'] = $data;
	

wp_send_json( $response );
 die;

}


//  listen history record

add_action("wp_ajax_listenHistory_record", "listenHistory_record");
add_action("wp_ajax_nopriv_listenHistory_record", "listenHistory_record");


function listenHistory_record(){

	global $wpdb;

	$response = array('valid'=>false,'msg'=>'','login'=>false);
    
	
		$response['login'] = true;
	

	$tab = $_POST['tab'];

	$listenHistory = $_COOKIE['listen_history'];

	if(is_user_logged_in()){
		 $current_user_id = get_current_user_id();
		$listenHistory = get_user_meta($current_user_id,'listen_history',true);
	}

	$data = array();

	$list = array();

	if(isset($listenHistory) && !empty($listenHistory)){

		$data = unserialize( base64_decode( $listenHistory) );
		$implode = implode(",", $data);
         $table_name = $wpdb->prefix."episode";
		$limit = 15;
		$offset = 0;
		$sql = "SELECT * from  $table_name WHERE id IN ($implode) ORDER BY FIELD(id,$implode) DESC";
	    $results = $wpdb->get_results($sql);
		foreach ($results as $key => $value) {

			   

			   $time = timeDurationFormat2($value->duration);

			   $formatted_date = date('m/d/Y', $value->published_date);



			   $titlename = str_replace("'","",$value->title);

			   $shows_name = get_the_title($value->podcast_id);

			   $shows_name = str_replace("'","",$shows_name);

			    $fileurl  = str_replace("'","",$value->url);

			    $listItem = array("name"=>$titlename,"file"=>$fileurl,"duration"=>$time,"image"=>$value->image_uri,"shows_name"=>$shows_name,"formatted_date"=>$formatted_date,"eid"=>$value->id,'podcast_url'=>get_permalink($value->podcast_id ));
			 	
			      // $list .= "{ name:'Artist ".$authorname." - Audio ".$titlename."',file:'".$value->url."',duration:'".$time."',image:'".$value->image_uri."',shows_name:'".$shows_name."'},";
			   //$list .= "{ name:'".$titlename."',file:'".$fileurl."',duration:'".$time."',image:'".$value->image_uri."',shows_name:'".$shows_name."',formatted_date:'".$formatted_date."',eid:'".$value->id."'},";

			    $list[] = $listItem;
	 }


	}
	

	$response['sql'] = $sql;
	$response['data'] = $list;


wp_send_json( $response );
 die;

}
function delete_unattached_attachments(){
	$attachments = get_posts( array(
	'post_type' => 'attachment',						
	'numberposts' => -1,	 	  								
	'fields' => 'ids', 
	'post_parent' => 0,
		));			
	$sizes = [];
	$fullsize = 0;
// 	return count($attachments);
		if ($attachments) {		 		
			foreach ($attachments as $attachmentID){
// 				$attachment_path = get_attached_file( $attachmentID); 
// 				//Delete attachment from database only, not file
// 				$delete_attachment = wp_delete_attachment($attachmentID, true);
// 				//Delete attachment file from disk
// 				$delete_file = unlink($attachment_path);		
				$attachment_filesize =  filesize( get_attached_file( $attachmentID ) );
				$sizes[] =['size'=>$attachment_filesize];
				$fullsize += $attachment_filesize;
			}					
		}
	return size_format($fullsize);
}
add_action( 'rest_api_init', function () {
  register_rest_route( 'myplugin/v1', '/delete-attachments', array(
    'methods' => 'GET',
    'callback' => 'delete_unattached_attachments',
  ) );
} );
