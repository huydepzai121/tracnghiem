/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2024 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

$(function() {
    // Select 2
    if ($('.select2').length) {
        $('.select2').select2({
            language: nv_lang_interface,
            dir: $('html').attr('dir'),
            width: '100%'
        });
    }

    // Xử lý riêng form dọn dẹp hệ thống
    $('#clearsystem-form').on('submit', function(e) {
        e.preventDefault();
        var that = $(this),
            url = that.attr('action'),
            data = that.serialize(),
            checked_num = $('[name^=deltype]:checked', that).length;

        if (checked_num < 1) {
            nvToast(nv_please_check, 'info');
            return;
        }

        $('#pload').removeClass('d-none');
        $('#presult, #pnoresult').addClass('d-none');
        $('input,button', that).prop('disabled', true);

        $.ajax({
            type: "POST",
            url: url,
            data: data,
            cache: !1,
            dataType: 'json',
            success: function(response) {
                $('input,button', that).prop('disabled', false);
                $('#pload').addClass('d-none');

                if (response.status == 'error') {
                    nvToast(response.mess, 'error');
                    return;
                }

                if (response.data.length < 1) {
                    $('#presult').addClass('d-none');
                    $('#pnoresult').removeClass('d-none');
                    return;
                }

                $('#pnoresult').addClass('d-none');
                $('.dynamic-item', $('#presult')).remove();

                let html = '';
                response.data.forEach(function(item) {
                    html += '<li class="list-group-item text-break dynamic-item">' + item + '</li>';
                });
                $('#presult').append(html).removeClass('d-none');
            },
            error: function(xhr, text, err) {
                console.log(xhr, text, err);
                nvToast(err, 'error');
                $('input,button', that).prop('disabled', false);
                $('#pload').addClass('d-none');
            }
        });
    });
});
