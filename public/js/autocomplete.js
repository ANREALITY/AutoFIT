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
					+ "&data[application_technical_short_name]=" + $('#order-application-number').val()
					+ "&data[environment_severity]=" + $('#order-environment-severity').val(),
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
 * Autocompletion for the field physical-connection-source-endpoint-source-application-number.
 */
$(function() {
	var physicalConnectionSourceEndpointSourceApplicationNumber = $('input[name="file_transfer_request[logical_connection][physical_connection_source][endpoint_source][application][technical_short_name]"]');
	physicalConnectionSourceEndpointSourceApplicationNumber
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
 * Autocompletion for the field physical-connection-source-endpoint-source-application-number.
 */
$(function() {
	var physicalConnectionSourceEndpointTargetApplicationNumber = $('input[name="file_transfer_request[logical_connection][physical_connection_source][endpoint_target][application][technical_short_name]"]');
	physicalConnectionSourceEndpointTargetApplicationNumber
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
 * Autocompletion for the field physical-connection-target-endpoint-target-application-number.
 */
$(function() {
	var physicalConnectionTargetEndpointTargetApplicationNumber = $('input[name="file_transfer_request[logical_connection][physical_connection_target][endpoint_target][application][technical_short_name]"]');
	physicalConnectionTargetEndpointTargetApplicationNumber
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
 * Autocompletion for the field physical-connection-source-endpoint-source-server-name.
 */
$(function() {
	var physicalConnectionSourceEndpointSourceServerName = $('.autocomplete-server');
	physicalConnectionSourceEndpointSourceServerName
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
 * Autocompletion for the field physical-connection-source-endpoint-source-server-number.
 */
$(function() {
	var physicalConnectionSourceEndpointTargetServerName = $('input[name="file_transfer_request[logical_connection][physical_connection_source][endpoint_target][server][name]"]');
	physicalConnectionSourceEndpointTargetServerName
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
 * Autocompletion for the field physical-connection-target-endpoint-target-server-number.
 */
$(function() {
	var physicalConnectionTargetEndpointTargetServerName = $('input[name="file_transfer_request[logical_connection][physical_connection_target][endpoint_target][server][name]"]');
	physicalConnectionTargetEndpointTargetServerName
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
