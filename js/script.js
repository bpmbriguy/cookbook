$(window).load(function() {
	$('#bgSlider').bgSlider({
		duration:2000,
		pagination:'.bg_pagination',
		preload:true,
		slideshow:30000,
		spinner:'.bg_spinner'
	});
});