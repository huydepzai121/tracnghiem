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
});
