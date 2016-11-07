/**
 * A hack for FTGW Protocol Server to disable the irrelevant target basic endpoint fields.
 */
$(document).ready(function() {
	fieldEndpointTargetServerPlace = $('#fieldgroup-basic-endpoint-target .field-server-place');
	fieldEndpointTargetServerName = $('#fieldgroup-basic-endpoint-target .input-server');
	fieldEndpointTargetExternalServerName = $('#fieldgroup-basic-endpoint-target .input-external-server');
	fieldEndpointTargetServerPlace.change(function() {
		fieldEndpointTargetServerName.val('');
		fieldEndpointTargetServerName.parent().fadeOut('slow');
		fieldEndpointTargetExternalServerName.val('');
		fieldEndpointTargetExternalServerName.parent().fadeOut('slow');
		console.log(12345);
	});
	fieldEndpointTargetServerPlace.filter(':checked').trigger('change');
});;