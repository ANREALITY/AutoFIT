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
				orderApplicationNumber = $('#order-application-number').val();
				$.getJSON("/order/ajax/provide-applications?data[technical_short_name]=" + query, function(response) {
					add(response);
				});
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
				orderApplicationNumber = $('#order-application-number').val();
				$.getJSON("/order/ajax/provide-service-invoice-positions-basic?data[number]=" + query + "&data[application_technical_short_name]=" + orderApplicationNumber, function(response) {
					add(response);
				});
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
				orderApplicationNumber = $('#order-application-number').val();
				$.getJSON("/order/ajax/provide-service-invoice-positions-personal?data[number]=" + query + "&data[application_technical_short_name]=" + orderApplicationNumber, function(response) {
					add(response);
				});
			}
		],
	});
});
