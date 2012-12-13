"use strict";

$(document).ready(function () {
    
    $('nav ul li a').on('click', function (e, ispop) {
        var $this = $(e.target).closest('a'),
            rel = $this.attr('rel'),
            $panels = $('#panel_container');
        if (rel && rel.length) {
            e.preventDefault();
            $panels.hide();
            $('iframe#menu').attr('src', '/admin/menu?view='+rel);
            $('iframe#edit_pane').attr('src', '/admin/edit');
            $this.parent().addClass('active').siblings().removeClass('active');
            $panels.ready(function() {
               $panels.show();
            });
            if (!ispop) {
                var state = {
                    active: rel,
                    url: '/admin/'+rel+'/'
                };
                console.log(rel, state);
                window.history.pushState(state, document.title, state.url);
            }
        }
    });
    
    window.onpopstate = function(e) {
        var state = e.state;
        console.log(state);
        $('nav ul li a[rel="'+state.active+'"] ').trigger('click', [true]);
    }
    
});