"use strict";

$(document).ready(function () {
    
    var errors = false;

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
            $this.on('DOMAttrModified', function(e) {
                var $t = $('a[data-wysihtml5-action]'),
                    val = $t.text(),
                    rep = $t.data('toggle');
                $t.html(rep).data('toggle', val);
            });
        }
    });
    $('a[data-wysihtml5-dialog-action]').addClass('btn').filter('[data-wysihtml5-dialog-action="save"]').addClass('btn-primary');
    $('.toggle-fullscreen').on('click', function(e) {
        var $el = $(e.target).closest('.form_field');
        h.requestFullscreen($el.get(0));
    });
    $('iframe.wysihtml5-sandbox').attr({
        mozallowfullscreen: true,
        webkitallowfullscreen: true,
        allowfullscreen: true
    });
    
    $('form').on('change', function () {
        errors = false;
        $(this).find('input, textarea, select').each(function() {
            var $this = $(this);
            if ($this.hasClass('confirm')) {
                var val = $this.val(),
                    name = $this.attr('name'),
                    $pair = $('input[name="'+name.slice(0, name.length - '_confirm'.length)+'"]'),
                    pairval = $pair.val();
                if (val != pairval) {
                    errors = true;   
                    $this.addClass('errors');
                    $pair.addClass('errors');
                } else {
                    $this.removeClass('errors');
                    $pair.removeClass('errors');
                }
            }
        });
    });
    
    // Use off here, because Firefox at least sometimes runs document.ready
    // twice.
    $('button.save').off('click').on('click', function(e) {
        if (errors) {
            alert('This entry cannot be saved because there are errors.');
            e.preventDefault();
        }
    });
    
    $('button.delete').off('click').on('click', function (e) {
        var view =  $(this).closest('form').find('input[name="view"]').attr('value'),
            message = 'Are you sure you want to delete this entry? (There is no reversing this action!)';
        if (view == 'pages') {
            message += ' Take note: all pages that are sub-pages of this one will also be deleted.';    
        }
        var ok = window.top.confirm(message);
        if (!ok)
            e.preventDefault();
    });
    
    if ( window.top.keypress)
        $('body').on('keypress', window.top.keypress);
        
});