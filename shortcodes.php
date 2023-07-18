<?php

function yidpod_episodes_shortcode($oldatts,$content,$tag){
	$atts = shortcode_atts(array(
		'horizontal' =>  "true",
		'search'=>null,
		'debug'=>false,
		'podcast_id'=>  null,
		'type'=>'episodes',
		'page'=>0,
		'limit'=>10,
		'category_id'=>null
	 ), $oldatts,$tag);
    ob_start();

	 if(!$atts['podcast_id'] && !$atts['search'] && !$atts['category_id']){
		?>
		here
		<div>No podcast id chosen.</div>
		<?php
		return ob_get_clean();

	 }
	 
	 $podcast_id = $atts['podcast_id'];
	$title =  $atts['search'];
	 if($podcast_id){
		 $podcast = get_post($atts['podcast_id']);
		 $title  = $podcast->post_title;
	 }
	 
	 if($atts['category_id']){
		 $category = get_term($category_id);
		 $title = $category->name;
	 }
	 $classes = "";
	 if($atts['horizontal'] == "true"){
		 $classes.= " horizontal";
	 }
    ?>

	<style>
		.yidpod_container{
			position: relative;
		}
		.episodes{
			display: flex;
			flex-direction: column;
			justify-content:center;
		}
		.horizontal {
			flex-direction: row;
			overflow: auto;
		}
		.yidpod_title{
			font-size: 26px;
		}
		.episode_image{
			width: 200px;

		}
		.episode{
			padding: 10px;
		}
	</style>
    <div class="yidpod_container">
		<div class="yidpod_title"><?php echo $title; ?></div>
		<div class="episodes <?php echo $classes; ?>">
		<?php 
		 global $wpdb;
		 $episode_table = $wpdb->prefix."episode";
			$episodes = web_yidpod_search($atts);
		 foreach($episodes as $episode){
		?>
        <div class="episode">
			<div class="episode_image">
				<img src="<?php echo $episode->image_uri; ?>" />
			</div>
			<div class="episode_info">
				<div class="episode_title">
					<?php echo $episode->title; ?>
				</div>
				
		 	</div>
		</div>

		<?php } ?>
		<?php yidpod_arrows_html('.yidpod_container','.episodes');  ?>

		 </div>
    </div>
    <?php
    return ob_get_clean();
}
function get_yidpod_episodes($atts){
	global $wpdb;
	$table_name = $wpdb->prefix . "episode"; 
	$where = "WHERE 1=1 and duration != '00:00' and duration != '0' and duration != '00:00:00' and duration is not null";
	$limit = $atts['limit'] ?? 10;
	if(isset($atts['search'])){
		$term = $atts['search'];
		$where .= " AND (title like '%$term%' OR author like '%$term%')";
	}

		if(isset($atts['podcast_id']) ){
			$where .= " AND podcast_id=".$atts['podcast_id'];
		}
		if(isset($atts['published_date']) && isset($atts['how'])){
			$where .= " AND (published_date ".$atts['how']."'".$atts['published_date']."'";
			$where .= " OR (created_at ".$atts['how']."'".$atts['published_date']."'";
			$where .= " OR UNIX_TIMESTAMP(updated_at) ".$atts['how']."'".$atts['published_date']."'".'))';
		}
		if(isset($atts['id'])){
			$where .= " AND id=".$atts['id'];
		}
		
	// }
	if(isset($atts['next'])){
		$where.=" ORDER BY published_date ASC";

	}else{
		if(isset($atts['audiobook']) && $atts['published_date'] == 0 ){
			$where.=" ORDER BY published_date ASC";
		}else{
			$where.=" ORDER BY published_date DESC";

		}
	}
	
	// if(isset($_POST['limit'])){
	$where .= " LIMIT ".$limit;
	// }
	if(isset($atts['offset'])){
		$where .= " OFFSET ".$atts['offset'];
	}
	
	$episodes = $wpdb->get_results("SELECT * from $table_name $where");
	if(isset($atts['debug'])){
		return "SELECT * from $table_name $where";
	}else{
	return  ($episodes);
	}
	// return $episodes;

}
add_shortcode('yidpod_episodes','yidpod_episodes_shortcode');

// add_shortcode('yidpod_podcasts','yidpod_podcasts_shortcode');



function web_yidpod_search($atts){
	global $wpdb;
	$episode_table_name = $wpdb->prefix . "episode"; 
	$podcast_table_name = $wpdb->prefix . "posts"; 
	$episodewhere = "1=1";

	$podcastwhere = "post_type = 'podcasts' AND post_status = 'publish'";
	$limit = $atts['limit'] ?? 10;
	if(($type)){
		$type = 'shows';
	}
	if(($atts['type'])){
		$type = $atts['type'];
	} 
	if(($atts['search']) || $term){
		$term = $atts['search'] ?? $term;

			$terms = get_option('yidpod_search_term');
			if(isset($terms[$term])){
				$special = true;
				$terms = str_replace(","," ",$terms[$term]);

				$episode_select = "MATCH (title) AGAINST ('$term $terms' IN BOOLEAN MODE) as almost,";
				$podcast_select = "MATCH (p.post_title) AGAINST ('$term $terms' IN BOOLEAN MODE) as almost,";
				$episodewhere .= " AND (MATCH (title) AGAINST ('$term $terms' IN BOOLEAN MODE))";
				$podcastwhere .= " AND (MATCH (p.post_title) AGAINST ('$term $terms' IN BOOLEAN MODE))";
				
			}else{
				$episode_select = "MATCH (title) AGAINST ('".'"'.$term.'"'."' IN BOOLEAN MODE) as exact, MATCH (title) AGAINST ('$term*' IN BOOLEAN MODE) as almost,";
				$podcast_select = "MATCH (p.post_title) AGAINST ('".'"'.$term.'"'."' IN BOOLEAN MODE) as exact, MATCH (p.post_title) AGAINST ('$term*' IN BOOLEAN MODE) almost,";
				$episodewhere .= " AND (MATCH (title) AGAINST ('".'"'.$term.'"'."' IN BOOLEAN MODE) OR MATCH (title) AGAINST ('$term*' IN BOOLEAN MODE))";
				$podcastwhere .= " AND (MATCH (p.post_title) AGAINST ('".'"'.$term.'"'."' IN BOOLEAN MODE) OR MATCH (p.post_title) AGAINST ('$term*' IN BOOLEAN MODE))";
			}
			
	}

	if($atts['podcast_id']){
		$episodewhere.=" AND podcast_id = ".$atts['podcast_id'];
	}
	$podcast_select .= "p.id AS id,CASE WHEN pm3.meta_value is NULL then '' ELSE pm3.meta_value END as author,p.post_title as title, concat('https://wordpress-905808-3145572.cloudwaysapps.com','/wp-content/uploads/',pm2.meta_value) AS image_uri,p.post_date as published_date,'0' as duration,'0' as podcast_id,'podcast' as type,'' as e_index,p.post_status, p.post_type";
	$episode_select .= "id,author,title,image_uri,published_date,duration,podcast_id";
	$episodequery = "(SELECT $episode_select,'episode' as type,e_index,'' as post_status,'t' as post_type,'' as 'tags',url from $episode_table_name WHERE ".$episodewhere.')';
	$podcastquery = "(SELECT $podcast_select,GROUP_CONCAT(t.`name`) as tags,'' as url from $podcast_table_name as p LEFT JOIN `wp_postmeta` AS pm1 ON p.id = pm1.post_id".
	" INNER JOIN `wp_postmeta` AS pm2 ON pm1.meta_value = pm2.post_id".
	" AND pm2.meta_key = '_wp_attached_file'".
	" AND pm1.meta_key = '_thumbnail_id' LEFT OUTER JOIN `wp_postmeta` as pm3 on pm3.post_id = id AND pm3.meta_key = 'podcast_author' LEFT JOIN wp_term_relationships tr
    on (p.id=tr.object_id)
LEFT JOIN wp_term_taxonomy tt
    on (tt.term_taxonomy_id=tr.term_taxonomy_id
    and tt.taxonomy='post_tag')
LEFT JOIN wp_terms t
    on (tt.term_id=t.term_id) WHERE $podcastwhere GROUP BY p.id)";
	$query = "";
	if($type == 'shows'){
		$query = $podcastquery;
	}
	if($type == 'episodes'){
		$query = $episodequery;
	}
	if($type == 'showsandepisodes'){
		$query = $podcastquery.' UNION '.$episodequery;
	}
	$offset = 0;
	if(($atts['page'])){
		$offset = $atts['page']*$atts['limit'];
	}
	if(!$atts['podcast_id']){
		if(($special)){
			$query.=' ORDER BY almost desc,INSTR(title,"'.$term.'"),title, published_date DESC LIMIT '.$limit.' OFFSET '.$offset;

		}else{
			$query.=' ORDER BY exact desc,almost desc,INSTR(title,"'.$term.'"),title, published_date DESC LIMIT '.$limit.' OFFSET '.$offset;

		}
	}else{
		$query.=' ORDER BY published_date DESC LIMIT '.$limit.' OFFSET '.$offset;
	}

	if(($atts['debug'])){
		

	echo ($query);
	$episodes = $wpdb->get_results($query);
	return $episodes;
	// die();
	}

	$episodes = $wpdb->get_results($query);

	return($episodes);
	// die();
}
function yidpod_category_shortcode($oldatts,$content,$tag){
	ob_start();
	$atts = shortcode_atts(array(
		'horizontal' =>  "true",
		'category_id'=>null,
		'category_slug'=>null,
		'class_id'=>null,
		'page'=>0,
		'limit'=>10
	 ), $oldatts,$tag);
	 
	$category = "";
	if($atts['category_slug']){
		$category =get_category_by_slug($atts['category_slug']);
		$category->ID = $category->term_id;
	}
	if($atts['category_id']){
		$category = get_category($atts['category_id']);
	}
	if(!$category){
		?>
		<div>No category found with that id or slug.</div>
		<?php
		return ob_get_clean();
	}
	
	if($atts['class_id']){
		$class_per_cat = $atts['class_id'];
		$per_cat = '.'.$class_per_cat;
	}
	//$args = array( 'posts_per_page' => $atts['limit'], 'offset'=> $atts['limit']*$atts['page'], 'cat' => $category->ID,'post_type'=>'podcasts' );
    $args = array( 'posts_per_page' => $atts['limit'], 'offset'=> $atts['limit']*$atts['page'], 'cat' => $category->ID,'post_type'=>'podcasts' );
    $podcasts = get_posts( $args );
	// $podcasts = $query->posts;
	$classes = "";
	if($atts['horizontal'] == "true"){
		$classes.= " horizontal";
	}
	?>
	
	<div class="category_page <?php echo $class_per_cat; ?>">
		<?php 
		$count = count($podcasts);
		 if($count >=5 && $atts['horizontal'] == "true"){
			 ?>
			 <div class="arrows">
				<div class="left-arrow">
				<i class="fa fa-arrow-left"></i>
				</div>
				<div class="right-arrow"> <i class="fa fa-arrow-right"></i></div>
			</div>
			 <?php
		 }
		?>
		<div class="yidpod_title"><?php echo $category->name;  ?></div>
		<div class="podcasts <?php echo $classes; ?>">
	 		<?php foreach($podcasts as $podcast){ 
			$id = $podcast->ID;   
			?>    
				
					<div class="podcast">
						 <a href="<?php echo get_the_permalink($id); ?>">
							 <div class="podcast_image">
							 <?php echo display_lazy_loaded_podcast_image($id,array(200,200)); ?>

							 </div>
							 <div class="podcast_title" title="<?php echo get_the_title($id); ?>"><?php echo $podcast->post_title; ?></div>
						 </a>
			 		</div>
			<?php  } ?>
		</div>
		<?php yidpod_arrows_html('.category_page','.podcasts',$per_cat);  ?>
		
	</div>
	<?php
	return ob_get_clean();
}
function yidpod_arrows_html($container,$parent,$per_cat){
	?>
	 
	
	<script>
		//console.log(jQuery);
		jQuery('<?php echo $container.$per_cat; ?> .right-arrow').on('click',function(){
			jQuery('<?php echo $container.$per_cat; ?> .left-arrow').show();
			let currentScroll = jQuery('<?php echo $per_cat.' '.$parent; ?>').get(0).scrollLeft;
			let scrollWidth = jQuery('<?php echo $per_cat.' '.$parent; ?>').get(0).scrollWidth;
			if((currentScroll + 200) >= scrollWidth){
				//console.log('here')
					return;
			}else{
				jQuery('<?php echo $per_cat.' '.$parent; ?>').animate({
					scrollLeft: '+=230px'
					}, "slow");
			}

		})
		jQuery('<?php echo $container.$per_cat; ?> .left-arrow').on('click',function(){
			let currentScroll = jQuery('<?php echo $per_cat.' '.$parent; ?>').get(0).scrollLeft;
			let scrollWidth = jQuery('<?php echo $per_cat.' '.$parent; ?>').get(0).scrollWidth;
			if((currentScroll - 200) <= 0){
				//console.log('here')
				jQuery('<?php echo $per_cat.' '.$parent; ?>').animate({
					scrollLeft: '-=220px'
					}, "slow");
					return;
			}else{
				jQuery('<?php echo $per_cat.' '.$parent; ?>').animate({
					scrollLeft: '-=220px'
					}, "slow");
			}

		})
	</script>
	<?php
}
add_shortcode('yidpod_category','yidpod_category_shortcode');

function yidpod_user_feed($request){
	global $wpdb;
	$episode_table = $wpdb->prefix.'episode';
	$subscribe_table = $wpdb->prefix.'yp_subscribe';
	$user_id = get_current_user_id();
	if(current_user_can( 'manage_options' )){
		$user_id = $_GET['user_id'] ?? get_current_user_id();
	}
	if($user_id){
		$query = "SELECT *,DATE_FORMAT(FROM_UNIXTIME(`published_date`), '%m/%d/%Y') AS formatted_date from ".$episode_table. ' WHERE podcast_id in (SELECT podcast_id from '.$subscribe_table.' where user_id = '.$user_id.') order by published_date DESC limit '.$_GET['limit'].' offset '.$_GET['offset'];
		$episodes = $wpdb->get_results($query);
		if(!$wpdb->last_error){
			return wp_send_json_success($episodes);
		}else{
			return wp_send_json_error($wpdb->last_error);
		}

	}
	return wp_send_json_error('not logged in');
}
// add_action('wp_ajax_yidpod_user_feed','yidpod_user_feed');
function yidpod_my_feed(){
	ob_start();

	?>
	<style>
		.episode_image{
			width: 100px;
			height: 100px;
		}
	</style>
	<div class="episodes">
		 
	</div>
	<script>
		jQuery(document).ready(function(){
			getEpisodes();
		});
		function getEpisodes(){
			jQuery.ajax({
				url: "<?php echo admin_url('admin-ajax.php'); ?>",
				data:{ action: 'yidpod_user_feed',limit: 10,user_id: 219,offset: 0},
				success: function(response){
					console.log(response);
					const episodes = response.data.map(function(e){
						return episode_html(e);
					}).join('');
					jQuery('.episodes').append(episodes)
				},
				error: function(error){
					console.log(error)
				}

			})
		}
		function episode_html(episode){
			
			const today = new Date();
			const yyyy = today.getFullYear();
			let mm = today.getMonth() + 1; // Months start at 0!
			let dd = today.getDate();

			if (dd < 10) dd = '0' + dd;
			if (mm < 10) mm = '0' + mm;

			var date2 = mm + '/' + dd + '/' + yyyy;
            var date1 = episode.formatted_date;

			var date3 = new Date(date1);
			var date4 = new Date(date2);
			var diffDays = parseInt((date4 - date3) / (1000 * 60 * 60 * 24), 10); 

			var published_date = episode.published_date;
			var duration = episode.duration;
			 var urlepi = `<?= site_url() ?>/listen/?podcast=${episode.podcast_id}`; 
			return `
				<div class="episode"><div class="cs-row">
				<div class="episode_image">
						<img src="${episode.image_uri}">
					</div>
					<div class="episode_title"><h4>${episode.title}</h4>
                    <span class="section__container"><span><i class="fa fa-calendar" aria-hidden="true"></i> ${diffDays} days ago </span><span><i class="fa fa-clock-o" aria-hidden="true"></i> ${duration}</span></span>
					</div>
					
                    <div class="cs-track-play-btn" data-image="${episode.image_uri}" data-url="${episode.url}" data-title="${episode.title}">
						 <i class="fa fa-play"></i>
					</div>
				 </div></div>`;
		}
	</script>
	<?php
	return ob_get_clean();
}
add_shortcode('yidpod_my_feed','yidpod_my_feed');