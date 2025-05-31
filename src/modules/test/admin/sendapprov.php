<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-9-2010 14:43
 */
if (!defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

$listid = $nv_Request->get_string('listid', 'get');
$id_array = array_map('intval', explode(',', $listid));

$sql = 'SELECT id, catid, status FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams WHERE id in (' . implode(',', $id_array) . ')';
$result = $db->query($sql);
while (list ($id, $catid, $status) = $result->fetch(3)) {
    $check_permission = false;
    if (defined('NV_IS_ADMIN_MODULE')) {
        $check_permission = true;
    } else {
        $check_edit = 0;
        if (isset($array_cat_admin[$admin_id][$catid])) {
            if ($array_cat_admin[$admin_id][$catid]['admin'] == 1) {
                $check_permission = true;
            } elseif ($array_cat_admin[$admin_id][$catid]['edit_content'] == 1) {
                $check_permission = true;
            }
        }
    }
    
    if ($check_permission > 0) {
        if ($status != 0) {
            $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_exams SET status=0 WHERE id =' . $id);
        }
    }
}

nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);