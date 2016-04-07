/**
 * Autocompletion for the field order-application-number.
 */
$(function() {
	$("#order-application-number")
		.autocomplete({
			autoFocus : true,
			delay : 500,
			minLength : 3,
			source : function(request, response) {
				$.get(
					"/order/ajax/provide-applications?"
					+ "data[technical_short_name]=" + request.term,
					{},
					function(data) {
						response(data.slice(0, 10));
					}
				);
			}
		}).on('focus', function(event) {
			console.log(new Date());
			console.log($(this));
		$(this).autocomplete("search", this.value);
	});
});
/**
 * Autocompletion for the field order-service-invoice-position-basic-number.
 */
$(function() {
	$("#order-service-invoice-position-basic-number")
		.autocomplete({
			autoFocus : true,
			delay : 500,
			minLength : 0,
			source : function(request, response) {
				$.get(
					"/order/ajax/provide-service-invoice-positions-basic?"
					+ "data[number]=" + request.term
					+ "&data[application_technical_short_name]=" + $('#order-application-number').val(),
					{},
					function(data) {
						response(data.slice(0, 10));
					}
				);
			}
		}).on('focus', function(event) {
			console.log(new Date());
			console.log($(this));
		$(this).autocomplete("search", this.value);
	});
});
/**
 * Autocompletion for the field order-service-invoice-position-personal-number.
 */
$(function() {
	$("#order-service-invoice-position-personal-number")
		.autocomplete({
			autoFocus : true,
			delay : 500,
			minLength : 0,
			source : function(request, response) {
				$.get(
					"/order/ajax/provide-service-invoice-positions-personal?"
					+ "data[number]=" + request.term
					+ "&data[application_technical_short_name]=" + $('#order-application-number').val(),
					{},
					function(data) {
						response(data.slice(0, 10));
					}
				);
			}
		}).on('focus', function(event) {
			console.log(new Date());
			console.log($(this));
		$(this).autocomplete("search", this.value);
	});
});
