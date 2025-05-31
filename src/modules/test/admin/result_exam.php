<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2015 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Tue, 02 Jun 2015 07:53:31 GMT
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

$page_title = $nv_Lang->getModule('result_exam');
$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op ;

$per_page = 20;
$page = $nv_Request->get_int('page', 'post,get', 1);
$array_search = $where = array();
$array_search['q'] = $nv_Request->get_title('q', 'post,get', '');
$array_search['groupid'] = $nv_Request->get_int('groupid', 'post,get', 0);

if (!empty(($array_search['q']))) {
    $base_url .= '&amp;q=' . $array_search['q'];
}
if (!empty(($array_search['groupid']))) {
    $base_url .= '&amp;groupid=' . $array_search['groupid'];
}

$db->sqlreset()
->select('COUNT(DISTINCT exam_id)')
->from(NV_PREFIXLANG . '_' . $module_data . '_answer t1')
->join('INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_exams t2 ON t1.exam_id = t2.id');
if (!empty($array_search['q'])) {
    $where[] = '(t2.title LIKE "%'. $array_search['q'] .'%")';
}
if (!empty($array_search['groupid'])) {
    $where[] = '(FIND_IN_SET(' . $array_search['groupid'] .', groups) > 0)';
}
$db->where(implode(' AND ', $where));
$num_items = $db->query($db->sql())->fetchColumn();

$db->select('t1.exam_id, t1.begin_time, t2.title, count(t1.id) as sum, count(DISTINCT t1.userid) as sum_user, avg(score) as score')
->order('max(t1.begin_time) DESC')
->group('t1.exam_id')
->limit($per_page)
->offset(($page - 1) * $per_page);
$result = $db->query($db->sql());
$array_data = array();
$tt = ($page - 1) * $per_page;
while($row = $result->fetch()) {
    $row['tt'] = ++$tt;
    $row['score'] = number_format($row['score'],1);
    $row['begin_time'] = date('H:i d/m/Y', $row['begin_time']);
    $row['link'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=history&amp;examid=' . $row['exam_id'];
    $array_data[$row['exam_id']] = $row;
}

$generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('OP', $op);

if (!empty($array_search)) {
    $xtpl->assign('SEARCH', $array_search);
}

$array_groups = nv_test_groups_list();
foreach ($array_groups as $groupid => $title) {
    if ($groupid == 5 || $groupid == 6) continue;
    $xtpl->assign('GROUP', array(
        'index' => $groupid,
        'title' => $title,
        'selected' => ($groupid == $array_search['groupid']) ? 'selected="selected"' : ''
    ));
    $xtpl->parse('main.group');
}
foreach ($array_data as $view) {
   
    $xtpl->assign('VIEW', $view);
    $xtpl->parse('main.loop');
}

if (!empty($generate_page)) {
    $xtpl->assign('NV_GENERATE_PAGE', $generate_page);
    $xtpl->parse('main.generate_page');
}
$xtpl->parse('main');
$contents = $xtpl->text('main');
include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';