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
