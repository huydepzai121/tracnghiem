<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

$vid = $nv_Request->get_int('vid', 'post', 0);

if ($vid > 0) {
    $row = $db->query('SELECT act FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE vid=' . $vid)->fetch();
    if (!empty($row)) {
        $act_vid = $row['act'] ? 0 : 1;
        $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . ' SET act=' . $act_vid . ' WHERE vid=' . $vid);
        $nv_Cache->delMod('modules');
        nv_jsonOutput([
            'success' => 1,
            'text' => 'Success!'
        ]);
    }
}

nv_jsonOutput([
    'success' => 0,
    'text' => 'Wrong data!'
]);
