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
    $(document).on('click', '[data-toggle="restoreHistory"]', function(e) {
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

    // Xóa 1 tag
    $('[data-toggle=nv_del_tag]').on('click', function(e) {
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
                    checkss: $('body').data('checksess'),
                    del_tid: btn.data('tid')
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

    // Xóa nhiều tag
    $('[data-toggle=nv_del_check_tags]').on('click', function(e) {
        e.preventDefault();

        let btn = $(this);
        let icon = $('i', btn);
        if (icon.is('.fa-spinner')) {
            return;
        }

        let listid = [];
        $('[data-toggle="checkSingle"][data-type="tag"]:checked').each(function() {
            listid.push($(this).val());
        });
        if (listid.length < 1)  {
            nvAlert(nv_please_check);
            return;
        }
        listid = listid.join(',');
        nvConfirm(nv_is_del_confirm[0], () => {
            icon.removeClass(icon.data('icon')).addClass('fa-spinner fa-spin-pulse');
            $.ajax({
                type: 'POST',
                url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=' + nv_func_name + '&nocache=' + new Date().getTime(),
                data: {
                    checkss: $('body').data('checksess'),
                    del_listid: listid
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

    // Xử lý thêm nhiều tag
    let mdTagMulti = $('#mdTagMulti');
    if (mdTagMulti.length) {
        mdTagMulti.on('hidden.bs.modal', function() {
            $('[name="mtitle"]', mdTagMulti).val('');
        });
    }

    // Xử lý thêm sửa 1 tag
    let mdTagSingle = $('#mdTagSingle');
    if (mdTagSingle.length) {
        $('[data-toggle="titlelength"]', mdTagSingle).html($('[name="title"]', mdTagSingle).val().length);
        $('[name="title"]', mdTagSingle).bind("keyup paste", function() {
            $('[data-toggle="titlelength"]', mdTagSingle).html($(this).val().length);
        });

        $('[data-toggle="descriptionlength"]', mdTagSingle).html($('[name="description"]', mdTagSingle).val().length);
        $('[name="description"]', mdTagSingle).bind("keyup paste", function() {
            $('[data-toggle="descriptionlength"]', mdTagSingle).html($(this).val().length);
        });

        function cleanFormTag() {
            $('.is-invalid', mdTagSingle).removeClass('is-invalid');
            $('.is-valid', mdTagSingle).removeClass('is-valid');

            $('[name="tid"]', mdTagSingle).val('0');
            $('[name="keywords"]', mdTagSingle).val('');
            $('[name="title"]', mdTagSingle).val('');
            $('[name="description"]', mdTagSingle).val('');
            $('[name="image"]', mdTagSingle).val('');
            $('[data-toggle="titlelength"]', mdTagSingle).text('0');
            $('[data-toggle="descriptionlength"]', mdTagSingle).text('0');
            $('[data-toggle="selectfile"]', mdTagSingle).data('currentpath', $('[data-toggle="selectfile"]', mdTagSingle).data('path'));
        }

        $('[data-toggle=add_tags]').on('click', function(e) {
            e.preventDefault();
            let btn = $(this);
            let icon = $('i', btn);
            if (icon.length && icon.is('.fa-spinner')) {
                return;
            }
            let md = bootstrap.Modal.getOrCreateInstance(mdTagSingle[0]);

            $('.modal-title', mdTagSingle).text(btn.data('mtitle'));
            if (btn.data('fc') == 'editTag') {
                icon.removeClass(icon.data('icon')).addClass('fa-spinner fa-spin-pulse');
                $.ajax({
                    type: 'POST',
                    url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=' + nv_func_name + '&nocache=' + new Date().getTime(),
                    data: {
                        checkss: $('body').data('checksess'),
                        loadEditTag: 1,
                        tid: btn.data('tid')
                    },
                    dataType: 'json',
                    cache: false,
                    success: function(respon) {
                        icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                        if (!respon.success) {
                            nvToast(respon.text, 'error');
                            return;
                        }
                        $('[name="tid"]', mdTagSingle).val(btn.data('tid'));
                        $('[name="keywords"]', mdTagSingle).val(respon.data.keywords);
                        $('[name="title"]', mdTagSingle).val(respon.data.title);
                        $('[name="description"]', mdTagSingle).val(respon.data.description);
                        $('[name="image"]', mdTagSingle).val(respon.data.image);
                        $('[data-toggle="selectfile"]', mdTagSingle).data('currentpath', respon.data.currentpath);

                        $('[name="title"]', mdTagSingle).trigger('keyup');
                        $('[name="description"]', mdTagSingle).trigger('keyup');

                        md.show();
                    },
                    error: function(xhr, text, err) {
                        icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                        nvToast(text, 'error');
                        console.log(xhr, text, err);
                    }
                });
                return;
            }
            cleanFormTag();
            md.show();
        });
    }

    // Xử lý thêm nhiều tag
    let mdTagLinks = $('#mdTagLinks');
    if (mdTagLinks.length) {
        mdTagLinks.on('hidden.bs.modal', function() {
            $('.modal-body', mdTagLinks).html('');
        });

        let md = bootstrap.Modal.getOrCreateInstance(mdTagLinks[0]);

        $('[data-toggle=link_tags]').on('click', function(e) {
            e.preventDefault();
            let btn = $(this);
            let icon = $('i', btn);
            if (icon.is('.fa-spinner')) {
                return;
            }
            $('[data-toggle="tags_id_check_del"]', mdTagLinks).data('tid', btn.data('tid'));
            icon.removeClass(icon.data('icon')).addClass('fa-spinner fa-spin-pulse');
            $.ajax({
                type: 'POST',
                url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=' + nv_func_name + '&nocache=' + new Date().getTime(),
                data: {
                    checkss: $('body').data('checksess'),
                    tid: btn.data('tid'),
                    tagLinks: 1
                },
                dataType: 'json',
                cache: false,
                success: function(respon) {
                    icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                    if (!respon.success) {
                        nvToast(respon.text, 'error');
                        return;
                    }
                    $('.modal-body', mdTagLinks).html(respon.html);
                    md.show();
                },
                error: function(xhr, text, err) {
                    icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                    nvToast(text, 'error');
                    console.log(xhr, text, err);
                }
            });
        });

        mdTagLinks.on('click', '[data-toggle="tag_keyword_edit"]', function(e) {
            e.preventDefault();

            let item = $('[data-item="' + $(this).data('id') + '"]', mdTagLinks);
            $('.show-keywords', item).addClass('d-none');
            $('.edit-keywords', item).removeClass('d-none');
        });

        mdTagLinks.on('click', '[data-toggle="tag_keyword_close"]', function(e) {
            e.preventDefault();

            let item = $('[data-item="' + $(this).data('id') + '"]', mdTagLinks);
            $('.show-keywords', item).removeClass('d-none');
            $('.edit-keywords', item).addClass('d-none');
        });

        mdTagLinks.on('click', '[data-toggle="keyword_change"]', function(e) {
            e.preventDefault();
            let btn = $(this);
            let icon = $('i', btn);
            if (icon.is('.fa-spinner')) {
                return;
            }
            let item = $('[data-item="' + btn.data('id') + '"]', mdTagLinks);
            icon.removeClass(icon.data('icon')).addClass('fa-spinner fa-spin-pulse');
            $.ajax({
                type: 'POST',
                url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=' + nv_func_name + '&nocache=' + new Date().getTime(),
                data: {
                    checkss: $('body').data('checksess'),
                    id: btn.data('id'),
                    tid: btn.data('tid'),
                    keyword: $('[name="keyword"]', item).val(),
                    keywordEdit: 1
                },
                dataType: 'json',
                cache: false,
                success: function(respon) {
                    icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                    if (!respon.success) {
                        nvToast(respon.text, 'error');
                        return;
                    }

                    $('[data-toggle="badgeKeyword"]', item).removeClass('text-bg-success text-bg-warning').addClass('text-bg-success').html('<i class="fa-solid fa-check"></i> ' + respon.keyword);
                    $('.show-keywords', item).removeClass('d-none');
                    $('.edit-keywords', item).addClass('d-none');
                },
                error: function(xhr, text, err) {
                    icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                    nvToast(text, 'error');
                    console.log(xhr, text, err);
                }
            });
        });

        mdTagLinks.on('click', '[data-toggle=tags_id_check_del]', function(e) {
            e.preventDefault();

            let btn = $(this);
            let icon = $('i', btn);
            if (icon.is('.fa-spinner')) {
                return;
            }

            let listid = [];
            $('[data-toggle="checkSingle"][data-type="link"]:checked').each(function() {
                listid.push($(this).val());
            });
            if (listid.length < 1)  {
                nvAlert(nv_please_check);
                return;
            }
            listid = listid.join(',');
            nvConfirm(nv_is_del_confirm[0], () => {
                icon.removeClass(icon.data('icon')).addClass('fa-spinner fa-spin-pulse');
                $.ajax({
                    type: 'POST',
                    url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=' + nv_func_name + '&nocache=' + new Date().getTime(),
                    data: {
                        checkss: $('body').data('checksess'),
                        tagsIdDel: 1,
                        ids: listid,
                        tid: btn.data('tid')
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
    }
});
