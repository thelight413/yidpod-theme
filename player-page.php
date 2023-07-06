<?php
/*


template name: Player Template

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
					<!--<div class="category-area"><?php //include('player/categories.php'); ?></div>-->

					 
					 <div class="inner__content">
					 	<div class="cs-content-search"></div>
                     <?php if(isset($_GET['podcast']) && !empty($_GET['podcast'])){ ?>
                     	
					<div class="playlist-ctn" style="display: block !important;height: auto;"></div>

						<?php }  else { ?>

                     
                   



					   <?php /*while ( have_posts() ) : the_post(); the_content();  endwhile; */
					   $cat = '';
					   if(!empty($_GET['cat'])){
						    $cat = $_GET['cat'];
						    $shortcode_cat = '[yidpod_category category_slug="'.$cat.'"]';
					   		echo do_shortcode($shortcode_cat);
					   }
						/*else if(isset($_GET['podcast']) && !empty($_GET['podcast'])){
							$category = get_the_terms( $_GET['podcast'], 'category' );     
							foreach ( $category as $cat){
							$shortcode_cat = '[yidpod_category category_slug="'.$cat->slug.'"]';
							echo do_shortcode($shortcode_cat);
							echo "<br><br>";
							}

						}
					   */
					   else{
						   // Added recently view items
					   	   $getdata = $_COOKIE['recently_view'] ?? null;
						    if(is_user_logged_in() || !empty($getdata)){
							   include('player/recently-view.php'); 
							}
						   
						   
						      $cat_option = get_option('yidpod_option_name');
							  $terms = explode(",",$cat_option);
						      
                               if(!empty($terms)){ 
						            $i = 0;
									foreach($terms as $cat){
										$i++;
										
										 $term = get_term( $cat, 'category' );
                                         $cat_slug = $term->slug;
										 $shortcode_cat = '[yidpod_category category_slug="'.$cat_slug.'" class_id="category_'.$i.'"]';
					   		             echo do_shortcode($shortcode_cat);
									}
						   
						   
						        }
						    
						   
						 /*  $cat = 'entertainment';
						    $shortcode_cat = '[yidpod_category category_slug="'.$cat.'"]';
					   		echo do_shortcode($shortcode_cat);
						   */
						    
					   }
					  
					   //echo '<div class="div_id__2805">';
					   $shortcode_episodes = '[yidpod_episodes podcast_id="2805" limit="10" ]';
					   //echo '</div>';
					   $shortcode_search = '[yidpod_episodes search="Kedoshim"]';

					   

					  }
	
					   
					   ?>
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

</script>

