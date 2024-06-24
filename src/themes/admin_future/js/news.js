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

    // Chọn ngày tháng
    if ($('.datepicker').length) {
        $('.datepicker').datepicker({
            dateFormat: nv_jsdate_get.replace('yyyy', 'yy'),
            changeMonth: true,
            changeYear: true,
            showOtherMonths: true,
            buttonText: '{LANG.select}',
            showButtonPanel: true,
            showOn: 'focus',
            isRTL: $('html').attr('dir') == 'rtl'
        });
    }

    // Mở rộng thu gọn tìm kiếm tin tức
    const postAdvBtn = document.getElementById('search-adv');
    if (postAdvBtn) {
        let form = $('#form-search-post');
        postAdvBtn.addEventListener('hide.bs.collapse', () => {
            $('[name="adv"]', form).val('0');
        });
        postAdvBtn.addEventListener('show.bs.collapse', () => {
            $('[name="adv"]', form).val('1');
        });
    }

    // Xóa 1 bài viết
    $('[data-toggle="delArticle"]').on('click', function(e) {
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
                url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=del_content&nocache=' + new Date().getTime(),
                data: {
                    checkss: btn.data('checksess'),
                    id: btn.data('id')
                },
                success: function(res) {
                    icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                    var r_split = res.split('_');
                    if (r_split[0] == 'OK') {
                        location.reload();
                    } else if (r_split[0] == 'ERR') {
                        nvToast(r_split[1], 'error');
                    } else {
                        nvToast(nv_is_del_confirm[2], 'error');
                    }
                },
                error: function(xhr, text, err) {
                    icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                    nvToast(text, 'error');
                    console.log(xhr, text, err);
                }
            });
        });
    });

    // Chọn 1/nhiều bài viết và thực hiện các chức năng
    $('[data-toggle="actionArticle"]').on('click', function(e) {
        e.preventDefault();
        let btn = $(this);
        if (btn.is(':disabled')) {
            return;
        }
        let ctn = $(btn.data('ctn')), listid = [];
        $('[data-toggle="checkSingle"]:checked', ctn).each(function() {
            listid.push($(this).val());
        });
        if (listid.length < 1)  {
            nvAlert(nv_please_check);
            return;
        }
        let action = $('#element_action').val();

        if (action == 'delete') {
            nvConfirm(nv_is_del_confirm[0], () => {
                btn.prop('disabled', true);
                $('#element_action').prop('disabled', true);
                $.ajax({
                    type: 'POST',
                    url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=del_content&nocache=' + new Date().getTime(),
                    data: {
                        checkss: $('body').data('checksess'),
                        listid: listid.join(',')
                    },
                    success: function(res) {
                        btn.prop('disabled', false);
                        $('#element_action').prop('disabled', false);
                        var r_split = res.split('_');
                        if (r_split[0] == 'OK') {
                            location.reload();
                        } else if (r_split[0] == 'ERR') {
                            nvToast(r_split[1], 'error');
                        } else {
                            nvToast(nv_is_del_confirm[2], 'error');
                        }
                    },
                    error: function(xhr, text, err) {
                        btn.prop('disabled', false);
                        $('#element_action').prop('disabled', false);
                        nvToast(text, 'error');
                        console.log(xhr, text, err);
                    }
                });
            });
        } else {
            window.location.href = script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=' + action + '&listid=' + listid.join(',') + '&checkss=' + $('body').data('checksess');
        }
    });

    // Sắp xếp bài viết tùy chỉnh
    let mdSortArt = $('#mdSortArticle');
    $('[data-toggle="sortArticle"]').on('click', function(e) {
        e.preventDefault();
        let btn = $(this);

        $('#mdSortArticleLabel').text(btn.data('title'));
        $('#sortArticleCurrent').val(btn.data('weight'));
        $('#sortArticleNew').val(btn.data('weight'));

        mdSortArt.data('id', btn.data('id'));
        mdSortArt.data('checksess', btn.data('checksess'));
        mdSortArt.data('weight', btn.data('weight'));
        const md = bootstrap.Modal.getOrCreateInstance(mdSortArt[0]);
        md.show();
    });
    if (mdSortArt.length) {
        mdSortArt.on('shown.bs.modal', function() {
            $('#sortArticleNew').focus();
        });

        $('#sortArticleSave').on('click', function(e) {
            e.preventDefault();
            let btn = $(this);
            let icon = $('i', btn);
            if (icon.is('.fa-spinner')) {
                return;
            }

            icon.removeClass(icon.data('icon')).addClass('fa-spinner fa-spin-pulse');
            $.ajax({
                type: 'POST',
                url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&nocache=' + new Date().getTime(),
                data: {
                    order_articles_new: $('#sortArticleNew').val(),
                    order_articles_id: mdSortArt.data('id'),
                    order_articles_checkss: mdSortArt.data('checksess')
                },
                success: function(res) {
                    icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                    if (res == 'OK') {
                        location.reload();
                        return;
                    }
                    nvToast(nv_is_change_act_confirm[2], 'error');
                },
                error: function(xhr, text, err) {
                    icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                    nvToast(text, 'error');
                    console.log(xhr, text, err);
                }
            });
        });
    }

    // Sao chép liên kết bài viết
    if ($('[data-toggle="copyArticleUrl"]').length) {
        var clipboard = new ClipboardJS('[data-toggle="copyArticleUrl"]');
        clipboard.on('success', function(e) {
            nvToast($(e.trigger).data('message'), 'success');
        });
    }

    // Lịch sử bài viết
    const mdHistory = $('#mdHistoryArticle');
    $('[data-toggle="historyArticle"]').on('click', function(e) {
        e.preventDefault();
        mdHistory.data('loadurl', $(this).data('loadurl'));
        (bootstrap.Modal.getOrCreateInstance(mdHistory[0])).show();
    });
    if (mdHistory.length) {
        mdHistory.on('show.bs.modal', function() {
            $('.modal-body', mdHistory).html('<div class="text-center"><i class="fa-solid fa-spinner fa-spin-pulse fa-2x"></i></div>').load(mdHistory.data('loadurl'));
        });
    }

    // Khôi phục lại lịch sử
    $(document).delegate('[data-toggle="restoreHistory"]', 'click', function(e) {
        e.preventDefault();
        let btn = $(this);
        let icon = $('i', btn);
        if (icon.is('.fa-spinner')) {
            return;
        }
        nvConfirm(btn.data('msg'), () => {
            icon.removeClass(icon.data('icon')).addClass('fa-spinner fa-spin-pulse');
            $.ajax({
                type: 'POST',
                url: btn.attr('href') + '&nocache=' + new Date().getTime(),
                data: {
                    restorehistory: $('body').data('checksess'),
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
                    window.location = respon.url;
                },
                error: function(xhr, text, err) {
                    icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                    nvToast(text, 'error');
                    console.log(xhr, text, err);
                }
            });
        });
    });
});
