/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2024 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

$(function() {
    // Thêm xóa cấu hình tùy chỉnh
    $('body').on('click', '[data-toggle="addCustomCfgItem"]', function() {
        var item = $(this).closest('.item'),
            new_item = item.clone();
        $('input[type=text]', new_item).val('');
        item.after(new_item);
    });

    $('body').on('click', '[data-toggle="delCustomCfgItem"]', function() {
        var item = $(this).closest('.item'),
            list = $(this).closest('.list');
        if ($('.item', list).length > 1) {
            item.remove();
        } else {
            $('input[type=text]', item).val('');
        }
    });
});
