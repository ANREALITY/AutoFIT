/**
 * A hack for FTGW CD ZOS to display the blocking type's label/legend.
 */
$(document).ready(function() {
	fieldEndpointTargetBlockingType = $('#fieldgroup-specific-endpoint-target .field-blocking');
	fieldEndpointTargetBlockingTypeLabel = fieldEndpointTargetBlockingType.parent().parent().find('legend').first();

	fieldEndpointTargetBlockingTypeLabel.css('display', 'inline');
});
