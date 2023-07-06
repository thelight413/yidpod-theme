<style type="text/css">
  .yidpod_container .episode {
    cursor: pointer;
}
.podcasts_list {
    display: grid;
    grid-gap: 10px;
    grid-template-columns: repeat(4, 1fr);
}
</style>


<?php 

function searchResultPodcasts(){
     
     $seachTitle = 'Multiple';

  global $wpdb;
 $sql = "(SELECT MATCH (title) AGAINST ('$seachTitle' IN BOOLEAN MODE) as exact, MATCH (title) AGAINST ('$seachTitle*' IN BOOLEAN MODE) as almost,id,author,title,image_uri,published_date,duration,podcast_id,'episode' as type,e_index,'' as post_status,'t' as post_type,'' as 'tags',url from wp_episode WHERE 1=1 AND (MATCH (title) AGAINST ('$seachTitle' IN BOOLEAN MODE) OR MATCH (title) AGAINST ('$seachTitle*' IN BOOLEAN MODE))) ORDER BY exact desc,almost desc,INSTR(title,'$seachTitle'),title, published_date DESC LIMIT 10 OFFSET 0";
 $results = $wpdb->get_results($sql);

  return $results;

}

$searchResultPodcasts = searchResultPodcasts();
 
  


?>


<style type="text/css">
#loader {
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
<div id="loader"></div>
<?php wp_footer(); ?>
</body>
</html>
 
<script>
	
	 // search list jquery
  
$("#user-icon").click(function(){
        $('.user-menu').slideToggle('slow');
    });
      
     // close search 

     jQuery(".custom_close").click(function(){
            jQuery(".cs-content-search").html(" ");
            jQuery(".searchlist").val("");
            jQuery(".search_list").html("");
            jQuery("#search_podcast").val("");
            jQuery(this).css("display","none");
            jQuery(".cat_wrpr").css("display","block");
            jQuery('#icon i').css('color','white');
     });
	
	// Mobile Menu
	
	jQuery(".mobile-menu-icon i").click(function(){
	    jQuery('.cs-sidebar').css('left','0');
		jQuery('.cs-sidebar .mobile-icon i').css('position','absolute');
	});
	jQuery("#close-menu i").click(function(){
	    jQuery('.cs-sidebar').css('left','-40%');
		jQuery('.cs-sidebar .mobile-icon i').css('position','unset');
	});
</script>
<?php if(!is_page(2908)){ ?>
<script>
	
	 // search list jquery
   var spinner = jQuery('#loader');
     jQuery("#searchlist").keyup(function(){
	
		 spinner.show();
          var podcast_title = jQuery(this).val();

          if(podcast_title == ""){
           spinner.hide();
            return false;
          }
           


           jQuery.ajax({
                             type : "post",
                             url : "<?php echo site_url(); ?>/wp-admin/admin-ajax.php",
                             data : {action: "get_podcast_search", podcast_title : podcast_title},
                             success: function(response) {

                              jQuery(".cs-content-search").html(response.data);
                              
                              jQuery(".custom_close").css("display","block");
                          
                               spinner.hide();
                               
                             },
                          }); 

     });


     jQuery('.search-area form').submit(function(event){
   event.preventDefault(); 

   spinner.show();
          var podcast_title = jQuery("#searchlist").val();

          if(podcast_title == ""){
           spinner.hide();
            return false;
          }
           


           jQuery.ajax({
                             type : "post",
                             url : "<?php echo site_url(); ?>/wp-admin/admin-ajax.php",
                             data : {action: "get_podcast_search", podcast_title : podcast_title},
                             success: function(response) {

                              jQuery(".cs-content-search").html(response.data);
                              
                              jQuery(".custom_close").css("display","block");
                          
                               spinner.hide();
                               
                             },
                          }); 

           
});

      
</script>
<?php } ?>

