// Linux/Unix EndpointSource #start#
const TRANSMISSION_TYPE_TXT = 'txt';

$(document).ready(function() {
    // basic
	basicFieldEndpointSourceServerPlace = $('#fieldgroup-basic-endpoint-source .field-server-place');
	fieldTheServerSource = $('#fieldgroup-basic-endpoint-source .input-server');
	fieldTheServerNodeNameSource = $('#fieldgroup-basic-endpoint-source .field-server-node-name');
	fieldTheServerEndpointServerConfigDnsAddressSource = $('#fieldgroup-basic-endpoint-source .field-endpoint-server-config-dns-address');
	fieldTheExternalServerSource = $('#fieldgroup-basic-endpoint-source .input-external-server');
    infoBoxServerHintSource = $('#fieldgroup-basic-endpoint-source .server-hint');
    // specific server related
    fieldServerSourceToggle = $('#fieldgroup-specific-endpoint-source .toggle-server');
    fieldClusterIdSource = $('#fieldgroup-specific-endpoint-source .field-cluster-id');
    fieldClusterVirtualNodeNameSource = $('#fieldgroup-specific-endpoint-source .field-cluster-virtual-node-name');
    infoBoxClusterSource = $('#fieldgroup-specific-endpoint-source .cluster-hint');
    fieldEndpointClusterConfigIdSource = $('#fieldgroup-specific-endpoint-source .field-endpoint-cluster-config-id');
    fieldEndpointClusterConfigDnsAddressSource = $('#fieldgroup-specific-endpoint-source .field-endpoint-cluster-config-dns-address');
});
$(document).ready(function() {
	fieldServerSourceToggle.change(function() {
		toggleFieldServerSource(this.value);
	});
	fieldServerSourceToggle.filter(':checked').trigger('change');
	basicFieldEndpointSourceServerPlace.change(function() {
		console.log(global.sourceServerQuantity);
		toggleFieldServerSource('');
	});
});
function toggleFieldServerSource(value) {
	if (value == '') {
		value = global.sourceServerQuantity;
	}
	if (value == SERVER_QUANTITY_ONE) {
        // manipulating basic fields
        // manipulating specific fields
        fieldClusterIdSource.val('');
        fieldClusterVirtualNodeNameSource.val('');
        fieldClusterVirtualNodeNameSource.parent().fadeOut('slow');
        infoBoxClusterSource.fadeOut('slow');
        fieldEndpointClusterConfigIdSource.val('');
        fieldEndpointClusterConfigDnsAddressSource.val('');
        fieldEndpointClusterConfigDnsAddressSource.parent().fadeOut('slow');
		if (global.sourceServerPlace != SERVER_PLACE_EXTERNAL) {
            // manipulating basic fields
            fieldTheServerSource.parent().fadeIn('slow');
            fieldTheServerNodeNameSource.parent().fadeIn('slow');
            fieldTheServerEndpointServerConfigDnsAddressSource.parent().fadeIn('slow');
            infoBoxServerHintSource.fadeIn('slow');
            // manipulating specific fields
            fieldServerSourceToggle.parent().parent().fadeIn('slow');
		}
		if (global.sourceServerPlace != SERVER_PLACE_INTERNAL) {
            // manipulating basic fields
            // manipulating specific fields
            fieldServerSourceToggle.parent().parent().fadeOut('slow');
		}
		global.sourceServerQuantity = SERVER_QUANTITY_ONE;
	} else if (value == SERVER_QUANTITY_MANY) {
        // manipulating basic fields
        fieldTheServerSource.val('');
        fieldTheServerSource.parent().fadeOut('slow');
        fieldTheServerNodeNameSource.val('');
        fieldTheServerNodeNameSource.parent().fadeOut('slow');
        fieldTheServerEndpointServerConfigDnsAddressSource.val('');
        fieldTheServerEndpointServerConfigDnsAddressSource.parent().fadeOut('slow');
        infoBoxServerHintSource.fadeOut('slow');
        // manipulating specific fields

		if (global.sourceServerPlace != SERVER_PLACE_EXTERNAL) {
            // manipulating basic fields
            // manipulating specific fields
			fieldServerSourceToggle.parent().parent().fadeIn('slow');
            fieldClusterVirtualNodeNameSource.parent().fadeIn('slow');
            infoBoxClusterSource.fadeIn('slow');
            fieldEndpointClusterConfigDnsAddressSource.parent().fadeIn('slow');
		}
		if (global.sourceServerPlace != SERVER_PLACE_INTERNAL) {
            // manipulating basic fields
            // manipulating specific fields
			fieldServerSourceToggle.parent().parent().fadeOut('slow');
            fieldClusterIdSource.val('');
            fieldClusterVirtualNodeNameSource.val('');
            fieldClusterVirtualNodeNameSource.parent().fadeOut('slow');
            infoBoxClusterSource.fadeOut('slow');
            fieldEndpointClusterConfigIdSource.val('');
            fieldEndpointClusterConfigDnsAddressSource.val('');
            fieldEndpointClusterConfigDnsAddressSource.parent().fadeOut('slow');
		}
		global.sourceServerQuantity = SERVER_QUANTITY_MANY;
	}
}
// Linux/Unix EndpointSource #stop#
