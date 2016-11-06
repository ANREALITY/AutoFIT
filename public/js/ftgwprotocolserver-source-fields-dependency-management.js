// Protocol Server EndpointSource #start#
$(document).ready(function() {
	fieldAddressSourceToggle = $('#fieldgroup-specific-endpoint-source .toggle-address');
	fieldDnsAddressSource = $('#fieldgroup-specific-endpoint-source .field-dns-address');
	fieldIpSource = $('#fieldgroup-specific-endpoint-source .field-ip');
});
$(document).ready(function() {
	fieldAddressSourceToggle.change(function() {
		toggleFieldAddressSource(this.value);
	});
	fieldAddressSourceToggle.filter(':checked').trigger('change');
});
function toggleFieldAddressSource(value) {
	if (value == '') {
		value = global.sourceAddressType;
	}
	if (value == ADDRESS_TYPE_DNS) {
		fieldIpSource.val('');
		fieldIpSource.parent().fadeOut('slow');
		fieldDnsAddressSource.parent().fadeIn('slow');

		global.sourceAddressType = ADDRESS_TYPE_DNS;
	} else if (value == ADDRESS_TYPE_IP) {
		fieldDnsAddressSource.val('');
		fieldDnsAddressSource.parent().fadeOut('slow');
		fieldIpSource.parent().fadeIn('slow');

		global.sourceAddressType = ADDRESS_TYPE_IP;
	}
}
// Protocol Server EndpointSource #stop#
