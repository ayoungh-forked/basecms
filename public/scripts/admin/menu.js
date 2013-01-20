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
    		startCollapsed: true
        });
            
        $('.nested_sortable ol').addClass('collapsed');
    }
    
    $('a').on('click', function(e) {
        var $this = $(this);
        if ($this.attr('target') && $this.attr('href')) {
            e.preventDefault();
            h.open($this.attr('href'), $this.attr('target'));    
        }
    });
    
    $('.collapse_control').hide();
    $('.expand_control').show();
            
    $('.expand_control, .collapse_control').on('click', function(e) {
        $(e.target).closest('li').children('ol').toggleClass('collapsed');
    });
    
    $('#controls').on('click', '.expand_all', function() {
        $('.collapsable_list ol').removeClass('collapsed');
    }).on('click', '.collapse_all', function() {   
        $('.collapsable_list ol').addClass('collapsed');
    });
    
});