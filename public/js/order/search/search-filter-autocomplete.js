/**
 * Autocompletion for the field username.
 */
const AUTOCOMPLETE_USERS_LIMIT = 25;
$(function() {
    $(".autocomplete-username")
        .autocomplete({
            autoFocus : true,
            delay : 500,
            minLength : 0,
            source : function(request, response) {
                $.get(
                    "/order/ajax/provide-users?"
                    + "data[username]=" + request.term,
                    {},
                    function(data) {
                        response(data.slice(0, AUTOCOMPLETE_USERS_LIMIT));
                    }
                );
            }
        }).on('focus', function(event) {
        console.log(new Date());
        console.log($(this));
        $(this).autocomplete("search", this.value);
    });
});
/**
 * Autocompletion for the field username.
 */
const AUTOCOMPLETE_FILE_TRANSFER_REQUESTS_LIMIT = 25;
$(function() {
    $(".autocomplete-change-number")
        .autocomplete({
            autoFocus : true,
            delay : 500,
            minLength : 0,
            source : function(request, response) {
                $.get(
                    "/order/ajax/provide-file-transfer-requests?"
                    + "data[change_number]=" + request.term,
                    {},
                    function(data) {
                        response(data.slice(0, AUTOCOMPLETE_FILE_TRANSFER_REQUESTS_LIMIT));
                    }
                );
            }
        }).on('focus', function(event) {
        console.log(new Date());
        console.log($(this));
        $(this).autocomplete("search", this.value);
    });
});
/**
 * Autocompletion for the field order-application-number.
 */
// @todo After removing the autocomplete.js of the order creation/editing from the global space change the constant's name to AUTOCOMPLETE_APPLICATIONS_LIMIT!
const AUTOCOMPLETE_ORDER_SEARCH_APPLICATIONS_LIMIT = 25;
$(function() {
    $(".order-search-autocomplete-application")
        .autocomplete({
            autoFocus : true,
            delay : 500,
            minLength : 3,
            source : function(request, response) {
                $.get(
                    "/order/ajax/provide-applications?"
                    + "data[technical_short_name]=" + request.term,
                    {},
                    function(data) {
                        response(data.slice(0, AUTOCOMPLETE_ORDER_SEARCH_APPLICATIONS_LIMIT));
                    }
                );
            }
        }).on('focus', function(event) {
        console.log(new Date());
        console.log($(this));
        $(this).autocomplete("search", this.value);
    });
});
/**
 * Autocompletion for the field order-environment-name.
 */
const AUTOCOMPLETE_ENVIRONMENTS_LIMIT = 25;
$(function() {
    $("#order-environment-name")
        .autocomplete({
            autoFocus : true,
            delay : 500,
            minLength : 0,
            source : function(request, response) {
                $.get(
                    "/order/ajax/provide-environments-for-order-search?"
                    + "&data[name]=" + request.term,
                    {},
                    function(data) {
                        response($.map(data, function(item) {
                            return {
                                label : item.name,
                                value : item.severity
                            }
                        }));
                    }
                );
            },
            select: function (event, ui) {
                $('#order-environment-name').val(ui.item.label);
                $('#order-environment-severity').val(ui.item.value);
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
});
/**
 * Autocompletion for the field server-name.
 */
const AUTOCOMPLETE_SERVERS_LIMIT = 25;
// Implemented this way for solving the issue with autocomplete for dynamically added fields (s. #120).
var initAutocompleteServerSource = function() {
    var serverName = $('.autocomplete-server');
    serverName
        .autocomplete({
            autoFocus : true,
            delay : 500,
            minLength : 0,
            source : function(request, response) {
                $.get(
                    "/order/ajax/provide-servers-for-order-search?"
                    + "data[name]=" + request.term,
                    {},
                    function(data) {
                        response(data.slice(0, AUTOCOMPLETE_SERVERS_LIMIT));
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
    initAutocompleteServerSource();
});
