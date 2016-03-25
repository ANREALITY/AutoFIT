/**
 * Enabling/disabling of fields.
 */
// endpoint source basic #start#
fieldNameEndpointSourceServerPlace = '"file_transfer_request[logical_connection][physical_connections][0][endpoint_source][server_place]"';
fieldNameEndpointSourceCustomerName = '"file_transfer_request[logical_connection][physical_connections][0][endpoint_source][customer][name]"';
fieldNameEndpointSourceApplicationTechnicalShortName = '"file_transfer_request[logical_connection][physical_connections][0][endpoint_source][application][technical_short_name]"';
fieldNameEndpointSourceName = '"file_transfer_request[logical_connection][physical_connections][0][endpoint_source][server][name]"';

$(document).ready(function() {
	fieldEndpointSourceServerPlace = $('input[type=radio][name=' + fieldNameEndpointSourceServerPlace + ']');
	toggleEndpointSourceServerPlaceDependentFields(fieldEndpointSourceServerPlace.value);
	fieldEndpointSourceServerPlace.change(function() {
		toggleEndpointSourceServerPlaceDependentFields(this.value);
	});
});
// endpoint source basic #stop#
// endpoint target basic #start#
fieldNameEndpointTargetServerPlace = '"file_transfer_request[logical_connection][physical_connections][0][endpoint_target][server_place]"';
fieldNameEndpointTargetCustomerName = '"file_transfer_request[logical_connection][physical_connections][0][endpoint_target][customer][name]"';
fieldNameEndpointTargetApplicationTechnicalShortName = '"file_transfer_request[logical_connection][physical_connections][0][endpoint_target][application][technical_short_name]"';
fieldNameEndpointTargetName = '"file_transfer_request[logical_connection][physical_connections][0][endpoint_target][server][name]"';

$(document).ready(function() {
	fieldEndpointSourceServerPlace = $('input[type=radio][name=' + fieldNameEndpointSourceServerPlace + ']');
	toggleEndpointSourceServerPlaceDependentFields(fieldEndpointSourceServerPlace.value);
	fieldEndpointSourceServerPlace.change(function() {
		toggleEndpointSourceServerPlaceDependentFields(this.value);
	});
	fieldEndpointTargetServerPlace = $('input[type=radio][name=' + fieldNameEndpointTargetServerPlace + ']');
	toggleEndpointTargetServerPlaceDependentFields(fieldEndpointTargetServerPlace.value);
	fieldEndpointTargetServerPlace.change(function() {
		toggleEndpointTargetServerPlaceDependentFields(this.value);
	});
});
//endpoint target basic #stop#

function toggleEndpointSourceServerPlaceDependentFields(value) {
	if (value == 'intranet') {
		$('input[name=' + fieldNameEndpointSourceCustomerName + ']').val('');
		$('input[name=' + fieldNameEndpointSourceCustomerName + ']').parent().fadeOut('fast');

		$('input[name=' + fieldNameEndpointSourceApplicationTechnicalShortName + ']').parent().fadeIn('fast');
		$('input[name=' + fieldNameEndpointSourceName + ']').parent().fadeIn('fast');
	}
	if (value == 'internet') {
		$('input[name=' + fieldNameEndpointSourceApplicationTechnicalShortName + ']').val('');
		$('input[name=' + fieldNameEndpointSourceApplicationTechnicalShortName + ']').parent().fadeOut('fast');
		$('input[name=' + fieldNameEndpointSourceName + ']').val('');
		$('input[name=' + fieldNameEndpointSourceName + ']').parent().fadeOut('fast');

		$('input[name=' + fieldNameEndpointSourceCustomerName + ']').parent().fadeIn('fast');
	}
}
function toggleEndpointTargetServerPlaceDependentFields(value) {
	if (value == 'intranet') {
		$('input[name=' + fieldNameEndpointTargetCustomerName + ']').val('');
		$('input[name=' + fieldNameEndpointTargetCustomerName + ']').parent().fadeOut('fast');

		$('input[name=' + fieldNameEndpointTargetApplicationTechnicalShortName + ']').parent().fadeIn('fast');
		$('input[name=' + fieldNameEndpointTargetName + ']').parent().fadeIn('fast');
	}
	if (value == 'internet') {
		$('input[name=' + fieldNameEndpointTargetApplicationTechnicalShortName + ']').val('');
		$('input[name=' + fieldNameEndpointTargetApplicationTechnicalShortName + ']').parent().fadeOut('fast');
		$('input[name=' + fieldNameEndpointTargetName + ']').val('');
		$('input[name=' + fieldNameEndpointTargetName + ']').parent().fadeOut('fast');

		$('input[name=' + fieldNameEndpointTargetCustomerName + ']').parent().fadeIn('fast');
	}
}
