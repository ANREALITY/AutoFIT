/**
 * Dynamic adding of notification field(-set-)s for.
 */
$(document).ready(function() {
	addNotificationButton = $('#add-notification-button');
	addNotificationButton.on('click', addNotification);
});

function addNotification() {
    var currentCount = $('#fieldgroup-logical_connection fieldset:first > fieldset').length;
    var template = $('#fieldgroup-logical_connection fieldset:first > span').data('template');
    template = template.replace(/__index__/g, currentCount);
    if (currentCount < 5) {
        $('#fieldgroup-logical_connection fieldset:first').append(template);
    }
    return false;
}
