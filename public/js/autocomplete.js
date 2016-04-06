// global variable
var keyPressed = new Date();
// call where you're watching for pressed keys.
var updateKeyPressed = function() {
	keyPressed = new Date();
}
/**
 * Autocompletion for the field order-application-number.
 */
$(function() {
	$("#order-application-number").autocomplete({
		minLength: 3,
		limit: 5,
		appendMethod:'replace',
		closeOnBlur: true,
		source : [
			function(query, add) {
				var currentDate = new Date();
				setInterval(function() {
					if (currentDate.getTime() > keyPressed.getTime()) {
						orderApplicationNumber = $('#order-application-number').val();
						$.getJSON("/order/ajax/provide-applications?data[technical_short_name]=" + query, function(response) {
							add(response);
						});
						updateKeyPressed();
					}
				}, 500);
			}
		],
	});
});

/**
 * Autocompletion for the field order-service-invoice-position-basic-number.
 */
$(function() {
	$("#order-service-invoice-position-basic-number").autocomplete({
		minLength: 3,
		limit: 5,
		appendMethod:'replace',
		closeOnBlur: true,
		source : [
			function(query, add) {
				var currentDate = new Date();
				setInterval(function() {
					if (currentDate.getTime() > keyPressed.getTime()) {
						orderApplicationNumber = $('#order-application-number').val();
						$.getJSON("/order/ajax/provide-service-invoice-positions-basic?data[number]=" + query + "&data[application_technical_short_name]=" + orderApplicationNumber, function(response) {
							add(response);
						});
						updateKeyPressed();
					}
				}, 500);
			}
		],
	});
});
/**
 * Autocompletion for the field order-service-invoice-position-personal-number.
 */
$(function() {
	$("#order-service-invoice-position-personal-number").autocomplete({
		minLength: 3,
		limit: 5,
		appendMethod:'replace',
		closeOnBlur: true,
		source : [
			function(query, add) {
				var currentDate = new Date();
				setInterval(function() {
					if (currentDate.getTime() > keyPressed.getTime()) {
						orderApplicationNumber = $('#order-application-number').val();
						$.getJSON("/order/ajax/provide-service-invoice-positions-personal?data[number]=" + query + "&data[application_technical_short_name]=" + orderApplicationNumber, function(response) {
							add(response);
						});
						updateKeyPressed();
					}
				}, 500);
			}
		],
	});
});
