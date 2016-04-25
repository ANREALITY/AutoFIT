/**
 * Enabling/disabling of fields.
 */
// PhysicalConnectionSource.EndpointSource basic #start#
fieldNamePhysicalConnectionSourceEndpointSourceServerPlace = '"file_transfer_request[logical_connection][physical_connection_source][endpoint_source][server_place]"';
fieldNamePhysicalConnectionSourceEndpointSourceCustomerName = '"file_transfer_request[logical_connection][physical_connection_source][endpoint_source][customer][name]"';
fieldNamePhysicalConnectionSourceEndpointSourceApplicationTechnicalShortName = '"file_transfer_request[logical_connection][physical_connection_source][endpoint_source][application][technical_short_name]"';
fieldNamePhysicalConnectionSourceEndpointSourceName = '"file_transfer_request[logical_connection][physical_connection_source][endpoint_source][server][name]"';

$(document).ready(function() {
	fieldEndpointSourceServerPlace = $('input[type=radio][name=' + fieldNamePhysicalConnectionSourceEndpointSourceServerPlace + ']');
	fieldEndpointSourceServerPlace.change(function() {
		togglePhysicalConnectionSourceEndpointSourceDependentFields(this.value);
	});
});
// PhysicalConnectionSource.EndpointSource basic #stop#
// PhysicalConnectionSource.EndpointTarget basic #start#
fieldNamePhysicalConnectionSourceEndpointTargetServerPlace = '"file_transfer_request[logical_connection][physical_connection_source][endpoint_target][server_place]"';
fieldNamePhysicalConnectionSourceEndpointTargetCustomerName = '"file_transfer_request[logical_connection][physical_connection_source][endpoint_target][customer][name]"';
fieldNamePhysicalConnectionSourceEndpointTargetApplicationTechnicalShortName = '"file_transfer_request[logical_connection][physical_connection_source][endpoint_target][application][technical_short_name]"';
fieldNamePhysicalConnectionSourceEndpointTargetName = '"file_transfer_request[logical_connection][physical_connection_source][endpoint_target][server][name]"';

$(document).ready(function() {
	fieldEndpointTargetServerPlace = $('input[type=radio][name=' + fieldNamePhysicalConnectionSourceEndpointTargetServerPlace + ']');
	fieldEndpointTargetServerPlace.change(function() {
		togglePhysicalConnectionSourceEndpointTargetDependentFields(this.value);
	});
});
// PhysicalConnectionSource.EndpointTarget basic #stop#
// PhysicalConnectionTarget.EndpointTarget basic #start#
fieldNamePhysicalConnectionTargetEndpointTargetServerPlace = '"file_transfer_request[logical_connection][physical_connection_target][endpoint_target][server_place]"';
fieldNamePhysicalConnectionTargetEndpointTargetCustomerName = '"file_transfer_request[logical_connection][physical_connection_target][endpoint_target][customer][name]"';
fieldNamePhysicalConnectionTargetEndpointTargetApplicationTechnicalShortName = '"file_transfer_request[logical_connection][physical_connection_target][endpoint_target][application][technical_short_name]"';
fieldNamePhysicalConnectionTargetEndpointTargetName = '"file_transfer_request[logical_connection][physical_connection_target][endpoint_target][server][name]"';

$(document).ready(function() {
	fieldEndpointTargetServerPlace = $('input[type=radio][name=' + fieldNamePhysicalConnectionTargetEndpointTargetServerPlace + ']');
	fieldEndpointTargetServerPlace.change(function() {
		togglePhysicalConnectionTargetEndpointTargetDependentFields(this.value);
	});
});
// PhysicalConnectionTarget.EndpointTarget basic #stop#

function togglePhysicalConnectionSourceEndpointSourceDependentFields(value) {
	if (value == 'intranet') {
		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointSourceCustomerName + ']').val('');
		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointSourceCustomerName + ']').parent().fadeOut('slow');

		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointSourceApplicationTechnicalShortName + ']').parent().fadeIn('slow');
		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointSourceName + ']').parent().fadeIn('slow');
	}
	if (value == 'internet') {
		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointSourceApplicationTechnicalShortName + ']').val('');
		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointSourceApplicationTechnicalShortName + ']').parent().fadeOut('slow');
		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointSourceName + ']').val('');
		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointSourceName + ']').parent().fadeOut('slow');

		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointSourceCustomerName + ']').parent().fadeIn('slow');
	}
}
function togglePhysicalConnectionSourceEndpointTargetDependentFields(value) {
	if (value == 'intranet') {
		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointTargetCustomerName + ']').val('');
		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointTargetCustomerName + ']').parent().fadeOut('slow');

		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointTargetApplicationTechnicalShortName + ']').parent().fadeIn('slow');
		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointTargetName + ']').parent().fadeIn('slow');
	}
	if (value == 'internet') {
		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointTargetApplicationTechnicalShortName + ']').val('');
		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointTargetApplicationTechnicalShortName + ']').parent().fadeOut('slow');
		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointTargetName + ']').val('');
		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointTargetName + ']').parent().fadeOut('slow');

		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointTargetCustomerName + ']').parent().fadeIn('slow');
	}
}
function togglePhysicalConnectionTargetEndpointTargetDependentFields(value) {
	if (value == 'intranet') {
		$('input[name=' + fieldNamePhysicalConnectionTargetEndpointTargetCustomerName + ']').val('');
		$('input[name=' + fieldNamePhysicalConnectionTargetEndpointTargetCustomerName + ']').parent().fadeOut('slow');

		$('input[name=' + fieldNamePhysicalConnectionTargetEndpointTargetApplicationTechnicalShortName + ']').parent().fadeIn('slow');
		$('input[name=' + fieldNamePhysicalConnectionTargetEndpointTargetName + ']').parent().fadeIn('slow');
	}
	if (value == 'internet') {
		$('input[name=' + fieldNamePhysicalConnectionTargetEndpointTargetApplicationTechnicalShortName + ']').val('');
		$('input[name=' + fieldNamePhysicalConnectionTargetEndpointTargetApplicationTechnicalShortName + ']').parent().fadeOut('slow');
		$('input[name=' + fieldNamePhysicalConnectionTargetEndpointTargetName + ']').val('');
		$('input[name=' + fieldNamePhysicalConnectionTargetEndpointTargetName + ']').parent().fadeOut('slow');

		$('input[name=' + fieldNamePhysicalConnectionTargetEndpointTargetCustomerName + ']').parent().fadeIn('slow');
	}
}

//Linux/Unix #start#
$(document).ready(function() {
	fieldServerSourceToggle = $('#fieldgroup-specific-endpoint-source .toggle-server');
	fieldTheServerSource = $('#fieldgroup-basic-endpoint-source .input-server');
	fieldAServerSource = $('#fieldgroup-specific-endpoint-source .input-server');
	fieldsetMultipleServersSource = $('#fieldgroup-specific-endpoint-source .fieldset-multiple-servers');
	fieldServiceAddressSource = $('.field-service-address');
	fieldServiceAddressToggle = $('#fieldgroup-specific-endpoint-source .toggle-service-address');

	fieldServerSourceToggle.change(function() {
		toggleFieldServerSource(this.value);
	});
	fieldServiceAddressToggle.change(function() {
		toggleFieldServiceAddressSource(this);
	});

	fieldServerSourceToggle.filter(':checked').trigger('change');
	fieldServiceAddressToggle.trigger('change');
});
function toggleFieldServerSource(value) {
	if (value == 'single_server') {
		fieldTheServerSource.parent().fadeIn('slow');
		fieldAServerSource.val('');
		fieldsetMultipleServersSource.fadeOut('slow');
		fieldServiceAddressToggle.parent().fadeIn('slow');
	} else if (value == 'multiple_servers') {
		fieldTheServerSource.val('');
		fieldTheServerSource.parent().fadeOut('slow');
		fieldsetMultipleServersSource.fadeIn('slow');
		fieldServiceAddressSource.val('');
		fieldServiceAddressToggle.prop('checked', false);
		fieldServiceAddressToggle.trigger('change');
		fieldServiceAddressToggle.parent().fadeOut('slow');
	}
}
function toggleFieldServiceAddressSource(field) {
	if ($(field).prop('checked')) {
		fieldServiceAddressSource.parent().fadeIn('slow');
	} else {
		fieldServiceAddressSource.parent().fadeOut('slow');
	}
}
//Linux/Unix #stop#
