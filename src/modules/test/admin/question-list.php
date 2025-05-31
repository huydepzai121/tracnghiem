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

// change status
/*
Không biết khối lệnh này sử dụng cho mục đích gì.  
Vì trong CSDL không có field status trước khi tôi thêm trước đó vào để xử lý công việc
if ($nv_Request->isset_request('change_status', 'post, get')) {
    $id = $nv_Request->get_int('id', 'post, get', 0);

    if (!$id) die('NO');

    $query = 'SELECT status FROM ' . NV_PREFIXLANG . '_' . $module_data . '_question WHERE id=' . $id;
    $result = $db->query($query);
    $numrows = $result->rowCount();
    if ($numrows > 0) {
        $active = 1;
        foreach ($result as $row) {
            if ($row['status'] == 1) {
                $active = 0;
            } else {
                $active = 1;
            }
        }
        $query = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_question SET
				status=' . $db->quote($active) . '
				WHERE id=' . $id;
        $db->query($query);
    }
    $nv_Cache->delMod($module_name);
    die('OK');
}
*/
$bank = $nv_Request->get_int('bank', 'post,get', 0);
$table_exams = NV_PREFIXLANG . '_' . $module_data . '_exams';
$table_question = NV_PREFIXLANG . '_' . $module_data . '_question';
if($bank){
    $table_exams = tableSystem . '_exams_bank';
    $table_question = tableSystem . '_exams_bank_question';
}
if ($nv_Request->isset_request('cancel_bank_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
    $id = $nv_Request->get_int('cancel_bank_id', 'get');
    $delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
    $redirect = $nv_Request->get_string('redirect', 'get');
    if ($id > 0 and $delete_checkss == md5($id . NV_CACHE_PREFIX . $client_info['session_id'])) {
        list($typeid_main) = $db->query('SELECT typeid FROM ' . $db_config['dbsystem'] . "." . NV_PREFIXLANG . '_' . $module_data . '_question WHERE idsite = ' . $global_config['idsite'] . ' AND idsq = ' . $id)->fetch(3);
        
        $db->query( 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_question SET  status= 0 WHERE id=' . $id);

        $db->query('DELETE FROM ' . $db_config['dbsystem'] . "." . NV_PREFIXLANG . '_' . $module_data . '_question WHERE idsite = ' . $global_config['idsite'] . ' AND idsq = ' . $id);

        while (!empty($typeid_main)) {
            $db->query('UPDATE ' . $db_config['dbsystem'] . ".". NV_PREFIXLANG . '_' . $module_data . '_bank SET num_req = num_req - 1 WHERE id=' . $typeid_main);
            list($typeid_main) = $db->query('SELECT parentid FROM ' .  $db_config['dbsystem'] . ".". NV_PREFIXLANG . '_' . $module_data . '_bank WHERE id = ' . $typeid_main)->fetch(3);
        }
        if (!empty($redirect)) {
            $url = nv_redirect_decrypt($redirect);
        } else {
            $url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op;
        }
        Header('Location: ' . $url);
        die();
    }
} 
if ($nv_Request->isset_request('confirm_question_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
    $id = $nv_Request->get_int('confirm_question_id', 'get');
    $delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
    $redirect = $nv_Request->get_string('redirect', 'get');
    list($status) = $db->query('SELECT status FROM ' . $db_config['dbsystem'] . "." . NV_PREFIXLANG . '_' . $module_data . '_question WHERE id=' . $id)->fetch(3);
    if ($id > 0 && $status !=10 && $delete_checkss == md5($id . NV_CACHE_PREFIX . $client_info['session_id'])) {
        /*xử lý ở server website mẹ */
        $db->query( 'UPDATE '  . $db_config['dbsystem'] . "." . NV_PREFIXLANG . '_' . $module_data . '_question SET  status= 10 WHERE id=' . $id);
        list($typeid_main) = $db->query('SELECT typeid FROM ' . $db_config['dbsystem'] . "." . NV_PREFIXLANG . '_' . $module_data . '_question WHERE id = '. $id)->fetch(3);
        while (!empty($typeid_main)) {
            $db->query('UPDATE ' . $db_config['dbsystem'] . ".". NV_PREFIXLANG . '_' . $module_data . '_bank SET num_req = num_req - 1 WHERE id=' . $typeid_main);
            list($typeid_main) = $db->query('SELECT parentid FROM ' .  $db_config['dbsystem'] . ".". NV_PREFIXLANG . '_' . $module_data . '_bank WHERE id = ' . $typeid_main)->fetch(3);
        }
        /*xử lý ở server website con */
        list($dbsite, $idsq) = $db->query('SELECT t1.dbsite, t2.idsq FROM ' . $db_config['dbsystem'] . '.' . $db_config['prefix'] . '_site AS t1 INNER JOIN ' .$db_config['dbsystem'] . '.' . NV_PREFIXLANG . '_' . $module_data . '_question AS t2 ON t1.idsite = t2.idsite WHERE t2.id = ' . $id)->fetch(3);
        
        $db->query( 'UPDATE '  . $dbsite . "." . NV_PREFIXLANG . '_' . $module_data . '_question SET  status= 10 WHERE id=' . $idsq);
    }
    if (!empty($redirect)) {
        $url = nv_redirect_decrypt($redirect);
    } else {
        $url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op;
    }
    Header('Location: ' . $url);
    die();
} 


if ($nv_Request->isset_request('delete_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
    $id = $nv_Request->get_int('delete_id', 'get');
    $delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
    $redirect = $nv_Request->get_string('redirect', 'get');
    if ($id > 0 and $delete_checkss == md5($id . NV_CACHE_PREFIX . $client_info['session_id'])) {
        $examinationsid = nv_delete_question($table_exams, $table_question, $id);
        $nv_Cache->delMod($module_name);
        if (!empty($redirect)) {
            $url = nv_redirect_decrypt($redirect) .  ( is_numeric($examinationsid) ? '&examinationsid=' . $examinationsid: '' );
        } else {
            $url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op .  ( is_numeric($examinationsid) ? '&examinationsid=' . $examinationsid: '' )   ;
        }
        Header('Location: ' . $url);
        die();
    }
} elseif ($nv_Request->isset_request('delete_list', 'post')) {
    $listall = $nv_Request->get_title('listall', 'post', '');
    $array_id = explode(',', $listall);
    $examinationsid = 0;
    if (!empty($array_id)) {
        foreach ($array_id as $question_id) {
            $examinationsid1 = nv_delete_question($table_exams, $table_question, $question_id);
            $examinationsid = is_numeric($examinationsid1) ? $examinationsid1: $examinationsid;
        }
        $nv_Cache->delMod($module_name);
        if ($examinationsid == 0) {
            die('OK');
        } else {
            die($examinationsid);
        };
    }
    die('NO');
}

if ($nv_Request->isset_request('exam_add', 'post')) {
    $exam_id = $nv_Request->get_int('exam_id', 'post', 0);
    $listall = $nv_Request->get_title('listall', 'post', '');
    $array_id = explode(',', $listall);

    if (empty($exam_id)) {
        die('NO');
    }

    $exam_info = $db->query('SELECT type FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams WHERE status=1 AND id=' . $exam_id)->fetch();
    if (!empty($exam_info)) {
        if (!empty($array_id)) {
            $stmt = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_exams_question (exams_id, question_id, weight) VALUES (:exams_id, :question_id, :weight)');
            foreach ($array_id as $question_id) {
                try {
                    $question_type = $db->query('SELECT type FROM ' . NV_PREFIXLANG . '_' . $module_data . '_question WHERE status=1 AND id=' . $question_id)->fetchColumn();
                    if ($question_type == $exam_info['type']) {
                        $weight = $db->query('SELECT max(weight) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams_question WHERE exams_id=' . $exam_id)->fetchColumn();
                        $weight = intval($weight) + 1;

                        $stmt->bindParam(':exams_id', $exam_id, PDO::PARAM_INT);
                        $stmt->bindParam(':question_id', $question_id, PDO::PARAM_INT);
                        $stmt->bindParam(':weight', $weight, PDO::PARAM_INT);
                        $exc = $stmt->execute();
                    }
                } catch (Exception $e) {
                    // xem nhu da them truoc do
                }
            }
            $nv_Cache->delMod($module_name);
            die('OK');
        }
    }
    die('NO');
}

$subjectid = $nv_Request->get_int('subjectid', 'get', 0);

$SUBJECT = array();
if (!empty($subjectid)) {
    $db->sqlreset()
    ->select('*')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_exam_subject')
    ->where('id =' . $subjectid);
    $SUBJECT= $db->query($db->sql())->fetch(2);
}
$examinationsid = $nv_Request->get_int('examinationsid', 'get', 0);
list($examinations_title) = $db->query('SELECT title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_examinations WHERE id=' . $examinationsid)->fetch(3);
if ($nv_Request->isset_request('add_question_subject', 'get') and $nv_Request->isset_request('question_checkss', 'get')) {
    $id = $nv_Request->get_int('add_question_subject', 'get');
    $question_checkss = $nv_Request->get_string('question_checkss', 'get');
    $redirect = $nv_Request->get_string('redirect', 'get', '');
    if ($id > 0 and $question_checkss == md5($id . NV_CACHE_PREFIX . $client_info['session_id'])) {
        $_sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_subject_questions (subjectid, questionid) VALUES (:subjectid, :questionid)';
        $data_insert = array();
        $data_insert['subjectid'] = $subjectid;
        $data_insert['questionid'] = $id;
        $new_id = $db->insert_id($_sql, 'id', $data_insert);
        nv_insert_logs(NV_LANG_DATA, $module_name, $nv_Lang->getModule('add_question_subject') , "(#". $id . ")" , $admin_info['userid']);
        $nv_Cache->delMod($module_name);
        Header('Location: ' . nv_redirect_decrypt($redirect));
        die();
    }
}
$where = '';
$array_search = array(
    'q' => $nv_Request->get_title('q', 'post,get'),
    'bank_type' => $nv_Request->get_title('bank_type', 'get')
);

// Fetch Limit
$per_page = 30;
$page = $nv_Request->get_int('page', 'post,get', 1);
$typeid = $nv_Request->get_int('typeid', 'get', 0);
$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;typeid=' . $typeid . (!empty($SUBJECT) ? '&subjectid=' . $SUBJECT['id'] : '' );

if (!empty($array_search['q'])) {
    $base_url .= '&q=' . $array_search['q'];
    $where .= ' AND (title LIKE "%' . $array_search['q'] . '%"
        OR useguide LIKE "%' . $array_search['q'] . '%"
        OR answer LIKE "%' . $array_search['q'] . '%"
        OR generaltext LIKE "%' . $array_search['q'] . '%"
    )';
}

if (!empty($array_search['bank_type'])) {
    $base_url .= '&bank_type=' . $array_search['bank_type'];
    $where .= ' AND bank_type=' . $array_search['bank_type'];
}

$db->sqlreset()
    ->select('COUNT(*)')
    ->from('' . NV_PREFIXLANG . '_' . $module_data . '_question AS t1')
    // ->join('LEFT JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_subject_questions AS t2 ON t1.id = t2.questionid')
    ->where('typeid=' . $typeid . ' AND examid=0' . $where);
$sth = $db->prepare($db->sql());
$sth->execute();
$num_items = $sth->fetchColumn();

$db->select('t1.*')
    ->order('addtime DESC')
    ->limit($per_page)
    ->offset(($page - 1) * $per_page);
$sth = $db->prepare($db->sql());
$sth->execute();
$data = array();
while ($view = $sth->fetch()) {
    $data[$view['id']] = $view;
}
if (!empty($data)) {
    $db->sqlreset()
    ->select('*')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_subject_questions')
    ->where('subjectid = ' . $subjectid . ' AND questionid IN (' . implode(',', array_keys($data) ) . ')' );
    $result = $db->query($db->sql());
    while ($row = $result->fetch(2)) {
        $data[$row['questionid']]['subjectid'] = $row['subjectid'];
    }
}

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);
$xtpl->assign('SEARCH', $array_search);
$xtpl->assign('BASE_URL', $base_url);
$xtpl->assign('TYPEID', $typeid);
$xtpl->assign('URL_ADD', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=question-content&amp;typeid=' . $typeid);
$xtpl->assign('IMPORT_URL', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=questionword&amp;typeid=' . $typeid);
$xtpl->assign('IMPORT_EXCEL', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=questionexcel&amp;typeid=' . $typeid);
if (!empty($SUBJECT)) {
    $xtpl->assign('SUBJECT', $SUBJECT);
    $xtpl->parse('main.question_subject');
}
if (!empty($examinations_title)) {
    $xtpl->assign('examinations_title', $examinations_title);
    $xtpl->parse('main.examinations_title');
}
$generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
if (!empty($generate_page)) {
    $xtpl->assign('NV_GENERATE_PAGE', $generate_page);
    $xtpl->parse('main.generate_page');
}
foreach($data as $view)
// while ($view = $sth->fetch()) 
{
    $view['bank_type'] = $array_bank_type[$view['bank_type']]['title'];
    $view['addtime'] = !empty($view['addtime']) ? nv_date('H:i d/m/Y', $view['addtime']) : 'N/A';
    $view['edittime'] = !empty($view['edittime']) ? nv_date('H:i d/m/Y', $view['edittime']) : 'N/A';
    $view['title'] = strip_tags($view['title']);
    $view['link_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=question-content&amp;id=' . $view['id'] . '&amp;typeid=' . $typeid . '&amp;redirect=' . nv_redirect_encrypt($client_info['selfurl']);
    $view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_id=' . $view['id'] . '&amp;delete_checkss=' . md5($view['id'] . NV_CACHE_PREFIX . $client_info['session_id']) . '&amp;typeid=' . $typeid . '&amp;redirect=' . nv_redirect_encrypt($client_info['selfurl']);
    $view['link_send_bank'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=bank_list&amp;send_bank_id=' . $view['id'] ;
    $view['link_cancel_bank'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;cancel_bank_id=' . $view['id'] . '&amp;delete_checkss=' . md5($view['id'] . NV_CACHE_PREFIX . $client_info['session_id']) . '&amp;typeid=' . $typeid . '&amp;redirect=' . nv_redirect_encrypt($client_info['selfurl']);
    $view['link_confirm'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;confirm_question_id=' . $view['id'] . '&amp;delete_checkss=' . md5($view['id'] . NV_CACHE_PREFIX . $client_info['session_id']) . '&amp;redirect=' . nv_redirect_encrypt($client_info['selfurl']);
    $view['status_title'] = $view['status']==1 ? $nv_Lang->getModule('text_post_status_0') : ( $view['status']==2 ?   $nv_Lang->getModule('re_update') : ($view['status']==10 ? $nv_Lang->getModule('confirmed') : '' ));

    $view['feature'] = empty($view['subjectid']) ? "<a class=\"btn btn-success btn-xs\" href=\"" . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;typeid=' . $typeid . '&amp;subjectid=' . $subjectid . '&amp;add_question_subject=' . $view['id'] . '&amp;question_checkss=' . md5($view['id'] . NV_CACHE_PREFIX . $client_info['session_id']) . '&amp;redirect=' . nv_redirect_encrypt($client_info['selfurl']) . "\" data-toggle=\"tooltip\" data-original-title=\"" . $nv_Lang->getGlobal('add') . "\"><em class=\"fa fa-plus\">  ". $nv_Lang->getGlobal('add') . "</em></a>" : '<strong>' . $nv_Lang->getModule('had_add') . '</strong>';

    $class_text_danger = "";
    if ($view['status'] == 1 || $view['status'] == 2) {
        $class_text_danger = "class=\"text-danger font-bold\"";
    }
    $xtpl->assign('class_text_danger', $class_text_danger);
    $xtpl->assign('VIEW', $view);
    if (!empty($SUBJECT)) {
        $xtpl->parse('main.loop.had_subject');
    } else {
        if (!empty($global_config['idsite'])) {
            $xtpl->parse('main.loop.not_subject.site_child_1');
            if($view['status'] == 1) {
                $xtpl->parse('main.loop.not_subject.site_child_2');
            }
        }
        else {
            $xtpl->parse('main.loop.not_subject.site_main');
        }
        $xtpl->parse('main.loop.not_subject');
    }
    $xtpl->parse('main.loop');
}
foreach ($array_bank_type as $bank_type) {
    $bank_type['selected'] = $bank_type['id'] == $array_search['bank_type'] ? 'selected="selected"' : '';
    $xtpl->assign('BANK_TYPE', $bank_type);
    $xtpl->parse('main.bank_type');
}

$array_action = array(
    'delete_list_id' => $nv_Lang->getGlobal('delete')
);
foreach ($array_action as $key => $value) {
    $xtpl->assign('ACTION', array(
        'key' => $key,
        'value' => $value
    ));
    $xtpl->parse('main.action_top');
    $xtpl->parse('main.action_bottom');
}
if (!empty($subjectid)) {
    $xtpl->assign('come_back', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=random_question&subjectid=' . $subjectid);
    $xtpl->parse('main.come_back');
}

if ($global_config['import_word']) {
    $xtpl->parse('main.msword');
}
if ($global_config['import_excel']) {
    $xtpl->parse('main.msexcel');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $nv_Lang->getModule('bank');
$set_active_op = 'bank';

$parentid = $typeid;
while ($parentid > 0) {
    $array_cat_i = $array_test_bank[$parentid];
    $array_mod_title[] = [
        'id' => $parentid,
        'title' => $array_cat_i['title'],
        'link' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=bank' . ($array_cat_i['parentid'] > 0 ? '&amp;typeid=' . $array_cat_i['id'] : '&amp;parentid=' . $array_cat_i['id'])
    ];
    $parentid = $array_cat_i['parentid'];
}
$array_mod_title[] = array(
    'title' => $page_title,
    'link' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=bank'
);
krsort($array_mod_title, SORT_NUMERIC);

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';