<?php
/*


template name: My shows Template

*/


get_template_part('player/header-player'); ?>
<style>
.cs-content-search {
    padding-top: 20px;
}
.podcasts_list .podcast {
    padding: 10px;
}
</style>
<div id="main-content">
           <div class="cs-row">
            <div class="cs-sidebar">
			<?php include('player/sidebar.php'); ?>
			</div>
			
            <div class="cs-content cs-feeds">
			<?php include('player/search-bar.php'); ?>
                <div class="cs-featured-content">
				     <div class="cs-content-search">
					 </div>
					 <div class="cs-content-feed">
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
				</div>
				<?php include('player/mini-player.php'); ?>
            </div>
          </div>



</div>
 <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
 <link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap4.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap4.min.js"></script>
  <script type="text/javascript">
  	$(document).ready(function () {
    $('#example').DataTable();
});
  </script>-->
  <style type="text/css">
    .podcast_image img {
    width: 100%;
    object-fit: cover;
}
  </style>
<?php get_template_part('player/footer-player'); ?> 







