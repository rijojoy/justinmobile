$(document).ready(function() {
    $('.form-confirm').click(function(e) {
        if(!confirm($(this).data('confirm'))) {
            event.preventDefault();
        }
    });

    $('#template_switch').change(function() {
        var template = $('#template_switch').val();
        var url = $('#current_url').val();
        window.location.replace(url + '?template=' + template);
    });

    $('.status-available-list .btn').click(function(){
        $('#class').val($(this).data('class'));    
    });
});