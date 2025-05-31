<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-9-2010 14:43
 */
if (!defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}
if ($nv_Request->isset_request('update_exam', 'post,get')) {
    $topicid = $nv_Request->get_int('topicid', 'post,get', '');
    $exam_id = $nv_Request->get_int('exam_id', 'post,get', '');
    $res = 'ERROR';
    if (!empty($topicid) && !empty($exam_id)) {
        $db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_exams SET topicid ='" . $topicid . "' WHERE id = '" . $exam_id . "'");
        $res = 'OK';
    }
    echo $res;
    exit();
}
$topicid = $nv_Request->get_int('topicid', 'get');
$topictitle = $db->query('SELECT title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_topics WHERE topicid =' . $topicid)->fetchColumn();
if (empty($topictitle)) {
    Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=topics');
    die();
}

$page_title = $nv_Lang->getModule('topic_page') . ': ' . $topictitle;

$global_array_cat = array();

$sql = 'SELECT id, alias FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat ORDER BY sort ASC';
$result = $db->query($sql);
while (list ($catid_i, $alias_i) = $result->fetch(3)) {
    $global_array_cat[$catid_i] = array(
        'alias' => $alias_i
    );
}

$sql = 'SELECT id, catid, alias, title, addtime FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams WHERE topicid=' . $topicid . ' ORDER BY addtime DESC';
$result = $db->query($sql);

$xtpl = new XTemplate('topicsnews.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
$xtpl->assign('TOPICID', $topicid);

$i = 0;
while ($row = $result->fetch()) {
    ++$i;
    $row['addtime'] = nv_date('H:i d/m/y', $row['addtime']);
    $row['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_cat[$row['catid']]['alias'] . '/' . $row['alias'] . '-' . $row['alias'] . '-' . $row['id'] . $global_config['rewrite_exturl'];
    $row['delete'] = '';
    $xtpl->assign('ROW', $row);
    $xtpl->parse('main.data.loop');
}
$result->closeCursor();

if ($i) {
    $xtpl->assign('URL_DELETE', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=topicdelnews');
    $xtpl->parse('main.data');
} else {
    $xtpl->parse('main.empty');
}
$xtpl->parse('main');
$contents = $xtpl->text('main');

$set_active_op = 'topics';
include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
