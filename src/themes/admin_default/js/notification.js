/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

// Giá trị này = 0 thì tạm dừng kiểm tra số thông báo
var load_notification = 1;

$(document).ready(function() {
    function nv_get_notification(timestamp) {
        if (load_notification) {
            $.ajax({
                type: 'POST',
                url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=siteinfo&' + nv_fc_variable + '=notification&nocache=' + new Date().getTime(),
                data: {
                    'notification_get': 1,
                    'timestamp': timestamp
                },
                success: function(data) {
                    if (data.data_from_file > 0) {
                        $('#notification').show().html(data.data_from_file);
                    } else {
                        $('#notification').hide();
                    }
                    // Load mỗi 30s một lần
                    setTimeout(function() {
                        nv_get_notification(0);
                    }, 30000);
                },
                cache: false
            });
        }
    }

    // Lấy và hiển thị số thông báo chưa đọc
    setTimeout(() => {
        nv_get_notification(0);
    }, 1000);

    // Load thêm thông báo khi cuộn xuống
    var last_id = 0;
    $('#notification_load').scroll(function() {
        if ($(this).scrollTop() + $(this).innerHeight() >= this.scrollHeight) {
            last_id = 0;

            // Tìm id thông báo cuối cùng
            var lNoti = $('#notification_load .notify_item:last');
            if (lNoti.length == 1) {
                last_id = $('.body-noti', lNoti).data('id');
            }

            $('#notification_waiting').show();
            $.get(script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=siteinfo&' + nv_fc_variable + '=notification&ajax=1&last_id=' + last_id + '&nocache=' + new Date().getTime(), function(result) {
                $('#notification_load').append(result);
                $('#notification_waiting').hide();
            });
        }
    });

    // Ấn nút mở thông báo ra
    $('#notification-area').on('show.bs.dropdown', function() {
        last_id = 0;
        $('#notification_load').html('');
        $('#notification_waiting').show();

        $.get(script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=siteinfo&' + nv_fc_variable + '=notification&ajax=1&nocache=' + new Date().getTime(), function(result) {
            $('#notification_load').html(result).slimScroll({
                height: '250px'
            });
            $("abbr.timeago").timeago();
            $('#notification_waiting').hide();
        });
    });

    // Xóa thông báo
    $('.notify_item .ntf-delete').click(function(e) {
        e.preventDefault();
        var $this = $(this);
        $.ajax({
            type: 'POST',
            url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=siteinfo&' + nv_fc_variable + '=notification&nocache=' + new Date().getTime(),
            data: 'delete=1&id=' + $this.data('id'),
            success: function(data) {
                if (data == 'OK') {
                    window.location.href = window.location.href;
                } else {
                    alert(nv_is_change_act_confirm[2]);
                }
            }
        });
    });

    function deleteNoti(target) {
        $.ajax({
            type: 'POST',
            url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=siteinfo&' + nv_fc_variable + '=notification&nocache=' + new Date().getTime(),
            data: 'delete=1&id=' + target.data('id'),
            success: function(data) {
                if (data != 'OK') {
                    alert(nv_is_del_confirm[2]);
                    return;
                }
                target.parent().parent().remove();
            }
        });
    }

    function toggleNoti(target) {
        $.ajax({
            type: 'POST',
            url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=siteinfo&' + nv_fc_variable + '=notification&nocache=' + new Date().getTime(),
            data: 'toggle=1&id=' + target.data('id'),
            success: function(data) {
                if (data == 'ERROR') {
                    alert(nv_is_change_act_confirm[2]);
                    return;
                }
                var eleBody = $('.body-noti', target.parent().parent());
                if (data == '1') {
                    // Đang là đã đọc > đánh dấu chưa đọc
                    $('.fa', target).removeClass('fa-eye-slash fa-eye').addClass('fa-eye-slash');
                    target.attr('title', target.data('msg-unread'));
                    eleBody.addClass('noti-read');
                } else {
                    // Đang là chưa đọc > đánh dấu đã đọc
                    $('.fa', target).removeClass('fa-eye-slash fa-eye').addClass('fa-eye');
                    target.attr('title', target.data('msg-read'));
                    eleBody.removeClass('noti-read');
                }
            }
        });
    }

    // Chặn đóng dropdown khi ấn bên trong nó và xử các tác vụ liên quan
    $('#notification-area .dropdown-menu').on('click', function(e) {
        e.stopPropagation();
        var target = $(e.target);
        if (target.is('.fa')) {
            target = target.parent();
        }

        // Đánh dấu đã đọc, chưa đọc
        if (target.is('[data-toggle="notitoggle"]')) {
            e.preventDefault();
            toggleNoti(target);
            return;
        }

        // Xóa thông báo
        if (target.is('[data-toggle="notidelete"]')) {
            e.preventDefault();
            deleteNoti(target);
            return;
        }

        // Đánh dấu đọc tất cả
        if (target.is('[data-toggle="markallnoti"]')) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=siteinfo&' + nv_fc_variable + '=notification&nocache=' + new Date().getTime(),
                data: 'notification_reset=1',
                success: function() {
                    $('#notification-area>a').trigger('click');
                    $('#notification').hide();
                }
            });
            return;
        }

        // Click vào thông báo
        if (!target.is('.body-noti')) {
            target = target.closest('.body-noti');
        }
        if (target.length == 1) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=siteinfo&' + nv_fc_variable + '=notification&nocache=' + new Date().getTime(),
                data: 'toggle=1&direct_view=1&id=' + target.data('id'),
                success: function() {
                    var btn = $('.ntf-toggle', target.parent());
                    $('.fa', btn).removeClass('fa-eye-slash fa-eye').addClass('fa-eye-slash');
                    btn.attr('title', btn.data('msg-unread'));
                    target.addClass('noti-read');
                    window.location = target.attr('href');
                }
            });
            return;
        }
    });
});
