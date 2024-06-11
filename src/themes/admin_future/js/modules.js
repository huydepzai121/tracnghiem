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
});
