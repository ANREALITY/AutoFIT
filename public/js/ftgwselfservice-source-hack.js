/**
 * A hack for FTGW Self-Service to disable the irrelevant source basic endpoint fields.
 */
fieldEndpointSourceCustomerName = $('#fieldgroup-basic-endpoint-source .field-customer-name');

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
}
