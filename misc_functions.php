<?php 

function display_lazy_loaded_podcast_image($podcast_id,$size){
    $thumb = wp_get_attachment_image_src(get_post_thumbnail_id($podcast_id), $size);
    $src = $thumb['0'];
	$class = "lazy";
    $placeholder = get_stylesheet_directory_uri().'/assets/image-solid.svg';
    return '<img src="'.$placeholder.'" data-original="'.$src.'" class="'.$class.'" />';

   
}