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
$page_title = $nv_Lang->getModule('examinations_subject');
$page = (isset($array_op[2]) and substr($array_op[2], 0, 5) == 'page-') ? intval(substr($array_op[2], 5)) : 1;
$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '/' . $array_op[1];
$db->sqlreset()
    ->select('COUNT(*)')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_exam_subject AS t1')
    ->join('INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_examinations AS t2 ON t1.exam_id=t2.id')
    ->where('t2.status=1 AND t2.alias="' . $array_op[1] . '"');
$numitems = $db->query($db->sql())->fetchColumn();
$db->select('t1.title, t1.alias AS subject_alias, t1.image, t1.begintime, t1.endtime, t1.exam_type, t1.ladder, t1.timer, t1.num_question,  t2.alias AS examinations_alias')
    ->order('t1.id ASC')
    ->limit($per_page)
    ->offset(($page - 1) * $per_page);

$array_data = array();
$result = $db->query($db->sql());
while ($row = $result->fetch(2)) {
    $row['image_url'] = !empty($row['image']) ? $row['image'] : NV_BASE_SITEURL . 'themes/default/images/examination.png';
    $row['timer_begin_end'] = sprintf($nv_Lang->getModule('time_begin_end'), date('d/m/Y', $row['begintime']), date('d/m/Y', $row['endtime']));
    $row['link_detail'] = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $row['examinations_alias'] . '/' . $row['subject_alias'], true);
    $array_data[] = $row;
}
$generate_page = nv_alias_page($page_title, $base_url, $numitems, $per_page, $page);
$contents = nv_theme_test_examinations_subject($array_data, $generate_page);
include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';