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

    // Submit đóng gói theme theo module
    $('#pkgThemeMod').on('submit', function(e) {
        e.preventDefault();
        let form = $(this);
        let loader = $('#pkgThemeModLoader');
        let resCtn = $('#pkgThemeModResult');
        if (loader.is(':visible')) {
            return;
        }

        let themename = $("select[name=themename]", form).val();
        let module_file = [];
        $("[name='module_file[]']:checked", form).each(function() {
            module_file.push($(this).val());
        });
        if (themename == 0 || module_file.length == 0) {
            nvToast(form.data('error'), 'error');
            return;
        }
        loader.removeClass('d-none');
        resCtn.addClass('d-none');
        $.ajax({
            type: 'POST',
            url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=' + nv_func_name + '&nocache=' + new Date().getTime(),
            data: {
                themename: themename,
                module_file: module_file.join(','),
                checkss: form.data('checkss')
            },
            dataType: 'json',
            cache: false,
            success: function(res) {
                loader.addClass('d-none');
                $('[data-toggle="pkgRes"]', resCtn).html('<a href="' + res.link + '" class="link-success fw-medium">' + res.name + ' (' + res.size + ')</a>');
                resCtn.removeClass('d-none');
            },
            error: function(xhr, text, err) {
                nvToast(text, 'error');
                console.log(xhr, text, err);
                loader.addClass('d-none');
            }
        });
    });

    // Chọn giao diện để copy block
    function xCopyBlockSel() {
        let theme1 = $("select[name=theme1]").val();
        let theme2 = $("select[name=theme2]").val();
        let lCtn = $('#loadposition');

        if (theme2 != 0 && theme1 != 0 && theme1 != theme2) {
            $("select[name=theme1]").prop('disabled', true);
            $("select[name=theme2]").prop('disabled', true);

            $('[data-toggle="res"]', lCtn).html('').addClass('d-none');
            $('[data-toggle="loader"]', lCtn).removeClass('d-none');
            lCtn.removeClass('d-none');

            $.ajax({
                type: 'POST',
                url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=loadposition&nocache=' + new Date().getTime(),
                data: {
                    theme2: theme2,
                    theme1: theme1,
                    checkss: $('[name="checkss"]', lCtn.closest('form')).val()
                },
                dataType: 'json',
                cache: false,
                success: function(res) {
                    $("select[name=theme1]").prop('disabled', false);
                    $("select[name=theme2]").prop('disabled', false);
                    $('[data-toggle="loader"]', lCtn).addClass('d-none');
                    if (!res.success) {
                        $('[data-toggle="res"]', lCtn).html('').addClass('d-none');
                        lCtn.addClass('d-none');
                        nvToast(res.text, 'error');
                        return;
                    }
                    $('[data-toggle="res"]', lCtn).html(res.html).removeClass('d-none');
                },
                error: function(xhr, text, err) {
                    nvToast(text, 'error');
                    console.log(xhr, text, err);
                    $('[data-toggle="res"]', lCtn).html('').addClass('d-none');
                    $('[data-toggle="loader"]', lCtn).addClass('d-none');
                    lCtn.addClass('d-none');
                    $("select[name=theme1]").prop('disabled', false);
                    $("select[name=theme2]").prop('disabled', false);
                }
            });
        } else {
            $("select[name=theme1]").prop('disabled', false);
            $("select[name=theme2]").prop('disabled', false);
            $('[data-toggle="res"]', lCtn).html('').addClass('d-none');
            $('[data-toggle="loader"]', lCtn).addClass('d-none');
            lCtn.addClass('d-none');
        }
    }
    $('[data-toggle="xCpBlSel"]').on('change', function() {
        xCopyBlockSel();
    });

    // Chọn tất cả vị trí chép block
    $(document).on('click', '[data-toggle="checkallpos"]', function() {
        if ($(this).data('all')) {
            $('[name="position[]"]').prop('checked', false);
            $(this).data('all', 0);
        } else {
            $('[name="position[]"]').prop('checked', true);
            $(this).data('all', 1);
        }
    });

    // Submit chép block
    $('#formXcopyBlock').on('submit', function(e) {
        e.preventDefault();
        let form = $(this);
        let btn = $('[type="submit"]', form);
        let icon = $('i', btn);
        if (icon.is('.fa-spinner')) {
            return;
        }

        let theme1 = $("select[name=theme1]").val();
        let theme2 = $("select[name=theme2]").val();
        let positionlist = [];
        $('input[name="position[]"]:checked').each(function() {
            positionlist.push($(this).val());
        });
        if (positionlist.length < 1) {
            nvToast(form.data('error'), 'error');
            return;
        }

        icon.removeClass(icon.data('icon')).addClass('fa-spinner fa-spin-pulse');
        $.ajax({
            type: 'POST',
            url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=xcopyprocess&nocache=' + new Date().getTime(),
            data: {
                theme2: theme2,
                theme1: theme1,
                position: positionlist.join(','),
                checkss: $('[name="checkss"]', form).val()
            },
            dataType: 'json',
            cache: false,
            success: function(res) {
                icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                if (!res.success) {
                    nvToast(res.text, 'error');
                    return;
                }
                nvToast(res.text, 'success');
            },
            error: function(xhr, text, err) {
                icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                nvToast(err, 'error');
                console.log(xhr, text, err);
            }
        });
    });
});
