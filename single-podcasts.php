<?php
/*


template name: Player Template

*/

$id = (isset($_GET['podcast']))?$_GET['podcast']:get_the_ID();

if(isset($id) && !empty($id)){
	$data = saveRecentPodcast($id);
   saveRecentPodcastCookies($id);
	$last_podcast_idValue = setcookie( 'last_podcast_id', $id, time() + 3600, COOKIEPATH, COOKIE_DOMAIN   );
}

$episode_id = $_GET['episode_id'] ?? null;
$single_page_id = $id;
get_template_part('player/header-player'); 
global $post;

?>
 
<div id="main-content">
           <div class="cs-row">
            <div class="cs-sidebar">
			<?php include('player/sidebar.php'); ?>
			</div>
			
            <div class="cs-content">
			<?php include('player/search-bar.php'); ?>
                <div class="cs-featured-content">
					 
					
					 <div class="inner__content">
					 	 <div class="cs-content-search">
					 </div>
					 <?php if($episode_id){
									include "ajax_template/single_description.php";

							}else { ?>
                        <div class="podcast-single-content">
							
							 <div class="text-info">
							   <div class="cs-row">
								   <div class="cs-podcast-thumbnail">
									  <?php the_post_thumbnail('medium'); ?>
								   </div>
								   <div class="cs-podcast-text">
								      <h2><?php the_title(); ?></h2>
									  <h4 class="sub-title-top"><?php echo get_post_meta( $post->ID, 'podcast_author', true ); ?></h4>
									  <div class="podcast-description">
										  <div class="cs-rdmore">
											<div class="cs-des">
											<?php
											
												$content =  strip_tags(get_the_content());
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
												$post_id =  get_the_ID();
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
													 <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a>
													 <a target="_blank" href="https://twitter.com/intent/tweet?via=<?php the_permalink(); ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a>
													 <a target="_blank" href="https://api.whatsapp.com/send?text=<?php the_permalink(); ?>"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
													 <a target="_blank" href="https://t.me/share/url?url={<?php the_permalink(); ?>}"><i class="fa fa-telegram" aria-hidden="true"></i></a>
												  </div>
												</div>
										   </div>
									  </div>
								   </div>
							   </div>
							    
							</div>
							
							<div class="cs-track-container">
								<?php 
								
									include('player/podcast-track-items.php');

								
								?>
							</div>
						</div>
						<?php } ?>
					
                     <input type="hidden" name="single_page_id" id="single_page_id" value="<?= get_the_ID() ?> ">
					</div>
				</div>
            </div>
          </div>
		  <?php include('player/mini-player.php'); ?>

</div>

<?php get_template_part('player/footer-player'); ?> 

<style type="text/css">
	.moreclass .more__text {
		display: block !important;
	}

</style>
