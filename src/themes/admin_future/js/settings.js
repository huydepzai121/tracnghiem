/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2024 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

// Hàm đọc form thiết lập CDN theo ngôn ngữ
function country_cdn_list_load() {
    let ele = $('#collapse-country-cdn');
    $.ajax({
        type: 'GET',
        cache: !1,
        url: ele.data('url'),
        success: function(data) {
            ele.attr('data-loaded', 'true');
            ele.html(data);
        },
        error: function(xhr, text, err) {
            nvToast(err, 'error');
            console.log(xhr, text, err);
        }
    })
}

$(function() {
    // Thêm xóa cấu hình tùy chỉnh
    $('body').on('click', '[data-toggle="addCustomCfgItem"]', function() {
        var item = $(this).closest('.item'),
            new_item = item.clone();
        $('input[type=text]', new_item).val('');
        item.after(new_item);
    });

    $('body').on('click', '[data-toggle="delCustomCfgItem"]', function() {
        var item = $(this).closest('.item'),
            list = $(this).closest('.list');
        if ($('.item', list).length > 1) {
            item.remove();
        } else {
            $('input[type=text]', item).val('');
        }
    });

    // Tự xác định path của FTP
    $('#autodetectftp').on('click', function(e) {
        e.preventDefault();
        e.preventDefault();
        let btn = $(this);
        let icon = $('i', btn);
        if (icon.is('.fa-spinner')) {
            return;
        }

        var form = btn.closest('form'),
            ftp_server = $('input[name="ftp_server"]', form).val(),
            ftp_user_name = $('input[name="ftp_user_name"]', form).val(),
            ftp_user_pass = $('input[name="ftp_user_pass"]', form).val(),
            ftp_port = $('input[name="ftp_port"]', form).val();
        if (ftp_server == '' || ftp_user_name == '' || ftp_user_pass == '') {
            nvToast(form.data('error'), 'error');
            return !1;
        }
        icon.removeClass(icon.data('icon')).addClass('fa-spinner fa-spin-pulse');
        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: {
                'ftp_server': ftp_server,
                'ftp_port': ftp_port,
                'ftp_user_name': ftp_user_name,
                'ftp_user_pass': ftp_user_pass,
                'autodetect': 1
            },
            dataType: "json",
            success: function(c) {
                icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                if ('error' == c.status) {
                    nvToast(c.mess, 'error');
                } else if('OK' == c.status) {
                    $('#ftp_path').val(c.mess);
                }
            },
            error: function(xhr, text, err) {
                icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                nvToast(err, 'error');
                console.log(xhr, text, err);
            }
        });
    });

    // Thêm và xóa CDN url ở trang thiết lập CDN
    $('body').on('click', '[data-toggle=add_cdn]', function(e) {
        e.preventDefault();
        var cdnlist = $(this).closest('.cdn-list'),
            item = $(this).closest('.item'),
            newitem = item.clone();
        let randId = nv_randomPassword(10);
        $('[data-toggle="cdn_default"]', newitem).attr('id', randId);
        $('[data-toggle="cdn_default_lbl"]', newitem).attr('for', randId);
        $('[name^=cdn_url], [name^=cdn_countries]', newitem).val('');
        $('[name^=cdn_is_default]', newitem).val('0');
        $('[data-toggle=cdn_default]', newitem).prop('checked', false);
        newitem.appendTo(cdnlist);
    });
    $('body').on('click', '[data-toggle=remove_cdn]', function(e) {
        e.preventDefault();
        var cdnlist = $(this).closest('.cdn-list'),
            item = $(this).closest('.item');
        if ($('.item', cdnlist).length > 1) {
            item.remove();
        } else {
            $('[name^=cdn_url], [name^=cdn_countries]', item).val('');
            $('[name^=cdn_is_default]', item).val('0');
            $('[data-toggle=cdn_default]', item).prop('checked', false);
        }
    });

    // Chọn CDN url mặc định
    $('body').on('change', '[data-toggle=cdn_default]', function() {
        var item = $(this).closest('.item');
        if ($(this).is(':checked')) {
            $('[name^=cdn_is_default]', item).val('1');
            $('[data-toggle=cdn_default]', item.siblings()).prop('checked', false);
            $('[name^=cdn_is_default]', item.siblings()).val('0');
        } else {
            $('[name^=cdn_is_default]', item).val('0');
        }
    });

    // Load CDN theo quốc gia
    $('#collapse-country-cdn').on('shown.bs.collapse', function() {
        if ($(this).attr('data-loaded') === 'false') {
            country_cdn_list_load();
        }
    });

    // Tự động submit form CDN theo quốc gia
    $('body').on('change', '[name^=ccdn]', function(e) {
        e.preventDefault();
        if ($(this).val() != '') {
            $(this).closest('li').addClass('list-group-item-success');
        } else {
            $(this).closest('li').removeClass('list-group-item-success');
        }
        $(this).closest('form').submit();
    });
});
