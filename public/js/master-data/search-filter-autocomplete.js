/**
 * Autocompletion for the field search-filter-cluster-virtual-node-name.
 */
const AUTOCOMPLETE_CLUSTERS_LIMIT = 25;
// Implemented this way for solving the issue with autocomplete for dynamically added fields (s. #120).
var initAutocompleteClusterVirtualNodeName = function() {
    var clusterVirtualNodeName = $('#search #fieldgroup-filter .autocomplete-cluster-virtual-node-name');
    clusterVirtualNodeName
        .autocomplete({
            autoFocus : true,
            delay : 500,
            minLength : 0,
            source : function(request, response) {
                $.get(
                    "/order/ajax/provide-clusters?"
                    + "&data[virtual_node_name]=" + request.term,
                    {},
                    function(data) {
                        response($.map(data, function(item) {
                            return {
                                label : item.virtualNodeName,
                                value : item.id
                            }
                        }));
                    }
                );
            },
            select: function (event, ui) {
                $('#search #fieldgroup-filter .autocomplete-cluster-virtual-node-name').val(ui.item.label);
                return false;
            },
            focus: function (event, ui) {
                this.value = ui.item.label;
                return false;
            },
        }).on('focus', function(event) {
        console.log(new Date());
        console.log($(this));
        $(this).autocomplete("search", this.value);
    });
};
$(document).ready(function() {
    initAutocompleteClusterVirtualNodeName();
});