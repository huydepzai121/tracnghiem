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

$array['id'] = $nv_Request->get_int('id', 'get,post', 0);
$array['area'] = $nv_Request->get_int('area', 'get,post', 0);

if ($array['id'] > 0) {
    $array = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams WHERE id=' . $array['id'])->fetch();
    if (!empty($array['id'])) {
        nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_test_cat[$array['catid']]['alias'] . '/' . $array['alias'] . '-' . $array['id'] . $global_config['rewrite_exturl']);
    } else {
        nv_info_die($nv_Lang->getGlobal('error_404_title'), $nv_Lang->getGlobal('error_404_title'), $nv_Lang->getGlobal('error_404_content'), 404);
    }
}
