/**
 * Autocompletion for the field order-application-number.
 */
$(function() {
	$(".autocomplete-application")
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
						response(data.slice(0, 25));
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
 * Autocompletion for the field order-environment-name.
 */
$(function() {
	$("#order-environment-name")
		.autocomplete({
			autoFocus : true,
			delay : 500,
			minLength : 0,
			source : function(request, response) {
				$.get(
					"/order/ajax/provide-environments?"
					+ "data[application_technical_short_name]=" + $('#order-application-number').val()
					+ "&data[name]=" + request.term,
					{},
					function(data) {
						response($.map(data, function(item) {
							return {
								label : item.name,
								value : item.severity
							}
						}));
					}
				);
			},
			select: function (event, ui) {
				$('#order-environment-name').val(ui.item.label);
				$('#order-environment-severity').val(ui.item.value);
				return false;
			},
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
					+ "&data[application_technical_short_name]=" + $('#order-application-number').val()
					+ "&data[environment_severity]=" + $('#order-environment-severity').val(),
					{},
					function(data) {
						response(data.slice(0, 25));
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
					+ "&data[application_technical_short_name]=" + $('#order-application-number').val()
					+ "&data[environment_severity]=" + $('#order-environment-severity').val(),
					{},
					function(data) {
						response(data.slice(0, 25));
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
 * Autocompletion for the field (billing|physical-connection-endpoint)-server-name.
 */
// Implemented this way for solving the issue with autocomplete for dynamically added fields (s. #120).
var initAutocompleteServer = function() {
	var physicalConnectionEndpointServerName = $('.autocomplete-server');
	physicalConnectionEndpointServerName
		.autocomplete({
			autoFocus : true,
			delay : 500,
			minLength : 0,
			source : function(request, response) {
				$.get(
					"/order/ajax/provide-servers?"
					+ "data[name]=" + request.term,
					{},
					function(data) {
						response(data.slice(0, 25));
					}
				);
			}
		}).on('focus', function(event) {
			console.log(new Date());
			console.log($(this));
		$(this).autocomplete("search", this.value);
	});
};
$(document).ready(function() {
	initAutocompleteServer();
});
