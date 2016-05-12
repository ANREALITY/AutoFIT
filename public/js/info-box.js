$(document).ready(function() {
	$('.info-box .header').click(function(){
	    $(this).parent().children('.body').slideToggle('slow');
	});
});
