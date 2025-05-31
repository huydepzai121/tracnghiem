<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 3-6-2010 0:14
 */
if (!defined('NV_IS_MOD_TEST')) {
    die('Stop!!!');
}
$page_title = $nv_Lang->getModule('examinations');
$page = (isset($array_op[1]) and substr($array_op[1], 0, 5) == 'page-') ? intval(substr($array_op[1], 5)) : 1;
$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
$db->sqlreset()
    ->select('COUNT(*)')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_examinations AS t1')
    ->join('INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_exam_subject AS t2 ON t1.id = t2.exam_id')
    ->group('t2.exam_id')
    ->where('t1.status=1');
$numitems = $db->query($db->sql())->fetchColumn();
$db->select('t1.*, COUNT(t2.exam_id) AS num_subject')
    ->order('begintime DESC')
    ->limit($per_page)
    ->offset(($page - 1) * $per_page);

$array_data = array();
$result = $db->query($db->sql());
while ($row = $result->fetch(2)) {
    $row['image_url'] = !empty($row['image']) ? $row['image'] : NV_BASE_SITEURL . 'themes/default/images/examination.png';
    $row['timer'] = sprintf($nv_Lang->getModule('time_begin_end'), date('d/m/Y', $row['begintime']), date('d/m/Y', $row['endtime']));
    $row['link_subject'] = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=examinations-subject/' . $row['alias'], true);
    $array_data[] = $row;
}
$generate_page = nv_alias_page($page_title, $base_url, $numitems, $per_page, $page);
$contents = nv_theme_test_examinations($array_data, $generate_page);
include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';