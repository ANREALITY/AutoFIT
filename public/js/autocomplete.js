/**
 * Autocompletion fro the field order-application-number.
 */
$(function() {
	$("#order-application-number").autocomplete({
		minLength: 3,
		limit: 5,
		source : [{
			url:"/order/ajax/provide-applications?data[technical_short_name]=%QUERY%",
			type:'remote'
		}],	 
	});
});
/**
 * Autocompletion fro the field order-service-invoice-position-basic-number.
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
				})
		}],	 
	});
});
