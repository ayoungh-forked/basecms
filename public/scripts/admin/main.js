"use strict";

$(document).ready(function () {
    
    $('nav ul li a').on('click', function (e) {
        e.preventDefault();
        var $this = $(this),
            rel = $this.attr('rel'),
            $panels = $('#panel_container');
        $panels.hide();
        $('iframe#menu').attr('src', '/admin/menu?view='+rel);
        //$('iframe#edit_pane').attr('src', '/admin/edit?type='+rel);
        $this.parent().addClass('active').siblings().removeClass('active');
        $panels.ready(function() {
           $panels.show();
        });
    });
    
});