<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-10-2010 18:49
 */
if (!defined('NV_IS_FILE_ADMIN')) die('Stop!!!');

global $nv_Lang;

$catid = $nv_Request->get_int('catid', 'post', 0);
$mod = $nv_Request->get_string('mod', 'post', '');
$new_vid = $nv_Request->get_int('new_vid', 'post', 0);
$content = 'NO_' . $catid;

list ($catid, $parentid, $numsubcat) = $db->query('SELECT id, parentid, numsub FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat WHERE id=' . $catid)->fetch(3);
if ($catid > 0) {
    if ($mod == 'inhome' and ($new_vid == 0 or $new_vid == 1)) {
        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_cat SET inhome=' . $new_vid . ' WHERE id=' . $catid;
        $db->query($sql);
        $content = 'OK_' . $parentid;
    } elseif ($mod == 'viewtype' and $nv_Request->isset_request('new_vid', 'post')) {
        $viewtype = $nv_Request->get_title('new_vid', 'post');
        $stmt = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_cat SET viewtype= :viewtype WHERE id=' . $catid);
        $stmt->bindParam(':viewtype', $viewtype, PDO::PARAM_INT);
        $stmt->execute();
        $content = 'OK_' . $parentid;
    } elseif ($mod == 'numlinks' and $new_vid >= 0 and $new_vid <= 20) {
        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_cat SET numlinks=' . $new_vid . ' WHERE id=' . $catid;
        $db->query($sql);
        $content = 'OK_' . $parentid;
    } elseif ($mod == 'topscore') {
        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_cat SET topscore=' . $new_vid . ' WHERE id=' . $catid;
        $db->query($sql);
        $content = 'OK_' . $parentid;
    } elseif ($mod == 'newday' and $new_vid >= 0 and $new_vid <= 20) {
        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_cat SET newday=' . $new_vid . ' WHERE id=' . $catid;
        $db->query($sql);
        $content = 'OK_' . $parentid;
    }
    $nv_Cache->delMod($module_name);
}

include NV_ROOTDIR . '/includes/header.php';
echo $content;
include NV_ROOTDIR . '/includes/footer.php';