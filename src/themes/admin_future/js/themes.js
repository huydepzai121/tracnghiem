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
});
