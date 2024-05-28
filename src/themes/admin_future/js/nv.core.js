/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2024 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

$(document).ready(function() {
    // Đếm ngược phiên đăng nhập của quản trị
    if ($('#countdown').length) {
        var countdown = $('#countdown'),
            distance = parseInt(countdown.data('duration')),
            countdownObj = setInterval(function() {
                distance = distance - 1000;

                var hours = Math.floor(distance / (1000 * 60 * 60)),
                    minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)),
                    seconds = Math.floor((distance % (1000 * 60)) / 1000);
                if (minutes < 10) {
                    minutes = '0' + minutes
                };
                if (seconds < 10) {
                    seconds = '0' + seconds
                };
                countdown.text(hours + ':' + minutes + ':' + seconds)

                if (distance <= 0) {
                    clearInterval(countdownObj);
                    window.location.reload()
                }
            }, 1000);
    };

    // Quản trị thoát
    $('[data-toggle="admin-logout"]').on('click', function(e) {
        e.preventDefault();
        nv_admin_logout();
    });

    // Đóng mở thanh menu phải
    $('[data-toggle="right-sidebar"]').on('click', function(e) {
        e.preventDefault();
        $('body').toggleClass('open-right-sidebar');
    });

    // Đóng mở thanh menu trái
    $('[data-toggle="left-sidebar"]').on('click', function(e) {
        e.preventDefault();
        $('body').toggleClass('collapsed-left-sidebar');

        var collapsed = $('body').is('.collapsed-left-sidebar');
        $.ajax({
            type: 'POST',
            url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=siteinfo&nocache=' + new Date().getTime(),
            data: {
                'collapsed_left_sidebar': collapsed
            },
            success: function(data) {
            },
            error: function(jqXHR, exception) {
                console.log(jqXHR, exception);
            }
        });
    });

    $("img.imgstatnkv").attr("src", "//static.nukeviet.vn/img.jpg");
});
