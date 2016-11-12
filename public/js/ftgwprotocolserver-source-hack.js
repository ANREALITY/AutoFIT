/**
 * A hack for FTGW Protocol Server to disable the irrelevant source basic endpoint fields.
 */
$(document).ready(function() {
	fieldEndpointSourceServerPlace = $('#fieldgroup-basic-endpoint-source .field-server-place');
	fieldEndpointSourceServerName = $('#fieldgroup-basic-endpoint-source .input-server');
	fieldEndpointSourceExternalServerName = $('#fieldgroup-basic-endpoint-source .input-external-server');
	infoBoxServerHintSource = $('#fieldgroup-basic-endpoint-source .server-hint');
	fieldEndpointSourceServerPlace.change(function() {
		fieldEndpointSourceServerName.val('');
		fieldEndpointSourceServerName.parent().fadeOut('slow');
		fieldEndpointSourceExternalServerName.val('');
		fieldEndpointSourceExternalServerName.parent().fadeOut('slow');
		infoBoxServerHintSource.fadeOut('slow');
	});
	fieldEndpointSourceServerPlace.filter(':checked').trigger('change');
});;