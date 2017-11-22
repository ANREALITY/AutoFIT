/**
 * Clearing and enabling/disabling of fields dependending on other fields.
 */
// fields #start#
$(document).ready(function() {
	fieldEnvironmentSeverity = $("#order-environment-severity");
	fieldEnvironmentName = $("#order-environment-name");
});
// fields #stop#

// search #start#
$(document).ready(function() {
	fieldEnvironmentName.on('autocompletechange', function() {
        console.log('autocompletechange');
        fieldEnvironmentSeverity.trigger('change');
	});
    fieldEnvironmentName.focus(function() {
        console.log('focus');
        updateEnvironmentSeverityField(this.value);
    });
});
function updateEnvironmentSeverityField(value) {
	fieldEnvironmentSeverity.val('');
	fieldEnvironmentName.val('');
}
// search #stop#
