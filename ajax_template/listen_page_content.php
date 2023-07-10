<?php
/**
 * Browse Shows page
 */
 $getdata = $_COOKIE['recently_view'];
 
 $cat_option = get_option('yidpod_option_name');
 $terms = explode(",",$cat_option);
						    if(is_user_logged_in() || !empty($getdata)){


							   global $wpdb;

					          $table_name = $wpdb->prefix."episode";
					

							$current_user_id = get_current_user_id(); // Alternative for getting current user ID
							$key = 'recently_view';
							$getdata = get_user_meta( $current_user_id, $key, true );

	                        if(!is_user_logged_in()){
	                        	$getdata = $_COOKIE['recently_view'];
	                        }

                        //update_user_meta( $current_user_id, 'recently_view', '' );
						if(isset($getdata) && !empty($getdata)){


							if(!is_user_logged_in()){
								$unserialize = unserialize( base64_decode( $getdata) );
							}
								else{
									$unserialize = unserialize($getdata);
								}
						

                        
						$unserialize = array_unique($unserialize);
						$unserialize = array_reverse($unserialize);
						 
                       if(isset($unserialize)){
						   
						$datarecord_container = '<div class="cs-content-search"></div>';

                               $countRecord = 0;
                               $datarecord = "";
                               $args = array('post_type' => 'podcasts','post__in'=> $unserialize, 'orderby'=>'post__in','posts_per_page'=> -1);
								// The Query
								$the_query = new WP_Query( $args );

                                 

								 while($the_query -> have_posts())
								   {
									  $the_query -> the_post();
									  $post_id = get_the_ID();
									  $category_detail=get_the_category( $post_id );
									  $cat_id = $category_detail[0]->term_id;
									  if(in_array($cat_id, $terms)){
									  	$countRecord++;
									  $datarecord .= '<div class="podcast-item">

								   <a href="'.get_the_permalink($post_id).'">
									<div class="podcast-image">

									'.display_lazy_loaded_podcast_image($post_id,array(200,200)).'</div>
									<div class="podcast_title" title="'. substr(get_the_title($post_id), 0, 80) .'">'. substr(get_the_title($post_id), 0, 80).'</div>
									</a>
									</div>';
									}
									  
								   }

								if($countRecord > 0){
									$datarecord_container .= '<div class="recently_view">
									<div class="yidpod_title rcp">Recently Played</div><div class="recently-view-posts owl-carousel owl-theme">';
									$datarecord_container .= $datarecord;
									$datarecord_container .= '</div></div>';
								}

						

						echo $datarecord_container;

                       }
                       
						}


                     ?>
			
			
<script>
var owl = $('.recently-view-posts');
owl.owlCarousel({
    loop:false,
	nav:true,
    margin:20,
    autoplay:false,
    autoplayTimeout:3000,
    autoplayHoverPause:true,
	 responsive:{
        0:{
           items:2, 
        },
        500:{
            items:3
        },
        1000:{
            items:4
        },
		1150:{
            items:5
        },
		1320:{
            items:5
        },
		1540:{
            items:6
        },
		1760:{
            items:7
        }
    }
});
 
</script>

<?php 
							}
						   
						   
						      
						      
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
?>