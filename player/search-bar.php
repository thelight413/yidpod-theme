<div class="cs-nav-wrpr">
                <div class="mobile-menu-icon"><i class="fa fa-bars" aria-hidden="true"></i></div>
				<div class="search-area">
					<form action="<?php echo get_site_url(); ?>/search/">
					<input type="search" name="search" placeholder="Search" id="searchlist" class="searchlist"><i class="fa fa-window-close custom_close" aria-hidden="true" style="display: none"></i>
					</form>
				</div>
				<div class="button-area">
				   <a href="https://jewishpodcasts.fm/signup" class="for-desktop cs-btn">Create a Podcast</a> <a href="https://thechesedfund.com/yidpod/helpusgrow" target="_blank" class="donate-btn">Donate</a>
				   <div class="user-account">
				   <i id="user-icon" class="fa fa-user-o" aria-hidden="true"></i>
				   <div class="user-menu">
					   <ul>
					   <li><a href="<?php the_permalink(2991); ?>"><i class="fa fa-question-circle" aria-hidden="true"></i> Contact Us</a></li>
					   <!--<li><a href="https://jewishpodcasts.fm/signup" target="_blank"><i class="fa fa-plus" aria-hidden="true"></i> Create a Podcast</a></li>-->
					    <?php if(is_user_logged_in()){ ?>
					   <li><a href="<?php the_permalink(2906); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Profile</a></li>
					   <?php }?>
					   <li><a href="<?php the_permalink(1980); ?>"><i class="fa fa-life-ring" aria-hidden="true"></i> Beta Tester</a></li>
					   <li class="for-mobile"><a href="https://jewishpodcasts.fm/signup" target="_blank"><i class="fa fa-plus" aria-hidden="true"></i> Create a Podcast</a></li>
					   <?php if(is_user_logged_in()){ ?>
						   <li><a href="<?php echo wp_logout_url( home_url('my-account') ); ?>"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
					  <?php }else{ ?>
						   <li><a href="<?php the_permalink(2531); ?>"><i class="fa fa-sign-out" aria-hidden="true"></i> Login</a></li>
					  <?php }?>
					    
					   </ul>
				   </div>

				   </div> 
				   <?php 
                   global $current_user;

                   if(isset($current_user->display_name) && !empty($current_user->display_name)){
                   	echo "<p class='display_name_profile'>Hello , $current_user->display_name </p>";
                   }

				   ?>
			    </div>
			</div>