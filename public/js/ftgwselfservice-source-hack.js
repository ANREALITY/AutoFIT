/**
 * A hack for FTGW Self-Service to disable the irrelevant source basic endpoint fields.
 */
$(document).ready(function() {
	fieldEndpointSourceCustomerName = $('#fieldgroup-basic-endpoint-source .field-customer-name');
	fieldEndpointSourceExternalServerName = $('#fieldgroup-basic-endpoint-source .input-external-server');
});

$(document).ready(function() {
	fieldEndpointSourceServerPlace = $('#fieldgroup-basic-endpoint-source .field-server-place');
	fieldEndpointSourceServerPlace.val('external').attr('checked', true);
	fieldEndpointSourceServerPlace.parent().parent().fadeOut();
	fieldEndpointSourceServerPlace.filter(':checked').trigger('change');

	disableNeedlessSourceFields();
});

function disableNeedlessSourceFields() {
	fieldEndpointSourceCustomerName.val('');
	fieldEndpointSourceCustomerName.parent().fadeOut('slow');
	fieldEndpointSourceExternalServerName.val('');
	fieldEndpointSourceExternalServerName.parent().fadeOut('slow');
}
