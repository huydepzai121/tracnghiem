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

$cr_question = $nv_Request->get_int('cr_question', 'post,get', 0);
$cr_number = $nv_Request->get_int('cr_number', 'post,get', 0);
$examid = $nv_Request->get_int('examid', 'post,get', 0);
$bank = $nv_Request->get_int('bank', 'post,get', 0);
$table_exams = NV_PREFIXLANG . '_' . $module_data . '_exams';
$table_question = NV_PREFIXLANG . '_' . $module_data . '_question';

if ($bank) {
    $table_exams = tableSystem . '_exams_bank';
    $table_question = tableSystem . '_exams_bank_question';
}
function export_list_question_html($examid, $question_selected = 1) {
    global $db, $table_question, $table_exams, $lang_module, $global_config, $module_file, $op ;
    $db->sqlreset()
    ->select('COUNT(*)')
    ->from($table_question)
    ->where('examid=' . $examid . ' AND type = 3');
    $count_type_3 = $db->query($db->sql())->fetchColumn();
    // danh sách câu hỏi thuộc đề thi
    $exams_info = $db->query('SELECT * FROM ' . $table_exams . ' WHERE id=' . $examid)->fetch();

    $array_question_data = array();
    $result = $db->query('SELECT id, weight, type, title, answer FROM ' . $table_question . ' WHERE examid=' . $examid . ' ORDER BY weight');
    while (list ($id, $weight, $type, $title, $answer) = $result->fetch(3)) {
        $answer = unserialize($answer);
        $array_question_data[$weight] = array(
            'id' => $id, 
            'title' => $title,
            'answer' => $answer,
            'type' => $type
        );
    }

    $xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('EXAMID', $examid);

    $number_question_view = 0;
    for ($i = 1; $i <= $exams_info['num_question'] + $count_type_3; $i++) {
        $xtpl->assign('disabled' , $i == $question_selected ? '': 'disabled');
        $number_question_view += ( $array_question_data[$i]['type'] !== 3 ? 1 : 0 );
        $question = array(
            'id' => isset($array_question_data[$i]) ? $array_question_data[$i]['id'] : 0,
            'number' => $i,
            'number_question_view' => $number_question_view,
            'title' => isset($array_question_data[$i]) ? trim($array_question_data[$i]['title']) : 0
        );

        $xtpl->assign('QUESTION', $question);
        if ($array_question_data[$i]['type'] == 3) {
            $xtpl->assign('from_question', $array_question_data[$i]['answer']['from_question']);
            $xtpl->assign('to_question', $array_question_data[$i]['answer']['to_question']);
            $xtpl->parse('question.common_question');
        } else {
            if (
                !isset($array_question_data[$i]) || 
                ($array_question_data[$i]['type'] != 6 && $array_question_data[$i]['type'] != 7 && empty($array_question_data[$i]['answer'])) || 
                empty($array_question_data[$i]['title'])
            ) {
                $xtpl->parse('question.really_question.danger');
            } else {
                $xtpl->parse('question.really_question.success');
            }
    
            if ($i == $question_selected) {
                $xtpl->parse('question.really_question.info');
            }
            $xtpl->parse('question.really_question');
        }


        $xtpl->parse('question');
    }
    return $xtpl->text('question');
}
// Lấy hiện thị danh sách các câu hỏi
if ($nv_Request->isset_request('export_list_question_html', 'post,get')) {
    $question_id = $nv_Request->get_int('question_id', 'post,get', 0);
    $exam_id = $nv_Request->get_int('exam_id', 'post,get', 0);
    nv_htmlOutput(export_list_question_html($exam_id, $question_id));
    die('NO');
}
// Sắp xếp câu hỏi
if ($nv_Request->isset_request('question_order', 'post,get')) {
    $order_new = $nv_Request->get_int('order_new', 'post', 0);
    $question_id = $nv_Request->get_int('question_id', 'post', 0);
    $exam_id = $nv_Request->get_int('exam_id', 'post', 0);
    if (change_question_order($exam_id, $question_id, $order_new)) {
        nv_htmlOutput(export_list_question_html($exam_id, $order_new));
    }
    die('NO');
}

if ($nv_Request->isset_request('eraser', 'post')) {
    $id = $nv_Request->get_int('id', 'post');

    if ($id > 0) {
        if (nv_eraser_question($table_question, $id)) {
            die('OK');
        }
    }
    die('NO');
} elseif ($nv_Request->isset_request('delete', 'post')) {
    $id = $nv_Request->get_int('id', 'post');
    $examid = $nv_Request->get_int('examid', 'post');
    if ($examid > 0) {
        if (nv_delete_question($table_exams, $table_question, $id, $examid)) {
            die('OK');
        }
    }
    die('NO');
} elseif ($nv_Request->isset_request('eraser_list', 'post')) {
    $listall = $nv_Request->get_title('listall', 'post', '');
    $array_id = explode(',', $listall);

    if (!empty($array_id)) {
        foreach ($array_id as $number_id) {
            if (!empty($number_id)) {
                nv_eraser_question($table_question, $number_id);
            }
        }
        die('OK');
    }
    die('NO');
} elseif ($nv_Request->isset_request('delete_list', 'post')) {
    $id = $nv_Request->get_int('id', 'post');
    $examid = $nv_Request->get_int('examid', 'post');
    $listall = $nv_Request->get_title('listall', 'post', '');
    $array_id = explode(',', $listall);

    if (!empty($array_id)) {
        foreach ($array_id as $id) {
            nv_delete_question($table_exams, $table_question, $id, $examid);
        }
        die('OK');
    }
    die('NO');
} elseif ($nv_Request->isset_request('add_question', 'post')) {
    $examid = $nv_Request->get_int('examid', 'post');
    $add_question = $nv_Request->get_int('add_question', 'post');

    if (!empty($add_question)) {
        $rows = $db->query('SELECT * FROM ' . $table_exams . ' WHERE id=' . $examid)->fetch();
        $add_question = $add_question + $rows['num_question'];
        $stmt = $db->prepare('UPDATE ' . $table_exams . ' SET num_question = :num_question WHERE id=' . $examid);
        $stmt->bindParam(':num_question', $add_question, PDO::PARAM_INT);
        if ($stmt->execute()) {
            nv_exam_question_status($examid);
            die('OK');
        }
    }
    die('NO');
}

$exams_info = $db->query('SELECT * FROM ' . $table_exams . ' WHERE id=' . $examid)->fetch();
if (!$exams_info) {
    Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=exams');
    die();
}

$where = '';
$array_search = array(
    'q' => $nv_Request->get_title('q', 'post,get')
);
$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;

// Fetch Limit
$per_page = $array_config['per_page'];
$page = $nv_Request->get_int('page', 'post,get', 1);
$db->sqlreset()
    ->select('COUNT(*)')
    ->from($table_question);

if (!empty($array_search['q'])) {
    $base_url .= '&q=' . $array_search['q'];
    $where .= ' AND (title LIKE :q_title OR note LIKE :q_note)';
}

$db->where('examid=' . $examid . $where);
$sth = $db->prepare($db->sql());

if (!empty($array_search['q'])) {
    $sth->bindValue(':q_title', '%' . $array_search['q'] . '%');
    $sth->bindValue(':q_note', '%' . $array_search['q'] . '%');
}
$sth->execute();
$num_items = $sth->fetchColumn();

$db->select('*')
    ->order('id DESC')
    ->limit($per_page)
    ->offset(($page - 1) * $per_page);

$sth = $db->prepare($db->sql());

if (!empty($array_search['q'])) {
    $sth->bindValue(':q_title', '%' . $array_search['q'] . '%');
    $sth->bindValue(':q_note', '%' . $array_search['q'] . '%');
}
$sth->execute();
$exam_data = $db->query('SELECT catid, alias FROM ' . $table_exams . '  WHERE id=' . $examid)->fetch();

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('DATA', $exams_info);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);
$xtpl->assign('ROW', $row);
$xtpl->assign('EXAMID', $examid);
$xtpl->assign('BANKEXAM', $bank ? 1 : 0);
$xtpl->assign('BASE_URL', $base_url);
$xtpl->assign('TEMPLATE', $global_config['module_theme']);
$xtpl->assign('SEARCH_EXAM', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_test_cat[$exam_data['catid']]['alias'] . '/' . $exam_data['alias'] . '-' . $examid . $global_config['rewrite_exturl']);
$xtpl->assign('ADD_EXAM', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=exams-content');
$xtpl->assign('EDIT_EXAM', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=exams-content&id=' . $examid . '&redirect=' . nv_redirect_encrypt($client_info['selfurl']));
$xtpl->assign('DELETE_EXAM', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=exams&amp;examid=' . $examid . '&amp;delete_id=' . $examid . '&amp;delete_checkss=' . md5($examid . NV_CACHE_PREFIX . $client_info['session_id']));
// if (nv_package_notice()) {
//     $xtpl->assign('URL_IMPORT', '#');
//     $xtpl->assign('URL_IMPORT_EXCEL', '#');
//     $xtpl->assign('PACKAGE_NOTIICE', nv_package_notice());
//     $xtpl->assign('ALERT_NOTIICE', nv_package_notice(true));
// }else{
    $xtpl->assign('URL_IMPORT', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=questionword&amp;examid=' . $examid);
    $xtpl->assign('URL_IMPORT_EXCEL', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=questionexcel&amp;examid=' . $examid);
// }

$generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
if (!empty($generate_page)) {
    $xtpl->assign('NV_GENERATE_PAGE', $generate_page);
    $xtpl->parse('main.generate_page');
}

$number = $page > 1 ? ($per_page * ($page - 1)) + 1 : 1;

while ($view = $sth->fetch()) {
    $view['number'] = $number++;
    $view['title'] = strip_tags($view['title']);
    $view['link_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=question-content&amp;id=' . $view['id'];
    $view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;examid=' . $view['examid'] . '&amp;delete_id=' . $view['id'] . '&amp;delete_checkss=' . md5($view['id'] . NV_CACHE_PREFIX . $client_info['session_id']);
    $xtpl->assign('VIEW', $view);
    $xtpl->parse('main.loop');
}

if ($exams_info['num_question'] > 0) {
    $xtpl->assign('LIST_QUESTIONS', export_list_question_html($examid));
}

list($firstid) = $db->query('SELECT id FROM ' . $table_question . ' WHERE examid=' . $examid . ' ORDER BY weight LIMIT 1')->fetch(3);
$xtpl->assign('FIRTSID', $firstid);

$array_action = array(
    'question_eraser' => $nv_Lang->getModule('eraser_question'),
    'question_delete' => $nv_Lang->getModule('del_question'),
    'question_add' => $nv_Lang->getModule('add_question')
);
foreach ($array_action as $key => $value) {
    $xtpl->assign('ACTION', array(
        'key' => $key,
        'value' => $value
    ));
    $xtpl->parse('main.action_top');
    $xtpl->parse('main.action_bottom');
}

if ($num_items == $exams_info['num_question']) {
    $xtpl->assign('DISABLED', 'disabled');
}

if (isset($exams_info['input_question']) && $exams_info['input_question'] == 1) {
    $xtpl->parse('main.msword');
}

if (isset($exams_info['input_question']) && $exams_info['input_question'] == 3) {
    $xtpl->parse('main.msexcel');
}

if (!empty($cr_question)) {
    $xtpl->assign('cr_question', $cr_question);
    $xtpl->assign('cr_number', $cr_number);
    $xtpl->parse('main.load_question');
}
$nv_Lang->getModule('exams_question') = sprintf($nv_Lang->getModule('exams_question'), $exams_info['title']);

$xtpl->parse('main');
$contents = $xtpl->text('main');

$set_active_op = 'exams';
$page_title = $nv_Lang->getModule('exams_question');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';