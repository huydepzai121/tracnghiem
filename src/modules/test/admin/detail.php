<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2015 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Tue, 02 Jun 2015 07:53:31 GMT
 */
if (!defined('NV_IS_FILE_ADMIN')) die('Stop!!!');

global $nv_Lang;

if ($nv_Request->isset_request('view_content', 'post,get')) {
    $id = $nv_Request->get_int('id', 'post,get', 0);
    $bank = $nv_Request->get_int('bank', 'post,get', 0);
    $content = nv_review_questions($bank, $id, "view_content",  true);
    die($content);
}

if ($nv_Request->isset_request('toword', 'post,get')) {
    $id = $nv_Request->get_int('id', 'post,get', 0);
    $title = $db->query('SELECT title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams WHERE id=' . $id)->fetchColumn();
    if ($title) {
        $title = change_alias($title);
        $content = nv_review_questions($bank, $id, true, true);
        nv_test_htmltoword($title, $content);
    }
}

$id = $nv_Request->get_int('id', 'post,get', 0);

$array_topic_module = array();
$array_topic_module[0] = $nv_Lang->getModule('topic_sl');
$db->sqlreset()
    ->select('topicid, title')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_topics');
$result = $db->query($db->sql());
while (list ($topicid_i, $title_i) = $result->fetch(3)) {
    $array_topic_module[$topicid_i] = $title_i;
}

$rows = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams WHERE id =' . $id)->fetch();
$rows['type'] = $array_exam_type[$rows['type']];
$rows['catid'] = $array_test_cat[$rows['catid']]['title'];
$rows['topicid'] = $array_topic_module[$rows['topicid']];

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);
$xtpl->assign('ROW', $rows);
$xtpl->assign('BACK_LINK', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=exams');
$xtpl->assign('EDIT_LINK', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=exams-content&id=' . $id);

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $nv_Lang->getModule('exams');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';