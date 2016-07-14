// Linux/Unix EndpointSource #start#
$(document).ready(function() {
	fieldServerSourceToggle = $('#fieldgroup-specific-endpoint-source .toggle-server');
	fieldTheServerSource = $('#fieldgroup-basic-endpoint-source .input-server');
	fieldAServerSource = $('#fieldgroup-specific-endpoint-source .input-server');
	fieldsetMultipleServersSource = $('#fieldgroup-specific-endpoint-source .fieldset-multiple-servers');
	fieldServiceAddressSource = $('#fieldgroup-specific-endpoint-source .field-service-address');
	fieldServiceAddressSourceToggle = $('#fieldgroup-specific-endpoint-source .toggle-service-address');
	buttonAddEndpointSourceServer = $('#fieldgroup-specific-endpoint-source #add-endpoint-source-server-button');

	fieldTheExternalServerSource = $('#fieldgroup-basic-endpoint-source .input-external-server');
	fieldAnExternalServerSource = $('#fieldgroup-specific-endpoint-source .input-external-server');
	fieldsetMultipleExternalServersSource = $('#fieldgroup-specific-endpoint-source .fieldset-multiple-external-servers');
	buttonAddEndpointSourceExternalServer = $('#fieldgroup-specific-endpoint-source #add-endpoint-source-external-server-button');

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
	if (value == SERVER_QUANTITY_ONE) {
		fieldTheServerSource.parent().fadeIn('slow');
		fieldAServerSource.val('');
		fieldsetMultipleServersSource.fadeOut('slow');

		buttonAddEndpointSourceServer.fadeOut('slow');
		
		fieldServiceAddressSourceToggle.parent().fadeIn('slow');
		fieldServiceAddressSourceToggle.trigger('change');

		fieldTheExternalServerSource.parent().fadeIn('slow');
		fieldAnExternalServerSource.val('');
		fieldsetMultipleExternalServersSource.fadeOut('slow');

		buttonAddEndpointSourceExternalServer.fadeOut('slow');
	} else if (value == SERVER_QUANTITY_MANY) {
		if (fieldTheServerSource.val() != '') {
			fieldAServerSource.first().val(fieldTheServerSource.val());
		}
		fieldTheServerSource.val('');
		fieldTheServerSource.parent().fadeOut('slow');
		fieldsetMultipleServersSource.fadeIn('slow');

		buttonAddEndpointSourceServer.fadeIn('slow');

		if (fieldTheExternalServerSource.val() != '') {
			fieldAnExternalServerSource.first().val(fieldTheExternalServerSource.val());
		}
		fieldTheExternalServerSource.val('');
		fieldTheExternalServerSource.parent().fadeOut('slow');
		fieldsetMultipleExternalServersSource.fadeIn('slow');

		buttonAddEndpointSourceExternalServer.fadeIn('slow');

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
