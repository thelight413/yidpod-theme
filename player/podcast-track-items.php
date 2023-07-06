<?php
/*
global $wpdb;
$podcast_id = $post->ID;

 $table_name = $wpdb->prefix."episode";
 $sql = "SELECT * from  $table_name WHERE podcast_id='$podcast_id'";
 $results = $wpdb->get_results($sql);

 foreach ($results as $key => $value) {
       $strlength = strlen($value->duration);
	 	if($strlength < 5)
       	      $time = substr($value->duration, 0, 2).":".substr($value->duration, 2, 3);	     
       else
       	$time = $value->duration;

       $authorname  = str_replace("'","",$value->author);
       $titlename  = str_replace("'","",$value->title);

       $titlename  = str_replace(":","",$titlename);

       $shows_name  = str_replace("'","",$shows_name);

       $shows_name  = str_replace(":","",$shows_name);
      

       $titlename = preg_replace('/[^A-Za-z0-9\-]/', ' ', $titlename);
	 	?>
		<div class="track-item">
			<div class="cs-row">
			  <div class="cs-track-thumbnail">
				<img src="<?php echo $value->image_uri; ?>">
			  </div>
			  <div class="cs-track-info">
				<h4><?php echo $titlename; ?></h4>
				<h5><span class="time"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $time; ?></span></h5>
				
			  </div>
			  <div class="cs-track-play-btn">
				 <i class="fa fa-play"></i>
			  </div>
			</div>
		</div>
		
		<?php
       
	 }
*/
?>
<div class="playlist-ctn" style="display: block !important;height: auto;"></div>


 