/*global document, window, alert, console, require*/

(function ($) {
    "use strict";

    var EventEmitter = (function () {
        return {
            emit: function (name, params) {
                params = params || {};

                var post = {
                    name: name,
                    params: params
                };
                console.log('Firing off event "' + name + '"', post);
                $.post('/events/emit', post, function (data) {
                    console.log(data);

                    // show flash message
                    var $container = $('#jsContainerFlashMessages');
                    $container.empty()
                        .hide();
                    var $message = $('<div class="alert alert-info" role="alert"></div>');
                    $message.html(data.message);
                    $container.html($message)
                        .fadeIn();
                });
            }
        };
    }());

    $('#jsButtonTheBigRedButton').on('click', function () {
        var $button = $(this);

        EventEmitter.emit('click', {
            element: 'button',
            target: $button.attr('id'),
            url: window.location.href,
            user_id: 2143
        });
    });
}(window.jQuery));
