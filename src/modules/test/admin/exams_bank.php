<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2020 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sat, 12 Dec 2020 17:37:01 GMT
 */

if (!defined('NV_IS_FILE_ADMIN')) die('Stop!!!');

global $nv_Lang;

if ($nv_Request->isset_request('main_cat_id', 'post, get')) {
    $main_cat_id = $nv_Request->get_int('main_cat_id', 'post,get', 0);
    $xtpl = new XTemplate('exams_bank.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $db->sqlreset()
    ->select('id, title')
    ->from(tableSystem . '_exams_bank_cats')
    ->where('parentid = ' . $main_cat_id)
    ->order('weight ASC');
    $result = $db->query($db->sql());
    while ($row = $result->fetch(2)) {
        $xtpl->assign('CAT', $row);
        $xtpl->parse('list_cat.cat');
    }
    $xtpl->parse('list_cat');
    echo $xtpl->text('list_cat');
    exit();
}
if ($nv_Request->isset_request('get_list_cat_select2', 'post, get')) {
    $q = $nv_Request->get_title('q', 'post, get', '');
    $array_data = array();
    $db->sqlreset()
    ->select('id, title as text')
    ->from(tableSystem . '_exams_bank_cats')
    ->where('title LIKE "%' . $q . '%"')
    ->order('title')
    ->limit(10);
    $result = $db->query($db->sql());
    while ($row = $result->fetch(2)) {
        $array_data[] = $row;
    }
    nv_jsonOutput($array_data);
    exit();
}

if ($nv_Request->isset_request('get_user_json', 'post, get')) {
    $q = $nv_Request->get_title('q', 'post, get', '');

    $db->sqlreset()
        ->select('userid, first_name, last_name, username')
        ->from(NV_USERS_GLOBALTABLE)
        ->where('(first_name LIKE "%' . $q . '%"
            OR last_name LIKE "%' . $q . '%"
            OR username LIKE "%' . $q . '%"
        )')
        ->order('userid ASC')
        ->limit(20);

    $sth = $db->prepare($db->sql());
    $sth->execute();

    $array_data = array();
    while (list($userid, $first_name, $last_name, $username) = $sth->fetch(3)) {
        $array_data[] = array(
            'id' => $userid,
            'fullname' => nv_show_name_user($first_name, $last_name, $username),
            'username' => $username
        );
    }

    header('Cache-Control: no-cache, must-revalidate');
    header('Content-type: application/json');

    ob_start('ob_gzhandler');
    echo json_encode($array_data);
    exit();
}

// xem đề
// if ($nv_Request->isset_request('view_content', 'post,get')) {
//     $id = $nv_Request->get_int('id', 'post,get', 0);
//     $content = nv_review_questions($id, "view_content",  true);
//     die($content);
// }

if ($nv_Request->isset_request('bank_exam_accept', 'post,get')) {
    $id = $nv_Request->get_int('id', 'post,get', 0);
    $status = $nv_Request->get_int('status', 'post,get', 0);
    $reasonReject = $nv_Request->get_title('reasonReject', 'post,get', '');

    if ($db->query('UPDATE ' . tableSystem . '_exams_bank SET status=' . intval($status) . ', reasonReject="' . $reasonReject . '" WHERE id=' . $id)) {
        die('OK');
    }
    die('NO');
}

if ($nv_Request->isset_request('delete_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
    $id = $nv_Request->get_int('delete_id', 'get');
    $delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
    if ($id > 0 and $delete_checkss == md5($id . NV_CACHE_PREFIX . $client_info['session_id'])) {
        $checkDel = $db->query('DELETE FROM ' . tableSystem . '_exams_bank  WHERE id = ' . $db->quote($id));
        if ($checkDel) {
            $db->query('DELETE FROM ' . tableSystem . '_exams_bank_question  WHERE examid = ' . $db->quote($id));
        }
        $nv_Cache->delMod($module_name);
        Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
        die();
    }
}

$row = array();
$error = array();

$where = '';
$array_search = array(
    'q' => $nv_Request->get_title('q', 'post,get'),
    'userPush' => $nv_Request->get_int('userPush', 'post,get', 0),
    'idsite' => $nv_Request->get_int('idsite', 'post,get', 0),
    'status' => $nv_Request->get_int('status', 'post,get', 0),
    'main_cat' => $nv_Request->get_int('main_cat', 'post,get', 0),
    'cat' => $nv_Request->get_int('cat', 'post,get', 0),
    // Tích chọn chưa xác định chủ đề sẽ được ưu tiên tìm kiến hơn
    'had_not_identified' => $nv_Request->get_int('had_not_identified', 'post,get', 0),
);
$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
// Fetch Limit
$per_page = 20;
$page = $nv_Request->get_int('page', 'post,get', 1);
$db->sqlreset()
    ->select('COUNT(*)')
    ->from('' . tableSystem . '_exams_bank AS t1');

if (!empty($array_search['q'])) {
    $base_url .= '&q=' . $array_search['q'];
    $where .= ' AND (t1.title LIKE :q_title)';
}

if (!empty($array_search['userPush'])) {
    $base_url .= '&userPush=' . $array_search['userPush'];
    $where .= ' AND t1.userid=' . $array_search['userPush'];
}

$domain_site_name = '';
if (!empty($array_search['idsite'])) {
    $base_url .= '&idsite=' . $array_search['idsite'];
    $where .= ' AND t1.idsite=' . $array_search['idsite'];
    list($domain_site_name) = $db->query('SELECT domain FROM ' . $db_config['dbsystem'] . "." . $db_config['prefix'] . '_site WHERE idsite = ' . $array_search['idsite'])->fetch(3);

}

if (!empty($array_search['status'])) {
    $base_url .= '&status=' . $array_search['status'];
    $where .= ' AND t1.status=' . $array_search['status'];
}

if (!empty($array_search['had_not_identified'])) {
    $base_url .= '&had_not_identified=' . $array_search['had_not_identified'];
    $where .= ' AND t1.catid= 0';
}

if (!empty($array_search['cat']) && empty($array_search['had_not_identified'])) {
    $base_url .= '&cat=' . $array_search['cat'];
    $where .= ' AND t1.catid=' . $array_search['cat'];
}

if (!empty($global_config['idsite'])) {
    $where .= ' AND t1.status=2';
}

$db->where('1=1' . $where);
$sth = $db->prepare($db->sql());
if (!empty($array_search['q'])) {
    $sth->bindValue(':q_title', '%' . $array_search['q'] . '%');
}

$sth->execute();
$num_items = $sth->fetchColumn();

$db->select('t1.* , t2.domain, t2.title AS site_title')
    ->order('t1.id DESC')
    ->join('LEFT JOIN ' . $db_config['dbsystem'] . "." . $db_config['prefix'] . '_site AS t2 ON t1.idsite = t2.idsite' )
    ->limit($per_page)
    ->offset(($page - 1) * $per_page);
$sth = $db->prepare($db->sql());

if (!empty($array_search['q'])) {
    $sth->bindValue(':q_title', '%' . $array_search['q'] . '%');
}
$sth->execute();

$userPush = array();
if ($array_search['userPush'] > 0) {
    $userPush = $db->query('SELECT userid, first_name, last_name, username FROM ' . NV_USERS_GLOBALTABLE . ' WHERE userid=' . $array_search['userPush'])->fetch();
    $userPush['fullname'] = nv_show_name_user($userPush['first_name'], $userPush['last_name']);
}


$array_users = array();
$_sql = 'SELECT * FROM ' . NV_USERS_GLOBALTABLE . ' where userid=' . $array_search['userPush'];
$_query = $db->query($_sql);
while ($_row = $_query->fetch()) {
    $array_users[$_row['userid']] = $_row;
}

// Lấy các chủ đề Chính
$main_cat = array();
$db->sqlreset()
->select('id, title')
->from(tableSystem . '_exams_bank_cats')
->where('parentid = 0')
->order('weight ASC');
$result = $db->query($db->sql());
while ($row = $result->fetch(2)) {
    $main_cat[] = $row;
}

// Lấy tên của chủ đề được chọn. 
$cats_select_title = '';
if ($array_search['cat'] > 0) {
    $db->sqlreset()
    ->select('title')
    ->from(tableSystem . '_exams_bank_cats')
    ->where('id = ' . $array_search['cat']);
    list($cats_select_title) = $db->query($db->sql())->fetch(3);
}

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('MODULE_UPLOAD', $module_upload);
$xtpl->assign('NV_SERVER_PROTOCOL', NV_SERVER_PROTOCOL);
$xtpl->assign('OP', $op);
$xtpl->assign('SEARCH', $array_search);
$xtpl->assign('PACKAGE_NOTIICE', nv_package_notice(0));
if ( $array_search['had_not_identified'] > 0) {
    $xtpl->assign('had_not_identified', 1);
    $xtpl->assign('catid', 0);
    $xtpl->assign('cats_select_title', $nv_Lang->getModule('cat_other'));
} else if ($array_search['cat'] > 0) {
    $xtpl->assign('had_not_identified', 0);
    $xtpl->assign('catid', $array_search['cat']);
    $xtpl->assign('cats_select_title', $cats_select_title);
} else {
    $xtpl->assign('had_not_identified', 0);
    $xtpl->assign('catid', 0);
    $xtpl->assign('cats_select_title', $nv_Lang->getModule('cat_all'));
}

if ($global_config['unallow_exams_bank']) {
    if ($nv_Lang->getGlobal('test_message_danger')) {
        $xtpl->assign('test_message_danger', $nv_Lang->getGlobal('test_message_danger'));
        $xtpl->parse('main.not_allow_use.test_message_danger');
    }
    if ($turn_off_msg) {
        $xtpl->parse('main.not_allow_use.msg_none');
    } else {
        $xtpl->parse('main.not_allow_use.msg_show');
    }
    $xtpl->parse('main.not_allow_use');
} else {
    $generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
    $xtpl->parse('main.thead');
    if (!empty($generate_page)) {
        $xtpl->assign('NV_GENERATE_PAGE', $generate_page);
        $xtpl->parse('main.generate_page');
    }
    if (empty($global_config['idsite']) or $global_config['users_special']) {
        $xtpl->parse('main.update_bank_cat');
        $xtpl->parse('main.view_bt_cats');
    }
    
    if (empty($global_config['idsite'])) {
        $xtpl->parse('main.is_main_site_head');
    }
    
    foreach ($main_cat as $row) {
        $xtpl->assign('CAT', $row);
        $xtpl->assign('selected', $row['id'] == $array_search['main_cat'] ? 'selected' : '');
        $xtpl->parse('main.main_cat');
        $xtpl->parse('main.perfect_scrollbar_cat');
    }
    
    $number = $page > 1 ? ($per_page * ($page - 1)) + 1 : 1;
    while ($view = $sth->fetch()) {
        $view['number'] = $number++;
        $view['addtime'] = nv_date('H:i:s d/m/Y', $view['addtime']);
        $view['statusName'] = $lang_module['bank_exam_status_' . $view['status']];
        $view['examBank_url'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=exams_bank_content&id=' . $view['id'] . '&page=' . $page;
        $view['domain'] = !empty($view['domain']) ? $view['domain'] : '';
        $view['site_title'] = !empty($view['site_title']) ? $view['site_title'] : 'Admin Aztest';
    
        $first_name = $db->query('SELECT first_name, last_name FROM ' . $db_config['dbsystem'] . '.' . $db_config['prefix'] . '_users WHERE userid=' . $view['userid'])->fetch();
        $view['userid'] = nv_show_name_user($first_name['first_name'], $first_name['last_name']);
        $view['catid'] = !empty($array_exams_bank_cats[$view['catid']]) ? $array_exams_bank_cats[$view['catid']]['title'] : $nv_Lang->getModule('cat_other');
        $view['link_question'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=question&amp;bank=1&amp;examid=' . $view['id'];
        $view['link_use'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=exams-content&bankExam=' . $view['id'];
        $view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_id=' . $view['id'] . '&amp;delete_checkss=' . md5($view['id'] . NV_CACHE_PREFIX . $client_info['session_id']);
        $view['filter'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '='. $op .'&amp;idsite=' . $view['idsite'];
        $xtpl->assign('VIEW', $view);
        
        if (empty($global_config['idsite'])) {
            if ($view['status'] == 1) {
                $xtpl->parse('main.loop.funcsAcceptReject');
            }
            $xtpl->parse('main.loop.delete');
        }
        if (empty($global_config['idsite'])) {
            $xtpl->parse('main.loop.main_site');
        }
        if ($view['status'] == 2) {
            $xtpl->parse('main.loop.useExam');
        }
    
        if (empty($global_config['idsite'])) {
            $xtpl->parse('main.loop.is_main_site_body');
        }
        $xtpl->parse('main.loop');
    }
}

foreach ($array_users as $value) {
    $xtpl->assign('USERPUSH', array(
        'key' => $value['userid'],
        'title' => $value['username'],
        'selected' => ($value['userid'] == $array_search['userPush']) ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.userPush');
}
if (!empty($array_search['idsite'])) {
    $xtpl->assign('SITE', array(
        'key' => $array_search['idsite'], 
        'title' => $domain_site_name
    ));
    $xtpl->parse('main.idsite');
}

for ($i = 1; $i < 4; $i++) {
    $xtpl->assign('MH', array(
        'id' => $i,
        'title' => $lang_module['bank_exam_status_' . $i],
        'selected' => $i == $array_search['status'] ? 'selected="selected"' : ''
    ));
    $xtpl->parse('main.status');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $nv_Lang->getModule('exams_bank');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
