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
/**
 * Dynamic adding of endpoint source server field(-set-)s.
 */
// Constants are supported in IE from v11. http://caniuse.com/#search=const
const ENDPOINT_SOURCE_SERVERS_MAX_NUMBER = 5;
$(document).ready(function() {
	addEndpointSourceServerButton = $('#add-endpoint-source-server-button');
	addEndpointSourceServerButton.on('click', addEndpointSourceServer);
});
function addEndpointSourceServer() {
    var currentCount = $('#fieldgroup-specific-endpoint-source .fieldset-multiple-servers fieldset:first > fieldset').length;
    var template = $('#fieldgroup-specific-endpoint-source .fieldset-multiple-servers fieldset:first > span').data('template');
    template = template.replace(/__index__/g, currentCount);
    if (currentCount < ENDPOINT_SOURCE_SERVERS_MAX_NUMBER) {
        $('#fieldgroup-specific-endpoint-source .fieldset-multiple-servers fieldset:first').append(template);
    }
    // This solves the issue with autocomplete for dynamically added fields (s. #120).
    initAutocompleteServer();
    return false;
}
/**
 * Dynamic adding of endpoint target server field(-set-)s.
 */
// Constants are supported in IE from v11. http://caniuse.com/#search=const
const ENDPOINT_TARGET_SERVERS_MAX_NUMBER = 5;
$(document).ready(function() {
	addEndpointTargetServerButton = $('#add-endpoint-target-server-button');
	addEndpointTargetServerButton.on('click', addEndpointTargetServer);
});
function addEndpointTargetServer() {
    var currentCount = $('#fieldgroup-specific-endpoint-target .fieldset-multiple-servers fieldset:first > fieldset').length;
    var template = $('#fieldgroup-specific-endpoint-target .fieldset-multiple-servers fieldset:first > span').data('template');
    template = template.replace(/__index__/g, currentCount);
    if (currentCount < ENDPOINT_TARGET_SERVERS_MAX_NUMBER) {
        $('#fieldgroup-specific-endpoint-target .fieldset-multiple-servers fieldset:first').append(template);
    }
    // This solves the issue with autocomplete for dynamically added fields (s. #120).
    initAutocompleteServer();
    return false;
}