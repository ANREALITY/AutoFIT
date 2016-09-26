/**
 * A hack for FTGW Self-Service to disable the irrelevant target basic endpoint fields.
 */
$(document).ready(function() {
	fieldEndpointTargetCustomerName = $('#fieldgroup-basic-endpoint-target .field-customer-name');
	fieldEndpointTargetExternalServerName = $('#fieldgroup-basic-endpoint-target .input-external-server');
});

$(document).ready(function() {
	fieldEndpointTargetServerPlace = $('#fieldgroup-basic-endpoint-target .field-server-place');
	fieldEndpointTargetServerPlace.val('external').attr('checked', true);
	fieldEndpointTargetServerPlace.parent().parent().fadeOut();
	fieldEndpointTargetServerPlace.filter(':checked').trigger('change');

	disableNeedlessTargetFields();
});

function disableNeedlessTargetFields() {
	fieldEndpointTargetCustomerName.val('');
	fieldEndpointTargetCustomerName.parent().fadeOut('slow');
	fieldEndpointTargetExternalServerName.val('');
	fieldEndpointTargetExternalServerName.parent().fadeOut('slow');
}
