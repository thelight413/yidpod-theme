<?php
/**
 * special categories
 */
global $wpdb;

$options = explode(",",get_option("yidpod_option_name"));
$special_categories = explode(",",get_option("yidpod_special_categories"));
for($i=0;$i<count($special_categories);$i++){



$classId = "categorynew_".$i;
$perClassId = '.'.$classId;

$category = ['title'=>$special_categories[$i]];
//$category['items'] = searchForPodcastsAndEpisodes('episodes',$special_categories[$i]);
$podcasts = searchForPodcastsAndEpisodes('episodes',$special_categories[$i]);

$checkPodcastArraycount = array();

foreach($podcasts as $podcast){

					$id = $podcast->podcast_id;
					if(!in_array($id, $checkPodcastArraycount)){
					$checkPodcastArraycount[] = $id;
					}
				}

$count = count($checkPodcastArraycount);
	if($count >6){
	?>
	<div class="category_page <?= $classId ?>">
			<div class="arrows">
			<div class="left-arrow">
			<i class="fa fa-arrow-left"></i>
			</div>
			<div class="right-arrow"> <i class="fa fa-arrow-right"></i></div>
			</div>
		<?php
		}
		?>
			<div class="yidpod_title"><?php echo $special_categories[$i];  ?></div>
			<div class="podcasts horizontal">
					<?php 
                    $checkPodcastArray = array();
					foreach($podcasts as $podcast){

					$id = $podcast->podcast_id;
					if(!in_array($id, $checkPodcastArray)){
					$checkPodcastArray[] = $id;

					$title = $podcast->title;
					$day = dayDifference($podcast->updated_at);
					?>

					<div class="podcast">
					<a href="<?php echo get_the_permalink($id); ?>">
					<div class="podcast_image">
					<?php echo display_lazy_loaded_podcast_image($id,array(200,200)); ?>
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
		yidpod_arrows_html('.category_page','.podcasts',$perClassId);
		?>
	</div>

	<?php  }  ?>                              
		
		
	

                                  