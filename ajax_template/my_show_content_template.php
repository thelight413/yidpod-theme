<?php
/**
 * My Shows page
 */
if(!is_user_logged_in()){ ?>
      <div class="not-login-wrpr">
        <h2>Please login to view your shows</h2>
        <a href="<?php the_permalink(2531); ?>" class="login-btn">Login</a>
      </div> 
<?php }else{ ?>

<div class="cs-content-search">
					 </div>
					 <div class="cs-content-feed cs-my-show">
					 <h3>My Shows</h3>
          
                      <?php

                       global $wpdb;
                       $current_user_id = get_current_user_id();
                        $table_name = $wpdb->prefix."yp_subscribe";

                        // get result from yp_subscribe table
                        $result_1 = $wpdb->get_results("SELECT * FROM $table_name WHERE user_id = $current_user_id");
                        
                                          
                      $key = 'subscribe_show';
                      
                      $getdata = get_user_meta( $current_user_id, "yidpod_subscribed", true );

                        if($getdata != ""){
                        $unserialize = explode(',',$getdata);
                        }
                      //$unserialize = unserialize($getdata);

                      if(!is_user_logged_in()){
                            
                            $getdata = $_COOKIE['subscribe_show'];
                            $unserialize = unserialize( base64_decode( $getdata) );

                      } 

                      if(isset($getdata) && !empty($getdata)){
                      

                      


                      if(count($unserialize) >0){
                      ?>
                      <div class="podcasts_list">
                      <?php
                      foreach($unserialize as $result){
                        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $result ), 'single-post-thumbnail' );

                      ?>

                      <div class="podcast">
                      <a href="<?= get_the_permalink($result); ?>">
                      <div class="podcast_image">

                      <img width="200" height="200" src="<?= $image[0] ?>" class="attachment-large size-large wp-post-image" alt="" loading="lazy">            </div>
                      <div class="podcast_title"><?= get_the_title($result) ?></div>
                      </a>
                      </div>

                      <?php } ?>
                       </div>
                      <?php 
					  }else{
						  echo '<p class="not-found">No record found</p><p class="browse-btn"><a href="'.get_the_permalink(2876).'">Browse Shows</a></p>';
					  }  }
                              else{
                       
                       echo '<p class="not-found">No record found</p><p class="browse-btn"><a href="'.get_the_permalink(2876).'">Browse Shows</a></p>';
                         

                      }
                          ?>


                   

    	           <script>console.log(<?php echo json_encode($results1); ?>);</script>
        
      
					 </div>

<?php } ?>