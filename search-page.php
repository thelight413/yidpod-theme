<?php
/*


template name: Search Template

*/


get_template_part('player/header-player'); ?>
<style>
 
.cs-search-page {
    padding: 20px 0;
}
.cs-search-page form input[type="search"] {
    width: 100%;
    height: 40px;
    border: 1px solid #757775;
    border-radius: 5px;
	font-size: 16px;
	padding-left:35px;
	background: transparent;
}
.cs-search-page form input[type="submit"] {
    padding: 0px 46px;                           
    height: 40px;
    background: #4bba6a;
    border: 1px solid #4bba6a;
    color: white;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
}
.cs-search-page form input[type="submit"]:hover{
	background: #000;
}
.cs-search-page form {
    margin-bottom: 30px;
}

.input-wrpr {
    position: relative;
        display: flex;
}
.input-wrpr #icon {
    position: absolute;
    left: 10px;
    top: 4px;
    

}
.input-wrpr .custom_close{
    position: absolute;
    right: 10px;
    top: 12px;
    cursor: pointer;
}
input#search_podcast {
    color: #fff;
}
</style>

 


<div id="main-content">
           <div class="cs-row">
            <div class="cs-sidebar">
			<?php include('player/sidebar.php'); ?>
			</div>
			
            <div class="cs-content cs-feeds">
			<?php include('player/search-bar.php'); ?>
                <div class="cs-featured-content search-page">
				      
					 <div class="cs-search-page">
					 <!--<h3>Search</h3>-->
					 <form action="" method="get" autocomplete="off">
					<!-- <div class="input-wrpr">
                        <input type="search" name="search" id="search_podcast" placeholder="Type Here" value="<?= $_GET['search']?>"><span id="icon"><i class="fa fa-search" aria-hidden="true"></i></span><i class="fa fa-window-close custom_close" aria-hidden="true" style="display: none"></i>
					 </div>-->
						<div class="btn_choices">
							 <input type="radio" name="btn_choices" id="radio1"  value="shows" <?php if(!isset($_GET['btn_choices']) || $_GET['btn_choices'] != "episodes" || $_GET['btn_choices'] != "showsandepisodes"){echo "checked"; } ?>><label for="radio1">Shows</label>
							 <input type="radio" name="btn_choices" id="radio2" value="episodes" <?php if(isset($_GET['btn_choices']) && $_GET['btn_choices']== "episodes") { echo "checked"; } ?>><label for="radio2">Episodes</label>
							 <input type="radio" name="btn_choices" id="radio3" value="showsandepisodes" <?php if(isset($_GET['btn_choices']) && $_GET['btn_choices']== "showsandepisodes") { echo "checked"; } ?>><label for="radio3">Shows & Episodes</label>
						</div>
                     </form>
                     <div class="search_list" ></div>					 
					 <div class="cat_wrpr" <?php if(isset($_GET['search'])){ echo 'style="display:none;"';}?>>
                     <h3>Podcast Categories</h3>
					  
						 <?php 
                            $colors = Array ('blue','red','orange','light-green','pink','light-blue','gray','green','magenta');
							$cat_option = get_option('yidpod_option_name');
              $terms = explode(",",$cat_option);

							if(!empty($terms)){
								echo '<ul class="grid-cat">';
								            $i=0;
											foreach($terms as $cat){
                        $term = get_term( $cat, 'category' );
                        $cat_slug = $term->slug;
                        $cat_name = $term->name;

												if($i == 9)
													$i = 0;
												 if($cat->name == 'Uncategorized'){
												  continue;
												} 
												echo '<li class="item '.$colors[$i].'"><a href="'.get_the_permalink(2876).'?cat='.$cat_slug.'">'.ucwords($cat_name).'</a></li>';
												
												$i++;
											}
								echo '</ul>';
							}
						 ?>
					  
                     </div>					 
					<?php	
					$seachTitle = '';
					if(isset($_GET['search'])){
						$seachTitle = $_GET['search'];
					}
					
if(!empty($seachTitle)){
	   global $wpdb;
	/*
    $sql = "(SELECT MATCH (title) AGAINST ('$seachTitle' IN BOOLEAN MODE) as exact, MATCH (title) AGAINST ('$seachTitle*' IN BOOLEAN MODE) as almost,id,author,title,image_uri,published_date,duration,podcast_id,'episode' as type,e_index,'' as post_status,'t' as post_type,'' as 'tags',url from wp_episode WHERE 1=1 AND (MATCH (title) AGAINST ('$seachTitle' IN BOOLEAN MODE) OR MATCH (title) AGAINST ('$seachTitle*' IN BOOLEAN MODE))) ORDER BY exact desc,almost desc,INSTR(title,'$seachTitle'),title, published_date DESC LIMIT 10 OFFSET 0";
   $results = $wpdb->get_results($sql);*/

   $results = searchForPodcastsAndEpisodes2($_GET['btn_choices'],$seachTitle);

   echo "<div class='results__container'><h1 style='color:#fff'>Search results</h1><div class='podcasts_list'>";

   foreach ($results as $key => $value) {
            ?>
           <div class="podcast">
                      <a href="<?php echo get_the_permalink($value->id); ?>">
						<div class="podcast_image">
						
							<img  src="<?php echo $value->image_uri; ?>" class="attachment-large size-large wp-post-image" alt="" loading="lazy" >						 </div>
						 <div class="podcast_title"><?php echo $value->title; ?></div>
						 </a>
			 		</div> 
<?php   }


   echo '</div></div>'; 
   
   
} ?>
					 </div>

               




				</div>
            </div>
          </div>
          <?php  include('player/mini-player.php'); ?> 

</div>

<?php get_template_part('player/footer-player'); ?> 

<style type="text/css">
#loader-inner {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  width: 100%;
  background: rgb(56 54 54 / 75%) url(<?php echo get_stylesheet_directory_uri(); ?>/player/assest/img/loader-thin.gif) no-repeat center center;
  z-index: 10000;
  background-size: 5%;
}
</style>  
<div id="loader-inner"></div>
<!---- search results -->
<script>
  var spinner = jQuery('#loader');
// for key up
     jQuery("#searchlist").keyup(function(){
          var podcast_title = jQuery(this).val();
        spinner.show();
          if(podcast_title == ""){
            jQuery(".search_list").html("");
 		 	     jQuery(".cat_wrpr").css("display","block");
			 spinner.hide();	
            return false;
          }

          var podcatsSelect = jQuery('input[name=btn_choices]:checked').val();
            

           jQuery.ajax({
                             type : "post",
                             url : "<?= site_url() ?>/wp-admin/admin-ajax.php",
                             data : {action: "get_podcast_search_page", podcast_title : podcast_title,podcats_elect : podcatsSelect},
                             success: function(response) {

                             	if(response.valid){
                             		 jQuery(".search_list").html(response.data);
                             		 jQuery(".cat_wrpr").css("display","none");
                                 jQuery(".results__container").css("display","none");
                             	}
                             	else{
                             		 jQuery(".search_list").html("");
                             		 jQuery(".cat_wrpr").css("display","block");
                             	}

                             jQuery(".custom_close").css("display","block");

                          
                              spinner.hide();
                               
                             },
                          }); 

     });


     // for radion button click

     jQuery('input[name=btn_choices]').click(function(){

     	 var podcast_title = jQuery("#searchlist").val();

       var check = true;

          if(podcast_title == ""){
            jQuery(".search_list").html("");
 		 	     jQuery(".cat_wrpr").css("display","block");
            check = false;
          }

          var podcatsSelect = jQuery('input[name=btn_choices]:checked').val();
            
            if(check){

           jQuery.ajax({
                             type : "post",
                             url : "<?= site_url() ?>/wp-admin/admin-ajax.php",
                             data : {action: "get_podcast_search_page", podcast_title : podcast_title,podcats_elect : podcatsSelect},
                             success: function(response) {

                             	if(response.valid){
                             		 jQuery(".search_list").html(response.data);
                             		 jQuery(".cat_wrpr").css("display","none");
                             	}
                             	else{
                             		 jQuery(".search_list").html("");
                             		 jQuery(".cat_wrpr").css("display","block");
                             	}

                             

                          
                              
                               
                             },
                          }); 
         }

     });
	
	
	
</script>


