/**
 * Autocompletion for the field order-application-number.
 */
const AUTOCOMPLETE_APPLICATIONS_LIMIT = 25;
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
						response(data.slice(0, AUTOCOMPLETE_APPLICATIONS_LIMIT));
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
const AUTOCOMPLETE_ENVIRONMENTS_LIMIT = 25;
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
			focus: function (event, ui) {
				this.value = ui.item.label;
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
const AUTOCOMPLETE_SERVICE_INVOICE_POSITIONS_BASIC_LIMIT = 25;
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
					+ "&data[environment_severity]=" + $('#order-environment-severity').val()
					+ "&data[connection_type]=" + $('#logical-connection-type').val(),
					{},
					function(data) {
						response(data.slice(0, AUTOCOMPLETE_SERVICE_INVOICE_POSITIONS_BASIC_LIMIT));
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
const AUTOCOMPLETE_SERVICE_INVOICE_POSITIONS_PERSONAL_LIMIT = 25;
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
					+ "&data[environment_severity]=" + $('#order-environment-severity').val()
					+ "&data[connection_type]=" + $('#logical-connection-type').val(),
					{},
					function(data) {
						response(data.slice(0, AUTOCOMPLETE_SERVICE_INVOICE_POSITIONS_PERSONAL_LIMIT));
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
 * Autocompletion for the field (billing|physical-connection-endpoint-source)-server-name.
 */
const AUTOCOMPLETE_SERVERS_SOUCE_LIMIT = 25;
// Implemented this way for solving the issue with autocomplete for dynamically added fields (s. #120).
var initAutocompleteServerSource = function() {
	var physicalConnectionEndpointSourceServerName = $('.fieldgroup-source .autocomplete-server');
	var physicalConnectionEndpointSourceType = $('#endpoint-type-source');
	physicalConnectionEndpointSourceServerName
		.autocomplete({
			autoFocus : true,
			delay : 500,
			minLength : 0,
			source : function(request, response) {
				$.get(
					"/order/ajax/provide-servers?"
					+ "data[name]=" + request.term
					+ '&' + "data[endpoint_type_name]=" + physicalConnectionEndpointSourceType.val(),
					{},
					function(data) {
						response(data.slice(0, AUTOCOMPLETE_SERVERS_SOUCE_LIMIT));
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
	initAutocompleteServerSource();
});
/**
 * Autocompletion for the field (billing|physical-connection-endpoint-target)-server-name.
 */
const AUTOCOMPLETE_SERVERS_TARGET_LIMIT = 25;
// Implemented this way for solving the issue with autocomplete for dynamically added fields (s. #120).
var initAutocompleteServerTarget = function() {
	var physicalConnectionEndpointTargetServerName = $('.fieldgroup-target .autocomplete-server');
	var physicalConnectionEndpointTargetType = $('#endpoint-type-target');
	physicalConnectionEndpointTargetServerName
		.autocomplete({
			autoFocus : true,
			delay : 500,
			minLength : 0,
			source : function(request, response) {
				$.get(
					"/order/ajax/provide-servers?"
					+ "data[name]=" + request.term
					+ '&' + "data[endpoint_type_name]=" + physicalConnectionEndpointTargetType.val(),
					{},
					function(data) {
						response(data.slice(0, AUTOCOMPLETE_SERVERS_TARGET_LIMIT));
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
	initAutocompleteServerTarget();
});
/**
 * Autocompletion for the field cluster-server-name.
 */
const AUTOCOMPLETE_SERVERS_NOT_IN_CLUSTER_LIMIT = 25;
// Implemented this way for solving the issue with autocomplete for dynamically added fields (s. #120).
var initAutocompleteClusterServer = function() {
	var clusterServerName = $('#fieldgroup-cluster .autocomplete-server');
	clusterServerName
		.autocomplete({
			autoFocus : true,
			delay : 500,
			minLength : 0,
			source : function(request, response) {
				$.get(
					"/order/ajax/provide-servers-not-in-cluster?"
					+ "data[name]=" + request.term,
					{},
					function(data) {
						response(data.slice(0, AUTOCOMPLETE_SERVERS_NOT_IN_CLUSTER_LIMIT));
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
	initAutocompleteClusterServer();
});
