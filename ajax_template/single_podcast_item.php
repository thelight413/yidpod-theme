<?php 





  global $wpdb;
 $table_name = $wpdb->prefix."episode";
$post_id = get_query_var( 'post_id' );
$sql = "SELECT * from  $table_name WHERE podcast_id='$post_id' order by published_date DESC ";
$results = $wpdb->get_results($sql);
$shows_name = get_the_title($post_id);


$playlist_track_ctn = "";
$index = 0;


foreach ($results as $key => $value) {


       $time = setTimeDuration($value->duration);

       $time = timeDurationFormat($time);

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
 <div class="podcast-single-content">
							 <div class="text-info">
							   <div class="cs-row">
								   <div class="cs-podcast-thumbnail">
									  <?php echo get_the_post_thumbnail($post_id,'medium'); ?>
								   </div>
								   <div class="cs-podcast-text">
								      <h2><?php echo get_the_title($post_id); ?></h2>
									  <h4 class="sub-title-top"><?php echo get_post_meta( $post_id, 'podcast_author', true ); ?></h4>
									  <div class="podcast-description">
										  <div class="cs-rdmore">
											<div class="cs-des">
											<?php
											
												$content =  strip_tags(get_the_content($post_id));
												$contentLength = strlen($content);

												if($contentLength > 150)
												{
	                                                 $more_text_class = '<span>... </span><a class="more">Show more</a>';
													 $htmlData1 = substr($content, 0, 150);
													 $htmlData2 = substr($content, 150, $contentLength);
													 $updateHtml = $htmlData1.'<div class="more__text" style="display:none">'.$htmlData2.'</div><div class="intro" style="display:block">'.$more_text_class.'</div>';
													 echo $updateHtml;

												}
												else
												{
													echo $content;
												}

											 ?>
										 </div>
										  </div>
									  </div>
									  <div class="cs-row cs-botm">
										   <div class="cs-podcast-subscribe">
										   <?php 
										   if(isset($post_id) && !empty($post_id)) {

              $key = 'subscribe_show';
              $text = "subscribe";
              $current_user_id = get_current_user_id();
			  $getdata = get_user_meta( $current_user_id, "yidpod_subscribed", true );


			  if(isset($getdata) && !empty($getdata)){
                   $unserialize = explode(',',$getdata);

		           if (in_array($post_id, $unserialize))
		           	$text = "unsubscribe";

		       }

		       if(!is_user_logged_in()){
             	$getdata = $_COOKIE['subscribe_show'];
             	$unserialize= unserialize( base64_decode( $getdata) );
             	
             	if (in_array($post_id, $unserialize))
		           	$text = "unsubscribe";
             	
             }
										   }

			 ?>
										   
										   
										   
										   
											 <div class="episode-subcribe">
											 <?php
												if(!is_user_logged_in()){ ?>
													<a href="<?php the_permalink(2531); ?>" class="login-btn">Login to Subscribe</a>
												<?php }else{ ?>
												<button id="episode_subscribe" data-id="<?= $post_id; ?>"><?= $text ?></button>
											<?php } ?>
											</div>
										   </div>
										   <div class="cs-podcast-btns">
											   <div class="share-podcast">
												 
												 <div class="links-podcast">
													 <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink($post_id); ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a>
													 <a target="_blank" href="https://twitter.com/intent/tweet?via=<?php the_permalink($post_id); ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a>
													 <a target="_blank" href="https://api.whatsapp.com/send?text=<?php the_permalink($post_id); ?>"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
													 <a target="_blank" href="https://t.me/share/url?url={<?php the_permalink($post_id); ?>}"><i class="fa fa-telegram" aria-hidden="true"></i></a>
												  </div>
												</div>
										   </div>
									  </div>
								   </div>
							   </div>
							    
							</div>
							
							<div class="cs-track-container">
							   <div class="playlist-ctn new_playlist" style="display: block !important;height: auto;">
							   	<?= $playlist_track_ctn ?>
							   </div>
							</div>
							<input type="hidden" name="single_page_id" id="single_page_id" value="<?= $post_id ?>">
							<input type="hidden" name="playtrackstatus" id="playtrackstatus" value="new">
						</div>

<?php


$id = (isset($_GET['podcast']))?$_GET['podcast']:get_the_ID();

if(isset($id) && !empty($id)){
	$data = saveRecentPodcast($id);
   saveRecentPodcastCookies($id);
	$last_podcast_idValue = setcookie( 'last_podcast_id', $id, time() + 3600, COOKIEPATH, COOKIE_DOMAIN   );
}

?>


						
						<script>
/*------------------ Read more button ----------------*/



</script>

<!-- css for show more and less -->
<style type="text/css">
				.moreclass .more__text {
		display: block !important;
		}

</style>