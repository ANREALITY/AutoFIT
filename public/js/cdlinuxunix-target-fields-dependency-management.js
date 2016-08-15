// Linux/Unix EndpointTarget #start#
$(document).ready(function() {
	basicFieldEndpointTargetServerPlace = $('#fieldgroup-basic-endpoint-target .field-server-place');
	fieldServerTargetToggle = $('#fieldgroup-specific-endpoint-target .toggle-server');
	fieldTheServerTarget = $('#fieldgroup-basic-endpoint-target .input-server');
	fieldAServerTarget = function() {
		return $('#fieldgroup-specific-endpoint-target .input-server');
	};
	fieldsetMultipleServersTarget = $('#fieldgroup-specific-endpoint-target .fieldset-multiple-servers');
	fieldServiceAddressTarget = $('#fieldgroup-specific-endpoint-target .field-service-address');
	fieldServiceAddressTargetToggle = $('#fieldgroup-specific-endpoint-target .toggle-service-address');
	buttonAddEndpointTargetServer = $('#fieldgroup-specific-endpoint-target #add-endpoint-target-server-button');
	fieldTheExternalServerTarget = $('#fieldgroup-basic-endpoint-target .input-external-server');
});
$(document).ready(function() {
	fieldServerTargetToggle.change(function() {
		toggleFieldServerTarget(this.value);
	});
	fieldServiceAddressTargetToggle.change(function() {
		toggleFieldServiceAddressTarget(this);
	});
	fieldServerTargetToggle.filter(':checked').trigger('change');
	// fieldServiceAddressTargetToggle.trigger('change');
	basicFieldEndpointTargetServerPlace.change(function() {
		console.log(global.targetServerQuantity);
		toggleFieldServerTarget('');
	});
});
function toggleFieldServerTarget(value) {
	if (value == '') {
		value = global.targetServerQuantity;
	}
	if (value == SERVER_QUANTITY_ONE) {
		if (global.targetServerPlace != SERVER_PLACE_EXTERNAL) {
			fieldServerTargetToggle.parent().parent().fadeIn('slow');
			fieldTheServerTarget.parent().fadeIn('slow');
		}
		fieldAServerTarget().val('');
		fieldsetMultipleServersTarget.fadeOut('slow');
		buttonAddEndpointTargetServer.fadeOut('slow');
		fieldServiceAddressTargetToggle.parent().fadeIn('slow');
		fieldServiceAddressTargetToggle.trigger('change');

		if (global.targetServerPlace != SERVER_PLACE_INTERNAL) {
			fieldServerTargetToggle.parent().parent().fadeOut('slow');
		}

		global.targetServerQuantity = SERVER_QUANTITY_ONE;
	} else if (value == SERVER_QUANTITY_MANY) {
		if (fieldTheServerTarget.val() != '') {
			fieldAServerTarget().first().val(fieldTheServerTarget.val());
		}
		fieldTheServerTarget.val('');
		fieldTheServerTarget.parent().fadeOut('slow');
		if (global.targetServerPlace != SERVER_PLACE_EXTERNAL) {
			fieldServerTargetToggle.parent().parent().fadeIn('slow');
			fieldsetMultipleServersTarget.fadeIn('slow');
			buttonAddEndpointTargetServer.fadeIn('slow');
		}
		if (global.targetServerPlace != SERVER_PLACE_INTERNAL) {
			fieldsetMultipleServersTarget.fadeOut('slow');
			buttonAddEndpointTargetServer.fadeOut('slow');
		}
		fieldServiceAddressTargetToggle.prop('checked', false);
		fieldServiceAddressTargetToggle.trigger('change');
		fieldServiceAddressTargetToggle.parent().fadeOut('slow');

		if (global.targetServerPlace != SERVER_PLACE_INTERNAL) {
			fieldServerTargetToggle.parent().parent().fadeOut('slow');
			fieldAServerTarget().val('');
			fieldsetMultipleServersTarget.fadeOut('slow');
			buttonAddEndpointTargetServer.fadeOut('slow');
		}

		global.targetServerQuantity = SERVER_QUANTITY_MANY;	
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
// Linux/Unix EndpointTarget #stop#
