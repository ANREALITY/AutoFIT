/**
 * A hack for FTGW Protocol Server to disable the irrelevant target basic endpoint fields.
 */
$(document).ready(function() {
	fieldEndpointTargetServerPlace = $('#fieldgroup-basic-endpoint-target .field-server-place');
	fieldEndpointTargetServerName = $('#fieldgroup-basic-endpoint-target .input-server');
	fieldEndpointTargetExternalServerName = $('#fieldgroup-basic-endpoint-target .input-external-server');
	infoBoxServerHintTarget = $('#fieldgroup-basic-endpoint-target .server-hint');
	fieldEndpointTargetServerPlace.change(function() {
		fieldEndpointTargetServerName.val('');
		fieldEndpointTargetServerName.parent().fadeOut('slow');
		fieldEndpointTargetExternalServerName.val('');
		fieldEndpointTargetExternalServerName.parent().fadeOut('slow');
		infoBoxServerHintTarget.fadeOut('slow');
		console.log(12345);
	});
	fieldEndpointTargetServerPlace.filter(':checked').trigger('change');
});;