"use strict";

$(document).ready(function () {
    
    $('nav ul li a').on('click', function (e, ispop, rel) {
        var $this = $(e.target).closest('a'),
            $panels = $('#panel_container');
        if (!rel) rel = $this.attr('rel');
        if (rel && rel.length) {
            if (!ispop) {
                e.preventDefault();
                $panels.hide();
                $('iframe#menu').attr('src', '/admin/menu?view='+rel);
                $('iframe#edit_pane').attr('src', '/admin/edit');
                $panels.ready(function() {
                   $panels.show();
                });
                var state = {
                    active: rel,
                    url: '/admin/'+rel+'/'
                };
                window.history.pushState(state, document.title, state.url);
            }
            $this.parent().addClass('active').siblings().removeClass('active');
        }
    });
    
    window.onpopstate = function(e) {
        var state = e.state;
        if(state)
            $('nav ul li a[rel="'+state.active+'"] ').trigger('click', [true, state.active]);
    }
    
});