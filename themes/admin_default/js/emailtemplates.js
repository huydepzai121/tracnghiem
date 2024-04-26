/**
 * NUKEVIET Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

$(document).ready(function() {
    // Thay đổi thứ tự danh mục
    $('[data-toggle="weightcat"]').on('change', function() {
        var weight = $(this).val();
        var catid = $(this).data('catid');
        $(this).prop('disabled', true);
        $.ajax({
            type: 'POST',
            url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=categories&nocache=' + new Date().getTime(),
            data: {
                'changeweight': $(this).data('checksess'),
                'catid': catid,
                'new_weight': weight
            },
            cache: false,
            success: function() {
                location.reload();
            },
            error: function(jqXHR, exception, te) {
                console.log(jqXHR, exception, te);
                location.reload();
            }
        });
    });

    // Xóa danh mục
    $('[data-toggle="delcat"]').on('click', function(e) {
        e.preventDefault();
        var catid = $(this).data('catid');
        if (confirm(nv_is_del_confirm[0])) {
            $.ajax({
                type: 'POST',
                url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=categories&nocache=' + new Date().getTime(),
                data: {
                    'delete': $(this).data('checksess'),
                    'catid': catid
                },
                cache: false,
                success: function(res) {
                    var r_split = res.split('_');
                    if (r_split[0] != 'OK') {
                        alert(nv_is_change_act_confirm[2]);
                    }
                    location.reload();
                },
                error: function(jqXHR, exception, te) {
                    console.log(jqXHR, exception, te);
                    location.reload();
                }
            });
        }
    });

    // Xóa mẫu email
    $('[data-click="deltpl"]').on('click', function(e) {
        e.preventDefault();
        var emailid = $(this).data('emailid');
        if (confirm(nv_is_del_confirm[0])) {
            $.ajax({
                type: 'POST',
                url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=main&nocache=' + new Date().getTime(),
                data: {
                    'delete': $(this).data('checksess'),
                    'emailid': emailid
                },
                cache: false,
                success: function(res) {
                    var r_split = res.split('_');
                    if (r_split[0] != 'OK') {
                        alert(nv_is_change_act_confirm[2]);
                    }
                    location.reload();
                },
                error: function(jqXHR, exception, te) {
                    console.log(jqXHR, exception, te);
                    location.reload();
                }
            });
        }
    });

    // Xóa đính kèm
    $(document).delegate('[data-toggle="attdel"]', 'click', function(e) {
        e.preventDefault();
        $(this).parent().parent().remove();
    });

    // Thay đổi hiển thị nội sung soạn email theo ngôn ngữ
    $('[data-toggle="collapsecontentchange"]').on('click', function(e) {
        e.preventDefault();
        $('[data-toggle="collapsecontentlabel"]').html($(this).html());
        $('[data-toggle="collapsecontent"]').removeClass('in');
        $('#collapse-content-' + $(this).data('lang')).addClass('in');
        $('[name="showlang"]').val($(this).data('lang'));
    });

    var formc = $('#form-emailtemplates');
    if (formc.length) {
        var fieldTimer;
        $('[name="pids[]"]').on('change', function() {
            if (fieldTimer) {
                clearTimeout(fieldTimer);
            }
            $('#merge-fields-content').html('');
            var pids = $(this).val();
            if ($('#tpl_sys_pids').length) {
                $('#tpl_sys_pids').find('option').each(function() {
                    pids.push($(this).attr('value'));
                });
            }
            fieldTimer = setTimeout(function() {
                $.ajax({
                    type: 'POST',
                    url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=contents&nocache=' + new Date().getTime(),
                    data: {
                        'getMergeFields': 1,
                        'pids': pids
                    },
                    cache: false,
                    success: function(res) {
                        $('#merge-fields-content').html(res);
                        fieldTimer = 0;
                    },
                    error: function(jqXHR, exception, t) {
                        console.log(jqXHR, exception, t);
                        fieldTimer = 0;
                    }
                });
            }, 500);
        });
        $('[name="pids[]"]').trigger('change');

        var focusEditor = 'emailtemplates_default_content';
        if (typeof CKEDITOR != 'undefined') {
            for (const [key, value] of Object.entries(CKEDITOR.instances)) {
                value.on('focus', function() {
                    focusEditor = key;
                });
            }
        } else {
            $('[data-toggle="textareaemailcontent"]').on('focus', function() {
                focusEditor = $(this).attr('id');
            });
        }
        $(document).delegate('[data-toggle="fchoose"]', 'click', function(e) {
            e.preventDefault();
            if (typeof CKEDITOR != 'undefined') {
                CKEDITOR.instances[focusEditor].insertHtml(' {' + $(this).data('value') + '}');
            } else {
                $('#' + focusEditor).val($('#' + focusEditor).val() + ' {' + $(this).data('value') + '}');
            }
        });
        $('[data-toggle="attadd"]').prop('disabled', false);

        // Thêm đính kèm
        $('[data-toggle="attadd"]').on('click', function(e) {
            e.preventDefault();
            var size = $(this).data('size');
            size++;
            $(this).data('size', size);
            var area_new = 'tpl_att' + size;
            $('#tpl-attach-temp').find('[name="attachments[]"]').attr('id', area_new);
            $('#tpl-attach-temp').find('[data-toggle="selectfile"]').attr('data-target', area_new);
            $('#tpl-attachments').append($('#tpl-attach-temp').html());
        });
    }

    // Select 2
    if ($(".select2").length) {
        $(".select2").select2({
            width: "100%",
            language: nv_lang_interface
        });
    }

    // Pickdate
    if ($('.datepicker-search').length) {
        $('.datepicker-search').datepicker({
            showOn: "both",
            dateFormat: "dd-mm-yy",
            changeMonth: true,
            changeYear: true,
            showOtherMonths: true,
            buttonText: null,
            buttonImage: null,
            buttonImageOnly: true
        });
    }
});
