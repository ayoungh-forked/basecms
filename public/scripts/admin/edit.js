"use strict";

$(document).ready(function () {
    
        $('textarea.html').each(function() {
            var $this = $(this),
                id = $this.attr('id');
            // If the textarea doesn't have an ID attribute, we can't apply the
            // text editor to it.
            if (id && !$this.data('setup')) {
                new wysihtml5.Editor(id, {
                    toolbar:      "wysihtml5-toolbar-"+id,
                    parserRules:  wysihtml5ParserRules,
                    stylesheets: ['/styles/user-styles.css']
                });    
                $this.data('setup', true);
            }
        });
        
        $('button.delete').off('click').on('click', function (e) {
            e.stopPropagation();
            var view =  $(this).closest('form').find('input[name="view"]').attr('value'),
                message = 'Are you sure you want to delete this '+view.slice(0, view.length - 1)+'? (There is no reversing this action!)';
            if (view == 'pages') {
                message += ' Take note: all pages that are sub-pages of this one will also be deleted.';    
            }
            var ok = window.top.confirm(message);
            if (!ok)
                e.preventDefault();
        });
});