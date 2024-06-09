<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2023 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_MAINFILE')) {
    exit('Stop!!!');
}

// FIXME xóa plugin sau khi dev xong giao diện admin_future
nv_add_hook($module_name, 'get_global_admin_theme', $priority, function ($vars) {
    $admin_theme = $vars[0];
    $module_name = $vars[1];
    $module_info = $vars[2];
    $op = $vars[3];

    if (defined('NV_ADMIN') and $module_name == 'siteinfo' and in_array($op, ['main', 'widget'])) {
        $admin_theme = 'admin_future';
    }

    return $admin_theme;
});
