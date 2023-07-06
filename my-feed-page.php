<?php
/*


template name: Feed Template

*/


get_template_part('player/header-player'); ?>
<style>
.cs-content-search {
    padding-top: 20px;
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
					 <h3>My Feed</h3>
					 <div class="tabs">
					  <ul id="tabs-nav">
						<li class="active"><a href="javascript:void" data-id="tab1">Latest Episodes</a></li>
						<li><a href="javascript:void" data-id="tab2">Listening History</a></li>
					  </ul> <!-- END tabs-nav -->
					  <div id="tabs-content">
						<div id="tab1" class="tab-content" style="display: block">
						   <div class="playlist-ctn" style="display: block !important;height: auto;"></div>
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
		  <?php include('player/mini-player.php'); ?> 

</div>





<?php get_template_part('player/footer-player'); ?> 
<script>
jQuery(document).ready(function(){

	var oldAudiodata = listAudio;
	
	$('#tabs-nav li').click(function(e){
		e.preventDefault();
         
         $('#tabs-nav li').removeClass('active');
  $(this).addClass('active');
  $('.tab-content').hide();

  var acrtivetab = $(this).find("a").attr("data-id");
  $(".tab-content").css("display","none");

  $("#"+acrtivetab).css("display","block");

  if(acrtivetab == "tab2"){
     listenHistoryRecord(acrtivetab);
  }else if(acrtivetab == "tab1"){
        latestAudio(oldAudiodata);
  }

// Click function
  
	  
  /*$('#tabs-nav li').removeClass('active');
  $(this).addClass('active');
  $('.tab-content').hide();
  
  var activeTab = $(this).find('a').attr('href');
  alert(activeTab);
  $(activeTab).fadeIn();
  return false;*/
  });

});


function listenHistoryRecord(tab){

	 jQuery.ajax({
                type : "post",
                url : "/wp-admin/admin-ajax.php",
                data : {action: "listenHistory_record", tab : tab},
                success: function(response) {

                    <?php if(is_user_logged_in()){ ?>

                	jQuery("#tab2").html('<div class="playlist-ctn" style="display: block !important;height: auto;"></div>');
                	jQuery("#tab1").html('');


                	
						try {
							listAudio = JSON.parse(JSON.stringify(response.data));
							jQuery(".playlist-ctn").html("");

							for (var i = 0; i < listAudio.length; i++) {
							createTrackItem(i,listAudio[i].name,listAudio[i].duration,listAudio[i].image,listAudio[i].formatted_date);
							}
							var indexAudio = 0;
							var playListItems = document.querySelectorAll(".playlist-track-ctn");

							for (let i = 0; i < playListItems.length; i++){
							playListItems[i].addEventListener("click", getClickedElement.bind(this));
							}



						}
						catch(err) {
						console.log("Error listAudio",err);
						}
                       
                       <?php 
                          } 
                          else{ 
                          	?>
                              jQuery("#tab2").html('<div class="not-login-wrpr"><h2>Please login to view your feed</h2><a href="<?= site_url(); ?>/my-account/" class="login-btn">Login</a></div>');
                	jQuery("#tab1").html('');
                          	<?php

                          }
                        ?>

                },
          }); 

}

// update latest Audio

function latestAudio(oldAudiodata){

	try {                   
		                    jQuery("#tab2").html('');
		                    jQuery("#tab1").html('<div class="playlist-ctn" style="display: block !important;height: auto;"></div>');
                	
							listAudio = oldAudiodata;
							jQuery(".playlist-ctn").html("");

							for (var i = 0; i < listAudio.length; i++) {
							createTrackItem(i,listAudio[i].name,listAudio[i].duration,listAudio[i].image,listAudio[i].formatted_date);
							}
							indexAudio = 0;
							currentAudio.load();
							var playListItems = document.querySelectorAll(".playlist-track-ctn");

							for (let i = 0; i < playListItems.length; i++){
							playListItems[i].addEventListener("click", getClickedElement.bind(this));
							}



						}
						catch(err) {
						console.log("Error listAudio",err);
						}

}

</script>