
 <link href="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
 <script src="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/owl.carousel.js"></script>
<div class="sidebar-inner"> 
    <div class="mobile-icon" id="close-menu"><i class="fa fa-chevron-left" aria-hidden="true"></i></div>
	 <?php
					$logo = get_site_url().'/wp-content/uploads/2022/06/YidPodcolor-logo.png';
				?>
				<div class="logo_wrp">
					<a href="#">
						<img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
					</a>
				</div>
	<div class="cs-links">
	  <?php wp_nav_menu( array(
    'menu' => 'Web Player'
) ); ?>
	</div>
</div> 
<script type="text/javascript" src="<?= get_stylesheet_directory_uri() ?>/player/assest/common_ajax.js"></script>
<style type="text/css">
#loader-inner {
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
 .podcast_image img, .podcast_img img{
    width: 100%;
    object-fit: cover;
}
@media screen and (max-width: 1920px) {
    .podcasts_list, .podcasts_lists {
            grid-template-columns: repeat(6, 1fr);
    }
    
} 
 .podcasts_lists .podcast {
    padding: 10px;
}
 .podcasts_lists {
    display: grid;
    grid-gap: 0;
    grid-template-columns: repeat(5, 1fr);
}
</style> 
<div id="loader-inner"></div>