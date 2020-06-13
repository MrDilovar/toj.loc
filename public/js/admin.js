$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(function() {
    'use strict';
    let forms = $('.formsValidate');
    [].filter.call(forms, function(form) {
        $(form).submit(function(event) {
            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }

            $(form).addClass('was-validated');
        });
    });
});

$('.confirmAction').submit(function (e) {
    if(!confirm('Удалить данный продукт?')) e.preventDefault();
});

$(function () {
    let orderStatus = $('.orderStatus');
    if (!orderStatus.length === true) return false;

    orderStatus.change(function () {
        let self = $(this);

        $.ajax({
            url: '/store/order/' + self.data('id'),
            method: 'post',
            data: {
                status_id: self.val(),
                '_method': 'PATCH'
            },
            complete: function () {
                window.location.reload();
            }
        });
    });
});
