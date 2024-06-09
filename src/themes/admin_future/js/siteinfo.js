/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2024 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

$(document).ready(function() {
    // Xóa gói cập nhật
    $('[data-toggle="deleteUpdPkg"]').on('click', function(e) {
        e.preventDefault();

        var $this = $(this);
        var icon = $('i', $this);
        if (icon.is('.fa-spinner')) {
            return;
        }

        nvConfirm(nv_is_del_confirm[0], () => {
            icon.removeClass(icon.data('icon')).addClass('fa-spinner fa-spin-pulse');
            $.ajax({
                type: 'POST',
                url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=webtools&' + nv_fc_variable + '=deleteupdate&nocache=' + new Date().getTime(),
                data: {
                    'checksess': $this.data('checksess')
                },
                dataType: 'json',
                success: function(data) {
                    icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                    if (data.success) {
                        var ctn = $('#notice-update-package');
                        ctn.css('overflow', 'hidden');
                        ctn.slideUp('200', function() {
                            ctn.remove();
                        });
                        return;
                    }
                    nvAlert(data.error.join('<br />'));
                },
                error: function(xhr, text, err) {
                    console.log(xhr, text, err);
                    nvToast(text, 'error');
                    icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                }
            });
        });
    });

    // Xử lý thứ tự khi mở ropdown sửa widget
    $('[data-toggle="widgetSize"]').on('show.bs.dropdown', event => {
        const wId = event.target.dataset.widget;
        const widget = document.getElementById(wId);
        widget.style.zIndex = 1;
    });
    $('[data-toggle="widgetSize"]').on('hide.bs.dropdown', event => {
        const wId = event.target.dataset.widget;
        const widget = document.getElementById(wId);
        widget.style.removeProperty('z-index');
    });

    const widgetCtn = $('.widget-containers');

    // Thêm khối widget ở trên cùng hoặc dưới cùng
    $('[data-toggle="widgetParentAdd"]').on('click', function(e) {
        e.preventDefault();
        let $this = $(this);
        let icon = $('i', $this);
        if (widgetCtn.data('busy')) {
            return;
        }
        icon.removeClass(icon.data('icon')).addClass('fa-spinner fa-spin-pulse');
        widgetCtn.data('busy', 1);
        $.ajax({
            type: 'POST',
            url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=widget&nocache=' + new Date().getTime(),
            data: {
                'addparent': $('body').data('checksess'),
                'placement': $this.data('placement')
            },
            dataType: 'json',
            success: function(data) {
                icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                widgetCtn.data('busy', 0);
                if (data.error) {
                    nvToast(data.message, 'error');
                    return;
                }
                location.reload();
            },
            error: function(xhr, text, err) {
                icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                widgetCtn.data('busy', 0);
                nvToast(text, 'error');
                console.log(xhr, text, err);
            }
        });
    });

    // Xóa widget
    $(document).delegate('[data-toggle="widgetDelete"]', 'click', function(e) {
        e.preventDefault();
        let $this = $(this);
        if (widgetCtn.data('busy')) {
            return;
        }
        widgetCtn.data('busy', 1);
        $this.addClass('fa-spin');
        $.ajax({
            type: 'POST',
            url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=widget&nocache=' + new Date().getTime(),
            data: {
                'delete': $('body').data('checksess'),
                'widget_id': $this.data('id'),
                'widget_parentid': $this.data('parent-id')
            },
            dataType: 'json',
            success: function(data) {
                $this.removeClass('fa-spin');
                widgetCtn.data('busy', 0);
                if (data.error) {
                    nvToast(data.message, 'error');
                    return;
                }
                location.reload();
            },
            error: function(xhr, text, err) {
                $this.removeClass('fa-spin');
                widgetCtn.data('busy', 0);
                nvToast(text, 'error');
                console.log(xhr, text, err);
            }
        });
    });

    // Thêm khối con
    $(document).delegate('[data-toggle="widgetAddChild"]', 'click', function(e) {
        e.preventDefault();
        let $this = $(this);
        if (widgetCtn.data('busy')) {
            return;
        }
        widgetCtn.data('busy', 1);
        $this.addClass('fa-spin');
        $.ajax({
            type: 'POST',
            url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=widget&nocache=' + new Date().getTime(),
            data: {
                'addchild': $('body').data('checksess'),
                'widget_id': $this.data('id'),
                'placement': $this.data('placement')
            },
            dataType: 'json',
            success: function(data) {
                $this.removeClass('fa-spin');
                widgetCtn.data('busy', 0);
                if (data.error) {
                    nvToast(data.message, 'error');
                    return;
                }
                location.reload();
            },
            error: function(xhr, text, err) {
                $this.removeClass('fa-spin');
                widgetCtn.data('busy', 0);
                nvToast(text, 'error');
                console.log(xhr, text, err);
            }
        });
    });

    // Chỉnh kích thước khối
    $(document).delegate('[data-toggle="widgetResize"]', 'change', function() {
        let $this = $(this);
        if (widgetCtn.data('busy')) {
            return;
        }
        widgetCtn.data('busy', 1);
        $('[data-toggle="widgetResize"]').prop('disabled', true);
        $.ajax({
            type: 'POST',
            url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=widget&nocache=' + new Date().getTime(),
            data: {
                'resize': $('body').data('checksess'),
                'widget_id': $this.data('id'),
                'widget_parentid': $this.data('parent-id'),
                'breakpoint': $this.data('breakpoint'),
                'value': $this.val()
            },
            dataType: 'json',
            success: function(data) {
                $('[data-toggle="widgetResize"]').prop('disabled', false);
                widgetCtn.data('busy', 0);
                if (data.error) {
                    nvToast(data.message, 'error');
                    return;
                }
                let id;
                if ($this.data('parent-id') < 0) {
                    id = 'widget_' + $this.data('id');
                } else {
                    id = 'widget_' + $this.data('parent-id') + '_sub' + $this.data('id');
                }
                let ctn = $('#' + id).parent();
                ctn.attr('class', data.sizes + ' ' + ctn.data('append-class'));
            },
            error: function(xhr, text, err) {
                $('[data-toggle="widgetResize"]').prop('disabled', false);
                widgetCtn.data('busy', 0);
                nvToast(text, 'error');
                console.log(xhr, text, err);
            }
        });
    });

    // Chọn hoặc đổi widget
    var mdChooseWidget = $('#mdChooseWidget'), mdChooseWidgetBs;
    if (mdChooseWidget.length) {
        mdChooseWidgetBs = bootstrap.Modal.getOrCreateInstance('#mdChooseWidget');
        mdChooseWidget[0].addEventListener('hidden.bs.modal', () => {
            $('.loader', mdChooseWidget).removeClass('d-none');
            $('.content', mdChooseWidget).html('');
        });
        mdChooseWidget[0].addEventListener('shown.bs.modal', () => {
            $.ajax({
                type: 'POST',
                url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&nocache=' + new Date().getTime(),
                data: {
                    'load_list_widgets': 1
                },
                success: function(data) {
                    $('.loader', mdChooseWidget).addClass('d-none');
                    $('.content', mdChooseWidget).html(data);
                },
                error: function(xhr, text, err) {
                    nvToast(text, 'error');
                    console.log(xhr, text, err);
                }
            });
        });
    }
    $(document).delegate('[data-toggle="widgetChoose"]', 'click', function(e) {
        e.preventDefault();
        let $this = $(this);

        mdChooseWidget.data('widget-id', $this.data('id'));
        mdChooseWidget.data('parent-id', $this.data('parent-id'));

        mdChooseWidgetBs.show();
    });
    $(document).delegate('[data-toggle="setWidget"]', 'click', function(e) {
        e.preventDefault();
        let $this = $(this);
        let icon = $('i', $this);
        if (widgetCtn.data('busy')) {
            return;
        }
        widgetCtn.data('busy', 1);
        icon.removeClass(icon.data('icon')).addClass('fa-spinner fa-spin-pulse');
        $.ajax({
            type: 'POST',
            url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=widget&nocache=' + new Date().getTime(),
            data: {
                'setwidget': $('body').data('checksess'),
                'widget_id': mdChooseWidget.data('widget-id'),
                'widget_parentid': mdChooseWidget.data('parent-id'),
                'id': $this.data('widget-id')
            },
            dataType: 'json',
            success: function(data) {
                icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                widgetCtn.data('busy', 0);
                if (data.error) {
                    nvToast(data.message, 'error');
                    return;
                }
                location.reload();
            },
            error: function(xhr, text, err) {
                icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
                widgetCtn.data('busy', 0);
                nvToast(text, 'error');
                console.log(xhr, text, err);
            }
        });
    });

    // Sắp xếp widget
    if ($('.widget-edit-drop').length > 0) {
        let widgetDrag, widgetRevert;
        $('.widget').draggable({
            revert: () => {
                return widgetRevert;
            },
            revertDuration: 0,
            opacity: 0.8,
            containment: '.main-content',
            cursor: 'move',
            distance: 15,
            zIndex: 10,
            start: (event) => {
                widgetRevert = true;
                widgetDrag = $(event.target).parent();
            }
        });

        function initDroppable() {
            $('.widget-edit-drop').droppable({
                drop: event => {
                    var target = $(event.target);
                    if (target.data('parent-id') == widgetDrag.data('parent-id') && target.data('id') == widgetDrag.data('id')) {
                        return;
                    }

                    let card1 = $('>.card', widgetDrag);
                    let card2 = $('>.card', target);
                    if (card1.length) {
                        card1.detach().prependTo(target);
                    }
                    if (card2.length) {
                        card2.detach().prependTo(widgetDrag);
                    }
                    $('.widget-edit-drop').droppable('destroy');
                    setTimeout(() => {
                        // Bug khi widget-edit-drop giảm height thì lần sau nó không bắt hover nên destroy rồi tạo lại
                        initDroppable();
                    }, 50);

                    $.ajax({
                        type: 'POST',
                        url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=widget&nocache=' + new Date().getTime(),
                        data: {
                            'swapwidget': $('body').data('checksess'),
                            'widget_id1': target.data('id'),
                            'widget_parentid1': target.data('parent-id'),
                            'widget_id2': widgetDrag.data('id'),
                            'widget_parentid2': widgetDrag.data('parent-id')
                        },
                        dataType: 'json',
                        success: function(data) {
                            if (data.error) {
                                nvToast(data.message, 'error');
                                return;
                            }
                            nvToast(data.message, 'success');
                        },
                        error: function(xhr, text, err) {
                            nvToast(text, 'error');
                            console.log(xhr, text, err);
                        }
                    });
                },
                classes: {
                    'ui-droppable-active': 'active',
                    'ui-droppable-hover': 'hover'
                },
            });
        }
        initDroppable();
    }
});
