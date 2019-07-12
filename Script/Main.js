$(document).ready(function (e) {
    $('#isn').focus();
    $('#iptSearch').focus();

    $('input[type=text]').click(function (e) {
        $(this).val("");
        $(this).focus();
        //$(this).select();
    });

});