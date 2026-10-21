/**
 * Contact form: native submit to FormSubmit, or AJAX to mailer.php
 */
(function($) {
    'use strict';

    function bindForm(formSelector, messageSelector) {
        var form = $(formSelector);
        var formMessages = $(messageSelector);
        if (!form.length) {
            return;
        }

        form.submit(function(e) {
            var action = (form.attr('action') || '').toLowerCase();
            if (action.indexOf('formsubmit.co') !== -1) {
                return true;
            }

            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: form.serialize()
            })
            .done(function(response) {
                formMessages.removeClass('error').addClass('success');
                formMessages.text(response);
                form.find('input[type="text"], input[type="email"], textarea').val('');
            })
            .fail(function(data) {
                formMessages.removeClass('success').addClass('error');
                formMessages.text(data.responseText || 'Your message could not be sent. Please email adv.sanyamrastogi@gmail.com or call +91-8881113636.');
            });
        });
    }

    bindForm('#contact-form', '#form-messages');
    bindForm('#contact-form2', '#form-messages2');
})(jQuery);
