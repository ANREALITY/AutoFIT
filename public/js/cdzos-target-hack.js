/**
 * A hack for CD ZOS to display the blocking type's label/legend.
 */
$(document).ready(function() {
	fieldEndpointTargetBlockingType = $('#fieldgroup-specific-endpoint-target .field-blocking-type');
	fieldEndpointTargetBlockingTypeLabel = fieldEndpointTargetBlockingType.parent().parent().find('legend').first();

	fieldEndpointTargetBlockingTypeLabel.css('display', 'inline');
});
