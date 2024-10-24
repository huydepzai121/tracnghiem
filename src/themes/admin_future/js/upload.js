/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2024 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

$(function() {
    // Giải thích các chức năng kiểm tra file tải lên
    $('[name=upload_checking_mode]').on('change', function() {
        var val = $(this).val();
        $(this).parent().find('[data-toggle="note"]').text($(this).find('option[value=' + val + ']').data('description'));
    });
});
