 <?php
 global $wpdb;
$user_id = get_current_user_id();
$episode_table = $wpdb->prefix.'episode';
$subscribe_table = $wpdb->prefix.'yp_subscribe';


// // time duration

// function timeDurationFormat($duration){

// 	$myArray = explode(":",$duration);
// 	$length = count($myArray);

// if($length == 1){
//        $duration1 = ((int)($duration/60));
//        $duration2  = ($duration%60);
//        return $duration1.":".$duration2;
//     }

//      if($length == 3 && strpos($duration, '::') !== true)
//      {
//        $time1 = $myArray[0];
//        $time2 = $myArray[1];
//        $time3 = $time1 * 60;
//        $time4 = $time3 + $time2;

//        $duration = $time4.":".$myArray[2];
//        $duration = str_replace(":0",":",$duration);
//      }


//      if($length == 2 && ($myArray[1] == "" || $myArray[1] == "00")){
//        $time1 = $myArray[0];      
//        $duration = $time1.":0";
//      }elseif($length == 2 && ($myArray[1] != "" || $myArray[1] != "00"))
//      {
     
// 		$time1 = $myArray[0];
// 		$time2 = $myArray[1];

// 		$duration = $time1.":".$time2;

// 		if($time2.length > 1)
// 		$duration = str_replace(":0",":",$duration);
       
//      }
     
//      return $duration;
     
//    }



$limit = 300;
$offset = 0;
if(!is_user_logged_in()){
  $getdata = $_COOKIE['subscribe_show'];
  $unserializeData= unserialize( base64_decode( $getdata) );
  $implodeData = implode(",",$unserializeData);
  $query = "SELECT *,DATE_FORMAT(FROM_UNIXTIME(`published_date`), '%m/%d/%Y') AS formatted_date from ".$episode_table." WHERE podcast_id in (".$implodeData.") order by published_date DESC  LIMIT ".$limit." OFFSET ".$offset;
}
  else{
    $query = "SELECT *,DATE_FORMAT(FROM_UNIXTIME(`published_date`), '%m/%d/%Y') AS formatted_date from ".$episode_table." WHERE podcast_id in (SELECT podcast_id from ".$subscribe_table." where user_id = '".$user_id."') order by published_date DESC  LIMIT ".$limit." OFFSET ".$offset;
  }

// latest episodes new

  /*$prefix = $wpdb->prefix;
$episodeTable = $prefix."episode"; 
$postmetaTable = $prefix."postmeta";
$query = "SELECT * from $episodeTable LEFT JOIN `$postmetaTable` AS pm1 ON pm1.post_id = podcast_id AND pm1.meta_key='hide_episodes_in_search' WHERE 1=1 and duration != '00:00' and duration != '0' and duration != '00:00:00' and duration is not null AND (pm1.meta_value is null or pm1.meta_value = '') ORDER BY published_date DESC LIMIT 50";*/

// end latest episodes new


    $query = "SELECT *,DATE_FORMAT(FROM_UNIXTIME(`published_date`), '%m/%d/%Y') AS formatted_date from ".$episode_table." WHERE podcast_id in (SELECT podcast_id from ".$subscribe_table." where user_id = '".$user_id."') order by published_date DESC  LIMIT ".$limit." OFFSET ".$offset;


$results = $wpdb->get_results($query);
$playlist_track_ctn = "";
$index = 0;
$shows_name = "";


foreach ($results as $key => $value) {

       $shows_name = get_the_title($value->podcast_id);
       //$time = setTimeDuration($value->duration);

       $time = timeDurationFormat($value->duration);

       $formatted_date = date('m/d/Y', $value->published_date);

       $titlename = preg_replace('/[^A-Za-z0-9\-]/', ' ', $titlename);

       $titlename = RemoveSpecialChar($value->title);

       $shows_name = RemoveSpecialChar($shows_name);

        $fileurl  = str_replace("'","",$value->url);

        $day = dayDifference($formatted_date);

        $playlist_track_ctn .= '<div class="playlist-track-ctn" id="ptc-'.$index.'" data-index="'.$index.'" ><img src="'.$value->image_uri.'" width="100" height="100"><div class="playlist-info-track" data-eid="'.$value->id.'" id="playlistinfotrack-'.$index.'">'.$titlename.'<div class="section__container" id="section__container'.$index.'"><span><i class="fa fa-calendar" aria-hidden="true"></i> '.$day.'</span><span><i class="fa fa-clock-o" aria-hidden="true"></i> '.$time.'</span></div></div><div class="playlist-btn-play" id="pbp-'.$index.'" data-index="'.$index.'"><i class="fa fa-play" height="40" width="40" id="p-img-0"></i></div></div>';
        $index++;
	 }

 ?>

 <div class="cs-content-search">
					 </div>
					 <div class="cs-content-feed">
					 <h3>My Feed</h3>
					 <div class="tabs">
					  <ul id="tabs-nav">
						<li class="active"><a href="#" data-id="tab1">Latest Episodes</a></li>
						<li><a href="#" data-id="tab2">Listening History</a></li>
					  </ul> <!-- END tabs-nav -->
					  <div id="tabs-content">
						<div id="tab1" class="tab-content" style="display: block">
            <?php
            if(!is_user_logged_in()){ ?>
                  <div class="not-login-wrpr">
                    <h2>The latest episodes from podcasts you've subscribe to will appear here</h2>
                    <a href="<?=site_url() ?>/browse-episodes" class="login-btn">Browse Podcasts</a>
                  </div> 
            <?php }else{ ?>


						   <div class="cs-track-container">
							   <div class="playlist-ctn new_playlist1" style="display: block !important;height: auto;">
							   	<?= $playlist_track_ctn ?>
							   </div>
							</div>
            <?php } ?>  
						</div>
						<div id="tab2" class="tab-content">
						  ....
						</div>
					  </div> <!-- END tabs-content -->
					</div> <!-- END tabs -->
					  
					  
					 </div>