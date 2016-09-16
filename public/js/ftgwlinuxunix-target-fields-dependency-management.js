// Linux/Unix EndpointTarget #start#
$(document).ready(function() {
	basicFieldEndpointTargetServerPlace = $('#fieldgroup-basic-endpoint-target .field-server-place');
	fieldServerTargetToggle = $('#fieldgroup-specific-endpoint-target .toggle-server');
	fieldTheServerTarget = $('#fieldgroup-basic-endpoint-target .input-server');
	fieldTheServerNodeNameTarget = $('#fieldgroup-basic-endpoint-target .field-server-node-name');
	fieldTheServerEndpointServerConfigDnsAddressTarget = $('#fieldgroup-basic-endpoint-target .field-endpoint-server-config-dns-address');
	fieldServiceAddressTarget = $('#fieldgroup-specific-endpoint-target .field-service-address');
	fieldServiceAddressTargetToggle = $('#fieldgroup-specific-endpoint-target .toggle-service-address');
	fieldTheExternalServerTarget = $('#fieldgroup-basic-endpoint-target .input-external-server');
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
	fieldServiceAddressTargetToggle.change(function() {
		toggleFieldServiceAddressTarget(this);
	});
	fieldServerTargetToggle.filter(':checked').trigger('change');
	// fieldServiceAddressTargetToggle.trigger('change');
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
		if (global.targetServerPlace != SERVER_PLACE_EXTERNAL) {
			fieldServerTargetToggle.parent().parent().fadeIn('slow');
			fieldTheServerTarget.parent().fadeIn('slow');
			fieldTheServerNodeNameTarget.parent().fadeIn('slow');
			fieldTheServerEndpointServerConfigDnsAddressTarget.parent().fadeIn('slow');
			fieldServiceAddressTargetToggle.parent().fadeIn('slow');
			fieldServiceAddressTargetToggle.trigger('change');
		}
		fieldClusterIdTarget.val('');
		fieldClusterVirtualNodeNameTarget.val('');
		fieldClusterVirtualNodeNameTarget.parent().fadeOut('slow');
		infoBoxClusterTarget.fadeOut('slow');
		fieldEndpointClusterConfigIdTarget.val('');
		fieldEndpointClusterConfigDnsAddressTarget.val('');
		fieldEndpointClusterConfigDnsAddressTarget.parent().fadeOut('slow');

		if (global.targetServerPlace != SERVER_PLACE_INTERNAL) {
			fieldServerTargetToggle.parent().parent().fadeOut('slow');
			fieldServiceAddressTargetToggle.prop('checked', false);
			fieldServiceAddressTargetToggle.trigger('change');
			fieldServiceAddressTargetToggle.parent().fadeOut('slow');
		}

		global.targetServerQuantity = SERVER_QUANTITY_ONE;
	} else if (value == SERVER_QUANTITY_MANY) {
		fieldTheServerTarget.val('');
		fieldTheServerTarget.parent().fadeOut('slow');
		fieldTheServerNodeNameTarget.val('');
		fieldTheServerNodeNameTarget.parent().fadeOut('slow');
		fieldTheServerEndpointServerConfigDnsAddressTarget.val('');
		fieldTheServerEndpointServerConfigDnsAddressTarget.parent().fadeOut('slow');
		fieldServiceAddressTargetToggle.prop('checked', false);
		fieldServiceAddressTargetToggle.trigger('change');
		fieldServiceAddressTargetToggle.parent().fadeOut('slow');
		if (global.targetServerPlace != SERVER_PLACE_EXTERNAL) {
			fieldServerTargetToggle.parent().parent().fadeIn('slow');
			fieldClusterVirtualNodeNameTarget.parent().fadeIn('slow');
			infoBoxClusterTarget.fadeIn('slow');
			fieldEndpointClusterConfigDnsAddressTarget.parent().fadeIn('slow');
		}
		if (global.targetServerPlace != SERVER_PLACE_INTERNAL) {
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
function toggleFieldServiceAddressTarget(field) {
	if ($(field).prop('checked')) {
		fieldServiceAddressTarget.parent().fadeIn('slow');
	} else {
		fieldServiceAddressTarget.val('');
		fieldServiceAddressTarget.parent().fadeOut('slow');
	}
}
// Linux/Unix EndpointTarget #stop#
