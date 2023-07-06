<?php
/*


template name: Create podcast Template

*/


get_template_part('player/header-player');


 if(isset($_POST['podcast_link']) && isset($_POST['submit_podcast'])){
        
        // echo $_POST['podcast_link'];
        $content = file_get_contents($_POST['podcast_link']);
        $x = new SimpleXmlElement($content);
        $title = $x->channel->title;
        $description = $x->channel->description;

        $link = $x->channel->link;
        $image_url = (string)$x->channel->image->url;
        $post_args = array(
            'post_title' => (string)$title,
            'post_content' => (string)$description,
            'post_excerpt' => $_POST['podcast_link'],
            'post_type' => 'podcasts',
            'post_status' => 'publish',
            'post_category' => $_POST['podcast_category'] ?? array()
        ); 

        $id = wp_insert_post(
            $post_args,true
    );
        if($id > 0){
      update_post_meta($id, 'feedlink', $_POST['podcast_link']);
      update_post_meta($id, 'image_uri',$image_url);
    if($x->channel->children('itunes', TRUE)){
        $author = $x->channel->children('itunes', TRUE)->author->__toString();
        update_post_meta($id,'podcast_author',$author);
    }

      // update user id in podcast postmeta
      $currentUser = get_current_user_id();
      update_post_meta($id,'user_id',$currentUser);

      addImageToPost($id,$image_url);
      yidpod_episodes_run_test($id);
      ?>
      <div class="notice notice-success is-dismissible text-center text-success">
        Successfully added podcast - <?php echo (string)$title; ?>
      
      </div>
      <?php
    }else{
      ?>
      <div class="notice notice-error is-dismissible text-center text-danger">
        Something went wrong. Please check logs.
      
      </div>
      <?php
    }
}


 ?>
<style>
.cs-content-search {
    padding-top: 20px;
}
input[name="podcast_link"] {
    background-color: #fff;
    border: 1px solid #bbb;
    padding: 2px;
    color: #4e4e4e;
    width: 60%;
    height: 40px;
    border-radius: 5px;
    font-size: 16px;
    padding-left: 10px;
}
</style>
<div id="main-content">
           <div class="cs-row">
            <div class="cs-sidebar">
			<?php include('player/sidebar.php'); ?>
			</div>
			
            <div class="cs-content cs-feeds">
                <div class="cs-featured-content">
				     <div class="cs-content-search">
					 </div>
					 <div class="cs-content-feed">
					 <h3>Create podcast</h3>


					<form action='' method='post'>
						<div class="form-group">
							<label for="podcast_link">Podcast Link:</label>
						   <input type="text" name="podcast_link" id="podcast_link" required />
					     </div>

						<div class="form-group">
						<label for="selectcategory">Select Category</label>
						<select name="podcast_category[]" multiple class="form-control" id="selectcategory">
						<?php
						$categories = get_categories(array(    'hide_empty' => false,));
						foreach($categories as $category){
						?>
						<option value = "<?php echo $category->cat_ID; ?>">
						<?php echo $category->name; ?>
						</option>
						<?php
						}
						?>
						</select>
						</div>
						<input type="submit" name="submit_podcast" class="btn btn-primary" />

					</form>


           

					 
					 </div>
				</div>
				<?php //include('player/mini-player.php'); ?> 
            </div>
          </div>
</div>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>

<!-- Popper JS -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<?php get_template_part('player/footer-player'); ?> 
