$(document).ready(function() {
    $('#serialize').on('click', function() {
        console.log('[' + Date.now() + ']' + ' ' + 'serialize');
        test = $('#create_file_transfer_request').serializeObject();
//        console.log(unescape('[' + Date.now() + ']' + ' ' + test));
        formJson = JSON.stringify(test);
        console.log('[' + Date.now() + ']' + ' ' + formJson);
        $('#formData').val(formJson);
    });
});
