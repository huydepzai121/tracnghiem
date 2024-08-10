/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2024 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

$(function() {
    // Chọn ngày tháng
    if ($('.datepicker-post').length) {
        $('.datepicker-post').datepicker({
            dateFormat: nv_jsdate_post.replace('yyyy', 'yy'),
            changeMonth: true,
            changeYear: true,
            showOtherMonths: true,
            showButtonPanel: true,
            showOn: 'focus',
            isRTL: $('html').attr('dir') == 'rtl'
        });
    }

    // Nút chọn ngày tháng
    $('[data-toggle="focusDate"]').on('click', function(e) {
        e.preventDefault();
        $('input', $(this).parent()).focus();
    });

    // Cuộn trang đến element
    let autoScroll = $('[data-toggle="autoScroll"]');
    if (autoScroll.length == 1) {
        $('html, body').animate({
            scrollTop: autoScroll.offset().top - 10
        }, 150);
    }

    // Xóa tài khoản tường lửa
    $('[data-toggle="delFwUser"]').on('click', function(e) {
        e.preventDefault();
        let btn = $(this);
        let icon = $('i', btn);
        if (icon.is('.fa-spinner')) {
            return;
        }
        nvConfirm(btn.data('message'), () => {
            icon.removeClass(icon.data('icon')).addClass('fa-spinner fa-spin-pulse');
            $.ajax({
                type: 'POST',
                url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=' + nv_func_name + '&nocache=' + new Date().getTime(),
                data: {
                    delid: btn.data('id'),
                    checkss: btn.data('checkss')
                },
                dataType: 'json',
                success: function(data) {
                    icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                    if (data.error) {
                        nvToast(data.message, 'error');
                        return;
                    }
                    location.reload();
                },
                error: function(xhr, text, err) {
                    icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                    nvToast(text, 'error');
                    console.log(xhr, text, err);
                }
            });
        });
    });

    // Đổi phiên bản IP cấm
    $('#ipt_ip_version').on('change', function() {
        if ($(this).val() == '4') {
            $('#ip4_mask').removeClass('d-none');
            $('#ip6_mask').addClass('d-none');
        } else {
            $('#ip4_mask').addClass('d-none');
            $('#ip6_mask').removeClass('d-none');
        }
    });
});
