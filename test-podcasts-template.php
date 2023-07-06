<?php 
/* Template Name: Test poscast template */

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
          <?php 
global $wpdb;
	$table_name = $wpdb->prefix."episode";

   $query = new WP_Query(array(
    'post_status' => 'publish',
    'orderby' => 'publish_date',
    'post_type' => 'podcasts',
    'order' => 'DESC',
    'posts_per_page' => 10));



	foreach($query->posts as $podcast) {
		$post_id = $podcast->ID;
		$feedlink = get_post_meta( $post_id, 'feedlink', true );
		$last_fetched = get_post_meta( $post_id, 'new_last_fetched', true );
		// $count = get_post_meta( $post_id, 'episodesCount', true );
		$query = "SELECT count(*) from ".$table_name." WHERE podcast_id = ".$post_id;
		
		$content = @file_get_contents($feedlink);
		
		$x = new SimpleXmlElement($content);

		$count 		= count($x->channel->item);
	
		$total += $count;
		// $result = $wpdb->get_results($query);
		$result = $wpdb->get_var($query);

	
		$totalc += $result;
		if($count != $result){
			echo "I'M NOT OK".$count." ".$result;
			echo "last updated".date("Y-m-d H:i",$last_fetched);
			echo "<div class='podcast'><div class='podcast_title1'>".$post_id." : ".$podcast->post_title."</div>";
		echo "<div class='feedlink'>".$feedlink.'</div></div>';
		}
		
		
		
}


   

?>


</div>


<?php get_template_part('player/footer-player'); ?> 

 