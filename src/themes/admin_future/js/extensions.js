/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

$(function() {
    // Hiển thị chi tiết ứng dụng
    let mdEd = $('#mdExtDetail');
    if (mdEd.length) {
        $('.ex-detail').on('click', function(e) {
            e.preventDefault();
            let btn = $(this);
            let icon = $('i', btn);
            if (icon.is('.fa-spinner')) {
                return;
            }
            $('#mdExtDetailLabel').html(btn.data('title'));
            icon.removeClass(icon.data('icon')).addClass('fa-spinner fa-spin-pulse');
            $.ajax({
                type: 'GET',
                url: btn.data('url') + '&nocache=' + new Date().getTime(),
                success: function(res) {
                    icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                    $('.modal-body', mdEd).html(res);
                    $('[data-bs-toggle="tooltip"]', mdEd).each(function() {
                        new bootstrap.Tooltip(this);
                    });
                    bootstrap.Modal.getOrCreateInstance(mdEd[0]).show();
                },
                error: function(xhr, text, err) {
                    icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                    nvToast(err, 'error');
                    console.log(xhr, text, err);
                }
            });
        });
    }
});
