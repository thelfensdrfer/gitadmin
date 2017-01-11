var App = {
    error: function(message) {
        console.error(message);
        console.trace();
        alertify.error(message);
    },
    success: function(message) {
        alertify.success(message);
    }
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$.extend(
{
    redirect: function(location, method, args) {
        var form = $('<form></form>');
        form.attr('method', method);
        form.attr('action', location);

        if (!args)
            args = {};

        args['_token'] = $('meta[name="csrf-token"]').attr('content');

        $.each(args, function(key, value) {
            var field = $('<input></input>');

            field.attr('type', 'hidden');
            field.attr('name', key);
            field.attr('value', value);

            form.append(field);
        });
        $(form).appendTo('body').submit();
    },
    redirectPost(location, args) {
        this.redirect(location, 'post', args);
    },
    redirectPut(location, args) {
        if (!args)
            args = {};
        this.redirect(location, 'post', $.extend({}, args, {'_method': 'put'}));
    },
    redirectDelete(location, args) {
        if (!args)
            args = {};
        this.redirect(location, 'post', $.extend({}, args, {'_method': 'delete'}));
    }
});

$(function() {
    $('.key-delete').on('click', function(e) {
        e.preventDefault();

        var url = $(this).attr('data-url');
        var $modal = $('#confirm-key-delete');

        // Cancel key deletion
        $modal
            .find('#confirm-key-delete-cancel')
            .off()
            .on('click', function() {
                $modal.modal('hide');
            });

        // Redirect user to delete url
        $modal
            .find('#confirm-key-delete-approve')
            .off()
            .on('click', function() {
                $.redirectDelete(url);
            });

        // Show confirmation dialog
        $modal.modal('show');

        return false;
    });

    // Dashboard
    var $keyStoreModal = $('#key-add').modal({
        onApprove: function() {
            $(this).find('form').submit();
            return false;
        }
    });

    $('.key-add').on('click', function(e) {
        e.preventDefault();

        // Show key creation dialog
        $keyStoreModal.modal('show');

        return false;
    });

    // User
    var $userAddModal = $('#user-add').modal({
        onApprove: function() {
            $(this).find('form').submit();
            return false;
        }
    });

    $('.user-add').on('click', function(e) {
        e.preventDefault();

        // Show key creation dialog
        $userAddModal.modal('show');

        return false;
    });

    $('.modal form').on('submit', function(e) {
        e.preventDefault();

        var $form = $(this);
        var $submitButton = $form.find('button[type="submit"]');

        $form.addClass('loading');

        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: $form.serialize(),
            success: function(data) {
                $form.removeClass('loading');

                console.log(data);

                if (data && data.redirect) {
                    window.location.href = data.redirect;
                } else {
                    $form.closest('.modal').modal('hide');
                    App.success('Erfolgreich gespeichert.');
                }
            },
            error: function(err) {
                $form.removeClass('loading');

                if (err.status === 422) {
                    var errors = JSON.parse(err.responseText);
                    if (!errors) {
                        App.error('Es ist ein Fehler beim speichern aufgetreten!');
                        return false;
                    }

                    var $messageContainer = $form.find('.message');

                    // Remove previous error classes and messages
                    $form.find('.error').removeClass('error');
                    $messageContainer.find('li').remove();

                    for (var field in errors) {
                        if (!errors.hasOwnProperty(field))
                            continue;

                        var $container = $form
                            .find('[name="' + field + '"]')
                            .parent();

                        for (var i = 0; i < errors[field].length; i++) {
                            var message = errors[field][i];
                            $container.addClass('error');
                            $messageContainer.append('<li>' + message + '</li>');
                        }
                    }
                } else {
                    App.error('Es ist ein unbekannter Fehler beim speichern aufgetreten!');
                    return false;
                }
            }
        })

        return false;
    });
});
