jQuery(document).ready(function(){

	jQuery("#play-btn-wrap").mouseenter(function() {
		jQuery("#pause-btn").removeClass("visibility-class");
	});
	jQuery("#pause-btn").mouseleave(function() {
		jQuery(this).addClass("visibility-class");
	});

});