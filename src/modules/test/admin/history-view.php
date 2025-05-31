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
$print_view = $nv_Request->get_int('print_view', 'get', 0);
$id = $nv_Request->get_int('id', 'get', 0);
$page = $nv_Request->get_int('page', 'get', 1);
$array_data = array();
$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;id=' . $id;

if ($nv_Request->isset_request('save_admin_test', 'post,get')) {
    $data_marks = $nv_Request->get_array('data_marks', 'post', array());
    $stmt = $db->prepare('UPDATE '  . NV_PREFIXLANG . '_' . $module_data . '_answer SET mark_constructed_response = :mark_constructed_response WHERE id='. $id);
    $stmt->bindValue(':mark_constructed_response', serialize($data_marks), PDO::PARAM_STR);
    $stmt->execute();
    die('OK');
}

$module_info['template'] = 'default';
require_once NV_ROOTDIR . '/modules/' . $module_file . '/theme.php';

$answer_info = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_answer WHERE id=' . $id)->fetch();
if (empty($answer_info)) {
    Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=history');
    die();
}
$exam_subject_id = $answer_info['exam_subject'];
$exams_info = array();
if (!empty($exam_subject_id)) {
    $exams_info = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exam_subject WHERE id=' . $exam_subject_id)->fetch();

}else {
    $exams_info = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams WHERE id=' . $answer_info['exam_id'])->fetch();
}
if (empty($exams_info)) {
    Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=history');
    die();
}


$exams_info['type'] = $array_exam_type[$exams_info['type']];
$exams_info['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_test_cat[$exams_info['catid']]['alias'] . '/' . $exams_info['alias'] . '-' . $exams_info['id'] . $global_config['rewrite_exturl'];
$exams_info['istesting'] = 0;

$user = $db->query('SELECT first_name, last_name, username, birthday, email FROM ' . NV_USERS_GLOBALTABLE . ' WHERE userid=' . $answer_info['userid'])->fetch();
$answer_info['fullname'] = nv_show_name_user($user['first_name'], $user['last_name'], $user['username']);
$answer_info['birthday'] = nv_date('d/n/Y', $user['birthday']);
$answer_info['email'] = $user['email'];
$time_test = $answer_info['end_time'] - $answer_info['begin_time'];
$answer_info['time_test'] = nv_convertfromSec($time_test);


$percent = ($answer_info['count_true'] * 100) / ($answer_info['count_true'] + $answer_info['count_false'] + $answer_info['count_skeep']);
$answer_info['rating'] = nv_get_rating($percent);

$mark_constructed_response = nv_unserialize($answer_info['mark_constructed_response']);
$test_exam_question = nv_unserialize($answer_info['test_exam_question']);
$test_exam_answer = nv_unserialize($answer_info['test_exam_answer']);
$tester_answer = nv_unserialize($answer_info['answer']);
if (empty($test_exam_question) || empty($test_exam_answer)) {
    return '';
}
$exam_info['exams_type'] = 1;
$result = $db->query('SELECT id, type FROM ' . NV_PREFIXLANG . '_' . $module_data . '_question WHERE id IN (' . implode(',', $test_exam_question) . ') AND type != 3 ORDER BY FIELD(id, ' . implode(',', $test_exam_question) . ')');
$i=0;
$answer_info['score_multi_choice'] = $answer_info['score'];
$answer_info['score_constructed_response'] = 0;
while ($row = $result->fetch()) {
    $i++;
    if ($row['type'] == 1 || $row['type'] == 2  || $row['type'] == 4 || $row['type'] == 5) {
        $exam_info['exams_type']*=2;
    } elseif ($row['type'] == 6 || $row['type'] == 7) {
        $answer_info['constructed_response'][$row['id']]=array('title' => $nv_Lang->getModule('question') . " " . $i, 'result' => !empty($mark_constructed_response[$row['id']]) ? $mark_constructed_response[$row['id']]: '');
        $exam_info['exams_type']*=3;
        $answer_info['score_constructed_response'] += !empty($mark_constructed_response[$row['id']]) ? $mark_constructed_response[$row['id']]: 0;
    }
}

$answer_info['total_question_have_not_mark'] = $i - $answer_info['count_true'] - $answer_info['count_false'] - $answer_info['count_skeep'];
$answer_info['score'] = $answer_info['score_multi_choice'] + $answer_info['score_constructed_response'];
$exam_info['exams_type'] = ($exam_info['exams_type'] % 6 == 0) ? '2' : (($exam_info['exams_type'] % 2 == 0) ? '1' : '0');

// Cấu hình để mặc định trong lịch sử thi không hiện thị phân trang.
$exams_info['per_page'] = 0;

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('ANSWER_INFO', $answer_info);
$xtpl->assign('EXAM_INFO', $exams_info);
$xtpl->assign('VIEW_ANSWER', nv_test_history_view_answer($exams_info, $answer_info, $print_view));
$xtpl->assign('LINK_PRINT', $base_url . '&print_view=1');
$xtpl->assign('LINK_PRINT_BACK', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&id=' . $id);
$redirect = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=history&examid=' . $answer_info['exam_id'];
$xtpl->assign('LINK_DELETE', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=history&amp;delete_id=' . $id . '&amp;delete_checkss=' . md5($id . NV_CACHE_PREFIX . $client_info['session_id']) . '&redirect=' . nv_redirect_encrypt($redirect));

if (!empty($print_view)) {
    $xtpl->parse('main.print');
}
if ($exam_info['exams_type'] == 0 || $exam_info['exams_type'] == 2) {
    foreach($answer_info['constructed_response'] as $value) {
        $xtpl->assign('LOOP', $value);
        $xtpl->parse('main.exams_type_0.loop');
    }
    $xtpl->parse('main.exams_type_0');
}
if ($exam_info['exams_type'] == 1) {
    $xtpl->parse('main.rating');
}
if ($exam_info['exams_type'] == 1 || $exam_info['exams_type'] == 2) {
    $xtpl->parse('main.exams_type_1');
}
if ($exam_info['exams_type'] == 2) {
    $xtpl->parse('main.exams_type_title_0');
    $xtpl->parse('main.exams_type_title_1');
    $xtpl->parse('main.exams_score_type_0');
    $xtpl->parse('main.exams_score_type_1');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = sprintf($nv_Lang->getModule('exams_answer_of'), $answer_info['fullname']);
$set_active_op = 'exams';

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents, !$print_view);
include NV_ROOTDIR . '/includes/footer.php';