<!DOCTYPE html>
<?php 
/*
if ( isset($_COOKIE['sign_up_letter1']) || $_GET['sign_up_later']) {

if(isset($_GET['sign_up_later']) && !empty($_GET['sign_up_later'])){
	$cookies = setcookie( 'sign_up_letter1', $_GET['sign_up_later'], time() + 36000000, COOKIEPATH, COOKIE_DOMAIN   );
	$temp_user_id_value = $_GET['sign_up_later'];
}else{
	$temp_user_id_value =	$_COOKIE['sign_up_letter1'];
}


	
	 
}else{
	
	if(!is_user_logged_in()){
	$url = site_url().'/my-account';
	  //wp_redirect( $url ); 
	 echo "<script>window.location.href = '".$url."';</script>";
 
      
	}
	 




} 
*/

?>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<?php elegant_description(); ?>
	<?php elegant_keywords(); ?>
	<?php elegant_canonical(); ?>

	<?php do_action( 'et_head_meta' ); ?>

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<script type="text/javascript">
		document.documentElement.className = 'js';
	</script>
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/player/css/style.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<?php wp_head(); ?>

	
</head>
<body <?php body_class(); ?>>



 
	  
			
		 
	