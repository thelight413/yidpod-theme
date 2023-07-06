<?php if ( 'on' == et_get_option( 'divi_back_to_top', 'false' ) ) : ?>

	<span class="et_pb_scroll_top et-pb-icon"></span>

<?php endif;

if ( ! is_page_template( 'page-template-blank.php' ) ) : ?>

			<footer id="main-footer">
				<?php get_sidebar( 'footer' ); ?>


		<?php
			if ( has_nav_menu( 'footer-menu' ) ) : ?>

				<div id="et-footer-nav">
					<div class="container">
						<?php
							wp_nav_menu( array(
								'theme_location' => 'footer-menu',
								'depth'          => '1',
								'menu_class'     => 'bottom-nav',
								'container'      => '',
								'fallback_cb'    => '',
							) );
						?>
					</div>
				</div> <!-- #et-footer-nav -->

			<?php endif; ?>

				<div id="footer-bottom">
					<div class="container clearfix">
				<?php
					if ( false !== et_get_option( 'show_footer_social_icons', true ) ) {
						get_template_part( 'includes/social_icons', 'footer' );
					}

					echo et_get_footer_credits();
				?>
					</div>	<!-- .container -->
				</div>
			</footer> <!-- #main-footer 22 -->
			
		</div> <!-- #et-main-area -->

<?php endif; // ! is_page_template( 'page-template-blank.php' ) ?>

	</div> <!-- #page-container -->

	<?php wp_footer(); ?>
</body>
</html>

<!------------- jQuery for contact us form for web player---------------->
<script>
jQuery('#feedback-contact').change(function() {
    var feedback = jQuery(this).val();
	if(feedback == 'Feedback'){
		jQuery('[name="your-message"]').attr('placeholder','Let us know your thoughts!');
	}
	if(feedback == 'Feature Request'){
		jQuery('[name="your-message"]').attr('placeholder','What features would you like to see in the app?');
	}
	if(feedback == 'Bug Report'){
		jQuery('[name="your-message"]').attr('placeholder','Please describe the issue you are experiencing.');
		jQuery('.report-bug').show();
	}else{
		jQuery('.report-bug').hide();
	}
	if(feedback == 'New Podcast'){
		jQuery('[name="your-message"]').attr('placeholder','Please include a link to the podcast you did like to see added.');
	}
});




</script>



