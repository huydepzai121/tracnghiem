<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2017 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sat, 15 Apr 2017 07:49:06 GMT
 */
if (!defined('NV_IS_MOD_TEST')) die('Stop!!!');

if ($nv_Request->isset_request('deletesave', 'post')) {
    $id = $nv_Request->get_int('id', 'post', 0);
    $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_usersave WHERE examid=' . $id . ' AND userid=' . $user_info['userid']);
    die('OK');
}

if (!defined('NV_IS_USER')) {
    Header('Location: ' . NV_BASE_SITEURL . 'index.php?' . NV_NAME_VARIABLE . '=users&' . NV_OP_VARIABLE . '=login&nv_redirect=' . nv_redirect_encrypt($client_info['selfurl']));
    die();
}

$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
$per_page = 20;
$page = 1;
if (isset($array_op[1]) and substr($array_op[1], 0, 5) == 'page-') {
    $page = intval(substr($array_op[1], 5));
}

$db->sqlreset()
    ->select('COUNT(*)')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_usersave')
    ->where('userid=' . $user_info['userid']);

$sth = $db->prepare($db->sql());
$sth->execute();
$num_items = $sth->fetchColumn();

$db->select('*')
    ->order('add_time DESC')
    ->limit($per_page)
    ->offset(($page - 1) * $per_page);
$sth = $db->prepare($db->sql());
$sth->execute();

$xtpl = new XTemplate('usersave.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);

$array_exam = array();
$number = $page > 1 ? ($per_page * ($page - 1)) + 1 : 1;
while ($view = $sth->fetch()) {
    $view['number'] = $number++;
    if (!isset($array_exam[$view['examid']])) {
        $exam_info = $db->query('SELECT id, title, alias, catid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams WHERE id=' . $view['examid'])->fetch();
        $view['exam'] = $array_exam[$view['examid']] = $exam_info;
    } else {
        $view['exam'] = $array_exam[$view['examid']];
    }
    $view['add_time'] = (empty($view['add_time'])) ? '' : nv_date('H:i d/m/Y', $view['add_time']);
    $view['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_test_cat[$view['exam']['catid']]['alias'] . '/' . $view['exam']['alias'] . '-' . $view['exam']['id'] . $global_config['rewrite_exturl'];
    $xtpl->assign('VIEW', $view);
    $xtpl->parse('main.loop');
}

$generate_page = nv_alias_page($page_title, $base_url, $num_items, $per_page, $page);
if (!empty($generate_page)) {
    $xtpl->assign('NV_GENERATE_PAGE', $generate_page);
    $xtpl->parse('main.generate_page');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $nv_Lang->getModule('usersave');
if ($page > 1) {
    $page_title = $page_title . ' - ' . $nv_Lang->getGlobal('page') . ' ' . $page;
}
$array_mod_title[] = array(
    'title' => $page_title,
    'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op
);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';