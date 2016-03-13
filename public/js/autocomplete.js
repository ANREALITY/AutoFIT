/**
 * Autocompletion fro the field file_transfer_request_application_number.
 */
$(function() {
	$("#file_transfer_request_application_number").autocomplete({
		minLength: 3,
		source : [{
			url:"http://autofit.db-systel.work.loc/order/ajax/provide-applications?data[technical_short_name]=%QUERY%",
			type:'remote'
		}],	 
	});
});
