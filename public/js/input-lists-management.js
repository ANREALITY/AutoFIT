/**
 * Dynamic adding & removing of notification field(-set-)s.
 */
// Constants are supported in IE from v11. http://caniuse.com/#search=const
const NOTIFICATIONS_MIN_NUMBER = 0;
const NOTIFICATIONS_MAX_NUMBER = 5;
$(document).ready(function() {
	addNotificationButton = $('#add-notification-button');
	addNotificationButton.on('click', addNotification);
	removeNotificationButton = $('.remove-notification-button');
	removeNotificationButton.on('click', removeNotification);
});
function addNotification() {
    var currentCount = $('#fieldgroup-logical_connection fieldset:first > fieldset').length;
    console.log('add start | current:' + currentCount);
    var template = $('#fieldgroup-logical_connection fieldset:first > span').data('template');
    template = template.replace(/__index__/g, currentCount);
    if (currentCount < NOTIFICATIONS_MAX_NUMBER) {
        $('#fieldgroup-logical_connection fieldset:first').append(template);
    	removeNotificationButton = $('.remove-notification-button');
    	removeNotificationButton.on('click', removeNotification);
    }
    currentCount = $('#fieldgroup-logical_connection fieldset:first > fieldset').length;
    console.log('add stop | current:' + currentCount);
    return false;
}
function removeNotification() {
    var currentCount = $('#fieldgroup-logical_connection fieldset:first > fieldset').length;
    console.log('remove start | current:' + currentCount);
    if (currentCount > NOTIFICATIONS_MIN_NUMBER) {
    	$(this).parent().remove();
    }
    currentCount = $('#fieldgroup-logical_connection fieldset:first > fieldset').length;
    console.log('remove stop | current:' + currentCount);
    return false;
}
/**
 * Dynamic adding & removing of include parameter fields.
 */
//Constants are supported in IE from v11. http://caniuse.com/#search=const
const INCLUDE_PARAMETERS_MIN_NUMBER = 1;
const INCLUDE_PARAMETERS_MAX_NUMBER = 5;
$(document).ready(function() {
	addIncludeParameterButton = $('#add-include-parameter-button');
	addIncludeParameterButton.on('click', addIncludeParameter);
	removeIncludeParameterButton = $('.remove-include-parameter-button');
	removeIncludeParameterButton.on('click', removeIncludeParameter);
});
function addIncludeParameter() {
    var currentCount = $('#fieldgroup-specific-endpoint-source .include-parameters fieldset:first > fieldset').length;
    console.log('add start | current:' + currentCount);
    var template = $('#fieldgroup-specific-endpoint-source .include-parameters fieldset:first > span').data('template');
    template = template.replace(/__index__/g, currentCount);
    if (currentCount < INCLUDE_PARAMETERS_MAX_NUMBER) {
        $('#fieldgroup-specific-endpoint-source .include-parameters fieldset:first').append(template);
    	removeIncludeParameterButton = $('.remove-include-parameter-button');
    	removeIncludeParameterButton.on('click', removeIncludeParameter);
    }
    currentCount = $('#fieldgroup-specific-endpoint-source .include-parameters fieldset:first > fieldset').length;
    console.log('add stop | current:' + currentCount);
    return false;
}
function removeIncludeParameter() {
    var currentCount = $('#fieldgroup-specific-endpoint-source .include-parameters fieldset:first > fieldset').length;
    console.log('remove start | current:' + currentCount);
    if (currentCount > INCLUDE_PARAMETERS_MIN_NUMBER) {
    	$(this).parent().remove();
    }
    currentCount = $('#fieldgroup-specific-endpoint-source .include-parameters fieldset:first > fieldset').length;
    console.log('remove stop | current:' + currentCount);
    return false;
}
/**
 * Dynamic adding & removing of access config source fields.
 */
//Constants are supported in IE from v11. http://caniuse.com/#search=const
const ACCESS_CONFIGS_SOURCE_MIN_NUMBER = 1;
const ACCESS_CONFIGS_SOURCE_MAX_NUMBER = 10;
$(document).ready(function() {
	addAccessConfigSourceButton = $('#fieldgroup-specific-endpoint-source .add-access-config-button');
	addAccessConfigSourceButton.on('click', addAccessConfigSource);
	removeAccessConfigButton = $('.remove-access-config-button');
	removeAccessConfigButton.on('click', removeAccessConfig);
});
function addAccessConfigSource() {
    var currentCount = $('#fieldgroup-specific-endpoint-source .access-configs fieldset:first > fieldset').length;
    console.log('add start | current:' + currentCount);
    var template = $('#fieldgroup-specific-endpoint-source .access-configs fieldset:first > span').data('template');
    template = template.replace(/__index__/g, currentCount);
    if (currentCount < ACCESS_CONFIGS_SOURCE_MAX_NUMBER) {
        $('#fieldgroup-specific-endpoint-source .access-configs fieldset:first').append(template);
    	removeAccessConfigButton = $('.remove-access-config-button');
    	removeAccessConfigButton.on('click', removeAccessConfig);
    }
    currentCount = $('#fieldgroup-specific-endpoint-source .access-configs fieldset:first > fieldset').length;
    console.log('add stop | current:' + currentCount);
    return false;
}
function removeAccessConfig() {
    var currentCount = $('#fieldgroup-specific-endpoint-source .access-configs fieldset:first > fieldset').length;
    console.log('remove start | current:' + currentCount);
    if (currentCount > ACCESS_CONFIGS_SOURCE_MIN_NUMBER) {
    	$(this).parent().remove();
    }
    currentCount = $('#fieldgroup-specific-endpoint-source .access-configs fieldset:first > fieldset').length;
    console.log('remove stop | current:' + currentCount);
    return false;
}
/**
 * Dynamic adding & removing of access config target fields.
 */
//Constants are supported in IE from v11. http://caniuse.com/#search=const
const ACCESS_CONFIGS_TARGET_MIN_NUMBER = 1;
const ACCESS_CONFIGS_TARGET_MAX_NUMBER = 10;
$(document).ready(function() {
	addAccessConfigTargetButton = $('#fieldgroup-specific-endpoint-target .add-access-config-button');
	addAccessConfigTargetButton.on('click', addAccessConfigTarget);
	removeAccessConfigButton = $('.remove-access-config-button');
	removeAccessConfigButton.on('click', removeAccessConfig);
});
function addAccessConfigTarget() {
    var currentCount = $('#fieldgroup-specific-endpoint-target .access-configs fieldset:first > fieldset').length;
    console.log('add start | current:' + currentCount);
    var template = $('#fieldgroup-specific-endpoint-target .access-configs fieldset:first > span').data('template');
    template = template.replace(/__index__/g, currentCount);
    if (currentCount < ACCESS_CONFIGS_TARGET_MAX_NUMBER) {
        $('#fieldgroup-specific-endpoint-target .access-configs fieldset:first').append(template);
    	removeAccessConfigButton = $('.remove-access-config-button');
    	removeAccessConfigButton.on('click', removeAccessConfig);
    }
    currentCount = $('#fieldgroup-specific-endpoint-target .access-configs fieldset:first > fieldset').length;
    console.log('add stop | current:' + currentCount);
    return false;
}
function removeAccessConfig() {
    var currentCount = $('#fieldgroup-specific-endpoint-target .access-configs fieldset:first > fieldset').length;
    console.log('remove start | current:' + currentCount);
    if (currentCount > ACCESS_CONFIGS_TARGET_MIN_NUMBER) {
    	$(this).parent().remove();
    }
    currentCount = $('#fieldgroup-specific-endpoint-target .access-configs fieldset:first > fieldset').length;
    console.log('remove stop | current:' + currentCount);
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
    initAutocompleteServerSource();
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
    initAutocompleteServerTarget();
    return false;
}
/**
 * Dynamic adding of endpoint source external server field(-set-)s.
 */
// Constants are supported in IE from v11. http://caniuse.com/#search=const
const ENDPOINT_SOURCE_EXTERNAL_SERVERS_MAX_NUMBER = 5;
$(document).ready(function() {
	addEndpointSourceExternalServerButton = $('#add-endpoint-source-external-server-button');
	addEndpointSourceExternalServerButton.on('click', addEndpointSourceExternalServer);
});
function addEndpointSourceExternalServer() {
    var currentCount = $('#fieldgroup-specific-endpoint-source .fieldset-multiple-external-servers fieldset:first > fieldset').length;
    var template = $('#fieldgroup-specific-endpoint-source .fieldset-multiple-external-servers fieldset:first > span').data('template');
    template = template.replace(/__index__/g, currentCount);
    if (currentCount < ENDPOINT_SOURCE_EXTERNAL_SERVERS_MAX_NUMBER) {
        $('#fieldgroup-specific-endpoint-source .fieldset-multiple-external-servers fieldset:first').append(template);
    }
    return false;
}
/**
 * Dynamic adding of endpoint target external server field(-set-)s.
 */
// Constants are supported in IE from v11. http://caniuse.com/#search=const
const ENDPOINT_TARGET_EXTERNAL_SERVERS_MAX_NUMBER = 5;
$(document).ready(function() {
	addEndpointTargetExternalServerButton = $('#add-endpoint-target-external-server-button');
	addEndpointTargetExternalServerButton.on('click', addEndpointTargetExternalServer);
});
function addEndpointTargetExternalServer() {
    var currentCount = $('#fieldgroup-specific-endpoint-target .fieldset-multiple-external-servers fieldset:first > fieldset').length;
    var template = $('#fieldgroup-specific-endpoint-target .fieldset-multiple-external-servers fieldset:first > span').data('template');
    template = template.replace(/__index__/g, currentCount);
    if (currentCount < ENDPOINT_TARGET_EXTERNAL_SERVERS_MAX_NUMBER) {
        $('#fieldgroup-specific-endpoint-target .fieldset-multiple-external-servers fieldset:first').append(template);
    }
    return false;
}
/**
 * Dynamic adding of cluster server field(-set-)s.
 */
// Constants are supported in IE from v11. http://caniuse.com/#search=const
const CLUSTER_SERVERS_MAX_NUMBER = 5;
$(document).ready(function() {
	addClusterServerButton = $('#add-cluster-server-button');
	addClusterServerButton.on('click', addClusterServer);
});
function addClusterServer() {
    var currentCount = $('#fieldgroup-cluster .fieldset-multiple-servers fieldset:first > fieldset').length;
    var template = $('#fieldgroup-cluster .fieldset-multiple-servers fieldset:first > span').data('template');
    template = template.replace(/__index__/g, currentCount);
    if (currentCount < CLUSTER_SERVERS_MAX_NUMBER) {
        $('#fieldgroup-cluster .fieldset-multiple-servers fieldset:first').append(template);
    }
    // This solves the issue with autocomplete for dynamically added fields (s. #120).
    initAutocompleteClusterServer();
    return false;
}
/**
 * Dynamic adding & removing of file parameter fields.
 */
//Constants are supported in IE from v11. http://caniuse.com/#search=const
const FILE_PARAMETERS_MIN_NUMBER = 1;
const FILE_PARAMETERS_MAX_NUMBER = 10;
$(document).ready(function() {
	addFileParameterButton = $('#add-file-parameter-button');
	addFileParameterButton.on('click', addFileParameter);
	removeFileParameterButton = $('.remove-file-parameter-button');
	removeFileParameterButton.on('click', removeFileParameter);
});
function addFileParameter() {
    var currentCount = $('#fieldgroup-specific-endpoint-target .file-parameters fieldset:first > fieldset').length;
    console.log('add start | current:' + currentCount);
    var template = $('#fieldgroup-specific-endpoint-target .file-parameters fieldset:first > span').data('template');
    template = template.replace(/__index__/g, currentCount);
    if (currentCount < FILE_PARAMETERS_MAX_NUMBER) {
        $('#fieldgroup-specific-endpoint-target .file-parameters fieldset:first').append(template);
    	removeFileParameterButton = $('.remove-file-parameter-button');
    	removeFileParameterButton.on('click', removeFileParameter);
    }
    currentCount = $('#fieldgroup-specific-endpoint-target .file-parameters fieldset:first > fieldset').length;
    console.log('add stop | current:' + currentCount);
    // initBlockingFieldsTarget();
    return false;
}
function removeFileParameter() {
    var currentCount = $('#fieldgroup-specific-endpoint-target .file-parameters fieldset:first > fieldset').length;
    console.log('remove start | current:' + currentCount);
    if (currentCount > FILE_PARAMETERS_MIN_NUMBER) {
    	$(this).parent().remove();
    }
    currentCount = $('#fieldgroup-specific-endpoint-target .file-parameters fieldset:first > fieldset').length;
    console.log('remove stop | current:' + currentCount);
    return false;
}
