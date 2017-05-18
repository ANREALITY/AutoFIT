// Linux/Unix EndpointTarget #start#
$(document).ready(function() {
	// basic
	basicFieldEndpointTargetServerPlace = $('#fieldgroup-basic-endpoint-target .field-server-place');
	fieldTheServerTarget = $('#fieldgroup-basic-endpoint-target .input-server');
	fieldTheServerNodeNameTarget = $('#fieldgroup-basic-endpoint-target .field-server-node-name');
	fieldTheServerEndpointServerConfigDnsAddressTarget = $('#fieldgroup-basic-endpoint-target .field-endpoint-server-config-dns-address');
	fieldTheExternalServerTarget = $('#fieldgroup-basic-endpoint-target .input-external-server');
    infoBoxServerHintTarget = $('#fieldgroup-basic-endpoint-target .server-hint');
    // specific
    fieldServerTargetToggle = $('#fieldgroup-specific-endpoint-target .toggle-server');
	fieldClusterIdTarget = $('#fieldgroup-specific-endpoint-target .field-cluster-id');
	fieldClusterVirtualNodeNameTarget = $('#fieldgroup-specific-endpoint-target .field-cluster-virtual-node-name');
	infoBoxClusterTarget = $('#fieldgroup-specific-endpoint-target .cluster-hint');
	fieldEndpointClusterConfigIdTarget = $('#fieldgroup-specific-endpoint-target .field-endpoint-cluster-config-id');
	fieldEndpointClusterConfigDnsAddressTarget = $('#fieldgroup-specific-endpoint-target .field-endpoint-cluster-config-dns-address');
});
$(document).ready(function() {
	fieldServerTargetToggle.change(function() {
		toggleFieldServerTarget(this.value);
	});
	fieldServerTargetToggle.filter(':checked').trigger('change');
	basicFieldEndpointTargetServerPlace.change(function() {
		console.log(global.targetServerQuantity);
		toggleFieldServerTarget('');
	});
});
function toggleFieldServerTarget(value) {
	if (value == '') {
		value = global.targetServerQuantity;
	}
	if (value == SERVER_QUANTITY_ONE) {
        fieldClusterIdTarget.val('');
        fieldClusterVirtualNodeNameTarget.val('');
        fieldClusterVirtualNodeNameTarget.parent().fadeOut('slow');
        infoBoxClusterTarget.fadeOut('slow');
        fieldEndpointClusterConfigIdTarget.val('');
        fieldEndpointClusterConfigDnsAddressTarget.val('');
        fieldEndpointClusterConfigDnsAddressTarget.parent().fadeOut('slow');
		if (global.targetServerPlace != SERVER_PLACE_EXTERNAL) {
            // manipulating basic fields
			fieldServerTargetToggle.parent().parent().fadeIn('slow');

			fieldTheServerTarget.parent().fadeIn('slow');
			infoBoxServerHintTarget.fadeIn('slow');
			fieldTheServerNodeNameTarget.parent().fadeIn('slow');
			fieldTheServerEndpointServerConfigDnsAddressTarget.parent().fadeIn('slow');
		}
		if (global.targetServerPlace != SERVER_PLACE_INTERNAL) {
            // manipulating basic fields
			fieldServerTargetToggle.parent().parent().fadeOut('slow');
		}
		global.targetServerQuantity = SERVER_QUANTITY_ONE;
	} else if (value == SERVER_QUANTITY_MANY) {
		fieldTheServerTarget.val('');
		fieldTheServerTarget.parent().fadeOut('slow');
		infoBoxServerHintTarget.fadeOut('slow');
		fieldTheServerNodeNameTarget.val('');
		fieldTheServerNodeNameTarget.parent().fadeOut('slow');
		fieldTheServerEndpointServerConfigDnsAddressTarget.val('');
		fieldTheServerEndpointServerConfigDnsAddressTarget.parent().fadeOut('slow');
		if (global.targetServerPlace != SERVER_PLACE_EXTERNAL) {
            // manipulating basic fields
			fieldServerTargetToggle.parent().parent().fadeIn('slow');

			fieldClusterVirtualNodeNameTarget.parent().fadeIn('slow');
			infoBoxClusterTarget.fadeIn('slow');
			fieldEndpointClusterConfigDnsAddressTarget.parent().fadeIn('slow');
		}
		if (global.targetServerPlace != SERVER_PLACE_INTERNAL) {
            // manipulating basic fields
			fieldServerTargetToggle.parent().parent().fadeOut('slow');

			fieldClusterIdTarget.val('');
			fieldClusterVirtualNodeNameTarget.val('');
			fieldClusterVirtualNodeNameTarget.parent().fadeOut('slow');
			infoBoxClusterTargetinfoBoxClusterTarget
			fieldEndpointClusterConfigIdTarget.val('');
			fieldEndpointClusterConfigDnsAddressTarget.val('');
			fieldEndpointClusterConfigDnsAddressTarget.parent().fadeOut('slow');
		}
		global.targetServerQuantity = SERVER_QUANTITY_MANY;	
	}
}
// Linux/Unix EndpointTarget #stop#
