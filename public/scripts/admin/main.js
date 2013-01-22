"use strict";

$(document).ready(function () {
    
    var $frames = $('iframe').each(function() {
        var $this = $(this),
            name = $this.attr('name'),
            cval = h.get('base_'+name);
        if (cval)
            $this.attr('src', cval);
    });
    
    $('a[href="/admin/logout/"]').on('click', function() {
        $frames.each(function() {
            var $this = $(this),
                name = $this.attr('name');
            h.clear('base_'+name);
        });
    });
    
    $('nav ul li a').on('click', function (e, ispop, rel) {
        var $this = $(e.target).closest('a'),
            $panels = $('#panel_container');
        if (!rel) rel = $this.attr('rel');
        if (rel && rel.length) {
            e.preventDefault();
            if (!$frames.length) {
                h.store('base_menu', '');
                h.store('base_edit_pane', '');
                window.location = '/admin/'+rel+'/';
                return;
            }
            var $menu = $frames.filter('#menu'),
                $edit = $frames.filter('#edit_pane'),
                visib = $menu.is(':visible');
            $panels.hide();
            h.open('/admin/menu?view='+rel, 'menu');
            h.open('/admin/edit', 'edit_pane');
            $panels.ready(function() {
               $panels.show();
               if (!visib) {
                   $menu.show();
                   $edit.hide();
               }
            });
            
            $this.parent().addClass('active').siblings().removeClass('active');
            history.replaceState({}, rel, '/admin/'+rel+'/');
        }
    });
    
});