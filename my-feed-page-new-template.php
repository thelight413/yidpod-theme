<?php
/*


template name: my feed new template

*/


if(isset($_GET['podcast']) && !empty($_GET['podcast'])){
    $id = $_GET['podcast'];
	$data = saveRecentPodcast($id);
}







get_template_part('player/header-player'); ?>

<div id="main-content">
           <div class="cs-row">
            <div class="cs-sidebar">
			<?php include('player/sidebar.php'); ?>
			</div>
			
            <div class="cs-content">
			<?php include('player/search-bar.php'); ?>
                <div class="cs-featured-content">
					<!--<div class="category-area"><?php include('player/categories.php'); ?></div>-->

					 
					 <div class="inner__content">
					 	<?php
 global $wpdb;
$user_id = get_current_user_id();
$episode_table = $wpdb->prefix.'episode';
$subscribe_table = $wpdb->prefix.'yp_subscribe';




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
                    <h2>Please login to view your feed</h2>
                    <a href="<?php the_permalink(2531); ?>" class="login-btn">Login</a>
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



					</div>

				</div>

            </div>
          </div>
		  <?php get_template_part('player/mini-player'); ?>

</div>

<?php get_template_part('player/footer-player'); ?> 
<script>
jQuery(document).on("click",".menu-item-11868 a",function(e){
	e.preventDefault();
	var page_url = 'https://yidpod.com/browse-episodes';
	window.history.pushState('page', '', page_url);
	jQuery('.menu-item').removeClass("active");
	jQuery('.menu-item-11868').addClass("active");
	jQuery("#loader-inner").css("display","block");
	var playlist_ctn = jQuery(".playlist-ctn").html();
	jQuery.ajax({
                             type : "post",
                             url : "/wp-admin/admin-ajax.php",
                             data : {action: "get_browse_episodes_content","page":"episodes"},
                             success: function(response) {
                               jQuery(".inner__content").html(response.result);
                               jQuery("#loader-inner").css("display","none");
                               if(playlist_ctn.length > 0){
                               	jQuery(".playlist-ctn").html(playlist_ctn)
                               }
                               
                             },
                          }); 

});

//jQuery('.menu-item-11868 a').trigger('click');




jQuery(document).on("click",".browse-episodes .podcasts .podcast a, .browse-episodes .podcast-item a",function(e){

e.preventDefault();
var podcasturl = jQuery(this).attr("href");
window.history.pushState('page', '', podcasturl);
   jQuery("#loader-inner").css("display","block");
    
		 jQuery.ajax({
		 type : "post",
		 url : "/wp-admin/admin-ajax.php",
		 data : {action: "get_single_episode_item","podcasturl":podcasturl},
		 success: function(response) {  
		 jQuery(".inner__content").html(response.result);
		 jQuery("#loader-inner").css("display","none");
		 document.documentElement.scrollTop = 0;
		 },         
	 });
 
});


jQuery(document).ready(function(){
	jQuery(".menu-web-player-container").find("ul li").each(function(){
		jQuery(this).removeClass('active');
	});

	jQuery('.menu-item-3049').addClass("active");

	jQuery("#tabs-nav li:eq(0)").trigger("click");
});

</script>

