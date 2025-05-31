<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2020 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wed, 29 Apr 2020 07:29:47 GMT
 */
if (!defined('NV_IS_FILE_ADMIN')) die('Stop!!!');

global $nv_Lang;

if ($nv_Request->isset_request('delete_session_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
    $session_id = $nv_Request->get_title('delete_session_id', 'get', '');

    $delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
    if ($session_id > 0 and $delete_checkss == md5($session_id . NV_CACHE_PREFIX . $client_info['session_id'])) {
        $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_info_member_answer  WHERE session_id = ' . $db->quote($session_id));
        $nv_Cache->delMod($module_name);
        Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
        die();
    }
}

$row = array();
$error = array();

// Fetch Limit
if (!$nv_Request->isset_request('id', 'post,get')) {
    $per_page = 20;
    $page = $nv_Request->get_int('page', 'post,get', 1);
    $db->sqlreset()
    ->select('COUNT(*)')
    ->from('' . NV_PREFIXLANG . '_' . $module_data . '_info_member_answer t1')
    ->join(' INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_exams t2 on t1.examid = t2.id LEFT JOIN ' . NV_USERS_GLOBALTABLE . ' t3 ON t1.userid=t3.userid');
    $sth = $db->prepare($db->sql());

    $sth->execute();
    $num_items = $sth->fetchColumn();

    $db->select('t1.*, t2.title, t3.username, t3.first_name, t3.last_name')
    ->order('session_id DESC')
    ->limit($per_page)
    ->offset(($page - 1) * $per_page);
    $sth = $db->prepare($db->sql());

    $sth->execute();
}

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('MODULE_UPLOAD', $module_upload);
$xtpl->assign('OP', $op);
$xtpl->assign('ROW', $row);

$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
$generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
if (!empty($generate_page)) {
    $xtpl->assign('NV_GENERATE_PAGE', $generate_page);
    $xtpl->parse('main.generate_page');
}
$number = $page > 1 ? ($per_page * ($page - 1)) + 1 : 1;
$num_sl = 0;
while ($view = $sth->fetch()) {
    $view['user'] = $view['userid'] ? nv_show_name_user($view['first_name'], $view['last_name'], $view['username']) : $nv_Lang->getModule('user_null');

    if ($view['delete_time'] < NV_CURRENTTIME) {
        $view['red'] = "style='background: #ff000012;'";
        $view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_session_id=' . $view['session_id'] . '&amp;delete_checkss=' . md5($view['session_id'] . NV_CACHE_PREFIX . $client_info['session_id']);
        $xtpl->parse('main.loop.delete');
    }else{
        $num_sl++;
    }

    $view['delete_time'] = nv_date('H:i d/m/Y', $view['delete_time']);

    $view['number'] = $number++;
    $xtpl->assign('VIEW', $view);
    $xtpl->parse('main.loop');
}
$xtpl->assign('STATUS_SL', $num_sl ? sprintf($nv_Lang->getModule('status_sl'), $num_sl) : $nv_Lang->getModule('status_sl_null'));

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $nv_Lang->getModule('statistics_testing_titlel');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';