<?php
/**
 * Latest Episodes
 */
$prefix = $wpdb->prefix;
$episodeTable = $prefix."episode"; 
$postmetaTable = $prefix."postmeta";
$qry = "SELECT * from $episodeTable LEFT JOIN `$postmetaTable` AS pm1 ON pm1.post_id = podcast_id AND pm1.meta_key='hide_episodes_in_search' WHERE 1=1 and duration != '00:00' and duration != '0' and duration != '00:00:00' and duration is not null AND (pm1.meta_value is null or pm1.meta_value = '') ORDER BY published_date DESC LIMIT 50";

    global $wpdb;
    $podcasts = $wpdb->get_results($qry);


?>


<div class="category_page latestepisodesnew">
			<div class="arrows">
			<div class="left-arrow">
			<i class="fa fa-arrow-left"></i>
			</div>
			<div class="right-arrow"> <i class="fa fa-arrow-right"></i></div>
			</div>
		
			<div class="yidpod_title">Latest Episodes</div>
			<div class="podcasts horizontal">
					<?php 
                    $checkPodcastArray = array();
					foreach($podcasts as $podcast){

					$id = $podcast->podcast_id;
					$day = dayDifference($podcast->updated_at);
					if(!in_array($id, $checkPodcastArray)){
					//$checkPodcastArray[] = $id;

					$title = $podcast->title;
					?>

					<div class="podcast">
					<a href="<?php echo get_the_permalink($id); ?>">
					<div class="podcast_image">
					<?php echo display_lazy_loaded_podcast_image($id,array(200,200)) ?>
					</div>
					<div class="podcast_title" title="<?php echo $title ?>" data-id="<?= $id; ?>"><?php echo $title; ?></div>
					</a>
					
					</div>
				<?php 
				} 

			} 

				?>
		    </div>
		<?php 
		yidpod_arrows_html('.category_page','.podcasts',".latestepisodesnew");
		?>
	</div>