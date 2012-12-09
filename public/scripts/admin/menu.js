"use strict";

$(document).ready(function() {

    var $nestedSortable = $('.nested_sortable');
    
    if ($nestedSortable.length) {
        $nestedSortable.nestedSortable({
            handle: 'div',
            items: 'li',
            toleranceElement: '> div',
            
			opacity: .6,
            
			revert: 150,

			isTree: true,
        });
            
        $('.nested_sortable ol').hide();
    }
    
    $('.collapse_all, .collapse_control').hide();
    $('.expand_all, .expand_control').show();
            
    $('.expand_control, .collapse_control').on('click', function() {
        $(this).hide().siblings('.collapse_control,.expand_control').show()
               .parents('.handle').siblings('ol').toggle();
    });
    
    $('.nested_sortable li').on('DOMNodeInserted', function () {
        $(this).find('.collapse_control').show().siblings('.expand_control').hide()
               .parents('.handle').siblings('ol').show();   
    });
    
    $nestedSortable.on('mouseup', function() {
        setTimeout(function() {
            var order_array = $nestedSortable.nestedSortable('serialize');
            $.post(window.location, order_array);
        }, 400);
    });
    
    $('#controls').on('click', '.expand_all', function() {
        $(this).hide().siblings('.collapse_all').show();
        $('.collapsable_list ol').show();
        $('.collapsable_list .expand_control').hide();
        $('.collapsable_list .collapse_control').show();
    }).on('click', '.collapse_all', function() {   
        $(this).hide().siblings('.expand_all').show();
        $('.collapsable_list ol').hide();
        $('.collapsable_list .expand_control').show();
        $('.collapsable_list .collapse_control').hide();
    });

});