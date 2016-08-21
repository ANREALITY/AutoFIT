/**
 * A hack for CD Windows Share to disable the irrelevant target basic endpoint fields.
 */
$(document).ready(function() {
	fieldEndpointTargetServerPlace = $('#fieldgroup-basic-endpoint-target .field-server-place');
	fieldEndpointTargetServerPlace.val('internal').attr('checked', true);
	fieldEndpointTargetServerPlace.parent().parent().fadeOut();
	fieldEndpointTargetServerPlace.filter(':checked').trigger('change');
});
