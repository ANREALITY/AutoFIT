/**
 * Autocompletion fro the field order-application-number.
 */
$(function() {
	$("#order-application-number").autocomplete({
		minLength: 3,
		source : [{
			url:"http://autofit.db-systel.work.loc/order/ajax/provide-applications?data[technical_short_name]=%QUERY%",
			type:'remote'
		}],	 
	});
});
