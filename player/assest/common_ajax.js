jQuery(document).ready(function(){
	// search ajax
	//jQuery('.menu-item-3050').addClass("active");
	jQuery(document).on("click",".menu-item-3048 a",function(e){
          e.preventDefault();
		  var page_url = 'https://yidpod.com/search/';
		  window.history.pushState('page', '', page_url);
		  var titletext = jQuery(this).text();
	          jQuery("title").text(titletext);
          jQuery("#menu-web-player li").each(function(){
		  	jQuery(this).removeClass("active");
		  });

		  var playlist_ctn = jQuery(".playlist-ctn").html();
		  jQuery(".menu-item-3048").addClass("active");
          jQuery("#loader-inner").css("display","block");
           jQuery.ajax({
                             type : "post",
                             url : "/wp-admin/admin-ajax.php",
                             data : {action: "get_search_page_content","page":"search"},
                             success: function(response) {
                               jQuery(".inner__content").html(response.result);
                               jQuery("#loader-inner").css("display","none");
                               if(playlist_ctn.length > 0){
                               	jQuery(".playlist-ctn").html(playlist_ctn)
                               }
                               
                             },
                          }); 
         
	});

   // get category data by ajax

   jQuery(document).on("click",".cat__item",function(){

   	var cat_name =  jQuery(this).find("a").attr("data-cat");

			jQuery("#loader-inner").css("display","block");
				jQuery.ajax({
				type : "post",
				url : "/wp-admin/admin-ajax.php",
				data : {action: "get_cat_item","cat_name":cat_name},
				success: function(response) {
				jQuery(".inner__content").html(response.result);
				jQuery("#loader-inner").css("display","none");
                 lazifyNewImages();

				},
			});

   });

   // get single page data
jQuery(document).on("click",".podcasts .podcast a:not(.browse-episodes .podcasts .podcast a),.podcasts_lists .podcast a,.podcast-item a:not(.browse-episodes .podcast-item a),.podcasts_list .podcast a",function(e){

e.preventDefault();
var podcasturl = jQuery(this).attr("href");
window.history.pushState('page', '', podcasturl);
   jQuery("#loader-inner").css("display","block");
		 jQuery.ajax({
		 type : "post",
		 url : "/wp-admin/admin-ajax.php",
		 data : {action: "get_single_item_podcast","podcasturl":podcasturl},
		 success: function(response) {
		 jQuery(".inner__content").html(response.result);
		 jQuery("#loader-inner").css("display","none");
		 document.documentElement.scrollTop = 0;
		lazifyNewImages();

		 },
	 });

});
  
   // my show page content
	jQuery(document).on("click",".menu-item-2888 a",function(e){
          e.preventDefault();
		      var page_url = 'https://yidpod.com/my-shows';
	          window.history.pushState('page', '', page_url);
	          var titletext = jQuery(this).text();
	          jQuery("title").text(titletext);
           jQuery("#menu-web-player li").each(function(){
		  	jQuery(this).removeClass("active");
		  });
		  jQuery(".menu-item-2888").addClass("active");
          jQuery("#loader-inner").css("display","block");
          var playlist_ctn = jQuery(".playlist-ctn").html();
           jQuery.ajax({
                             type : "post",
                             url : "/wp-admin/admin-ajax.php",
                             data : {action: "get_myshow_page_content","page":"myshow"},
                             success: function(response) {
                               jQuery(".inner__content").html(response.result);
                               jQuery("#loader-inner").css("display","none");
                                if(playlist_ctn.length > 0){
                               	jQuery(".playlist-ctn").html(playlist_ctn)
                               }
                               lazifyNewImages();

                             },
                          }); 
         
	});
	//Browse episode button
	jQuery(document).on("click",".menu-item-11868 a",function(e){
		e.preventDefault();
		var page_url = 'https://yidpod.com/browse-episodes';
		window.history.pushState('page', '', page_url);
		jQuery('.menu-item').removeClass("active");
		jQuery('.menu-item-11868').addClass("active");
		jQuery("#loader-inner").css("display","block");
		var playlist_ctn = jQuery(".playlist-ctn").html();
		jQuery.ajax({
								 type : "post",
								 url : "/wp-admin/admin-ajax.php",
								 data : {action: "get_browse_episodes_content","page":"episodes"},
								 success: function(response) {
								   jQuery(".inner__content").html(response.result);
								   jQuery("#loader-inner").css("display","none");
								   if(playlist_ctn.length > 0){
									   jQuery(".playlist-ctn").html(playlist_ctn)
								   }
								   
								 },
							  }); 
	
	});
	 // my feed page content
	jQuery(document).on("click",".menu-item-3050 a,.logo_wrp a",function(e){
          e.preventDefault();
		     var page_url = 'https://yidpod.com/listen/';
	          window.history.pushState('page', '', page_url);
	          console.log("page_url",page_url);
	          jQuery("title").text("Listen");

          jQuery("#menu-web-player li").each(function(){
		  	jQuery(this).removeClass("active");
		  });
		  jQuery(".menu-item-3050").addClass("active");
          jQuery("#loader-inner").css("display","block");
          var playlist_ctn = jQuery(".playlist-ctn").html();
           jQuery.ajax({
                             type : "post",
                             url : "/wp-admin/admin-ajax.php",
                             data : {action: "get_listen_page_content","page":"listen"},
                             success: function(response) {
                               jQuery(".inner__content").html(response.result);
                               jQuery("#loader-inner").css("display","none");
                                if(playlist_ctn.length > 0){
                               	jQuery(".playlist-ctn").html(playlist_ctn)
                               }
                               lazifyNewImages();

                             },
                          }); 
         
	});

	// listen page content
	jQuery(document).on("click",".menu-item-3049 a",function(e){
          e.preventDefault();
		  var page_url = 'https://yidpod.com/my-feed/';
	          window.history.pushState('page', '', page_url);
	          var titletext = jQuery(this).text();
	          jQuery("title").text(titletext);
          jQuery("#menu-web-player li").each(function(){
		  	jQuery(this).removeClass("active");
		  });
		  jQuery(".menu-item-3049").addClass("active");
          jQuery("#loader-inner").css("display","block");
          var playlist_ctn = jQuery(".playlist-ctn").html();
           jQuery.ajax({
                             type : "post",
                             url : "/wp-admin/admin-ajax.php",
                             data : {action: "get_mysfeed_page_content","page":"listen"},
                             success: function(response) {
                               jQuery(".inner__content").html(response.result);
                               jQuery("#loader-inner").css("display","none");
                                if(playlist_ctn.length > 0){
                               	jQuery(".playlist-ctn").html(playlist_ctn)
                               }
								lazifyNewImages();

                             },
                          }); 
         
	});


   

});


// get browse page content

jQuery(document).on("click",".menu-item-11868 a",function(e){
	e.preventDefault();
	var page_url = 'https://yidpod.com/browse-episodes';
	window.history.pushState('page', '', page_url);
	var titletext = jQuery(this).text();
	          jQuery("title").text(titletext);
	jQuery('.menu-item').removeClass("active");
	jQuery('.menu-item-11868').addClass("active");
	jQuery("#loader-inner").css("display","block");
	var playlist_ctn = jQuery(".playlist-ctn").html();
	jQuery.ajax({
                             type : "post",
                             url : "/wp-admin/admin-ajax.php",
                             data : {action: "get_browse_episodes_content","page":"episodes"},
                             success: function(response) {
                               jQuery(".inner__content").html(response.result);
                               jQuery("#loader-inner").css("display","none");
                               if(playlist_ctn.length > 0){
                               	jQuery(".playlist-ctn").html(playlist_ctn)
                               }
                               lazifyNewImages();

                             },
                          }); 

});


// for read more button
jQuery(document).ready(function(){

		

		jQuery(document).on("click",".more",function(e){
			e.preventDefault();
			var rmore_length = jQuery('.cs-des').html().length;
		var more_text_class = '<span>... </span><a class="more">Show more</a>';
		var less_text_class = '<span></span><a class="more">Less</a>';
		
			if(jQuery(".cs-rdmore").hasClass("moreclass")){
				jQuery(".intro").html(more_text_class);
			}else{
				jQuery(".intro").html(less_text_class);
			}
			jQuery('.cs-rdmore').toggleClass('moreclass');

		});

		// my feed page

		var oldAudiodata = listAudio;
	
	jQuery(document).on('click','#tabs-nav li',function(e){
		e.preventDefault();
         
         jQuery('#tabs-nav li').removeClass('active');
  jQuery(this).addClass('active');
  jQuery('.tab-content').hide();

  var acrtivetab = jQuery(this).find("a").attr("data-id");
  jQuery(".tab-content").css("display","none");

  jQuery("#"+acrtivetab).css("display","block");

  if(acrtivetab == "tab2"){
     listenHistoryRecord(acrtivetab);
  }else if(acrtivetab == "tab1"){
       // latestAudio(oldAudiodata);

       jQuery("#loader-inner").css("display","block");
           jQuery.ajax({
                             type : "post",
                             url : "/wp-admin/admin-ajax.php",
                             data : {action: "get_mysfeed_page_content","page":"myfeed"},
                             success: function(response) {
                               jQuery(".inner__content").html(response.result);
                               jQuery("#loader-inner").css("display","none");
                               lazifyNewImages();
                             },
                          }); 

  }
  });

	// End my feed page

});


function listenHistoryRecord(tab){
	jQuery("#loader-inner").css("display","block");
	 jQuery.ajax({
                type : "post",
                url : "/wp-admin/admin-ajax.php",
                data : {action: "listenHistory_record", tab : tab},
                success: function(response) {
                	 if(response.login){

                	
                     if(response.data.length > 0){
                	jQuery("#tab2").html('<div class="playlist-ctn" style="display: block !important;height: auto;"></div>');
                	jQuery("#tab1").html('');


                	
						try {
							listAudio = JSON.parse(JSON.stringify(response.data));
							jQuery(".playlist-ctn").html("");

							for (var i = 0; i < listAudio.length; i++) {
							createTrackItem(i,listAudio[i].name,listAudio[i].duration,listAudio[i].image,listAudio[i].formatted_date,listAudio[i].eid);
							}
							var indexAudio = 0;
							var playListItems = document.querySelectorAll(".playlist-track-ctn");

							for (let i = 0; i < playListItems.length; i++){
							playListItems[i].addEventListener("click", getClickedElement.bind(this));
							}



						}
						catch(err) {
						console.log("Error listAudio",err);
						}
					}else{
						jQuery("#tab2").html('<div class="not-login-wrpr"><a href="/browse-episodes/" class="login-btn">Browse episodes</a></div>');
					}

					}else{
						jQuery("#tab2").html('<div class="not-login-wrpr"><h2>Please login to view your history</h2><a href="/my-account/" class="login-btn">Login</a></div>');
					    jQuery("#tab1").html('');
					}

						jQuery("#loader-inner").css("display","none");

                },
          }); 

}

// update latest Audio

function latestAudio(oldAudiodata){

	try {                   
		                    jQuery("#tab2").html('');
		                    jQuery("#tab1").html('<div class="playlist-ctn" style="display: block !important;height: auto;"></div>');
                	
							listAudio = oldAudiodata;
							jQuery(".playlist-ctn").html("");

							for (var i = 0; i < listAudio.length; i++) {
							createTrackItem(i,listAudio[i].name,listAudio[i].duration,listAudio[i].image,listAudio[i].formatted_date,listAudio[i].eid);
							}
							indexAudio = 0;
							currentAudio.load();
							var playListItems = document.querySelectorAll(".playlist-track-ctn");

							for (let i = 0; i < playListItems.length; i++){
							playListItems[i].addEventListener("click", getClickedElement.bind(this));
							}



						}
						catch(err) {
						console.log("Error listAudio",err);
						}

}


jQuery(document).ready(function(){

	// play list of single podcast
jQuery(document).on("click",".new_playlist .playlist-track-ctn .playlist-btn-play",function(e){
	     var post_id = jQuery("#single_page_id").val();
	     var indexid = jQuery(this).attr("data-index");
  

	     if (typeof indexid !== 'undefined'){
	     	jQuery("#loader-inner").css("display","block");
	     jQuery.ajax({
                type : "post",
                url : "/wp-admin/admin-ajax.php",
                data : {action: "singlelistrecord", post_id : post_id},
                success: function(response) {
                	   jQuery("#loader-inner").css("display","none");
                       jQuery(".playlist-ctn").removeClass("new_playlist");
            	
						try {
							listAudio = JSON.parse(JSON.stringify(response.data));
							jQuery(".playlist-ctn").html("");

							for (var i = 0; i < listAudio.length; i++) {
							createTrackItem(i,listAudio[i].name,listAudio[i].duration,listAudio[i].image,listAudio[i].formatted_date,listAudio[i].eid);
							}
							
							var playListItems = document.querySelectorAll(".playlist-track-ctn");

							for (let i = 0; i < playListItems.length; i++){
							playListItems[i].addEventListener("click", getClickedElement.bind(this));
							}

                            indexAudio = indexid;

           

                            loadNewTrack(indexAudio);

                            

						}
						catch(err) {
						console.log("Error listAudio",err);
						}
                },
          }); 

	 }

});

// my feed latest episode

jQuery(document).on("click",".new_playlist1 .playlist-track-ctn .playlist-btn-play",function(e){
	     
	     var indexid = jQuery(this).attr("data-index");

  
	     if (typeof indexid !== 'undefined'){
	     	jQuery("#loader-inner").css("display","block");
	     jQuery.ajax({
                type : "post",
                url : "/wp-admin/admin-ajax.php",
                data : {action: "singlelistrecordle", latestepisodes : "latestepisodes"},
                success: function(response) {
                	
                       jQuery(".playlist-ctn").removeClass("new_playlist1");
                       jQuery("#loader-inner").css("display","none");
            	
						try {
							listAudio = JSON.parse(JSON.stringify(response.data));
							jQuery(".playlist-ctn").html("");

							for (var i = 0; i < listAudio.length; i++) {
							createTrackItem(i,listAudio[i].name,listAudio[i].duration,listAudio[i].image,listAudio[i].formatted_date,listAudio[i].eid);
							}
							
							var playListItems = document.querySelectorAll(".playlist-track-ctn");

							for (let i = 0; i < playListItems.length; i++){
							playListItems[i].addEventListener("click", getClickedElement.bind(this));
							}

                            indexAudio = indexid;

           

                            loadNewTrack(indexAudio);

                            

						}
						catch(err) {
						console.log("Error listAudio",err);
						}
                },
          }); 

	 }

});



// single play description

jQuery(document).on("click",".play__btn",function(e){
	
	     var episode_id = jQuery(this).attr("data-id");
	     var thisVar = jQuery(this);

	     var playlistchck = jQuery(".play__btn").attr("playlist");

	     if(typeof playlistchck !== "undefined"){
          
          var status = thisVar.attr("status");

          if(status == "play"){
          	thisVar.attr("status","pause");
          	thisVar.text("Play");
          	toggleAudio();
          }
          else if(status == "pause"){

          	thisVar.attr("status","play");
          	thisVar.text("Pause");
          	toggleAudio();

          }

	     }
	     
	     if (episode_id && typeof playlistchck === "undefined"){
	     jQuery.ajax({
                type : "post",
                url : "/wp-admin/admin-ajax.php",
                data : {action: "singleplay", episode_id : episode_id},
                success: function(response) {
                	
                       
            	
						try {
							listAudio = JSON.parse(JSON.stringify(response.data));
							jQuery(".playlist-ctn").html("");

							for (var i = 0; i < listAudio.length; i++) {
							createTrackItem(i,listAudio[i].name,listAudio[i].duration,listAudio[i].image,listAudio[i].formatted_date,listAudio[i].eid);
							}
							
							var playListItems = document.querySelectorAll(".playlist-track-ctn");

							for (let i = 0; i < playListItems.length; i++){
							playListItems[i].addEventListener("click", getClickedElement.bind(this));
							}

                            indexAudio = 0;

           

                            loadNewTrack(indexAudio);

                            thisVar.attr("playlist","on");

                            thisVar.attr("status","play");

                            thisVar.text("Pause");



                            

						}
						catch(err) {
						console.log("Error listAudio",err);
						}
                },
          }); 

	 }

});


var current_episode_id = null;
jQuery(document).on("click",".playlist-info-track",function(e){
	e.preventDefault();
   	var episode_id = jQuery(this).attr("data-eid");
   	var playlist__ctn = jQuery(".playlist-ctn").html();
   	var single_page_id = jQuery("#single_page_id").val();
	current_episode_id = single_page_id;
   	if(typeof single_page_id == "undefined"){
   		single_page_id = 0;
   	}
   	if(episode_id){
		const page_url = window.location.href+'?episode_id='+episode_id;
		window.history.pushState('page', '', page_url);

   		jQuery("#loader-inner").css("display","block");
				jQuery.ajax({
				type : "post",
				url : "/wp-admin/admin-ajax.php",
				data : {action: "get_single_item_podcast_description","episode_id":episode_id,"single_page_id":single_page_id},
				success: function(response) {
				jQuery(".inner__content").html(response.result);
				jQuery("#loader-inner").css("display","none");
				jQuery(".playlist-ctn").html(playlist__ctn);

				},
			});

   	}

   	   

});

// share button click
jQuery(document).on("click",".btn__container .share-episode",function(e){

 jQuery("#share_episode").toggleClass("show");

});

// back button 

jQuery(document).on("click",".back__btn button",function(e){

	var action = "backbutton";

	var back_btnValue = jQuery("#back_btn").val();

	var back_btn_page_id = jQuery("#back_btn_page_id").val();
	const page_url = window.location.href.split('?')[0]

	window.history.pushState('page', '', page_url);
	if(back_btn_page_id == "0")
		action = "get_mysfeed_page_content";

	jQuery("#loader-inner").css("display","block");
				jQuery.ajax({
				type : "post",
				url : "/wp-admin/admin-ajax.php",
				data : {action: action,"value":back_btnValue},
				success: function(response) {

				jQuery(".inner__content").html(response.result);
				jQuery("#loader-inner").css("display","none");

				},
			});



})




});



jQuery(document).on("click",".sub-title",function(e){

	var episode_id = jQuery('.sub-title').attr('data-id');
    action = "go_to_show_page";
    jQuery("#loader-inner").css("display","block");
				jQuery.ajax({
				type : "post",
				url : "/wp-admin/admin-ajax.php",
				data : {action: action,"episode_id":episode_id},
				success: function(response) {

				jQuery(".inner__content").html(response.result);
				jQuery("#loader-inner").css("display","none");
			 
				window.history.pushState('page', '', response.podcasturl);
				},
			});
});


jQuery(document).on("click",".mini-webplayer .copylinktoepisodes",function(e){

	e.preventDefault();
	var player = document.querySelector('#source-audio'); 

    var copyText = player.src;

    var thisVar = jQuery(this);

    var thisText = jQuery(this).text();

   document.addEventListener('copy', function(e) {
      e.clipboardData.setData('text/plain', copyText);
      e.preventDefault();
   }, true);

   document.execCommand('copy');  
 
   jQuery(this).text("Copied episode link");

   setTimeout(function() {
     thisVar.text(thisText);
    
   }, 3000);



});
function lazifyNewImages(){
	var lazyImages = [].slice.call(document.querySelectorAll("img.lazy"));
	if ("IntersectionObserver" in window) {
	let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
	entries.forEach(function(entry) {
	if (entry.isIntersecting) {
	let lazyImage = entry.target;
	lazyImage.src = lazyImage.dataset.original;
	console.log(lazyImage.dataset.original);

		lazyImage.classList.remove("lazy");
		lazyImageObserver.unobserve(lazyImage);
		}
		});
	});
	
	lazyImages.forEach(function(lazyImage) {
		lazyImageObserver.observe(lazyImage);
	});
	} else {
	// Possibly fall back to event handlers here
	}
}