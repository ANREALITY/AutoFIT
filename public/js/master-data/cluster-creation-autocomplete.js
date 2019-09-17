/**
 * Autocompletion for the field cluster-server-name.
 */
const AUTOCOMPLETE_SERVERS_NOT_IN_CLUSTER_LIMIT = 25;
// Implemented this way for solving the issue with autocomplete for dynamically added fields (s. #120).
var initAutocompleteClusterServer = function() {
    var clusterServerName = $('#fieldgroup-cluster .autocomplete-server');
    clusterServerName
        .autocomplete({
            autoFocus : true,
            delay : 500,
            minLength : 0,
            source : function(request, response) {
                $.get(
                    "/order/ajax/provide-servers-not-in-cluster?"
                    + "data[name]=" + request.term,
                    {},
                    function(data) {
                        response(data.slice(0, AUTOCOMPLETE_SERVERS_NOT_IN_CLUSTER_LIMIT));
                    }
                );
            }
        }).on('focus', function(event) {
        console.log(new Date());
        console.log($(this));
        $(this).autocomplete("search", this.value);
    });
};
$(document).ready(function() {
    initAutocompleteClusterServer();
});
