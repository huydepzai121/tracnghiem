/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2024 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

$(function() {
    // Chọn icon giao diện
    let sel2Fa = $('.select2-fontawesome');
    if (sel2Fa.length) {
        sel2Fa.select2({
            minimumInputLength: 1,
            ajax: {
                delay: 250,
                cache: false,
                type: 'POST',
                url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=edit&nocache=' + new Date().getTime(),
                dataType: 'json',
                data: params => {
                    return {
                        q: params.term,
                        ajax_icon: $('body').data('checksess'),
                        page: params.page || 1
                    };
                }
            },
            templateResult: state => {
                if (!state.id) {
                    return state.text;
                }
                return $(`<div class="d-flex align-items-center">
                    <i class="` + state.id + ` fa-fw"></i>
                    <div class="ms-2">` + state.text + `</div>
                </div>`);
            },
            templateSelection: state => {
                if (!state.id) {
                    return state.text;
                }
                return $(`<div class="d-flex align-items-center">
                    <i class="` + state.id + ` fa-fw"></i>
                    <div class="ms-2">` + state.text + `</div>
                </div>`);
            }
        });
    }

    // Kích hoạt/đình chỉ module
    $('[data-toggle="changeActModule"]').on('change', function() {
        let btn = $(this);
        let act = btn.is(':checked');
        nvConfirm(nv_is_change_act_confirm[0], () => {
            btn.prop('disabled', true);
            $.ajax({
                type: 'POST',
                url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=change_act&nocache=' + new Date().getTime(),
                data: {
                    checkss: btn.data('checkss'),
                    mod: btn.data('mod')
                },
                dataType: 'json',
                cache: false,
                success: function(respon) {
                    if (!respon.success) {
                        btn.prop('checked', !act);
                        btn.prop('disabled', false);
                        nvToast(respon.text, 'error');
                        return;
                    }
                    location.reload();
                },
                error: function(xhr, text, err) {
                    btn.prop('checked', !act);
                    btn.prop('disabled', false);
                    nvToast(err, 'error');
                    console.log(xhr, text, err);
                }
            });
        }, () => {
            btn.prop('checked', !act);
        });
    });

    // Thay đổi thứ tự module
    $('[data-toggle="changeWeiModule"]').on('change', function() {
        let btn = $(this);
        btn.prop('disabled', true);
        $.ajax({
            type: 'POST',
            url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=change_weight&nocache=' + new Date().getTime(),
            data: {
                mod: btn.data('mod'),
                new_weight: btn.val()
            },
            dataType: 'json',
            cache: false,
            success: function(respon) {
                if (!respon.success) {
                    nvToast(respon.text, 'error');
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                    return;
                }
                location.reload();
            },
            error: function(xhr, text, err) {
                nvToast(err, 'error');
                console.log(xhr, text, err);
                setTimeout(() => {
                    location.reload();
                }, 2000);
            }
        });
    });

    // Xóa module
    $('[data-toggle="deleteModule"]').on('click', function(e) {
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
                url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=del&nocache=' + new Date().getTime(),
                data: {
                    checkss: btn.data('checkss'),
                    mod: btn.data('mod')
                },
                dataType: 'json',
                cache: false,
                success: function(respon) {
                    icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                    if (!respon.success) {
                        nvToast(respon.text, 'error');
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

    // Cài lại module
    $('[data-toggle="recreateModule"]').on('click', function() {
        let md = $('#modal-reinstall-module');
        let btn = $(this);
        let icon = $('i', btn);
        if (icon.is('.fa-spinner')) {
            return;
        }
        $('[name="mod"]', md).val(btn.data('mod'));
        icon.removeClass(icon.data('icon')).addClass('fa-spinner fa-spin-pulse');
        $.ajax({
            type: 'POST',
            url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=setup_module_check&nocache=' + new Date().getTime(),
            data: {
                checkss: btn.data('checkss'),
                module: btn.data('mod')
            },
            dataType: 'json',
            cache: false,
            success: function(respon) {
                icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                if (respon.status != 'success') {
                    nvToast(respon.message.join(', '), 'error');
                    return;
                }
                $('[name="checkss"]', md).val(respon.checkss);
                $('[name="sample"]', md).val('0');
                if (respon.code == 1) {
                    $('.showoption', md).removeClass('d-none');
                } else {
                    $('.showoption', md).addClass('d-none');
                }
                $('.message', md).html(respon.message.join('. ') + '.');
                bootstrap.Modal.getOrCreateInstance(md[0]).show();
            },
            error: function(xhr, text, err) {
                icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                nvToast(text, 'error');
                console.log(xhr, text, err);
            }
        });
    });
});
