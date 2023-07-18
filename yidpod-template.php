<?php
/*


template name: Yidpod new template

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
					<!--- inner 22-->					 
					 <div class="inner__content">
					 	<?php the_content() ?> 
					</div>

				</div>
            </div>
          </div>
		  <?php include('player/mini-player.php'); ?>

</div>

<?php get_template_part('player/footer-player'); ?> 
<script>


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

	jQuery('.menu-item-11868').addClass("active");
});
</script>

