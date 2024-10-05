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

    // Xóa crontab
    $('[data-toggle="delCron"]').on('click', function(e) {
        e.preventDefault();
        let btn = $(this);
        let icon = $('i', btn);
        if (icon.is('.fa-spinner')) {
            return;
        }
        nvConfirm(nv_is_del_confirm[0], () => {
            icon.removeClass(icon.data('icon')).addClass('fa-spinner fa-spin-pulse');
            $.ajax({
                type: 'POST',
                url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=' + nv_func_name + '&nocache=' + new Date().getTime(),
                data: {
                    checkss: btn.data('checkss'),
                    cron_del: btn.data('id')
                },
                dataType: 'json',
                cache: false,
                success: function(respon) {
                    icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                    if (!respon.success) {
                        nvToast(respon.text, 'error');
                        return;
                    }
                    nvToast(nv_is_del_confirm[1], 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                },
                error: function(xhr, text, err) {
                    icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                    nvToast(err, 'error');
                    console.log(xhr, text, err);
                }
            });
        });
    });

    // Chọn ngày tháng
    if ($('.datepicker').length) {
        $('.datepicker').each(function() {
            let pk = $(this);
            let inMd = pk.closest('.modal');
            pk.datepicker({
                dateFormat: nv_jsdate_post.replace('yyyy', 'yy'),
                changeMonth: true,
                changeYear: true,
                showOtherMonths: true,
                showButtonPanel: true,
                showOn: 'focus',
                isRTL: $('html').attr('dir') == 'rtl',
                beforeShow: (ipt, pkr) => {
                    if (inMd.length) {
                        setTimeout(() => {
                            pkr.dpDiv[0].style.setProperty("z-index", "9999", "important");
                        }, 100);
                    }
                }
            });
        });
    }

    let btnAddCron = $('[data-toggle="cronAdd"]');
    if (btnAddCron.length) {
        // Ấn nút thêm crontab
        btnAddCron.on('click', function(e) {
            e.preventDefault();
            let md = $('#mdCronForm');
            $('.modal-title').html($(this).attr('aria-label'));
            $('[type="checkbox"]', md).prop('checked', false);
            $('[type="text"]:not(.datepicker)', md).val('');
            $('.datepicker', md).each(function() {
                $(this).val($(this).data('default'));
            });
            $('[type="number"]', md).val('60');
            $('[name="id"]', md).val('0');
            $('option', md).prop('selected', false);
            $('.is-invalid', md).removeClass('is-invalid');
            $('[name="run_file"]', md).val(btnAddCron.data('autofile'));
            btnAddCron.data('autofile', '');
            bootstrap.Modal.getOrCreateInstance(md[0]).show();
        });

        // Tự mở form thêm
        if (btnAddCron.data('autofile') != '') {
            btnAddCron.trigger('click');
        }
    }

    // Lấy thông tin chi tiết crontab để sửa
    $('[data-toggle="editCron"]').on('click', function(e) {
        e.preventDefault();
        let btn = $(this);
        let icon = $('i', btn);
        if (icon.is('.fa-spinner')) {
            return;
        }
        icon.removeClass(icon.data('icon')).addClass('fa-spinner fa-spin-pulse');
        $.ajax({
            type: 'POST',
            url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=' + nv_func_name + '&nocache=' + new Date().getTime(),
            data: {
                crontabinfo: 1,
                checkss: btn.data('checkss'),
                id: btn.data('id')
            },
            dataType: 'json',
            cache: false,
            success: function(respon) {
                icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                if (!respon.success) {
                    nvToast(respon.text, 'error');
                    return;
                }
                let data = respon.data;
                let md = $('#mdCronForm');

                $('.modal-title').html(data.form_title);
                $('[name="id"]', md).val(btn.data('id'));
                $('.is-invalid', md).removeClass('is-invalid');
                $('[name="cron_name"]', md).val(data.cron_name);
                $('[name="run_file"]', md).val(data.run_file);
                $('[name="run_func_iavim"]', md).val(data.run_func);
                $('[name="params_iavim"]', md).val(data.params);
                $('[name="hour"]', md).val(data.hour);
                $('[name="min"]', md).val(data.min);
                $('[name="start_date"]', md).val(data.start_date);
                $('[name="interval_iavim"]', md).val(data.inter_val);
                $('[name="inter_val_type"]', md).val(data.inter_val_type);
                $('[name="del"]', md).prop('checked', data.del);

                bootstrap.Modal.getOrCreateInstance(md[0]).show();
            },
            error: function(xhr, text, err) {
                icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                nvToast(err, 'error');
                console.log(xhr, text, err);
            }
        });
    });
    // Hiệu chỉnh lại picker date khi mở modal edit/add lên
    $('#mdCronForm').on('shown.bs.modal', function() {
        $('.datepicker', $('#mdCronForm')).each(function() {
            let pk = $(this);
            let inMd = pk.closest('.modal');
            pk.datepicker('destroy');
            setTimeout(() => {
                pk.datepicker({
                    dateFormat: nv_jsdate_post.replace('yyyy', 'yy'),
                    changeMonth: true,
                    changeYear: true,
                    showOtherMonths: true,
                    showButtonPanel: true,
                    showOn: 'focus',
                    isRTL: $('html').attr('dir') == 'rtl',
                    beforeShow: (ipt, pkr) => {
                        if (inMd.length) {
                            setTimeout(() => {
                                pkr.dpDiv[0].style.setProperty("z-index", "9999", "important");
                                pkr.dpDiv.position({
                                    my: 'left top',
                                    at: 'left bottom',
                                    of: ipt
                                });
                            }, 10);
                        }
                    }
                });
            }, 1);
        });
    });

    // Kích hoạt đình chỉ crontab
    $('[data-toggle="actCron"]').on('click', function(e) {
        e.preventDefault();
        let btn = $(this);
        let icon = $('i', btn);
        if (icon.is('.fa-spinner')) {
            return;
        }
        nvConfirm(nv_is_change_act_confirm[0], () => {
            icon.removeClass(icon.data('icon')).addClass('fa-spinner fa-spin-pulse');
            $.ajax({
                type: 'POST',
                url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=' + nv_func_name + '&nocache=' + new Date().getTime(),
                data: {
                    checkss: btn.data('checkss'),
                    cron_changeact: btn.data('id')
                },
                dataType: 'json',
                cache: false,
                success: function(respon) {
                    icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                    if (!respon.success) {
                        nvToast(respon.text, 'error');
                        return;
                    }
                    nvToast(nv_is_change_act_confirm[1], 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                },
                error: function(xhr, text, err) {
                    icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                    nvToast(err, 'error');
                    console.log(xhr, text, err);
                }
            });
        });
    });
});
