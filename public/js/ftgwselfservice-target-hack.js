/**
 * A hack for FTGW Self-Service to disable the irrelevant target basic endpoint fields.
 */
fieldEndpointTargetCustomerName = $('#fieldgroup-basic-endpoint-target .field-customer-name');

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
}
