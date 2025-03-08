$(document).ready(function() {

    $('.search-block-row').each(function(i) {
        var selectedValue = $(this).find('.select-filter').prop('selectedIndex');
        if (selectedValue !== 0) {
            $(this).removeClass('default');
            $('.add-filter').attr('state', 'true');
        }
    });

    /*var popover = new Popover(document.querySelector('.info'), {
        container: 'body'
    })*/


});

// Отмена или удаление фильтра
$('body').on( "click", '.btn-close', function() {
    var parent_wrapper = $(this).closest('.search-block-row').addClass('default');
    var this_select = parent_wrapper.find('.select-filter');
    var select_id = this_select.attr('id');
    var selectedValue = this_select.prop('selectedIndex');
    if ($('.search-form .select-filter').length == 1) {
        $('.add-filter').attr('state', 'false');
    }

    if (select_id == 0) {
        this_select.prop('selectedIndex',0);
    } else {
        parent_wrapper.remove();
    }

});

// Выбор фильтра

$('body').on( "click", '.select-filter', function() {
    if ($('.search-form .select-filter').length == 1) {
        $('.add-filter').attr('state', 'true');
    }
    $(this).closest('.search-block-row').removeClass('default');

});

// Добавление нового фильтра

$('body').on( "click", '.add-filter', function() {

    var new_filter = $('.search-form .search-block-row:last').clone().addClass('default');
    new_filter.find('.search-field input').val('');
    var filter_id = +new_filter.find('.select-filter').attr('id');
    new_filter.find('.select-filter').attr('id',filter_id + 1);

    $( ".search-form .search-block-row:last" ).after(new_filter);

});
