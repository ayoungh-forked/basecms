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
    
    /*
     * Hotkeys!
     * 
     */
    window.keypress = function(e) {
        switch (e.charCode) {
            case 110:
                if (e.ctrlKey || e.metaKey) {
                    e.preventDefault();
                    // Check to see if there is a menu open with an 'add' button first.
                    var $btn = $(window.top.frames[0].document.getElementsByClassName('btn add').item(0)) || $('.btn.add');
                    if ($btn.length) {
                        if ($btn.get(0).tagName == 'A')
                            window.top.open($btn.attr('href'), $btn.attr('target'));
                        else
                            $btn.click();
                    }
                }
        }
    }
    
    $('body').on('keypress', keypress);
    
});