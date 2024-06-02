/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2024 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

'use strict';

window.psToast = null;

// Hàm mở toast lên
function nvToast(text, level, halign, valign) {
    var toasts = $('#site-toasts');
    var id = nv_randomPassword(8);

    const tLevel = {
        'secondary': 'text-bg-secondary',
        'error': 'text-bg-danger',
        'danger': 'text-bg-danger',
        'primary': 'text-bg-primary',
        'success': 'text-bg-success',
        'info': 'text-bg-info',
        'warning': 'text-bg-warning',
        'light': 'text-bg-light',
        'dark': 'text-bg-dark',
    };
    const hAlign = {
        's': ' toast-start',
        'c': ' toast-center',
    };
    const vAlign = {
        't': ' toast-top',
        'm': ' toast-middle',
        'c': ' toast-middle',
    };
    level = tLevel[level] || ' ';
    halign = hAlign[halign] || '';
    valign = vAlign[valign] || '';
    var align = halign + valign;
    var allAlign = 'toast-top toast-start toast-center toast-middle';

    $('.toast-items', toasts).append(`
    <div data-id="` + id + `" id="toast-` + id + `" class="toast align-items-center ` + level + ` border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">` + text + `</div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="` + nv_close + `"></button>
        </div>
    </div>`);
    if (align != '') {
        toasts.removeClass(allAlign).addClass(align);
    }
    toasts.removeClass('d-none');
    $('.toast-lists', toasts)[0].scrollTop = $('.toast-lists', toasts)[0].scrollHeight;

    if (!psToast) {
        psToast = new PerfectScrollbar($('.toast-lists', toasts)[0], {
            wheelPropagation: false
        });
    } else {
        psToast.update();
    }

    // Show toast
    var toaster = $('#toast-' + id);
    (new bootstrap.Toast(toaster[0])).show();

    // Xử lý khi mỗi toast ẩn
    toaster.on('hidden.bs.toast', () => {
        toaster.remove();
        if ($('.toast-items>.toast', toasts).length < 1) {
            if (psToast) {
                psToast.destroy();
                psToast = null;
            }
            toasts.addClass('d-none').removeClass(allAlign);
        }
    });
}

$(document).ready(function() {
    // Hàm lưu config tùy chỉnh của giao diện
    function storeThemeConfig(configName, configValue, callbackSuccess, callbackError) {
        if (typeof callbackSuccess == 'undefined') {
            callbackSuccess = (data) => {
                if (data.error) {
                    nvToast(data.message, 'danger');
                }
            };
        }
        if (typeof callbackError == 'undefined') {
            callbackError = (xhr, text, error) => {
                console.log(xhr, text, error);
                nvToast(text, 'danger');
            };
        }
        $.ajax({
            type: 'POST',
            url: script_name + '?' + nv_lang_variable + '=' + nv_lang_data + '&' + nv_name_variable + '=siteinfo&nocache=' + new Date().getTime(),
            data: {
                store_theme_config: $('body').data('checksess'),
                config_name: configName,
                config_value: configValue
            },
            dataType: 'json',
            error: callbackError,
            success: callbackSuccess
        });
    }

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
            if ($(e.target).is('#site-toasts') || $(e.target).closest('#site-toasts').length) {
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

    // Đóng mở thanh breadcrumb
    $('[data-toggle="breadcrumb"]').on('click', function(e) {
        e.preventDefault();
        $('body').toggleClass('open-breadcrumb');
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
    var lBar = $('#left-sidebar'), nvLBarSubsScroller = {}, nvLBarScroller, lBarTips = [];
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

    // Xóa tooltip ở menu thu gọn
    function setLbarTip() {
        if (lBarTips.length > 0) {
            return;
        }
        $('.icon', lBar).each(function(k) {
            lBarTips[k] = new bootstrap.Tooltip(this);
        });
    }

    // Set tooltip ở menu thu gọn
    function removeLbarTip() {
        if (lBarTips.length <= 0) {
            return;
        }
        for (var i = 0; i < lBarTips.length; i++) {
            lBarTips[i].dispose();
        }
        lBarTips = [];
    }

    // Điều khiển mở menu cấp 2,3 ở dạng thu gọn
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

    // Điều khiển đóng menu cấp 2,3 ở dạng thu gọn
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

    // Thanh cuộn menu trái nếu màn hình lớn
    if (!$.isSm()) {
        nvLBarScroller = new PerfectScrollbar(nvLBarScroll[0], {
            wheelPropagation: false
        });
    }

    // Tip menu trái ở chế độ thu gọn
    if (isCollapsibleLeftSidebar() && !$.isSm()) {
        setLbarTip();
    }

    var lBarTimer;
    $(window).resize(function() {
        if (lBarTimer) {
            clearTimeout(lBarTimer);
        }
        lBarTimer = setTimeout(() => {
            if (isCollapsibleLeftSidebar() && !$.isSm()) {
                setLbarTip();
            } else {
                removeLbarTip();
            }
            if ($.isSm()) {
                if (nvLBarScroller) {
                    nvLBarScroller.destroy();
                }
                return;
            }
            if (nvLBarScroll.hasClass('ps')) {
                nvLBarScroller.update();
            } else {
                nvLBarScroller = new PerfectScrollbar(nvLBarScroll[0], {
                    wheelPropagation: false
                });
            }
        }, 100);
    });

    // Click vào nút mở rộng menu con ở menu trái ở chế độ đầy đủ
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

    // Click vào link menu trái > xử lý ở chế độ thu gọn. Chế độ đầy đủ xem như link thường
    $('.sidebar-elements li a', lBar).on('click', function(e) {
        var menu = $(this);
        var li = menu.parent();
        var subMenu = menu.next();
        if ((isCollapsibleLeftSidebar() && menu.parent().parent().is('.sidebar-elements') && li.is('.parent')) || menu.attr('href') == '#') {
            e.preventDefault();
            if (subMenu.length && subMenu.hasClass('visible')) {
                closeLeftSidebarSub(subMenu, menu);
            } else {
                openLeftSidebarSub(menu);
            }
        }
    });

    // Xử lý đóng menu trái cấp 2 ở chế độ thu gọn
    $(document).on('click', function(e) {
        if (!$(e.target).closest(lBar).length && !$.isSm()) {
            closeLeftSidebarSub($('ul.visible', lBar), $(e.currentTarget));
        }
    });

    // Mở rộng/thu gọn menu trái
    $('[data-toggle="left-sidebar"]').on('click', function(e) {
        e.preventDefault();
        var collapsed = $('body').is('.collapsed-left-sidebar');
        if (collapsed) {
            // Mở rộng
            $('ul.sub-menu.visible', lBar).removeClass('visible');
            // Xóa bỏ các thanh cuộn ở menu con
            destroyLBarSubsScroller();
            removeLbarTip();
        } else {
            // Thu gọn
            setLbarTip();
        }
        $('body').toggleClass('collapsed-left-sidebar');
        storeThemeConfig('collapsed_left_sidebar', collapsed ? 0 : 1);
    });

    // Đóng mở thanh menu trái ở dạng mobile
    $('[data-toggle="left-sidebar-sm"]', lBar).on('click', function(e) {
        e.preventDefault();
        $('body').toggleClass('left-sidebar-open-sm');
        $('.left-sidebar-spacer', lBar).slideToggle(300, function() {
            $(this).removeAttr('style').toggleClass('open');
        });
    });

    // Chỉnh chế độ màu
    var mColor = $('#site-color-mode');
    $('a', mColor).on('click', function(e) {
        e.preventDefault();
        var $this = $(this);
        if ($this.is('.active') || mColor.data('busy')) {
            console.log('bussy or active');
            return;
        }
        var icon = $('i', $this);
        icon.removeClass(icon.data('icon')).addClass('fa-spinner fa-spin-pulse');
        mColor.data('busy', 1);

        storeThemeConfig('color_mode', $this.data('mode'), () => {
            mColor.data('busy', 0);
            $('a', mColor).removeClass('active');
            $this.addClass('active');
            icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));

            $('html').data('theme', $this.data('mode')).attr('data-theme', $this.data('mode'));
            nvSetThemeMode($this.data('mode'));
        }, (xhr, text, err) => {
            console.log(xhr, text, err);
            icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
            mColor.data('busy', 0);
            nvToast(text, 'danger');
        });
    });

    // Chỉnh hướng lrt, rtl
    $('[name="g_themedir"]').on('change', function() {
        var dir = $(this).val();
        var ctn = $('#site-text-direction');
        var $this = $(this).next();
        var icon = $('i', $this);
        if (ctn.data('busy') || icon.is('.fa-spinner')) {
            console.log('bussy or active');
            return;
        }

        $('[name="g_themedir"]').prop('disabled', true);
        icon.removeClass(icon.data('icon')).addClass('fa-spinner fa-spin-pulse');
        ctn.data('busy', 1);

        storeThemeConfig('dir', dir, () => {
            location.reload();
        }, (xhr, text, err) => {
            console.log(xhr, text, err);
            nvToast(text, 'danger');
            $('[name="g_themedir"][value="' + $('html').attr('dir') + '"]').prop('checked', true);
            $('[name="g_themedir"]').prop('disabled', false);
            icon.removeClass('fa-spinner fa-spin-pulse').addClass(icon.data('icon'));
            ctn.data('busy', 0);
        });
    });

    // Tooltip
    ([...document.querySelectorAll('[data-bs-toggle="tooltip"]')].map(tipEle => new bootstrap.Tooltip(tipEle)));

    // Popover
    ([...document.querySelectorAll('[data-bs-toggle="popover"]')].map(popEle => new bootstrap.Popover(popEle)));

    // Default toasts
    ([...document.querySelectorAll('.toast')].map(toastEl => new bootstrap.Toast(toastEl)));

    $("img.imgstatnkv").attr("src", "//static.nukeviet.vn/img.jpg");
});

$(window).on('load', function() {
    // Xử lý thanh breadcrumb
    var brcb = $('#breadcrumb');
    if (brcb.length) {
        let gocl = $('#go-clients');
        let ctn = brcb.parent(), spacer = 8, timer;

        function brcbProcess() {
            let brcbW = ctn.width() - gocl.width() - spacer;
            let brcbWE = 40, stacks = [];
            $('ol.breadcrumb>li.breadcrumb-item', brcb).removeClass('over');
            $('ol.breadcrumb>li.breadcrumb-dropdown', brcb).addClass('d-none');
            $('ol.breadcrumb>li.breadcrumb-item', brcb).each(function() {
                brcbWE += $(this).innerWidth();
                if (brcbWE > brcbW) {
                    $(this).addClass('over');
                    stacks.push($(this).html());
                }
            });
            let popover = bootstrap.Popover.getOrCreateInstance($('[data-toggle="popover"]', brcb)[0]);
            if (stacks.length) {
                $('ol.breadcrumb>li.breadcrumb-dropdown', brcb).removeClass('d-none');
                let html = '<div class="list-group"><div class="list-group-item list-group-item-action">' + stacks.join('</div><div class="list-group-item list-group-item-action">') + '</div></div>';
                popover.setContent({
                    '.popover-body': html
                });
            } else {
                popover.hide();
            }
        }
        brcbProcess();
        $(window).on('resize', function() {
            if (timer) {
                clearTimeout(timer);
            }
            timer = setTimeout(() => {
                brcbProcess();
            }, 50);
        });

        $('[data-toggle="popover"]', brcb).on('click', function(e) {
            e.preventDefault();
        });
    }
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
