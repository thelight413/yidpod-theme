 <?php 
       
		   // recently view 


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
						  
						$class_per_cat = 'xyz-recent';
						$classes = " horizontal"; 
						$per_cat = '.'.$class_per_cat;
						 ?>

						<div class="category_page <?php echo $class_per_cat; ?>">
						
								<?php  
								 $args = array('post_type' => 'podcasts','post__in'=> $unserialize, 'orderby'=>'post__in','posts_per_page'=> 50);
								 // The Query
								 $the_query = new WP_Query( $args );
								 $total = $the_query->found_posts;
								if($total >5){
									?>
									<div class="arrows">
										<div class="left-arrow">
										<i class="fa fa-arrow-left"></i>
										</div>
										<div class="right-arrow"> <i class="fa fa-arrow-right"></i></div>
									</div>
									<?php
								}
								?>
								<div class="yidpod_title">Recently Played</div>
								<div class="podcasts <?php echo $classes; ?> hello">

								<?php  while($the_query -> have_posts())
						              {
							            $the_query -> the_post();
							            $post_id = get_the_ID();								  
									?>    
										
											<div class="podcast">
												<a href="<?php echo get_the_permalink($post_id); ?>">
													<div class="podcast_image">
														<?php echo display_lazy_loaded_podcast_image($post_id,array(200,200)); ?>
													</div>
													<div class="podcast_title"><?php echo get_the_title(); ?></div>
												</a>
											</div>
									<?php  } ?>
								</div>
								<?php yidpod_arrows_html('.category_page','.podcasts',$per_cat);  ?>
								
							</div>

<?php
                       }
                       
		}
                     ?>
			
 