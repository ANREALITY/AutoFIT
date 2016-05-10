/**
 * Clearing and enabling/disabling of fields dependending on other fields.
 */
// Billing #start#
$(document).ready(function() {
	fieldApplicationTechnicalShortName = $('#order-application-number');
	fieldEnvironmentSeverity = $("#order-environment-severity");
	fieldEnvironmentName = $("#order-environment-name");
	fieldInvoicePositionBasic = $("#order-service-invoice-position-basic-number");
	fieldInvoicePositionPersonal = $("#order-service-invoice-position-personal-number");
});

$(document).ready(function() {
	fieldApplicationTechnicalShortName.on('autocompletechange', function() {
		console.log('autocompletechange');
		fieldApplicationTechnicalShortName.trigger('change');
	});
	fieldApplicationTechnicalShortName.change(function() {
		console.log('change');
		updateApplicationDependentFields(this.value);
	});
	fieldEnvironmentName.on('autocompletechange', function() {
		console.log('autocompletechange');
		fieldEnvironmentSeverity.trigger('change');
	});
	fieldEnvironmentSeverity.change(function() {
		console.log('change');
		updateEnvironmentDependentFields(this.value);
	});
});
//Billing #stop#

function updateApplicationDependentFields(value) {
	fieldEnvironmentSeverity.val('');
	fieldEnvironmentName.val('');
	fieldInvoicePositionBasic.val('');
	fieldInvoicePositionPersonal.val('');
}

function updateEnvironmentDependentFields(value) {
	fieldInvoicePositionBasic.val('');
	fieldInvoicePositionPersonal.val('');
}

// PhysicalConnectionSource.EndpointSource basic #start#
fieldNamePhysicalConnectionSourceEndpointSourceServerPlace = '"file_transfer_request[logical_connection][physical_connection_source][endpoint_source][server_place]"';
fieldNamePhysicalConnectionSourceEndpointSourceCustomerName = '"file_transfer_request[logical_connection][physical_connection_source][endpoint_source][customer][name]"';
fieldNamePhysicalConnectionSourceEndpointSourceApplicationTechnicalShortName = '"file_transfer_request[logical_connection][physical_connection_source][endpoint_source][application][technical_short_name]"';
fieldNamePhysicalConnectionSourceEndpointSourceName = '"file_transfer_request[logical_connection][physical_connection_source][endpoint_source][server][name]"';

$(document).ready(function() {
	fieldPhysicalConnectionSourceEndpointSourceServerPlace = $('input[type=radio][name=' + fieldNamePhysicalConnectionSourceEndpointSourceServerPlace + ']');
	fieldPhysicalConnectionSourceEndpointSourceServerPlace.change(function() {
		togglePhysicalConnectionSourceEndpointSourceDependentFields(this.value);
	});
	fieldPhysicalConnectionSourceEndpointSourceServerPlace.filter(':checked').trigger('change');
});
// PhysicalConnectionSource.EndpointSource basic #stop#
// PhysicalConnectionSource.EndpointTarget basic #start#
fieldNamePhysicalConnectionSourceEndpointTargetServerPlace = '"file_transfer_request[logical_connection][physical_connection_source][endpoint_target][server_place]"';
fieldNamePhysicalConnectionSourceEndpointTargetCustomerName = '"file_transfer_request[logical_connection][physical_connection_source][endpoint_target][customer][name]"';
fieldNamePhysicalConnectionSourceEndpointTargetApplicationTechnicalShortName = '"file_transfer_request[logical_connection][physical_connection_source][endpoint_target][application][technical_short_name]"';
fieldNamePhysicalConnectionSourceEndpointTargetName = '"file_transfer_request[logical_connection][physical_connection_source][endpoint_target][server][name]"';

$(document).ready(function() {
	fieldPhysicalConnectionSourceEndpointTargetServerPlace = $('input[type=radio][name=' + fieldNamePhysicalConnectionSourceEndpointTargetServerPlace + ']');
	fieldPhysicalConnectionSourceEndpointTargetServerPlace.change(function() {
		togglePhysicalConnectionSourceEndpointTargetDependentFields(this.value);
	});
	fieldPhysicalConnectionSourceEndpointTargetServerPlace.filter(':checked').trigger('change');
});
// PhysicalConnectionSource.EndpointTarget basic #stop#
// PhysicalConnectionTarget.EndpointTarget basic #start#
fieldNamePhysicalConnectionTargetEndpointTargetServerPlace = '"file_transfer_request[logical_connection][physical_connection_target][endpoint_target][server_place]"';
fieldNamePhysicalConnectionTargetEndpointTargetCustomerName = '"file_transfer_request[logical_connection][physical_connection_target][endpoint_target][customer][name]"';
fieldNamePhysicalConnectionTargetEndpointTargetApplicationTechnicalShortName = '"file_transfer_request[logical_connection][physical_connection_target][endpoint_target][application][technical_short_name]"';
fieldNamePhysicalConnectionTargetEndpointTargetName = '"file_transfer_request[logical_connection][physical_connection_target][endpoint_target][server][name]"';

$(document).ready(function() {
	fieldPhysicalConnectionSourceEndpointSourceServerPlace = $('input[type=radio][name=' + fieldNamePhysicalConnectionTargetEndpointTargetServerPlace + ']');
	fieldPhysicalConnectionSourceEndpointSourceServerPlace.change(function() {
		togglePhysicalConnectionTargetEndpointTargetDependentFields(this.value);
	});
	fieldPhysicalConnectionSourceEndpointSourceServerPlace.filter(':checked').trigger('change');
});
// PhysicalConnectionTarget.EndpointTarget basic #stop#

function togglePhysicalConnectionSourceEndpointSourceDependentFields(value) {
	if (value == 'internal') {
		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointSourceCustomerName + ']').val('');
		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointSourceCustomerName + ']').parent().fadeOut('slow');

		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointSourceApplicationTechnicalShortName + ']').parent().fadeIn('slow');
		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointSourceName + ']').parent().fadeIn('slow');
	}
	if (value == 'external') {
		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointSourceApplicationTechnicalShortName + ']').val('');
		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointSourceApplicationTechnicalShortName + ']').parent().fadeOut('slow');
		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointSourceName + ']').val('');
		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointSourceName + ']').parent().fadeOut('slow');

		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointSourceCustomerName + ']').parent().fadeIn('slow');
	}
}
function togglePhysicalConnectionSourceEndpointTargetDependentFields(value) {
	if (value == 'internal') {
		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointTargetCustomerName + ']').val('');
		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointTargetCustomerName + ']').parent().fadeOut('slow');

		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointTargetApplicationTechnicalShortName + ']').parent().fadeIn('slow');
		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointTargetName + ']').parent().fadeIn('slow');
	}
	if (value == 'external') {
		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointTargetApplicationTechnicalShortName + ']').val('');
		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointTargetApplicationTechnicalShortName + ']').parent().fadeOut('slow');
		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointTargetName + ']').val('');
		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointTargetName + ']').parent().fadeOut('slow');

		$('input[name=' + fieldNamePhysicalConnectionSourceEndpointTargetCustomerName + ']').parent().fadeIn('slow');
	}
}
function togglePhysicalConnectionTargetEndpointTargetDependentFields(value) {
	if (value == 'internal') {
		$('input[name=' + fieldNamePhysicalConnectionTargetEndpointTargetCustomerName + ']').val('');
		$('input[name=' + fieldNamePhysicalConnectionTargetEndpointTargetCustomerName + ']').parent().fadeOut('slow');

		$('input[name=' + fieldNamePhysicalConnectionTargetEndpointTargetApplicationTechnicalShortName + ']').parent().fadeIn('slow');
		$('input[name=' + fieldNamePhysicalConnectionTargetEndpointTargetName + ']').parent().fadeIn('slow');
	}
	if (value == 'external') {
		$('input[name=' + fieldNamePhysicalConnectionTargetEndpointTargetApplicationTechnicalShortName + ']').val('');
		$('input[name=' + fieldNamePhysicalConnectionTargetEndpointTargetApplicationTechnicalShortName + ']').parent().fadeOut('slow');
		$('input[name=' + fieldNamePhysicalConnectionTargetEndpointTargetName + ']').val('');
		$('input[name=' + fieldNamePhysicalConnectionTargetEndpointTargetName + ']').parent().fadeOut('slow');

		$('input[name=' + fieldNamePhysicalConnectionTargetEndpointTargetCustomerName + ']').parent().fadeIn('slow');
	}
}

// Linux/Unix EndpointSource #start#
$(document).ready(function() {
	fieldServerSourceToggle = $('#fieldgroup-specific-endpoint-source .toggle-server');
	fieldTheServerSource = $('#fieldgroup-basic-endpoint-source .input-server');
	fieldAServerSource = $('#fieldgroup-specific-endpoint-source .input-server');
	fieldsetMultipleServersSource = $('#fieldgroup-specific-endpoint-source .fieldset-multiple-servers');
	fieldServiceAddressSource = $('#fieldgroup-specific-endpoint-source .field-service-address');
	fieldServiceAddressSourceToggle = $('#fieldgroup-specific-endpoint-source .toggle-service-address');

	fieldServerSourceToggle.change(function() {
		toggleFieldServerSource(this.value);
	});
	fieldServiceAddressSourceToggle.change(function() {
		toggleFieldServiceAddressSource(this);
	});

	fieldServerSourceToggle.filter(':checked').trigger('change');
	// fieldServiceAddressSourceToggle.trigger('change');
});
function toggleFieldServerSource(value) {
	if (value == 'single_server') {
		fieldTheServerSource.parent().fadeIn('slow');
		fieldAServerSource.val('');
		fieldsetMultipleServersSource.fadeOut('slow');
		
		fieldServiceAddressSourceToggle.parent().fadeIn('slow');
		fieldServiceAddressSourceToggle.trigger('change');
	} else if (value == 'multiple_servers') {
		fieldAServerSource.first().val(fieldTheServerSource.val());
		fieldTheServerSource.val('');
		fieldTheServerSource.parent().fadeOut('slow');
		fieldsetMultipleServersSource.fadeIn('slow');
		
		fieldServiceAddressSourceToggle.prop('checked', false);
		fieldServiceAddressSourceToggle.trigger('change');
		fieldServiceAddressSourceToggle.parent().fadeOut('slow');
	}
}
function toggleFieldServiceAddressSource(field) {
	if ($(field).prop('checked')) {
		fieldServiceAddressSource.parent().fadeIn('slow');
	} else {
		fieldServiceAddressSource.val('');
		fieldServiceAddressSource.parent().fadeOut('slow');
	}
}
// Linux/Unix EndpointSource #stop#

// Linux/Unix EndpointTarget #start#
$(document).ready(function() {
	fieldServerTargetToggle = $('#fieldgroup-specific-endpoint-target .toggle-server');
	fieldTheServerTarget = $('#fieldgroup-basic-endpoint-target .input-server');
	fieldAServerTarget = $('#fieldgroup-specific-endpoint-target .input-server');
	fieldsetMultipleServersTarget = $('#fieldgroup-specific-endpoint-target .fieldset-multiple-servers');
	fieldServiceAddressTarget = $('#fieldgroup-specific-endpoint-target .field-service-address');
	fieldServiceAddressTargetToggle = $('#fieldgroup-specific-endpoint-target .toggle-service-address');
	fieldClusterTarget = $('#fieldgroup-specific-endpoint-target .field-cluster');
	fieldClusterTargetToggle = $('#fieldgroup-specific-endpoint-target .toggle-cluster');

	fieldServerTargetToggle.change(function() {
		toggleFieldServerTarget(this.value);
	});
	fieldServiceAddressTargetToggle.change(function() {
		toggleFieldServiceAddressTarget(this);
	});
	fieldClusterTargetToggle.change(function() {
		toggleFieldClusterTarget(this);
	});

	fieldServerTargetToggle.filter(':checked').trigger('change');
	// fieldServiceAddressTargetToggle.trigger('change');
	// fieldClusterTargetToggle.trigger('change');
});
function toggleFieldServerTarget(value) {
	if (value == 'single_server') {
		fieldTheServerTarget.parent().fadeIn('slow');
		fieldAServerTarget.val('');
		fieldsetMultipleServersTarget.fadeOut('slow');
		
		fieldServiceAddressTargetToggle.parent().fadeIn('slow');
		fieldServiceAddressTargetToggle.trigger('change');
		
		fieldClusterTargetToggle.prop('checked', false);
		fieldClusterTargetToggle.trigger('change');
		fieldClusterTargetToggle.parent().fadeOut('slow');
	} else if (value == 'multiple_servers') {
		fieldAServerTarget.first().val(fieldTheServerTarget.val());
		fieldTheServerTarget.val('');
		fieldTheServerTarget.parent().fadeOut('slow');
		fieldsetMultipleServersTarget.fadeIn('slow');
		
		fieldServiceAddressTargetToggle.prop('checked', false);
		fieldServiceAddressTargetToggle.trigger('change');
		fieldServiceAddressTargetToggle.parent().fadeOut('slow');
		
		fieldClusterTargetToggle.parent().fadeIn('slow');
		fieldClusterTargetToggle.trigger('change');
	}
}
function toggleFieldServiceAddressTarget(field) {
	if ($(field).prop('checked')) {
		fieldServiceAddressTarget.parent().fadeIn('slow');
	} else {
		fieldServiceAddressTarget.val('');
		fieldServiceAddressTarget.parent().fadeOut('slow');
	}
}
function toggleFieldClusterTarget(field) {
	if ($(field).prop('checked')) {
		fieldClusterTarget.parent().fadeIn('slow');
	} else {
		fieldClusterTarget.val('');
		fieldClusterTarget.parent().fadeOut('slow');
	}
}
// Linux/Unix EndpointTarget #stop#
