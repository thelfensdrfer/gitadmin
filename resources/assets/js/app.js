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
    $('.key-delete').on('click', function() {
        var url = $(this).attr('data-url');
        var $modal = $('#confirm-key-delete');

        $modal
            .find('#confirm-key-delete-cancel')
            .off()
            .on('click', function() {
                $modal.modal('hide');
            });
        $modal
            .find('#confirm-key-delete-approve')
            .off()
            .on('click', function() {
                $.redirectDelete(url);
            });
        $modal.modal('show');
    });
});
