$('input:checkbox').click(function(){
    if ($(this).is(':checked')) {
        $(this).parent().addClass('open-checkbox');
    } else {
        $(this).parent().removeClass('open-checkbox');
    }
}); 
