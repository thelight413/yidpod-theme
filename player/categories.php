 

<?php 

//$terms = get_terms('category');
$cat_option = get_option('yidpod_option_name');
$terms = explode(",",$cat_option);
if(!empty($terms)){
	echo '<div class="category-slider owl-carousel owl-theme">';
				foreach($terms as $cat){
                    $term = get_term( $cat, 'category' );
                    $cat_slug = $term->slug;
                    $cat_name = $term->name;
					 if($cat_name == 'Uncategorized'){
				      continue;
					} 
					echo '<div class="item"><a href="'.get_the_permalink(2876).'?cat='.$cat_slug.'">'.$cat_name.'</a></div>';
				}
	echo '</div>';
}
?>

<script>
var owl = $('.category-slider');
owl.owlCarousel({
    loop:true,
    margin:10,
	autoWidth:true,
	items:6,
	nav:true,
	 responsive:{
        0:{
           items:2, 
        },
        600:{
            items:3
        },
        1000:{
            items:6
        }
    }
});
 
</script>
 