/**
 * Dynamic adding of notification field(-set-)s.
 */
// Constants are supported in IE from v11. http://caniuse.com/#search=const
const NOTIFICATIONS_MAX_NUMBER = 5;
$(document).ready(function() {
	addNotificationButton = $('#add-notification-button');
	addNotificationButton.on('click', addNotification);
});
function addNotification() {
    var currentCount = $('#fieldgroup-logical_connection fieldset:first > fieldset').length;
    var template = $('#fieldgroup-logical_connection fieldset:first > span').data('template');
    template = template.replace(/__index__/g, currentCount);
    if (currentCount < NOTIFICATIONS_MAX_NUMBER) {
        $('#fieldgroup-logical_connection fieldset:first').append(template);
    }
    return false;
}
/**
 * Dynamic adding of include parameter fields.
 */
//Constants are supported in IE from v11. http://caniuse.com/#search=const
const INCLUDE_PARAMETERS_MAX_NUMBER = 5;
$(document).ready(function() {
	addIncludeParameterButton = $('#add-include-parameter-button');
	addIncludeParameterButton.on('click', addIncludeParameter);
});
function addIncludeParameter() {
    var currentCount = $('#fieldgroup-specific-endpoint-source .include-parameters fieldset:first > fieldset').length;
    var template = $('#fieldgroup-specific-endpoint-source .include-parameters fieldset:first > span').data('template');
    template = template.replace(/__index__/g, currentCount);
    if (currentCount < INCLUDE_PARAMETERS_MAX_NUMBER) {
        $('#fieldgroup-specific-endpoint-source .include-parameters fieldset:first').append(template);
    }
    return false;
}
