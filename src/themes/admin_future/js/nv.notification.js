/**
 * NUKEVIET Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

$(document).ready(function() {
    var timer = 0;
    var page = 1;
    var ps = false;
    var ctn = $('#main-notifications');

    if (ctn.length != 1) {
        return;
    }

    /*
     * Query vĩnh viễn để tính số thông báo mới
     */
    function nv_get_notification() {
        if (timer) {
            clearTimeout(timer);
        }
        $.ajax({
            type: 'POST',
            url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=siteinfo&' + nv_fc_variable + '=notification&nocache=' + new Date().getTime(),
            data: {
                'notification_get': 1
            },
            success: function(data) {
                console.log(data);
                return;


                var indicator = $('#main-notifications>.icon-notifications .indicator');
                if (data.new > 0) {
                    indicator.removeClass('d-none');
                } else {
                    indicator.addClass('d-none');
                }
                $('#main-notifications>.main-notifications>li>.title .badge').html(data.total);
                timer = setTimeout("nv_get_notification()", 30000);
            },
            error: function(jqXHR, exception) {
                console.log(jqXHR, exception);
                timer = setTimeout("nv_get_notification()", 30000);
            }
        });
    }

    function notification_reset() {
        $.post(script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=siteinfo&' + nv_fc_variable + '=notification&nocache=' + new Date().getTime(), 'notification_reset=1', function(res) {
            var indicator = $('#main-notifications>.icon-notifications .indicator');
            indicator.addClass('d-none');
        });
    }

    // Xem thử có thông báo nào mới hay không
    nv_get_notification();

    // Cuộn xuống để xem nhiều thông báo hơn nữa
    ($('.noti-lists', ctn)[0]).addEventListener('ps-y-reach-end', function() {
        page++;
        $('#main-notifications .loader').show();
        $.get(script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=siteinfo&' + nv_fc_variable + '=notification&ajax=1&page=' + page + '&nocache=' + new Date().getTime(), function(result) {
            $('#main-notifications .nv-notification-scroller .content').append(result);
            $('#main-notifications .loader').hide();
            if (result != '') {
                ps.update();
                $('#main-notifications .nv-notification-scroller .content span.date').timeago();
            }
        });
    });

    // Khi ấn nút có hình cái chuông để xem thông báo
    $('#main-notifications').on('show.bs.dropdown', function() {
        if (ps) {
            ps.destroy();
            ps = false;
        }
        notification_reset();
        $('.noti-lists-inner', ctn).html('');
        //$('#main-notifications .loader').show();
        page = 1;
        $.get(script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=siteinfo&' + nv_fc_variable + '=notification&ajax=1&nocache=' + new Date().getTime(), function(result) {
            $('.noti-lists-inner', ctn).html(result);
            //$('#main-notifications .nv-notification-scroller .content span.date').timeago();

            //$('#main-notifications .loader').hide();
            ps = new PerfectScrollbar($('.noti-lists', ctn)[0], {
                wheelPropagation: false
            });
        });
    });

    /*
     * Khi nhấp vô thông báo trên header
     * Đánh dấu thông báo đó là đã đọc
     */
    $('#main-notifications .nv-notification-scroller .content').delegate('ul>li', 'click', function(e) {
        if ($(this).hasClass('notification-unread')) {
            $.ajax({
                type: 'POST',
                url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=siteinfo&' + nv_fc_variable + '=notification&nocache=' + new Date().getTime(),
                data: {
                    'setviewed': 1,
                    'id': $(this).data('id')
                },
                cache: false,
                success: function(data) {
                    // Không làm gì cả
                },
                error: function(jqXHR, exception) {
                    // Không làm gì cả
                }
            });
        }
    });
});
