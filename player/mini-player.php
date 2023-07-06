<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/player/assest/style.css"> 
<div class="mini-webplayer">
	<div class="cs-row">
		<div class="player-info">
		<div>
         	<img class="imagesrc" src="<?= site_url() ?>/wp-content/uploads/2022/05/1652056632980.jpg">
		</div>
		 <div>
		 	<h3 class="title" >Episode Name</h3>
		 	<h4 class="sub-title">Shows Name</h4>
		</div>
		</div>
		<div class="player-control">
			 
			<audio id="myAudio" ontimeupdate="onTimeUpdate()">
			  <!-- <source src="audio.ogg" type="audio/ogg"> -->
			  <source id="source-audio" src="" type="audio/mpeg">
			  Your browser does not support the audio element.
			</audio>

			<div class="player-ctn">
			  
			  <div class="btn-ctn">
				 <div class="btn-action first-btn" onclick="previous()">
					<div id="btn-faws-back">
					  <i class='fa fa-step-backward'></i>
					</div>
				 </div>
				 <div class="btn-action" onclick="rewind()">
					<div id="btn-faws-rewind">
					  <i class='fa fa-rotate-left'></i>
					</div>
				 </div>
				 <div class="btn-action cs-play-pause" onclick="toggleAudio()">
					<div id="icon-play">
					<svg xmlns="http://www.w3.org/2000/svg" height="32px" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:white}</style><path d="M0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zM188.3 147.1c-7.6 4.2-12.3 12.3-12.3 20.9V344c0 8.7 4.7 16.7 12.3 20.9s16.8 4.1 24.3-.5l144-88c7.1-4.4 11.5-12.1 11.5-20.5s-4.4-16.1-11.5-20.5l-144-88c-7.4-4.5-16.7-4.7-24.3-.5z"/></svg>
					</div>
					<div id="icon-pause" style="display: none">
						<svg xmlns="http://www.w3.org/2000/svg" height="32px" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:white}</style><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM224 192V320c0 17.7-14.3 32-32 32s-32-14.3-32-32V192c0-17.7 14.3-32 32-32s32 14.3 32 32zm128 0V320c0 17.7-14.3 32-32 32s-32-14.3-32-32V192c0-17.7 14.3-32 32-32s32 14.3 32 32z"/></svg>
					 </div>
					
				 </div>
				 <div class="btn-action btn-play" onclick="forward()">
					<div id="btn-faws-forward">
					  <i class='fa fa-rotate-right'></i>
					</div>
				 </div>
				 <div class="btn-action" onclick="next()">
					<div id="btn-faws-next">
					  <i class='fa fa-step-forward'></i>
					</div>
				 </div>
				
			  </div>
			   
			 <!--  <div id="myProgress">
				<div class="timer">00:00</div><div id="myBar"></div><div class="indicator"></div><div class="duration">00:00</div>
			  </div> -->

			  <div id="myProgress__new" class="range-slider">
				<div class="timer">00:00</div>
                  <input type="range" min="1" max="100" value="1" class="myprogressnew range-slider__range">
                  <span class="range-slider__value">100</span>
                  <div class="duration">00:00</div>
			  </div>
			  
			  <div class="playlist-ctn"></div>
			</div>
 

		</div>
		<div class="player-setting range-slider">

		<div class="cs-speed">
			    <select id="audio_speed">
				 
				 <option value="">Change Speed</option>
				 <option value=".5">0.5X</option>
				 <option value=".8">0.8X</option>
				 <option value="1" selected>1X</option>
				 <option value="1.2">1.2X</option>
				 <option value="1.5">1.5X</option>
				 <option value="1.8">1.8X</option>
				 <option value="2">2X</option>
				 <option value="2.5">2.5X</option>
				 <option value="3">3X</option>
				 <option value="3.5">3.5X</option>
				</select>
		</div>	 
         
		 
		
             <div class="btn-mute" id="toggleMute" onclick="toggleMute()">
				<div id="btn-faws-volume">
				  <i id="icon-vol-up" class='fa fa-volume-up'></i>
				  <i id="icon-vol-mute" class='fa fa-volume-off' style="display: none"></i>
				</div>
			 </div>
			 <input class="range-slider__range" type="range" min="1" max="10" value="5" id="volume_control">
            <span class="range-slider__value">50</span>
			   <div class="share-option">
				  <span class="ellipsis-share"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></span>
					<div class="dropcustom dropdown-share">
						<li class="cs-download">
							<a href="#" target="_blank" download>Download</a>
							<div id="download_progress" style="display: none;">
								<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
									<span>0%</span>
								</div>
							</div>
						</li>
						<li class="copylinktoepisodes">Copy Link to Episode</li>
						<li><a target="_blank" id="wts_btn" href="">Share to Whatsapp</a></li>
						<li><a target="_blank" id="twtr_btn" href="">Share to Twitter</a></li>
						<li><a target="_blank" id="fb_btn" href="">Share to Facebook</a></li>
					</div>
				</div>
		</div>
	</div>
	
		<div class="cs-links hide-in-desktop bottom-links">
			<?php 
				wp_nav_menu( array(
				'menu' => 'Web Player'
				) ); 
			?>
		</div>
	</div>




<?php 

   // for time duration




   global $wpdb;
  // get podcast id by default it should b 2439
  $last_podcast_id = $_COOKIE['last_podcast_id'] ?? null;
  $podcast_last_play_id = $_COOKIE['podcast_last_play_id'] ?? null;
  $defaultid = 2439;

	if(is_single()){
	  $defaultid = get_the_ID();
	}
	elseif (isset($last_podcast_id) && !empty($last_podcast_id)) 
	{
		$defaultid = $last_podcast_id;
	}
    
	 if(!empty($_GET['cat'])){
		$myposts = get_posts(array(
		'showposts' => 1, //add -1 if you want to show all posts
		'post_type' => 'podcasts',
		'tax_query' => array(
		array(
		'taxonomy' => 'category',
		'field' => 'slug',
		'terms' => $_GET['cat'] //pass your term name here
		)
		))
		);
		$podcast_id = (isset($myposts[0]->ID))?$myposts[0]->ID:$defaultid;
	}
	else{
		$podcast_id = (isset($_GET['podcast']))?$_GET['podcast']:$defaultid;
	}


 
		 $shows_name = get_the_title($podcast_id);
		 $table_name = $wpdb->prefix."episode";
		 $limit = 15;
		 $offset = 0;
		 $sql = "SELECT * from  $table_name WHERE podcast_id='$podcast_id' order by published_date DESC ";
			  $results = $wpdb->get_results($sql);
      
	  // for last play id
              
		$results1 = unserialize( base64_decode( $podcast_last_play_id) );

		$list = "";
		if(!empty($results1['name']) && !empty($results1['eid'])){


		$shows_name = RemoveSpecialChar($results1['shows_name']);

		$titlename = RemoveSpecialChar($results1['name']);
		$fileurl  = str_replace("'","",$results1['file']);
       	$time = $results1['duration'];
       	$eid = $results1['eid'];


        $list .= "{ name:'".$titlename."',file:'".$fileurl."',duration:'".$time."',image:'".$results1['image']."',shows_name:'".$shows_name."',formatted_date:'".$results1['formatted_date']."',eid:'".$eid."',podcast_url:'".get_permalink($podcast_id)."'},";

        	?>
      <script type="text/javascript">
      	jQuery(document).ready(function(){
      		jQuery("#ptc-0").css("display","none");
      	});
      	
        	setTimeout(function() {
				var vid = document.getElementById("myAudio");
				vid.currentTime = <?= $results1['time'] ?>; 
			}, 300);
			</script>
			<?php 
        }
		
	 foreach ($results as $key => $value) {


       $time = setTimeDuration($value->duration);

       $formatted_date = date('m/d/Y', $value->published_date);

       $titlename = preg_replace('/[^A-Za-z0-9\-]/', ' ', $titlename);

       $titlename = RemoveSpecialChar($value->title);

       if(is_single()){
       	$shows_name = get_the_title(get_the_ID());
       }

       $shows_name = RemoveSpecialChar($shows_name);

        $fileurl  = str_replace("'","",$value->url);

       $list .= "{ name:'".$titlename."',file:'".$fileurl."',duration:'".$time."',image:'".$value->image_uri."',shows_name:'".$shows_name."',formatted_date:'".$formatted_date."',eid:'".$value->id."',podcast_url:'".get_permalink($podcast_id)."'},";
	 }

?>
<script>

<?php 
    // for last podcast ID
	if(!is_single() && isset($podcast_last_play_id) && !empty($podcast_last_play_id))
	{  
		$results = unserialize( base64_decode( $podcast_last_play_id) );
		$list = "";
		$time = setTimeDuration($results['duration']);
		$time = $results['duration'];
		$list .= "{ name:'".$results['name']."',file:'".$results['file']."',duration:'".$time."',image:'".$results['image']."',shows_name:'".$results['shows_name']."',formatted_date:'".$results['formatted_date']."',eid:'".$results['eid']."',podcast_url:'".get_permalink($podcast_id)."'},";

		?>
			setTimeout(function() {
				var vid = document.getElementById("myAudio");
				vid.currentTime = <?= $results['time'] ?>; 
				if(listAudio[0].eid){
					jQuery(".sub-title").attr("data-id",listAudio[0].eid);
				}
			}, 300);

		<?php


	}

?>


var listAudio = [
    <?= $list ?>
  ];
console.log(listAudio)
var podcast_id = '<?php echo $podcast_id; ?>';
jQuery(document).ready(function(){

	 // subscribe and unsubscribe
	jQuery(document).on("click","#episode_subscribe",function(){ 
           var subscribe = jQuery(this).attr("data-id");
           var text = jQuery(this).text();
           var thisvar = jQuery(this);
             
                          jQuery.ajax({
                             type : "post",
                             url : "<?php echo site_url(); ?>/wp-admin/admin-ajax.php",
                             data : {action: "subscribe_podcasts2", subscribe : subscribe,text:text},
                             success: function(response) {
                             	
                             	if(response.valid)
                                thisvar.text(response.message);
                               
                             },
                          }); 
   });

  // episode event listner
     jQuery(".div_id__2805 .yidpod_container .episode").click(function(){
          
          window.location.href = '<?= site_url(); ?>/listen/?podcast=2805';

     });

  // audio control

  jQuery("#volume_control").change(function(){
  	var volume1 = jQuery(this).val();
  	setCookie("volume",volume1,"2");
  	 volume1 = volume1/10;
  	currentAudio.volume = volume1;
  });


// rate speed audio

jQuery("#audio_speed").change(function(){ 
	var vid = document.getElementById("myAudio");

	var ratespeed = jQuery(this).val();
     vid.playbackRate = ratespeed;

     setCookie("volumerate",ratespeed,"2");

	 }); 

});
  

</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
  <script  src="<?php echo get_stylesheet_directory_uri(); ?>/player/assest/script.js"></script>

  <script type="text/javascript">
  	
function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

//setCookie("volume","7","2");

jQuery(document).ready(function(){

var cookiename  = getCookie("volume");

var volumerateval  = getCookie("volumerate");

if(cookiename){
	var volume1 = cookiename/10;
	currentAudio.volume = volume1;
	jQuery("#volume_control").val(cookiename);
}

if(volumerateval){
	currentAudio.playbackRate = volumerateval;
	jQuery("#audio_speed").val(volumerateval);
}

});


  </script>
  <script type="text/javascript">
  jQuery(document).ready(function(){
  jQuery(".share-episode").click(function(){
    jQuery(".share-links").toggle();
  });
});

// History reload when click browser back button.
jQuery(window).on('popstate', function() {
window.history.back();
window.location.reload();
});   

 

  </script>
  
    
<!--- End player ---->