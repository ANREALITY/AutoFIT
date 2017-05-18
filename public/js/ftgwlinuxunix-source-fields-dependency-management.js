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
    // specific
    fieldServerSourceToggle = $('#fieldgroup-specific-endpoint-source .toggle-server');
	fieldClusterIdSource = $('#fieldgroup-specific-endpoint-source .field-cluster-id');
	fieldClusterVirtualNodeNameSource = $('#fieldgroup-specific-endpoint-source .field-cluster-virtual-node-name');
	infoBoxClusterSource = $('#fieldgroup-specific-endpoint-source .cluster-hint');
	fieldEndpointClusterConfigIdSource = $('#fieldgroup-specific-endpoint-source .field-endpoint-cluster-config-id');
	fieldEndpointClusterConfigDnsAddressSource = $('#fieldgroup-specific-endpoint-source .field-endpoint-cluster-config-dns-address');
	fieldTransmissionInterval = $('#fieldgroup-specific-endpoint-source .field-transmission-interval');
	fieldTransmissionType = $('#fieldgroup-specific-endpoint-source .field-transmission-type');
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
        fieldClusterIdSource.val('');
        fieldClusterVirtualNodeNameSource.val('');
        fieldClusterVirtualNodeNameSource.parent().fadeOut('slow');
        infoBoxClusterSource.fadeOut('slow');
        fieldEndpointClusterConfigIdSource.val('');
        fieldEndpointClusterConfigDnsAddressSource.val('');
        fieldEndpointClusterConfigDnsAddressSource.parent().fadeOut('slow');
		if (global.sourceServerPlace != SERVER_PLACE_EXTERNAL) {
            // manipulating basic fields
			fieldServerSourceToggle.parent().parent().fadeIn('slow');

			fieldTheServerSource.parent().fadeIn('slow');
			infoBoxServerHintSource.fadeIn('slow');
			fieldTheServerNodeNameSource.parent().fadeIn('slow');
			fieldTheServerEndpointServerConfigDnsAddressSource.parent().fadeIn('slow');
			fieldTransmissionType.parent().parent().fadeIn('slow');
			fieldTransmissionInterval.parent().fadeIn('slow');
		}
		if (global.sourceServerPlace != SERVER_PLACE_INTERNAL) {
            // manipulating basic fields
			fieldServerSourceToggle.parent().parent().fadeOut('slow');

			fieldTransmissionInterval.val('');
			fieldTransmissionInterval.parent().fadeOut('slow');
			fieldTransmissionType.val(TRANSMISSION_TYPE_TXT).attr('checked', true);
			fieldTransmissionType.parent().parent().fadeOut('slow');
		}
		global.sourceServerQuantity = SERVER_QUANTITY_ONE;
	} else if (value == SERVER_QUANTITY_MANY) {
		fieldTheServerSource.val('');
		fieldTheServerSource.parent().fadeOut('slow');
		infoBoxServerHintSource.fadeOut('slow');
		fieldTheServerNodeNameSource.val('');
		fieldTheServerNodeNameSource.parent().fadeOut('slow');
		fieldTheServerEndpointServerConfigDnsAddressSource.val('');
		fieldTheServerEndpointServerConfigDnsAddressSource.parent().fadeOut('slow');
		if (global.sourceServerPlace != SERVER_PLACE_EXTERNAL) {
            // manipulating basic fields
			fieldServerSourceToggle.parent().parent().fadeIn('slow');

			fieldClusterVirtualNodeNameSource.parent().fadeIn('slow');
			infoBoxClusterSource.fadeIn('slow');
			fieldEndpointClusterConfigDnsAddressSource.parent().fadeIn('slow');
			fieldTransmissionType.parent().parent().fadeIn('slow');
			fieldTransmissionInterval.parent().fadeIn('slow');
		}
		if (global.sourceServerPlace != SERVER_PLACE_INTERNAL) {
            // manipulating basic fields
			fieldServerSourceToggle.parent().parent().fadeOut('slow');

			fieldClusterIdSource.val('');
			fieldClusterVirtualNodeNameSource.val('');
			fieldClusterVirtualNodeNameSource.parent().fadeOut('slow');
			infoBoxClusterSource.fadeOut('slow');
			fieldEndpointClusterConfigIdSource.val('');
			fieldEndpointClusterConfigDnsAddressSource.val('');
			fieldEndpointClusterConfigDnsAddressSource.parent().fadeOut('slow');
			fieldTransmissionInterval.val('');
			fieldTransmissionInterval.parent().fadeOut('slow');
			fieldTransmissionType.val(TRANSMISSION_TYPE_TXT).attr('checked', true);
			fieldTransmissionType.parent().parent().fadeOut('slow');
		}
		global.sourceServerQuantity = SERVER_QUANTITY_MANY;
	}
}
// Linux/Unix EndpointSource #stop#
