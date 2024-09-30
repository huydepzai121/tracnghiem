/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2024 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

$(function() {
    // Lưu cấu hình Dữ liệu có cấu trúc, cả form và từng giá trị
    $('#strdata').on('submit', function(e) {
        e.preventDefault();
        var url = $(this).attr('action'),
            data = $(this).serialize();
        $.ajax({
            type: 'POST',
            cache: !1,
            url: url,
            data: data,
            dataType: "json",
            success: function() {},
            error: function(xhr, text, err) {
                console.log(xhr, text, err);
                nvToast(err, 'error');
            }
        })
    });
    $('#strdata .autosubmit').on('change', function() {
        var that = $(this),
            form = that.parents('form'),
            url = form.attr('action'),
            name = that.attr('name'),
            checkss = $('[name=checkss]', form).val(),
            val = that.is(':checked') ? 1 : 0;
        that.prop('disabled', true);
        $.ajax({
            type: 'POST',
            cache: !1,
            url: url,
            data: {
                'name': name,
                'val': val,
                'checkss': checkss
            },
            dataType: "json",
            success: function(result) {
                that.prop('disabled', false);
                if ('error' == result.status) {
                    nvToast(result.mess, 'error');
                    that.prop('checked', !val);
                }
            },
            error: function(xhr, text, err) {
                console.log(xhr, text, err);
                nvToast(err, 'error');
                that.prop('disabled', false);
                that.prop('checked', !val);
            }
        })
    });

    // Lấy dữ liệu mẫu json thông tin doanh nghiệp
    $('[data-toggle=sample_data]').on('click', function(e) {
        e.preventDefault();
        let btn = $(this);
        let icon = $('i', btn);
        if (icon.is('.fa-spinner')) {
            return;
        }
        var url = $(this).data('url'),
            form = $(this).parents('form');
        icon.removeClass(icon.data('icon')).addClass('fa-spinner fa-spin-pulse');
        $.ajax({
            type: 'POST',
            cache: !1,
            url: url,
            data: 'sample_data=1',
            success: function(result) {
                icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                $('[name=jsondata]', form).val(result);
            },
            error: function(xhr, text, err) {
                icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                console.log(xhr, text, err);
                nvToast(err, 'error');
            }
        });
    });

    // Xóa dữ liệu mẫu thông tin doanh nghiệp
    $('[data-toggle=lbinf_delete]').on('click', function(e) {
        e.preventDefault();
        let btn = $(this);
        let icon = $('i', btn);
        if (icon.is('.fa-spinner')) {
            return;
        }

        var url = $(this).data('url');
        nvConfirm($(this).data('confirm'), () => {
            icon.removeClass(icon.data('icon')).addClass('fa-spinner fa-spin-pulse');
            $.ajax({
                type: 'POST',
                cache: !1,
                url: url,
                data: 'lbinf_delete=1',
                success: function(result) {
                    window.location.href = result
                },
                error: function(xhr, text, err) {
                    icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                    console.log(xhr, text, err);
                    nvToast(err, 'error');
                }
            });
        });
    });

    // Click mở modal tải lên logo
    let mdLogo = $('#mdUploadLogo');
    $('#organization_logo').on('click', function(e) {
        e.preventDefault();
        bootstrap.Modal.getOrCreateInstance(mdLogo[0]).show();
    });
    mdLogo.on('shown.bs.modal', function() {
        UAV.init();
    });
    mdLogo.on('hide.bs.modal', function() {
        location.reload();
    });
    let mdLogoRes = $('#organlogo-uploaded');
    if (mdLogoRes.length) {
        try {
            let jso = JSON.parse(trim(mdLogoRes.html()));
            if (jso.success) {
                parent.location.reload();
                return;
            }
            window.parent.postMessage(jso.error, location.origin);
        } catch (error) {
            window.parent.postMessage(error, location.origin);
        }
    }
    if (mdLogo.length) {
        window.addEventListener("message", function(event) {
            if (event.origin !== location.origin) {
                return;
            }
            nvToast(event.data, 'error');
        });
    }

    // Xóa biểu trưng tổ chức
    $('#organization_logo_del').on('click', function(e) {
        e.preventDefault();
        let btn = $(this);
        let icon = $('i', btn);
        if (icon.is('.fa-spinner')) {
            return;
        }
        var url = $(this).parents('form').attr('action');
        icon.removeClass(icon.data('icon')).addClass('fa-spinner fa-spin-pulse');
        $.ajax({
            type: 'POST',
            cache: !1,
            url: url,
            data: 'logodel=1',
            dataType: "json",
            success: function() {
                location.reload();
            },
            error: function(xhr, text, err) {
                icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                console.log(xhr, text, err);
                nvToast(err, 'error');
            }
        });
    });
});
