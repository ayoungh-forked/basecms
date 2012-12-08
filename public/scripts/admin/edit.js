"use strict";

$(document).ready(function () {
        $('textarea.html').each(function() {
            var id = $(this).attr('id');
            // If the textarea doesn't have an ID attribute, we can't apply the
            // text editor to it.
            if (id) {
                new wysihtml5.Editor(id, {
                    toolbar:      "wysihtml5-toolbar-"+id,
                    parserRules:  wysihtml5ParserRules,
                    stylesheets: ['/styles/user-styles.css']
                });    
            }
        });
});