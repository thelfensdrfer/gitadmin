/// <reference path="../types/semantic-ui.d.ts" />
/// <reference path="../types/semantic-ui-calendar.d.ts" />


class App {
    error(message: string) {
        console.error(message);
        console.trace();
        alertify.error(message);
    };

    success(message: string) {
        alertify.success(message);
    };

    redirect(location: string, method: string, args?: any) {
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
    };

    redirectPost(location: string, args?: any) {
        this.redirect(location, 'post', args);
    };

    redirectPut(location: string, args?: any) {
        if (!args)
            args = {};
        this.redirect(location, 'post', $.extend({}, args, {'_method': 'put'}));
    };

    redirectDelete(location: string, args?: any) {
        if (!args)
            args = {};
        this.redirect(location, 'post', $.extend({}, args, {'_method': 'delete'}));
    }
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(function() {
    var app = new App;

    // Date picker
    $('.datepicker').calendar({
        type: 'date',
    });

    function deleteModal(e: JQueryEventObject, url: string, modalId: string, cancelId: string, approveId: string) {
        e.preventDefault();

        var $modal = $(modalId);

        // Cancel deletion
        $modal
            .find(cancelId)
            .off()
            .on('click', function() {
                $modal.modal('hide');
            });

        // Redirect user to delete url
        $modal
            .find(approveId)
            .off()
            .on('click', function() {
                app.redirectDelete(url);
            });

        // Show confirmation dialog
        $modal.modal('show');

        return false;
    }

    $('.key-delete').on('click', function(e) {
        deleteModal(e, $(this).attr('data-url'), '#confirm-key-delete', '#confirm-key-delete-cancel', '#confirm-key-delete-approve');
    });

    $('.repository-delete').on('click', function(e) {
        deleteModal(e, $(this).attr('data-url'), '#confirm-repository-delete', '#confirm-repository-delete-cancel', '#confirm-repository-delete-approve');
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

    // Repositories
    var $repositoryStoreModal = $('#repository-add').modal({
        onApprove: function() {
            $(this).find('form').submit();
            return false;
        }
    });

    $('.repository-add').on('click', function(e) {
        e.preventDefault();

        // Show repository creation dialog
        $repositoryStoreModal.modal('show');

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
                    app.success('Erfolgreich gespeichert.');
                }
            },
            error: function(err) {
                $form.removeClass('loading');

                if (err.status === 422) {
                    var errors = JSON.parse(err.responseText);
                    if (!errors) {
                        app.error('Es ist ein Fehler beim speichern aufgetreten!');
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
                    app.error('Es ist ein unbekannter Fehler beim speichern aufgetreten!');
                    return false;
                }
            }
        })

        return false;
    });
});
