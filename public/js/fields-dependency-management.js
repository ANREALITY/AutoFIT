/**
 * Clearing and enabling/disabling of fields dependending on other fields.
 */
// Billing #start#
$(document).ready(function() {
	fieldApplicationNumber = $('#order-application-number');
	fieldEnvironmentSeverity = $("#order-environment-severity");
	fieldEnvironmentName = $("#order-environment-name");
	fieldInvoicePositionBasic = $("#order-service-invoice-position-basic-number");
	fieldInvoicePositionPersonal = $("#order-service-invoice-position-personal-number");
});

$(document).ready(function() {
	fieldApplicationNumber.on('autocompletechange', function() {
		console.log('autocompletechange');
		fieldApplicationNumber.trigger('change');
	});
	fieldApplicationNumber.change(function() {
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
// Billing #stop#

// EndpointSource basic #start#
$(document).ready(function() {
	fieldEndpointSourceServerPlace = $('#fieldgroup-basic-endpoint-source .field-server-place');
	fieldEndpointSourceCustomerName = $('#fieldgroup-basic-endpoint-source .field-customer-name');
	fieldEndpointSourceApplicationNumber = $('#fieldgroup-basic-endpoint-source .field-application-number');
	fieldEndpointSourceServerName = $('#fieldgroup-basic-endpoint-source .input-server');

	fieldEndpointSourceServerPlace.change(function() {
		toggleEndpointSourceDependentFields(this.value);
	});
	fieldEndpointSourceServerPlace.filter(':checked').trigger('change');
});
function toggleEndpointSourceDependentFields(value) {
	if (value == 'internal') {
		fieldEndpointSourceCustomerName.val('');
		fieldEndpointSourceCustomerName.parent().fadeOut('slow');

		fieldEndpointSourceApplicationNumber.parent().fadeIn('slow');
		fieldEndpointSourceServerName.parent().fadeIn('slow');
	}
	if (value == 'external') {
		fieldEndpointSourceApplicationNumber.val('');
		fieldEndpointSourceApplicationNumber.parent().fadeOut('slow');
		fieldEndpointSourceServerName.val('');
		fieldEndpointSourceServerName.parent().fadeOut('slow');

		fieldEndpointSourceCustomerName.parent().fadeIn('slow');
	}
}
// EndpointSource basic #stop#

// EndpointTarget basic #start#
$(document).ready(function() {
	fieldEndpointTargetServerPlace = $('#fieldgroup-basic-endpoint-target .field-server-place');
	fieldEndpointTargetCustomerName = $('#fieldgroup-basic-endpoint-target .field-customer-name');
	fieldEndpointTargetApplicationNumber = $('#fieldgroup-basic-endpoint-target .field-application-number');
	fieldEndpointTargetServerName = $('#fieldgroup-basic-endpoint-target .input-server');

	fieldEndpointTargetServerPlace.change(function() {
		toggleEndpointTargetDependentFields(this.value);
	});
	fieldEndpointTargetServerPlace.filter(':checked').trigger('change');
});
function toggleEndpointTargetDependentFields(value) {
	if (value == 'internal') {
		fieldEndpointTargetCustomerName.val('');
		fieldEndpointTargetCustomerName.parent().fadeOut('slow');

		fieldEndpointTargetApplicationNumber.parent().fadeIn('slow');
		fieldEndpointTargetServerName.parent().fadeIn('slow');
	}
	if (value == 'external') {
		fieldEndpointTargetApplicationNumber.val('');
		fieldEndpointTargetApplicationNumber.parent().fadeOut('slow');
		fieldEndpointTargetServerName.val('');
		fieldEndpointTargetServerName.parent().fadeOut('slow');

		fieldEndpointTargetCustomerName.parent().fadeIn('slow');
	}
}
// EndpointTarget basic #stop#

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
		if (fieldTheServerSource.val() != '') {
			fieldAServerSource.first().val(fieldTheServerSource.val());
		}
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
		if (fieldTheServerTarget.val() != '') {
			fieldAServerTarget.first().val(fieldTheServerTarget.val());
		}
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
