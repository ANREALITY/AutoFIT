// Protocol Server EndpointTarget #start#
$(document).ready(function() {
	fieldAddressTargetToggle = $('#fieldgroup-specific-endpoint-target .toggle-address');
	fieldDnsAddressTarget = $('#fieldgroup-specific-endpoint-target .field-dns-address');
	fieldIpTarget = $('#fieldgroup-specific-endpoint-target .field-ip');
});
$(document).ready(function() {
	fieldAddressTargetToggle.change(function() {
		toggleFieldAddressTarget(this.value);
	});
	fieldAddressTargetToggle.filter(':checked').trigger('change');
});
function toggleFieldAddressTarget(value) {
	if (value == '') {
		value = global.targetAddressType;
	}
	if (value == ADDRESS_TYPE_DNS) {
		fieldIpTarget.val('');
		fieldIpTarget.parent().fadeOut('slow');
		fieldDnsAddressTarget.parent().fadeIn('slow');

		global.targetAddressType = ADDRESS_TYPE_DNS;
	} else if (value == ADDRESS_TYPE_IP) {
		fieldDnsAddressTarget.val('');
		fieldDnsAddressTarget.parent().fadeOut('slow');
		fieldIpTarget.parent().fadeIn('slow');

		global.targetAddressType = ADDRESS_TYPE_IP;
	}
}
// Protocol Server EndpointTarget #stop#
