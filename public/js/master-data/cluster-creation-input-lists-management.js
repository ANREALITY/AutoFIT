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
