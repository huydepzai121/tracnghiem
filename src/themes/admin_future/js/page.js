/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

'use strict';

$(function () {
    // Ẩn hiện schema about tuỳ thuộc vào schema type
    $('#schema_type').on('change', function () {
        var schemaType = $(this).val();
        if (schemaType === 'webpage') {
            $('#schema_about_container').removeClass('d-none');
        } else {
            $('#schema_about_container').addClass('d-none');
        }
    });
});
