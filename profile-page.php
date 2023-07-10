<?php
/*


template name: Profile Template

*/


get_template_part('player/header-player'); ?>
<style>
.cs-content-search {
    padding-top: 20px;
}
.logo_wrp.exit-btn{
	text-align: left;
}
.logo_wrp.exit-btn a {
    background: #4bba6a;
    margin: 10px 0;
    display: inline-block;
    padding: 2px 10px;
    color: white;
    border-radius: 5px;
    font-size: 16px;
	font-weight: 600;
}
.logo_wrp.exit-btn a .fa {
    font-size: 18px;
}
</style>

<?php



global $current_user, $wp_roles;
//get_currentuserinfo(); //deprecated since 3.1

/* Load the registration file. */
//require_once( ABSPATH . WPINC . '/registration.php' ); //deprecated since 3.1
$error = array();    
/* If profile was saved, update profile. */
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-user' ) {

    /* Update user password. */
    if ( !empty($_POST['pass1'] ) && !empty( $_POST['pass2'] ) ) {
        if ( $_POST['pass1'] == $_POST['pass2'] )
            wp_update_user( array( 'ID' => $current_user->ID, 'user_pass' => esc_attr( $_POST['pass1'] ) ) );
        else
            $error[] = __('The passwords you entered do not match.  Your password was not updated.', 'profile');
    }

     
    if ( !empty( $_POST['url'] ) )
        wp_update_user( array( 'ID' => $current_user->ID, 'user_url' => esc_url( $_POST['url'] ) ) );
	
	/* Update user Email.
    if ( !empty( $_POST['email'] ) ){
        if (!is_email(esc_attr( $_POST['email'] )))
            $error[] = __('The Email you entered is not valid.  please try again.', 'profile');
        elseif(email_exists(esc_attr( $_POST['email'] )) != $current_user->ID )
            $error[] = __('This email is already used by another user.  try a different one.', 'profile');
        else{
            wp_update_user( array ('ID' => $current_user->ID, 'user_email' => esc_attr( $_POST['email'] )));
        }
    }*/

    if ( !empty( $_POST['first-name'] ) )
        update_user_meta( $current_user->ID, 'first_name', esc_attr( $_POST['first-name'] ) );
    if ( !empty( $_POST['last-name'] ) )
        update_user_meta($current_user->ID, 'last_name', esc_attr( $_POST['last-name'] ) );
    if ( !empty( $_POST['description'] ) )
        update_user_meta( $current_user->ID, 'description', esc_attr( $_POST['description'] ) );

    /* Redirect so the page will show updated info.*/
  /*I am not Author of this Code- i dont know why but it worked for me after changing below line to if ( count($error) == 0 ){ */
    if ( count($error) == 0 ) {
        //action hook for plugins and extra fields saving
        do_action('edit_user_profile_update', $current_user->ID);
        wp_redirect( get_permalink() );
         
    }
}
?>


<div id="main-content">
           <div class="cs-row">
            <div class="cs-sidebar">
			<?php include('player/sidebar.php'); ?>
			</div>
			
            <div class="cs-content cs-feeds">
			<?php include('player/search-bar.php'); ?>
                <div class="cs-featured-content">
                	<div class="inner__content">
					<div class="logo_wrp exit-btn">
						<a href="#"><i class="fa fa-arrow-left" aria-hidden="true"></i> Exit</a>
				    </div>
						 <div class="cs-content-profile">
					 <h3>My Profile</h3>
					  <?php if ( !is_user_logged_in() ) : ?>
											<p class="warning">
												<?php _e('You must be logged in to edit your profile.', 'profile'); ?>
											</p><!-- .warning -->
					  <?php else : ?>
					  <?php if ( count($error) > 0 ) echo '<p class="error">' . implode("<br />", $error) . '</p>'; ?>
										<form method="post" id="updateuser" action="<?php the_permalink(); ?>">
											<p class="form-username">
												<label for="first-name"><?php _e('First Name', 'profile'); ?></label>
												<input class="text-input" name="first-name" type="text" id="first-name" value="<?php the_author_meta( 'first_name', $current_user->ID ); ?>" />
											</p><!-- .form-username -->
											<p class="form-username">
												<label for="last-name"><?php _e('Last Name', 'profile'); ?></label>
												<input class="text-input" name="last-name" type="text" id="last-name" value="<?php the_author_meta( 'last_name', $current_user->ID ); ?>" />
											</p> 
											<p class="form-url">
												<label for="url"><?php _e('Website', 'profile'); ?></label>
												<input class="text-input" name="url" type="text" id="url" value="<?php the_author_meta( 'user_url', $current_user->ID ); ?>" />
											</p><!-- .form-url -->
											<p class="form-password">
												<label for="pass1"><?php _e('Password', 'profile'); ?> </label>
												<input class="text-input" name="pass1" type="password" id="pass1" />
											</p><!-- .form-password -->
											<p class="form-password">
												<label for="pass2"><?php _e('Repeat Password', 'profile'); ?></label>
												<input class="text-input" name="pass2" type="password" id="pass2" />
											</p><!-- .form-password -->
											<p class="form-textarea">
												<label for="description"><?php _e('Biographical Information', 'profile') ?></label>
												<textarea name="description" id="description" rows="3" cols="50"><?php the_author_meta( 'description', $current_user->ID ); ?></textarea>
											</p><!-- .form-textarea -->

											 
											<p class="form-submit">
												 
												<input name="updateuser" type="submit" class="submit button" value="<?php _e('Update', 'profile'); ?>" />
												<?php wp_nonce_field( 'update-user' ) ?>
												<input name="action" type="hidden" id="action" value="update-user" />
											</p><!-- .form-submit -->
										</form><!-- #updateuser -->
										<?php endif; ?>
										
										 
						 
					 </div>
					 </div>
				</div>

				
            </div>
          </div>
		  <?php include('player/mini-player.php'); ?>

         
</div>

<?php get_template_part('player/footer-player'); ?> 


