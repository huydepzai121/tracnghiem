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

    // Đóng mở thanh menu phải nếu nó có
    var rBar = $('#right-sidebar');
    if (rBar.length) {
        $('[data-toggle="right-sidebar"]').on('click', function(e) {
            e.preventDefault();
            $('body').toggleClass('open-right-sidebar');
        });
        $(document).on('click', function(e) {
            if ($(e.target).is('[data-toggle="right-sidebar"]') || $(e.target).closest('[data-toggle="right-sidebar"]').length) {
                return;
            }
            if ($(e.target).is('.right-sidebar') || $(e.target).closest('.right-sidebar').length) {
                return;
            }
            if ($('body').is('.open-right-sidebar')) {
                $('body').removeClass('open-right-sidebar');
            }
        });
        new PerfectScrollbar($('.right-sidebar-inner', rBar)[0], {
            wheelPropagation: false
        });
    }

    // Đóng mở thanh menu trái
    $('[data-toggle="left-sidebar"]').on('click', function(e) {
        e.preventDefault();
        $('body').toggleClass('collapsed-left-sidebar');

        var collapsed = $('body').is('.collapsed-left-sidebar');
        $.ajax({
            type: 'POST',
            url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=siteinfo&nocache=' + new Date().getTime(),
            data: {
                'collapsed_left_sidebar': collapsed ? 1 : 0
            },
            error: function(jqXHR, exception) {
                console.log(jqXHR, exception);
            }
        });
    });

    // Menu các module admin
    var menuSys = $('#menu-sys'), psMsys;
    $('[data-bs-toggle="dropdown"]', menuSys).on('show.bs.dropdown', function() {
        if (psMsys) {
            return;
        }
        psMsys = new PerfectScrollbar($('.menu-sys-inner', menuSys)[0], {
            wheelPropagation: false
        });
    });

    // Xử lý đổi ngôn ngữ
    $('[name="gsitelanginterface"]').on('change', function() {
        window.location = script_name + '?langinterface=' + $(this).val() + '&' + nv_lang_variable +  '=' + nv_lang_data;
    });
    $('[name="gsitelangdata"]').on('change', function() {
        window.location = script_name + '?langinterface=' + nv_lang_interface + '&' + nv_lang_variable +  '=' + $(this).val();
    });

    /**
     * Điều khiển menu trái
     */
    var lBar = $('#left-sidebar'), nvLBarSubsScroller = {}, nvLBarScroller;
    var nvLBarScroll = $('.left-sidebar-scroll', lBar);

    // Menu trái thu gọn hay không?
    function isCollapsibleLeftSidebar() {
        return $('body').is('.collapsed-left-sidebar');
    }

    // Xóa các thanh cuộn trong menu phụ
    function destroyLBarSubsScroller() {
        $.each(nvLBarSubsScroller, function(k) {
            nvLBarSubsScroller[k].destroy();
        });
        nvLBarSubsScroller = {};
    }

    // Cập nhật thanh cuộn chính của menu trái
    function updateLeftSidebarScrollbar() {
        if (!$.isSm()) {
            nvLBarScroller.update();
        }
    }

    // Cập nhật thanh cuộn menu con
    function updateLBarSubsScroller() {
        $.each(nvLBarSubsScroller, function(k) {
            nvLBarSubsScroller[k].update();
        });
    }

    function openLeftSidebarSub(menu) {
        var li = $(menu).parent(), // Li item
            subMenu = $(menu).next(),
            speed = 200,
            isLev1 = menu.parents().eq(1).hasClass('sidebar-elements'), // Xác định có phải menu cấp 1 không
            menuOpened = li.siblings('.open'); // Các menu cùng cấp khác đang mở

        // Đóng các menu cùng cấp đang mở
        if (menuOpened) {
            closeLeftSidebarSub($('> ul', menuOpened), menu);
        }

        if (!$.isSm() && isCollapsibleLeftSidebar() && isLev1) {
            // Mở menu dạng thu gọn
            destroyLBarSubsScroller();
            li.addClass('open');
            subMenu.addClass('visible');

            var scroller = li.find('.nv-left-sidebar-scroller');
            scroller.each(function(k, v) {
                nvLBarSubsScroller[k] = new PerfectScrollbar(v, {
                    wheelPropagation: false
                });
            });
        } else {
            // Mở menu dạng đầy đủ
            subMenu.slideDown({
                duration: speed,
                complete: function() {
                    li.addClass("open");
                    $(this).removeAttr("style");
                    updateLeftSidebarScrollbar();
                    updateLBarSubsScroller();
                }
            });
        }
    }

    function closeLeftSidebarSub(subMenu, menu) {
        var li = $(subMenu).parent(),
            subMenuOpened = $("li.open", li), // Các menu con đang mở
            notInMenu = !menu.closest(lBar).length,
            speed = 200,
            isLev1 = menu.parents().eq(1).hasClass("sidebar-elements"); // Xác định có phải menu cấp 1 không

        if (!$.isSm() && isCollapsibleLeftSidebar() && (isLev1 || notInMenu)) {
            // Đóng menu dạng thu gọn
            li.removeClass("open");
            subMenu.removeClass("visible");
            subMenuOpened.removeClass("open").removeAttr("style");
            updateLBarSubsScroller();
        } else {
            // Đóng menu dạng đầy đủ
            subMenu.slideUp({
                duration: speed,
                complete: function() {
                    li.removeClass("open");
                    $(this).removeAttr("style");
                    subMenuOpened.removeClass("open").removeAttr("style");
                    updateLeftSidebarScrollbar();
                    updateLBarSubsScroller();
                }
            });
        }

    }

    if (!$.isSm()) {
        nvLBarScroller = new PerfectScrollbar(nvLBarScroll[0], {
            wheelPropagation: false
        });
    }

    $('span.toggle', lBar).on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var menu = $(this).parent();
        var li = menu.parent();
        var subMenu = menu.next();

        if (li.hasClass('open')) {
            closeLeftSidebarSub(subMenu, menu);
        } else {
            openLeftSidebarSub(menu);
        }
    });

    $("img.imgstatnkv").attr("src", "//static.nukeviet.vn/img.jpg");
});

/*
 * Kiểm tra loại màn hình
 */
+
function(e) {
    e.isBreakpoint = function(t) {
        var i, a, o;
        switch (t) {
            case 'xs':
                o = 'd-none d-sm-block';
                break;
            case 'sm':
                o = 'd-none d-md-block';
                break;
            case 'md':
                o = 'd-none d-lg-block';
                break;
            case 'lg':
                o = 'd-none d-xl-block';
                break;
            case 'xl':
                o = 'd-none d-xxl-block'
                break;
            case 'xxl':
                o = 'd-none'
        }
        return a = (i = e('<div/>', {
            class: o
        }).appendTo('body')).is(':hidden'), i.remove(), a
    };
    e.extend(e, {
        isXs: function() {
            return e.isBreakpoint('xs')
        },
        isSm: function() {
            return e.isBreakpoint('sm')
        },
        isMd: function() {
            return e.isBreakpoint('md')
        },
        isLg: function() {
            return e.isBreakpoint('lg')
        },
        isXl: function() {
            return e.isBreakpoint('xl')
        },
        isXxl: function() {
            return e.isBreakpoint('xxl')
        }
    });
}(jQuery);
