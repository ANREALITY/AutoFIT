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
