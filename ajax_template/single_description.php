<?php 

//$episode_id = get_query_var( 'episode_id' );
//$single_page_id = get_query_var( 'single_page_id' );

// $data = get_query_var( 'data' );
// $data = explode(",", $data);
// $episode_id = $data[0];
// $single_page_id = $data[1];

global $wpdb;
$table_name = $wpdb->prefix."episode";
$sql = "SELECT * from  $table_name WHERE id='$episode_id' ";
$results = $wpdb->get_results($sql);
?>
<div class="back__btn">
	<button><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
	<input type="hidden" id="back_btn" value="<?= $episode_id ?>">
	<input type="hidden" id="back_btn_page_id" value="<?= $single_page_id ?>">
</div>
<div class="cs-content-search"></div>
<div class="single__description_container cs-episode-page">
<div class="single__description_container_inner" style="text-align: center;margin-top: 15px;">
<img src="<?= $results[0]->image_uri ?>" width="250" class="episode-img"/>
<h2 class="cs-clickable-title sub-title df" data-id="<?= $episode_id ?>" ><?= $results[0]->title ?></h2>
<h4 class="sub-title-top" data-author="<?= $results[0]->author ?>"><?= $results[0]->author ?></h4>


<div class="btn__container">
<button data-id="<?= $episode_id ?>" class="play__btn">Play</button>




<div class="share-option">
				  <span class="ellipsis-share2"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></span>
					<div class="dropcustom dropdown-share2">
						<li class="cs-download"><a href="<?= $results[0]->url ?>" target="_blank" download>Download</a></li>
						<li class="copylinktoepisodes">Copy Link to Episode</li>
						<li><a target="_blank" id="wts_btn" href="https://api.whatsapp.com/send?text=<?= $results[0]->url ?>">Share to Whatsapp</a></li>
						<li><a target="_blank" id="twtr_btn" href="https://twitter.com/intent/tweet?via=<?= $results[0]->url ?>">Share to Twitter</a></li>
						<li><a target="_blank" id="fb_btn" href="https://www.facebook.com/sharer/sharer.php?u=<?= $results[0]->url ?>">Share to Facebook</a></li>
					</div>
</div>

 
 

		</div>
</div>
</div>
<p class="single_description"><?= strip_tags($results[0]->description) ?></p>
</div>

<script>
// Function to hide the dropdown when clicked outside
function hideDropdownOutsideClick2() {
	jQuery(document).on("click", function(event) {
    var target = jQuery(event.target);
    var dropdown = jQuery(".dropdown-share2");

    if (!target.closest(".ellipsis-share2").length && !target.closest(".dropdown-share2").length) {
      dropdown.slideUp(function() {
        dropdown.removeClass("open");
      });
    }
  });
}

// Click event handler for ellipsis-share
jQuery(".ellipsis-share2").on("click", function() {
  var dropdown = jQuery(this).next(".dropdown-share2");

  dropdown.slideToggle(function() {
    dropdown.toggleClass("open");

    if (dropdown.hasClass("open")) {
      hideDropdownOutsideClick2();
    } else {
		jQuery(document).off("click");
    }
  });
});

jQuery('.cs-episode-page .copylinktoepisodes').on('click', function(){
    // var linkElement = document.querySelector('.cs-episode-page .cs-download a');
    var link = window.location.href;
    const self = this;
    // Copy the link to the clipboard
    navigator.clipboard.writeText(link).then(function() {
    //  console.log('Link copied to clipboard:', link);
    //  alert('Link copied to clipboard!');
    jQuery(self).text("Copied episode link");
    
    }).catch(function(error) {
      console.error('Failed to copy link to clipboard:', error);
    });

});

</script>