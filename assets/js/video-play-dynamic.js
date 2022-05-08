// WP VIDEO
var video = document.getElementById("videoPlayer");
var btn = document.getElementById("round");
var bgCover = document.getElementById("video-cover");
function playPause() { 
    if (video.paused) {
        video.play();
        btn.style.display = "none";
        bgCover.style.display = "none";
    }
    else { 
        video.pause();
    } 
}

// https://developers.google.com/youtube/iframe_api_reference
// YOUTUBE
var playerYT;

// this function gets called when API is ready to use
function onYouTubePlayerAPIReady() {
// create the global player from the specific iframe (#video)
playerYT = new YT.Player("video-iframe", {
    events: {
    // call this function when player is ready to use
    onReady: onPlayerReady
    }
});
}


function onPlayerReady(event) {
// bind events
var playButtonYT = jQuery("#play-btn");
var pauseButtonYT = jQuery("#pause-btn");
var svgPlayer = document.getElementById("play");
var bgCover = document.getElementById("video-cover");

    playButtonYT.on("click", function (e) {

        if(jQuery(window).width() < 768) {
            pauseButtonYT.addClass("d-none playing");
        } else {
            pauseButtonYT.toggleClass("d-none playing");
        }

        pauseButtonYT.removeClass("visibility-class");
        playButtonYT.toggleClass("d-none");

        bgCover.style.display = "none";

        if(pauseButtonYT.hasClass("playing")) {
            playerYT.playVideo();
        } else {
            playerYT.pauseVideo();
        }

});

pauseButtonYT.on("click", function (e) {

    pauseButtonYT.toggleClass("d-none playing");
    playButtonYT.toggleClass("d-none");

    bgCover.style.display = "none";

    if(pauseButtonYT.hasClass("playing")) {
        playerYT.playVideo();
    } else {
        playerYT.pauseVideo();
    }

    });

}

//Inject YouTube API script
var tag = document.createElement("script");
tag.src = "//www.youtube.com/player_api";
var firstScriptTag = document.getElementsByTagName("script")[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
