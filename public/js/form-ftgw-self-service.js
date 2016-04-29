/**
 * FtgwSelfService specific formatting
 */
const TYPE_SELF_SERVICE = 'FtgwSelfService';

fieldNamePhysicalConnectionSourceEndpointSourceType = '"file_transfer_request[logical_connection][physical_connection_source][endpoint_source][type]"';

fieldNamePhysicalConnectionSourceEndpointSourceServerPlace = '"file_transfer_request[logical_connection][physical_connection_source][endpoint_source][server_place]"';
fieldNamePhysicalConnectionSourceEndpointSourceCustomerName = '"file_transfer_request[logical_connection][physical_connection_source][endpoint_source][customer][name]"';
fieldNamePhysicalConnectionSourceEndpointSourceApplicationTechnicalShortName = '"file_transfer_request[logical_connection][physical_connection_source][endpoint_source][application][technical_short_name]"';
fieldNamePhysicalConnectionSourceEndpointSourceServerName = '"file_transfer_request[logical_connection][physical_connection_source][endpoint_source][server][name]"';

fieldNamePhysicalConnectionTargetEndpointTargetType = '"file_transfer_request[logical_connection][physical_connection_target][endpoint_target][type]"';

fieldNamePhysicalConnectionTargetEndpointTargetServerPlace = '"file_transfer_request[logical_connection][physical_connection_target][endpoint_target][server_place]"';
fieldNamePhysicalConnectionTargetEndpointTargetCustomerName = '"file_transfer_request[logical_connection][physical_connection_target][endpoint_target][customer][name]"';
fieldNamePhysicalConnectionTargetEndpointTargetApplicationTechnicalShortName = '"file_transfer_request[logical_connection][physical_connection_target][endpoint_target][application][technical_short_name]"';
fieldNamePhysicalConnectionTargetEndpointTargetServerName = '"file_transfer_request[logical_connection][physical_connection_target][endpoint_target][server][name]"';

$(document).ready(function() {
	physicalConnectionSourceEndpointSourceType = $('input[name=' + fieldNamePhysicalConnectionSourceEndpointSourceType + ']').val();
	if (physicalConnectionSourceEndpointSourceType === TYPE_SELF_SERVICE) {
		removeNeedlessSourceFields();
	}
	physicalConnectionTargetEndpointTargetType = $('input[name=' + fieldNamePhysicalConnectionTargetEndpointTargetType + ']').val();
	if (physicalConnectionTargetEndpointTargetType === TYPE_SELF_SERVICE) {
		removeNeedlessTargetFields();
	}
});

function removeNeedlessSourceFields() {
	$('input[name=' + fieldNamePhysicalConnectionSourceEndpointSourceServerPlace + ']').parent().parent().hide();
	$('input[name=' + fieldNamePhysicalConnectionSourceEndpointSourceCustomerName + ']').val('');
	$('input[name=' + fieldNamePhysicalConnectionSourceEndpointSourceCustomerName + ']').parent().hide();
	$('input[name=' + fieldNamePhysicalConnectionSourceEndpointSourceApplicationTechnicalShortName + ']').val('');
	$('input[name=' + fieldNamePhysicalConnectionSourceEndpointSourceApplicationTechnicalShortName + ']').parent().hide();
	$('input[name=' + fieldNamePhysicalConnectionSourceEndpointSourceServerName + ']').val('');
	$('input[name=' + fieldNamePhysicalConnectionSourceEndpointSourceServerName + ']').parent().hide();
}

function removeNeedlessTargetFields() {
	$('input[name=' + fieldNamePhysicalConnectionTargetEndpointTargetServerPlace + ']').parent().parent().hide();
	$('input[name=' + fieldNamePhysicalConnectionTargetEndpointTargetCustomerName + ']').val('');
	$('input[name=' + fieldNamePhysicalConnectionTargetEndpointTargetCustomerName + ']').parent().hide();
	$('input[name=' + fieldNamePhysicalConnectionTargetEndpointTargetApplicationTechnicalShortName + ']').val('');
	$('input[name=' + fieldNamePhysicalConnectionTargetEndpointTargetApplicationTechnicalShortName + ']').parent().hide();
	$('input[name=' + fieldNamePhysicalConnectionTargetEndpointTargetServerName + ']').val('');
	$('input[name=' + fieldNamePhysicalConnectionTargetEndpointTargetServerName + ']').parent().hide();
}
