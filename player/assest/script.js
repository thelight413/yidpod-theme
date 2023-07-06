function createDuration(duration) {
    // console.log(duration)
    // let myArray = duration.split(':');

    // if (myArray.length == 3 && !duration.includes('::')) {
    //     let time1 = myArray[0];
    //     let time2 = myArray[1];

    //     let time3 = time1 * 60;

    //     let time4 = parseInt(time3) + parseInt(time2);

    //     duration = time4 + ':' + myArray[2];
    //     duration = duration.replace(':0', ':');
    // }

    // if (myArray.length == 2 && (myArray[1] == '' || myArray[1] == '00')) {
    //     let time1 = myArray[0];

    //     duration = time1 + ':0';
    // } else if (
    //     myArray.length == 2 &&
    //     (myArray[1] != '' || myArray[1] != '00')
    // ) {
    //     let time1 = myArray[0];
    //     let time2 = myArray[1];
    //     //time2 =  time2.replace("0","");
    //     duration = time1 + ':' + time2;

    //     if (time2.length > 1) duration = duration.replace(':0', ':');
    // }

    return duration;
}

function createTrackItem(index, name, duration, image, formatted_date, eid) {
    // for day difference
    const today = new Date();
    const yyyy = today.getFullYear();
    let mm = today.getMonth() + 1; // Months start at 0!
    let dd = today.getDate();

    if (dd < 10) dd = '0' + dd;
    if (mm < 10) mm = '0' + mm;

    var date2 = mm + '/' + dd + '/' + yyyy;
    var date1 = formatted_date;

    var date3 = new Date(date1);
    var date4 = new Date(date2);
    var diffDays = parseInt((date4 - date3) / (1000 * 60 * 60 * 24), 10);

    var trackItem = document.createElement('div');
    trackItem.setAttribute('class', 'playlist-track-ctn');
    trackItem.setAttribute('id', 'ptc-' + index);
    trackItem.setAttribute('data-index', index);
    document.querySelector('.playlist-ctn').appendChild(trackItem);

    var imageEle = document.createElement('img');
    imageEle.setAttribute('src', image);
    imageEle.setAttribute('width', '100');
    imageEle.setAttribute('height', '100');

    document.querySelector('#ptc-' + index).appendChild(imageEle);

    // create new span tag

    var sectioncontainer = document.createElement('div');
    sectioncontainer.setAttribute('class', 'section__container');
    sectioncontainer.setAttribute('id', 'section__container' + index);

    var span1 = document.createElement('span');

    var dmy_text = '';

    if (diffDays > 0 && diffDays < 31) {
        dmy_text = diffDays + ' days ago';
    } else if (diffDays > 0 && diffDays < 365 && diffDays > 31) {
        var divide = diffDays / 30;
        var resultmonth = parseInt(divide);
        dmy_text = resultmonth + ' month ago';
    } else if (diffDays > 0 && diffDays > 365) {
        var divide = diffDays / 365;
        var resultmonth = parseInt(divide);
        dmy_text = resultmonth + ' year ago';
    } else {
        dmy_text = ' 0 day ago';
    }

    var span1_data =
        '<i class="fa fa-calendar" aria-hidden="true"></i> ' + dmy_text;
    span1.innerHTML = span1_data;

    // time duraion format

    let myArray = duration.split(':');

    if (myArray.length == 3 && !duration.includes('::')) {
        let time1 = myArray[0];
        let time2 = myArray[1];

        let time3 = time1 * 60;

        let time4 = parseInt(time3) + parseInt(time2);

        duration = time4 + ':' + myArray[2];
        duration = duration.replace(':0', ':');
    }

    if (myArray.length == 2 && (myArray[1] == '' || myArray[1] == '00')) {
        let time1 = myArray[0];

        duration = time1 + ':0';
    } else if (
        myArray.length == 2 &&
        (myArray[1] != '' || myArray[1] != '00')
    ) {
        let time1 = myArray[0];
        let time2 = myArray[1];
        //time2 =  time2.replace("0","");
        duration = time1 + ':' + time2;

        if (time2.length > 1) duration = duration.replace(':0', ':');
    }

    // end time duration format

    var span2 = document.createElement('span');
    var span2_data =
        '<i class="fa fa-clock-o" aria-hidden="true"></i> ' + duration;
    span2.innerHTML = span2_data;

    var trackInfoItem = document.createElement('div');
    trackInfoItem.setAttribute('class', 'playlist-info-track');
    trackInfoItem.setAttribute('id', 'playlistinfotrack-' + index);
    trackInfoItem.setAttribute('data-eid', eid);
    trackInfoItem.innerHTML = name;
    document.querySelector('#ptc-' + index).appendChild(trackInfoItem);

    document
        .querySelector('#playlistinfotrack-' + index)
        .appendChild(sectioncontainer);

    document.querySelector('#section__container' + index).appendChild(span1);
    document.querySelector('#section__container' + index).appendChild(span2);

    var playBtnItem = document.createElement('div');
    playBtnItem.setAttribute('class', 'playlist-btn-play');
    playBtnItem.setAttribute('id', 'pbp-' + index);
    document.querySelector('#ptc-' + index).appendChild(playBtnItem);

    var btnImg = document.createElement('i');
    btnImg.setAttribute('class', 'fa fa-play');
    btnImg.setAttribute('height', '40');
    btnImg.setAttribute('width', '40');
    btnImg.setAttribute('id', 'p-img-' + index);
    document.querySelector('#pbp-' + index).appendChild(btnImg);

    /* var trackDurationItem = document.createElement('div');
    trackDurationItem.setAttribute("class", "playlist-duration");
    trackDurationItem.innerHTML = duration
    document.querySelector("#ptc-"+index).appendChild(trackDurationItem);*/
}

/*var listAudio = [
    {
      name:"Artist 1 - audio 1",
      file:"https://records.jewishpodcasts.fm/protected/1137/1653250378603.mp3?show_id=491&episode_id=36933",
      duration:"08:47"
    },
    {
      name:"Artist 2 - audio 2",
      file:"https://records.jewishpodcasts.fm/protected/1137/1653250404233.mp3?show_id=491&episode_id=36934",
      duration:"05:53"
    },
    {
      name:"Artist 3 - audio 3",
      file:"https://records.jewishpodcasts.fm/protected/1137/1652810261803.mp3?show_id=491&episode_id=36698",
      duration:"00:16:08"
    }
  ]*/

try {
    for (var i = 0; i < listAudio.length; i++) {
        createTrackItem(
            i,
            listAudio[i].name,
            listAudio[i].duration,
            listAudio[i].image,
            listAudio[i].formatted_date,
            listAudio[i].eid
        );
    }
} catch (err) {
    console.log('Error listAudio', err);
}

var indexAudio = 0;

function loadNewTrack(index) {
    var player = document.querySelector('#source-audio');

    try {
        player.src = listAudio[index].file;
    } catch (err) {
        console.log('Error listAudio', err);
    }
    jQuery('.title').attr('data-podcast_url',"")
    console.log('hello');
    document.querySelector('.mini-webplayer .title').innerHTML = listAudio[index].name;
    document.querySelector('.mini-webplayer .imagesrc').src = listAudio[index].image;
    document.querySelector('.mini-webplayer .sub-title').innerHTML =
        listAudio[index].shows_name;
    jQuery('.sub-title').attr('data-id', listAudio[index].eid);

    this.currentAudio = document.getElementById('myAudio');
    this.currentAudio.load();
    this.toggleAudio();
    this.updateStylePlaylist(this.indexAudio, index);
    this.indexAudio = index;

    indexAudio = index;

    /*---------- Make Share links ---------------*/

    var current_index = listAudio[indexAudio].file;
    var fb_share_link =
        'https://www.facebook.com/sharer/sharer.php?u=' + current_index;
    document.querySelector('#fb_btn').href = fb_share_link;

    var twtr_share_link =
        'https://twitter.com/intent/tweet?via=' + current_index;
    document.querySelector('#twtr_btn').href = twtr_share_link;

    var wts_share_link = 'https://api.whatsapp.com/send?text=' + current_index;
    document.querySelector('#wts_btn').href = twtr_share_link;

    var tele_share_link = 'https://t.me/share/url?url={' + current_index + '}';
   // document.querySelector('#tele_btn').href = tele_share_link;
    /*---------- End code Share links ---------------*/

    /*--------------- Download url --------------*/
    document.querySelector('.cs-download a').href = current_index;

    /*--------------- end download url ----------*/
}

var playListItems = document.querySelectorAll('.playlist-track-ctn');

for (let i = 0; i < playListItems.length; i++) {
    playListItems[i].addEventListener('click', getClickedElement.bind(this));
}

function updateListAudioTab() {
    var playListItems = document.querySelectorAll('.playlist-track-ctn');

    for (let i = 0; i < playListItems.length; i++) {
        playListItems[i].addEventListener(
            'click',
            getClickedElement.bind(this)
        );
    }

    return playListItems;
}

function getClickedElement(event) {
    var playListItems = document.querySelectorAll('.playlist-track-ctn');

    for (let i = 0; i < playListItems.length; i++) {
        if (playListItems[i] == event.target) {
            var clickedIndex = event.target.getAttribute('data-index');
            if (clickedIndex == this.indexAudio || indexAudio == clickedIndex) {
                // alert('Same audio');
                //this.toggleAudio()
                toggleAudio();
                listenHistory(this.indexAudio);
            } else {
                loadNewTrack(clickedIndex);
                listenHistory(this.indexAudio);
            }
        }
    }
}

try {
    document.querySelector('#source-audio').src = listAudio[indexAudio].file;
    document.querySelector('.mini-webplayer .title').innerHTML = listAudio[indexAudio].name;

    document.querySelector('.mini-webplayer .imagesrc').src = listAudio[indexAudio].image;
    document.querySelector('.mini-webplayer .sub-title').innerHTML =
        listAudio[indexAudio].shows_name;
        console.log('hello')
    jQuery('.mini-webplayer .sub-title').attr('data-id', listAudio[indexAudio].eid);
    jQuery('.mini-webplayer .copylinktoepisodes').attr('data-link', listAudio[indexAudio].podcast_url + '?episode_id='+ listAudio[indexAudio].eid);
    console.log('here')
    /*---------- Make Share links ---------------*/

    var current_index = listAudio[indexAudio].file;
    var fb_share_link =
        'https://www.facebook.com/sharer/sharer.php?u=' + current_index;
    document.querySelector('#fb_btn').href = fb_share_link;

    var twtr_share_link =
        'https://twitter.com/intent/tweet?via=' + current_index;
    document.querySelector('#twtr_btn').href = twtr_share_link;

    var wts_share_link = 'https://api.whatsapp.com/send?text=' + current_index;
    document.querySelector('#wts_btn').href = wts_share_link;

    var tele_share_link = 'https://t.me/share/url?url={' + current_index + '}';
    //document.querySelector('#tele_btn').href = tele_share_link;
    /*---------- End code Share links ---------------*/

    /*--------------- Download url --------------*/
    document.querySelector('.cs-download a').href = current_index;

    /*--------------- end download url ----------*/
} catch (err) {
    console.log('Error listAudio', err);
}

var currentAudio = document.getElementById('myAudio');

currentAudio.load();

currentAudio.onloadedmetadata = function () {
    //document.getElementsByClassName('duration')[0].innerHTML = this.getMinutes(this.currentAudio.duration)
    var durationVal = createDuration(listAudio[indexAudio].duration);
    document.getElementsByClassName('duration')[0].innerHTML = durationVal;
}.bind(this);

var interval1;

function toggleAudio() {
    var currentAudio = document.getElementById('myAudio');
    try {
        if (currentAudio.paused) {
            listenHistory(this.indexAudio);
            document.querySelector('#icon-play').style.display = 'none';
            document.querySelector('#icon-pause').style.display = 'block';
            document
                .querySelector('#ptc-' + this.indexAudio)
                .classList.add('active-track');
            this.playToPause(this.indexAudio);
            this.currentAudio.play();
        } else {
            listenHistory(this.indexAudio);
            document.querySelector('#icon-play').style.display = 'block';
            document.querySelector('#icon-pause').style.display = 'none';
            this.pauseToPlay(this.indexAudio);
            this.currentAudio.pause();
        }
    } catch (err) {
        console.log('Error listAudio', err);
    }

    // store cookie for podcast id

    //$.cookie('last_play_podcast', podcast_id, { expires: 1,path:'/' });
}

function pauseAudio() {
    this.currentAudio.pause();
    clearInterval(interval1);
}

var timer = document.getElementsByClassName('timer')[0];

var barProgress = document.getElementById('myBar');

var width = 0;

var checkBarStatus = true;

function onTimeUpdate() {
    var t = this.currentAudio.currentTime;
    timer.innerHTML = this.getMinutes(t);
    this.setBarProgress();

    // cookie save

    onTimeUpdateCookie(listAudio[this.indexAudio], t);

    if (this.currentAudio.ended) {
        document.querySelector('#icon-play').style.display = 'block';
        document.querySelector('#icon-pause').style.display = 'none';
        this.pauseToPlay(this.indexAudio);
        try {
            if (this.indexAudio < listAudio.length - 1) {
                var index = parseInt(this.indexAudio) + 1;
                this.loadNewTrack(index);
            }
        } catch (err) {
            console.log('Error listAudio', err);
        }
    }
}

function setBarProgress() {
    var progress =
        (this.currentAudio.currentTime / this.currentAudio.duration) * 100;
    //document.getElementById('myBar').style.width = progress + '%';
    //document.querySelector('.indicator').style.left = 'calc('+progress+'% - 7px)';

    //jQuery(".myprogressnew").val(progress);
     if(this.checkBarStatus){
       document.querySelector('.myprogressnew').value = progress; 
     }
     


}

function getMinutes(t) {
    var min = parseInt(parseInt(t) / 60);
    var sec = parseInt(t % 60);
    if (sec < 10) {
        sec = '0' + sec;
    }
    if (min < 10) {
        min = '0' + min;
    }
    return min + ':' + sec;
}

/*var progressbar = document.querySelector('#myProgress');
progressbar.addEventListener('click', seek.bind(this));

function seek(event) {
    var percent = event.offsetX / progressbar.offsetWidth;
    this.currentAudio.currentTime = percent * this.currentAudio.duration;
    barProgress.style.width = percent * 100 + '%';
}*/

/*jQuery(document).on("change",".myprogressnew",function(){
    debugger;
     var thisval = jQuery(this).val();

     var percent = (thisval/100);
     currentAudio.currentTime = percent * currentAudio.duration;

});*/

var progressbar = document.querySelector('.myprogressnew');
progressbar.addEventListener('click', seek.bind(this));


progressbar.onmouseout = function(event) {
  /* event.target: parent element */
     setTimeout(function(){
     this.checkBarStatus = true;
 }, 10000);
};
progressbar.onmouseover = function(event) {
  /* event.target: child element (bubbled) */
   this.checkBarStatus = false;
   checkBarStatus = false;
};

progressbar.onmouseenter = function(event) {
  /* event.target: child element (bubbled) */
   this.checkBarStatus = false;
   checkBarStatus = false;
};

function seek(event) {
    //var percent = event.offsetX / progressbar.offsetWidth;
    this.checkBarStatus = false;
     var thisval = jQuery(".myprogressnew").val();
     var percent = (thisval/100);
    this.currentAudio.currentTime = percent * this.currentAudio.duration;

    //this.checkBarStatus = true;
    //barProgress.style.width = percent * 100 + '%';
    
 //    setTimeout(function(){
 //     this.checkBarStatus = true;
 // }, 10000);

}


function forward() {
    this.currentAudio.currentTime = this.currentAudio.currentTime + 5;
    this.setBarProgress();
}

function rewind() {
    this.currentAudio.currentTime = this.currentAudio.currentTime - 5;
    this.setBarProgress();
}

function next() {
    try {
        if (this.indexAudio < listAudio.length - 1) {
            var oldIndex = this.indexAudio;
            this.indexAudio++;
            updateStylePlaylist(oldIndex, this.indexAudio);
            this.loadNewTrack(this.indexAudio);
        }
    } catch (err) {
        console.log('Error listAudio', err);
    }
}

function previous() {
    if (this.indexAudio > 0) {
        var oldIndex = this.indexAudio;
        this.indexAudio--;
        updateStylePlaylist(oldIndex, this.indexAudio);
        this.loadNewTrack(this.indexAudio);
    }
}

function updateStylePlaylist(oldIndex, newIndex) {
    try {
        /*if(document.querySelector('#ptc-'+oldIndex) == null)
        oldIndex = 0;*/

        document
            .querySelector('#ptc-' + oldIndex)
            .classList.remove('active-track');
        this.pauseToPlay(oldIndex);
        document
            .querySelector('#ptc-' + newIndex)
            .classList.add('active-track');
        this.playToPause(newIndex);
    } catch (err) {
        console.log('Error listAudio', err);
    }
}

function playToPause(index) {
    try {
        var ele = document.querySelector('#p-img-' + index);
        ele.classList.remove('fa-play');
        ele.classList.add('fa-pause');
    } catch (err) {
        console.log('Error listAudio', err);
    }
}

function pauseToPlay(index) {
    try {
        var ele = document.querySelector('#p-img-' + index);
        ele.classList.remove('fa-pause');
        ele.classList.add('fa-play');
    } catch (err) {
        console.log('Error listAudio', err);
    }
}

function toggleMute() {
    var btnMute = document.querySelector('#toggleMute');
    var volUp = document.querySelector('#icon-vol-up');
    var volMute = document.querySelector('#icon-vol-mute');
    if (this.currentAudio.muted == false) {
        this.currentAudio.muted = true;
        volUp.style.display = 'none';
        volMute.style.display = 'block';
    } else {
        this.currentAudio.muted = false;
        volMute.style.display = 'none';
        volUp.style.display = 'block';
    }
}

function onTimeUpdateCookie(data, time) {
    data.time = time;

    // jQuery.ajax({
    //                            type : "post",
    //                            url : "/wp-admin/admin-ajax.php",
    //                            data : {action: "cookie_update_time", data : data},
    //                            success: function(response) {

    //                            },
    //                         });
}

// listen history update

function listenHistory(id) {
    if (listAudio[id]) {
        try {
            var episodeid = listAudio[id].eid;

            if (episodeid) {
                // jQuery.ajax({
                //       type : "post",
                //       url : "/wp-admin/admin-ajax.php",
                //       data : {action: "listenhistoryupdate", episodeid : episodeid},
                //       success: function(response) {
                //       },
                // });
            }
        } catch (err) {
            console.log('Error listAudio', err);
        }
    }
}


jQuery(document).on("click",".playlist-track-ctn",function(){

    var dataeid = jQuery(this).find(".playlist-info-track").attr("data-eid");

    try {
            

            if (dataeid) {
                jQuery.ajax({
                      type : "post",
                      url : "/wp-admin/admin-ajax.php",
                      data : {action: "listenhistoryupdate", episodeid : dataeid},
                      success: function(response) {
                        //console.log("response",response);
                        
                      },
                });
            }
        } catch (err) {
            console.log('Error listAudio', err);
        }

});


function forceDownload1(blob, filename) {
  var a = document.createElement('a');
  a.download = filename;
  a.href = blob;
  // For Firefox https://stackoverflow.com/a/32226068
  document.body.appendChild(a);
  a.click();
  a.remove();
  jQuery('#download_progress').hide();
	jQuery('#download_progress .progress-bar').css('background', "radial-gradient(closest-side, white 79%, transparent 80% 100%), conic-gradient(#56a331 0%, #b3b3b3 0)");
  jQuery('#download_progress span').text('0%');
}

// Current blob size limit is around 500MB for browsers
function downloadResource1(url, filename) {
  if (!filename) filename = url.split('\\').pop().split('/').pop();
  console.log('downloading');
  jQuery('#download_progress').show();
  fetch(url, {
      headers: new Headers({
        'Origin': location.origin
      }),
      mode: 'cors'
    })
    .then(response => {

        const contentEncoding = response.headers.get('content-encoding');
        const contentLength = response.headers.get(contentEncoding ? 'x-file-size' : 'content-length');
        contentType = response.headers.get('content-type') || contentType;
        if (contentLength === null) {
            throw Error('Response size header unavailable');
        }

        const total = parseInt(contentLength, 10);
        let loaded = 0;

        return new Response(
            new ReadableStream({
                start(controller) {
                    const reader = response.body.getReader();

                    read();

                    function read() {
                        reader.read().then(({done, value}) => {
                            if (done) {
                                controller.close();
                                return;
                            }
                            loaded += value.byteLength;
                            // progress({loaded, total})
                           const percent =  Math.round(loaded / total * 100);
                           jQuery('#download_progress .progress-bar').css('background', "radial-gradient(closest-side, white 79%, transparent 80% 100%), conic-gradient(#56a331 "+percent+"%, #b3b3b3 0)");
                           jQuery('#download_progress span').text(percent+'%');
                            
                            controller.enqueue(value);
                            read();
                        }).catch(error => {
                            console.error(error);
                            controller.error(error)
                        })
                    }
                }
            })
        );
    })
    .then(response => response.blob())
    .then(blob => {
      let blobUrl = window.URL.createObjectURL(blob);
      forceDownload1(blobUrl, filename);
    })
    .catch(e => { 
        console.error(e);
    //    window.location.href = url;
       }
        );
}


jQuery(document).on("click",".cs-download a",function(e){

e.preventDefault();

var url = jQuery(this).attr("href");
var filename = "audio.mp3";
var title = jQuery(".cs-clickable-title").text();
if(title != ""){
    filename = title+".mp3";
}
downloadResource1(url, filename);
return false;

});


// Function to hide the dropdown when clicked outside
function hideDropdownOutsideClick() {
    jQuery(document).on("click", function(event) {
      var target = jQuery(event.target);
      var dropdown = jQuery(".dropdown-share");
  
      if (!target.closest(".ellipsis-share").length && !target.closest(".dropdown-share").length) {
        dropdown.slideUp(function() {
          dropdown.removeClass("open");
        });
      }
    });
  }
  
  // Click event handler for ellipsis-share
  jQuery(".ellipsis-share").on("click", function() {
    var dropdown = jQuery(this).next(".dropdown-share");
  
    dropdown.slideToggle(function() {
      dropdown.toggleClass("open");
  
      if (dropdown.hasClass("open")) {
        hideDropdownOutsideClick();
      } else {
        jQuery(document).off("click");
      }
    });
  });
  




jQuery(document).ready(function(){
    jQuery(".myprogressnew").val(1);
});

//jQuery(document).ready(function(){
//    jQuery("#volume_control").val(5);
//    jQuery("#volume_control").trigger("click");
//});





// Player progress bar script

const settings={
  fill: '#56a331',
  background: '#b5cbb0'
}

// First find all our sliders
const sliders = document.querySelectorAll('.range-slider');


Array.prototype.forEach.call(sliders,(slider)=>{
  // Look inside our slider for our input add an event listener
//   ... the input inside addEventListener() is looking for the input action, we could change it to something like change
  slider.querySelector('input').addEventListener('input', (event)=>{
    // 1. apply our value to the span
    slider.querySelector('span').innerHTML = event.target.value;
    // 2. apply our fill to the input
    applyFill(event.target);
  });
  // Don't wait for the listener, apply it now!
  applyFill(slider.querySelector('input'));
});

// This function applies the fill to our sliders by using a linear gradient background
function applyFill(slider) {
  // Let's turn our value into a percentage to figure out how far it is in between the min and max of our input
  const percentage = 100*(slider.value-slider.min)/(slider.max-slider.min);
  // now we'll create a linear gradient that separates at the above point
  // Our background color will change here
  const bg = `linear-gradient(90deg, ${settings.fill} ${percentage}%, ${settings.background} ${percentage+0.1}%)`;
  slider.style.background = bg;
}

// Player progress bar script - /End