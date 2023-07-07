 <?php
 /**
  * Search page content 
  * and Search page and search-bar functionality
  */
 ?>
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
												echo '<li class="item '.$colors[$i].' cat__item" ><a data-cat="'.$cat_slug.'" href="javascript:void(0)">'.ucwords($cat_name).'</a></li>';
												
												$i++;
											}
								echo '</ul>';
							}
						 ?>
					  
                     </div>	


                     <script>

  
// for key up
     jQuery(document).on("keyup","#searchlist",function(){
     	var spinner = jQuery('#loader');
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

     jQuery(document).on("click","input[name=btn_choices]",function(){

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