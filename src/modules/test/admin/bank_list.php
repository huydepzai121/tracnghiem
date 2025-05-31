<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2015 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Tue, 02 Jun 2015 07:53:31 GMT
 */
/*
* các trạng thái status của ngân hàng đề thi
site con
0: chưa gửi
1: đã gửi
2: cập nhật lại
10: đã duyệt
site mẹ
0: tự tạo
1: đã nhận
2: cập nhật lại
10: đã xác nhận
*/
if (!defined('NV_IS_FILE_ADMIN')) die('Stop!!!');

global $nv_Lang;

$table_name = $db_config['dbsystem'] . "." . NV_PREFIXLANG . '_' . $module_data . '_bank';
$send_bank_id = $nv_Request->get_int('send_bank_id', 'get,post', 0);
$parentid = $nv_Request->get_int('parentid', 'get,post', 0);
$result = $db->query('SELECT title, typeid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_question WHERE id = ' . $send_bank_id);
list($title, $typeid) = $result->fetch(3);

if (empty($send_bank_id) || empty($title)) {
    Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=bank');
    die();
}

$error = array();
if ($nv_Request->isset_request('submit', 'post,get')) {
    $id = $nv_Request->get_int('send_bank_id', 'post');
    $typeid_main = $nv_Request->get_int('typeid_main', 'post');
    
    if (empty($id)) {
        die(json_encode(array(
            'error' => 1,
            'msg' => $nv_Lang->getModule('error_select_question'),
        )));
    }
    if (empty($typeid_main)) {
        die(json_encode(array(
            'error' => 1,
            'msg' => $nv_Lang->getModule('error_select_typeid'),
        )));
    }
    $db->sqlreset()
        ->select('*')
        ->from('' . NV_PREFIXLANG . '_' . $module_data . '_question')
        ->where('id = ' . $id);
    $sth = $db->prepare($db->sql());
    $sth->execute();
    $row = $sth->fetch(2);
    if (!empty($row)) {
        $db->sqlreset()
            ->select('COUNT(*)')
            ->from($db_config['dbsystem'] . "." . NV_PREFIXLANG . '_' . $module_data . '_question')
            ->where('idsite = ' . $global_config['idsite'] . ' AND idsq = ' . $id );
        $count = $db->query($db->sql())->fetchColumn();
        if (empty($count)){
            $_sql = 'INSERT INTO ' . $db_config['dbsystem'] . "." . NV_PREFIXLANG . '_' . $module_data . '_question (idsite, idsq, status, examid, typeid, bank_type, title, useguide, type, answer, weight, answer_style, answer_fixed, point, count_true, max_answerid, generaltext, answer_editor, answer_editor_type, addtime, userid, note, limit_time_audio, mark_max_constructed_response) VALUES (:idsite, :idsq, 1 , :examid, :typeid, :bank_type, :title, :useguide, :type, :answer, :weight, :answer_style, :answer_fixed, :point, :count_true, :max_answerid, :generaltext, :answer_editor, :answer_editor_type, ' . NV_CURRENTTIME . ', :userid,"", :limit_time_audio, :mark_max_constructed_response )';
            $data_insert = array();
            $data_insert['idsite'] = $global_config['idsite'];
            $data_insert['idsq'] = $row['id'];
            $data_insert['examid'] = $row['examid'];
            $data_insert['typeid'] = $typeid_main;
            $data_insert['bank_type'] = $row['bank_type'];
            $data_insert['title'] = $row['title'];
            $data_insert['type'] = $row['type'];
            $data_insert['useguide'] = $row['useguide'];
            $data_insert['answer'] = $row['answer'];
            $data_insert['weight'] = $row['weight'];
            $data_insert['answer_style'] = $row['answer_style'];
            $data_insert['answer_fixed'] = $row['answer_fixed'];
            $data_insert['point'] = $row['point'];
            $data_insert['count_true'] = $row['count_true'];
            $data_insert['max_answerid'] = $row['max_answerid'];
            $data_insert['generaltext'] = $row['generaltext'];
            $data_insert['answer_editor'] = $row['answer_editor'];
            $data_insert['answer_editor_type'] = $row['answer_editor_type'];
            $data_insert['userid'] = $row['userid'];
            $data_insert['limit_time_audio'] = $row['limit_time_audio'];
            $data_insert['mark_max_constructed_response'] = $row['mark_max_constructed_response'];
            $new_id = $db->insert_id($_sql, 'id', $data_insert);
            if (!empty($new_id)) {
                $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_question SET status = 1 WHERE id=' . $row['id']);
                while (!empty($typeid_main)) {
                    $db->query('UPDATE ' . $db_config['dbsystem'] . ".". NV_PREFIXLANG . '_' . $module_data . '_bank SET num_req = num_req + 1 WHERE id=' . $typeid_main);
                    list($typeid_main) = $db->query('SELECT parentid FROM ' .  $db_config['dbsystem'] . ".". NV_PREFIXLANG . '_' . $module_data . '_bank WHERE id = ' . $typeid_main)->fetch(3);
                }

            }
        } else {
            list($status_old, $typeid_old) = $db->query('SELECT status, typeid FROM ' . $db_config['dbsystem'] . "." . NV_PREFIXLANG . '_' . $module_data . '_question WHERE idsite = ' . $global_config['idsite'] . ' AND idsq = ' . $id)->fetch(3);
            $stmt = $db->prepare('UPDATE '  . $db_config['dbsystem'] . "." . NV_PREFIXLANG . '_' . $module_data . '_question SET status = :status, typeid = :typeid WHERE idsite = :idsite AND idsq = :idsq');
            $stmt->bindValue(':status', 2, PDO::PARAM_INT);
            $stmt->bindValue(':typeid', $typeid_main , PDO::PARAM_INT);
            $stmt->bindValue(':idsite', $global_config['idsite'], PDO::PARAM_INT); 
            $stmt->bindValue(':idsq', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_question SET status = 2 WHERE id=' . $row['id']);
                if ($status_old == 10 ) {
                    while (!empty($typeid_main)) {
                        $db->query('UPDATE ' . $db_config['dbsystem'] . ".". NV_PREFIXLANG . '_' . $module_data . '_bank SET num_req = num_req + 1 WHERE id=' . $typeid_main);
                        list($typeid_main) = $db->query('SELECT parentid FROM ' .  $db_config['dbsystem'] . ".". NV_PREFIXLANG . '_' . $module_data . '_bank WHERE id = ' . $typeid_main)->fetch(3);
                    }

                }else if (($typeid_old != $typeid_main)) {
                    while (!empty($typeid_main)) {
                        $db->query('UPDATE ' . $db_config['dbsystem'] . ".". NV_PREFIXLANG . '_' . $module_data . '_bank SET num_req = num_req + 1 WHERE id=' . $typeid_main);
                        list($typeid_main) = $db->query('SELECT parentid FROM ' .  $db_config['dbsystem'] . ".". NV_PREFIXLANG . '_' . $module_data . '_bank WHERE id = ' . $typeid_main)->fetch(3);
                    }
                    while (!empty($typeid_old)) {
                        $db->query('UPDATE ' . $db_config['dbsystem'] . ".". NV_PREFIXLANG . '_' . $module_data . '_bank SET num_req = num_req - 1 WHERE id=' . $typeid_old);
                        list($typeid_old) = $db->query('SELECT parentid FROM ' .  $db_config['dbsystem'] . ".". NV_PREFIXLANG . '_' . $module_data . '_bank WHERE id = ' . $typeid_old)->fetch(3);
                    }
                }
            }
        }
        die(json_encode(array(
            'error' => 0,
            'msg' => $nv_Lang->getModule('save_success'),
            'typeid' => $typeid
        )));
    }
} 

$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;send_bank_id=' . $send_bank_id;
// Fetch Limit
$show_view = false;
if (!$nv_Request->isset_request('id', 'post,get')) {
    $show_view = true;
    $per_page = 20;
    $page = $nv_Request->get_int('page', 'post,get', 1);
    $db->sqlreset()
        ->select('COUNT(*)')
        ->from($table_name)
        ->where('parentid=' . $parentid);

    $sth = $db->prepare($db->sql());

    $sth->execute();
    $num_items = $sth->fetchColumn();

    $db->select('*')
        ->order('weight ASC')
        ->limit($per_page)
        ->offset(($page - 1) * $per_page);
    $sth = $db->prepare($db->sql());
    $sth->execute();
}

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
$xtpl->assign('TEMPLATE', $global_config['module_theme']);
$xtpl->assign('OP', $op);
$xtpl->assign('MODULE_UPLOAD', $module_upload);
$xtpl->assign('TITLE', $title);
$xtpl->assign('send_bank_id', $send_bank_id);
$xtpl->assign('typeidsite', $typeidsite);

if ($show_view) {
    $base_url_cr = !empty($parentid) ? $base_url .  '&amp;parentid=' . $parentid : $base_url;
    $generate_page = nv_generate_page($base_url_cr, $num_items, $per_page, $page);
    if (!empty($generate_page)) {
        $xtpl->assign('NV_GENERATE_PAGE', $generate_page);
        $xtpl->parse('main.view.generate_page');
    }
    while ($view = $sth->fetch()) {
        $view['link_view'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;parentid=' . $view['id'] . '&amp;send_bank_id=' . $send_bank_id;
        $xtpl->assign('VIEW', $view);
        if (empty($parentid)) {
            $xtpl->parse('main.view.loop.main_bank');
        } else {
            $xtpl->parse('main.view.loop.bank');
            $xtpl->parse('main.view.loop.able_select');
        }
        $xtpl->parse('main.view.loop');
    }
    $xtpl->parse('main.view');
}

if (!empty($error)) {
    $xtpl->assign('ERROR', implode('<br />', $error));
    $xtpl->parse('main.error');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $nv_Lang->getModule('bank');
$array_mod_title[] = array(
    'title' => $page_title,
    'link' => $base_url
);

$_sql = 'SELECT * FROM ' . $db_config['dbsystem'] . "." .  NV_PREFIXLANG . '_' . $module_data . '_bank ORDER BY sort';
$array_test_bank_nstatus_main = $nv_Cache->db($_sql, 'id', $module_name);

while ($parentid > 0) {
    $array_cat_i = $array_test_bank_nstatus_main[$parentid];
    $array_mod_title[] = [
        'id' => $parentid,
        'title' => $array_cat_i['title'],
    ];
    $parentid = $array_cat_i['parentid'];
}
include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';