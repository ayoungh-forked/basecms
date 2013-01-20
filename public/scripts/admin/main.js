"use strict";

$(document).ready(function () {
    
    $('iframe').each(function() {
        var $this = $(this),
            name = $this.attr('name'),
            cval = h.read_cookie('base_'+name);
        console.log(name, cval);
        if (cval)
            $this.attr('src', cval);
        
    });
    
    $('nav ul li a').on('click', function (e, ispop, rel) {
        var $this = $(e.target).closest('a'),
            $panels = $('#panel_container');
        if (!rel) rel = $this.attr('rel');
        if (rel && rel.length) {
            if (!ispop) {
                e.preventDefault();
                $panels.hide();
                h.open('/admin/menu?view='+rel, 'menu');
                h.open('/admin/edit', 'edit_pane');
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