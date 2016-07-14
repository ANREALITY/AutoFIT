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
	buttonAddEndpointTargetServer = $('#fieldgroup-specific-endpoint-target #add-endpoint-target-server-button');

	fieldTheExternalServerTarget = $('#fieldgroup-basic-endpoint-target .input-external-server');
	fieldAnExternalServerTarget = $('#fieldgroup-specific-endpoint-target .input-external-server');
	fieldsetMultipleExternalServersTarget = $('#fieldgroup-specific-endpoint-target .fieldset-multiple-external-servers');
	buttonAddEndpointTargetExternalServer = $('#fieldgroup-specific-endpoint-target #add-endpoint-target-external-server-button');

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

		buttonAddEndpointTargetServer.fadeOut('slow');

		fieldTheExternalServerTarget.parent().fadeIn('slow');
		fieldAnExternalServerTarget.val('');
		fieldsetMultipleExternalServersTarget.fadeOut('slow');

		buttonAddEndpointTargetExternalServer.fadeOut('slow');
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

		buttonAddEndpointTargetServer.fadeIn('slow');

		if (fieldTheExternalServerTarget.val() != '') {
			fieldAnExternalServerTarget.first().val(fieldTheExternalServerTarget.val());
		}
		fieldTheExternalServerTarget.val('');
		fieldTheExternalServerTarget.parent().fadeOut('slow');
		fieldsetMultipleExternalServersTarget.fadeIn('slow');

		buttonAddEndpointTargetExternalServer.fadeIn('slow');
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
