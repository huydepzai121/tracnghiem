<?php

/**
 * @Project NUKEVIET 4.x
 * @Author hongoctrien (contact@mynukeviet.net)
 * @Copyright (C) 2016 hongoctrien. All rights reserved
 * @Createdate Wed, 27 Apr 2016 07:24:36 GMT
 */
if (!defined('NV_IS_MOD_TEST')) die('Stop!!!');
$array_isdone = $tester_answer = array();
$st_links = $array_config['st_links'];
$userid = defined('NV_IS_USER') ? $user_info['userid'] : 0;


list($user_idsite) = $db->query('SELECT idsite FROM ' . NV_USERS_GLOBALTABLE . ' WHERE userid="' . $userid . '"')->fetch(3);
/**
 * $examinations_subject['exam_id'] lưu id của kỳ thi ở table nv4_vi_test_examinations
 * $examinations_subject['examsid'] lưu id của đề thi ở table nv4_vi_test_exams nếu môn thi đó dạng đề thi ngẫu nhiên
 */
$examinations_subject = array();
if ($nv_Request->isset_request('exam_subject_id', 'post') || !empty($exam_subject_id)) {
    $exam_subject_id = !empty($exam_subject_id) ? $exam_subject_id : $nv_Request->get_int('exam_subject_id', 'post', 0);
    $examinations_subject_session = $nv_Request->get_string($module_data . '_examinations_subject', 'session', '');
    $examinations_subject_session = json_decode($examinations_subject_session, true);
    $examinations_subject = !empty($examinations_subject_session[$exam_subject_id]) ? $examinations_subject_session[$exam_subject_id] : array();
    if (empty($examinations_subject)) {
        $db->sqlreset()
            ->select('t1.title AS examinations_title, t2.title AS subject_title, t2.*, t3.questionid, t3.examsid')
            ->from(NV_PREFIXLANG . '_' . $module_data . '_examinations AS t1')
            ->join(
                'INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_exam_subject AS t2 ON t1.id = t2.exam_id '
                    . 'INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_subject_questions AS t3 ON t2.id = t3.subjectid '
            )
            ->where('t2.id = "' . $exam_subject_id . '"');
        $examsids = array();
        $questionids = array();
        $result = $db->query($db->sql());
        while ($row = $result->fetch(2)) {
            $examinations_subject = $row;
            if (!empty($row['examsid'])) $examsids[] = $row['examsid'];
            if (!empty($row['questionid'])) $questionids[] = $row['questionid'];
        }
        if (!empty($examinations_subject)) {
            $examinations_subject['examsid'] = !empty($examsids) ? $examsids[mt_rand(0, count($examsids) - 1)] : 0;
            $array_index = !empty($questionids) && (count($questionids) >= $examinations_subject['num_question']) ? array_rand($questionids, $examinations_subject['num_question']) : array_keys($questionids);
            $examinations_subject['questionid'] = array();
            foreach ($array_index as $i) {
                $examinations_subject['questionid'][] = $questionids[$i];
            }
            shuffle($examinations_subject['questionid']);
            $examinations_subject_session[$exam_subject_id] = $examinations_subject;
            $nv_Request->set_Session($module_data . '_examinations_subject', json_encode($examinations_subject_session));
        }
    }
    $id = $examinations_subject['examsid'];
}

if ($nv_Request->isset_request('set_end_time', 'post')) {
    $exam_data = $nv_Request->get_string($module_data . '_testing', 'session', '');
    if (!empty($exam_data)) {
        $exam_data = json_decode($exam_data, true);
        $exam_data['endtime'] = NV_CURRENTTIME;
        $nv_Request->set_Session($module_data . '_testing', json_encode($exam_data));

        if ($nv_Request) {
            if (!empty($user_info['userid'])) {
                $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_info_member_answer where userid=' . $user_info['userid']);
            } elseif (!empty($client_info['session_id'])) {
                $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_info_member_answer where session_id="' . $client_info['session_id'] . '"');
            }
        }

        die('OK');
    }
    trigger_error($nv_Lang->getModule('error_set_end_time'));
    die('NO');
}

function delete_info_member_answer()
{
    global $client_info, $user_info, $module_data, $db;
    if (!empty($user_info['userid'])) {
        $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_info_member_answer where userid=' . $user_info['userid'] . ' OR session_id="' . $client_info['session_id'] . '"');
    } elseif (!empty($client_info['session_id'])) {
        $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_info_member_answer where session_id="' . $client_info['session_id'] . '"');
    }
}
if ($nv_Request->isset_request('sendinfo', 'post')) {
    $id = $nv_Request->get_int('id', 'post', 0);
    $price = $nv_Request->get_int('price', 'post', 0);
    $questionid = $nv_Request->get_title('questionid', 'post', '');
    $answerid = $nv_Request->get_title('answerid', 'post', '');
    $_code = $nv_Request->get_title('code', 'post', '');

    if (defined('NV_IS_USER') && !defined('NV_IS_MODADMIN') && defined('NV_TEST_PAYMENT') && !empty($price)) {
        require_once NV_ROOTDIR . '/modules/wallet/wallet.class.php';
        $wallet = new nukeviet_wallet();
        if ($wallet->my_money($user_info['userid'])['money_total'] == 0) {
            die('NO_' . $nv_Lang->getModule('error_notenough'));
        }
    }

    delete_info_member_answer();

    $count_users_testing = $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_info_member_answer WHERE examid=' . $id . ' AND delete_time > ' . NV_CURRENTTIME)->fetchColumn();
    $count_users_testing_all = $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_info_member_answer WHERE delete_time > ' . NV_CURRENTTIME)->fetchColumn();
    if ($count_users_testing_all >= $global_config['max_user_test_site']) {
        die('NO_' . $nv_Lang->getModule('error_count_users_testing_all_site'));
    } elseif ($count_users_testing >= $global_config['max_user_test_room']) {
        die('NO_' . $nv_Lang->getModule('error_count_users_testing'));
    }

    list($timer, $type, $code, $begintime, $endtime, $history_save, $exams_max_time) = $db->query('SELECT timer, type, code, begintime, endtime, history_save, exams_max_time FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams WHERE id=' . $id)->fetch(3);
    if (!empty($examinations_subject)) {
        $code = !empty($examinations_subject['code']) ? $examinations_subject['code'] : nv_genpass(6, 3);
        list($timer, $type, $code, $begintime, $endtime, $history_save) = array($examinations_subject['timer'], 1, $code, $examinations_subject['begintime'], $examinations_subject['endtime'], 1);
    }
    if (!$timer) {
        die('NO_' . $nv_Lang->getModule('error_unknow'));
    } elseif (!empty($begintime) && $begintime > NV_CURRENTTIME) {
        die('NO_' . $nv_Lang->getModule('error_begintime'));
    } elseif (!empty($endtime) && $endtime < NV_CURRENTTIME) {
        die('NO_' . $nv_Lang->getModule('error_endtime'));
    } elseif ($type == 1 and !empty($code)) {
        if ($_code != $code) {
            die('NO_' . $nv_Lang->getModule('error_exams_code'));
        }
    }

    $db->sqlreset()
    ->select('COUNT(*)')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_answer')
    ->where('exam_id =' . $id . ' AND userid = '. $userid);
    $num_time_exam = $db->query($db->sql())->fetchColumn();
    if ($type == 1 && !empty($exams_max_time) && !empty($userid) && $num_time_exam > $exams_max_time) {
        die('NO_' . $nv_Lang->getModule('have_enough_time_exam'));
    }

    $exam_data = $nv_Request->get_string($module_data . '_testing', 'session', '');
    if (!empty($exam_data)) {
        $exam_data = json_decode($exam_data, true);
        $exam_data['begintime'] = NV_CURRENTTIME;
        $exam_data['duetime'] = $duetime = NV_CURRENTTIME + ($timer * 60);
        $nv_Request->set_Session($module_data . '_testing', json_encode($exam_data));

        if ($nv_Request) {
            if (!empty($user_info['userid'])) {
                $db->query('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_info_member_answer(session_id, examid, userid, delete_time) VALUES("' . $client_info['session_id'] . '", ' . $id . ', ' . $user_info['userid'] . ', ' . $duetime . ')');
            } elseif (!empty($client_info['session_id'])) {
                $db->query('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_info_member_answer(session_id, examid, delete_time) VALUES("' . $client_info['session_id'] . '", ' . $id . ', ' . $duetime . ')');
            }
        }

        die('OK_' . $duetime);
    }
    die('NO_' . $nv_Lang->getModule('error_unknow'));
}

if ($nv_Request->isset_request('upload_audio', 'post, get')) {
    $html_return = '';
    $audio_question_id = $nv_Request->get_int('audio_question_id', 'get', 0);
    $session_exam = $nv_Request->get_string($module_data . '_testing', 'session', '');
    $session_exam = json_decode($session_exam, true);
    $target_dir = NV_ROOTDIR . '/' . NV_TEMP_DIR . '/';

    $_FILES["audio_data"]["name"] = 'test_' . $session_exam['userid'] . '_' . $session_exam['id'] . '_' . $audio_question_id . '.wav';
    $target_file = $target_dir . basename($_FILES["audio_data"]["name"]);
    // Check if file already exists
    /* if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    } */

    // Check file size
    if ($_FILES["audio_data"]["size"] > $global_config['nv_max_size']) {
        echo 'ERROR_' . $nv_Lang->getModule('file_max_too_size');
        exit();
    }
    
    if (move_uploaded_file($_FILES["audio_data"]["tmp_name"], $target_file)) {
        $html_return = NV_BASE_SITEURL . NV_TEMP_DIR . '/' . $_FILES["audio_data"]["name"];
        echo $html_return;
        exit();
    } else {
        echo "Sorry, there was an error uploading your file.";
        exit();
    }
    exit();
}

if ($nv_Request->isset_request('save_exam', 'post')) {
    $id = $nv_Request->get_int('id', 'post', 0);
    $array_reponsive = array();
    if (!defined('NV_IS_USER')) {
        $array_reponsive['status'] = 0;
        $array_reponsive['message'] = $nv_Lang->getModule('login_to_save');
    } else {
        list($type) = $db->query('SELECT type FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams WHERE id=' . $id)->fetch(3);
        if ($type != 0) {
            $array_reponsive['status'] = 2;
            $array_reponsive['message'] = $nv_Lang->getModule('exams_not_allow_save');
        } else {

            list($userid) = $db->query('SELECT userid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_usersave WHERE examid=' . $id . ' AND userid=' . $user_info['userid'])->fetch(3);

            if ($userid == 0) {
                $_sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_usersave(examid, userid, add_time) VALUES(' . $id . ', ' . $user_info['userid'] . ', ' . NV_CURRENTTIME . ')';
                $new_id = $db->query($_sql);
                if ($new_id) {
                    $array_reponsive['status'] = 1;
                    $array_reponsive['message'] = $nv_Lang->getModule('exam_saved_reponsive');
                }
            } else {
                $array_reponsive['status'] = 1;
                $array_reponsive['message'] = $nv_Lang->getModule('exam_saved');
            }
        }
    }

    echo (json_encode($array_reponsive));
    exit();
} elseif ($nv_Request->isset_request('exit_exam', 'post')) {
    delete_info_member_answer();

    nv_unset_session();
    die();
}

// kiểm tra quyền xem chủ đề
if ($catid > 0) {
    if (!nv_user_in_groups($array_test_cat[$catid]['groups_view']) && empty($examinations_subject)) {
        $contents = nv_theme_alert($nv_Lang->getModule('exams_premission_none_title'), sprintf($nv_Lang->getModule('cat_premission_none_content'), $array_test_cat[$catid]['title']));
        include NV_ROOTDIR . '/includes/header.php';
        echo nv_site_theme($contents);
        include NV_ROOTDIR . '/includes/footer.php';
    }
}
$exam_info = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams WHERE isfull=1 AND id=' . $id)->fetch();
/*
lấy thông tin từ $examinations_subject
*/
if (!empty($examinations_subject)) {
    $exam_info['question_list'] = $examinations_subject['exam_type'] == 'random_question' ?  implode(',', $examinations_subject['questionid']) : $exam_info['question_list'];
    $exam_info['code'] = !empty($examinations_subject['code']) ? $examinations_subject['code'] : nv_genpass(6, 3);
    $exam_info['status'] = 1;
    $exam_info['timer'] = $examinations_subject['timer'];
    $exam_info['ladder'] = $examinations_subject['ladder'];
    $exam_info['num_question'] = $examinations_subject['exam_type'] == 'random_question' ? $examinations_subject['num_question'] : $exam_info['num_question'];
    $exam_info['title'] = $examinations_subject['title'];
    $exam_info['title'] = $examinations_subject['title'];
    $exam_info['begintime'] = $examinations_subject['begintime'];
    $exam_info['endtime'] = $examinations_subject['endtime'];

    // những thông tin này tạm code cứng để ở đây, sau này phát triển thêm lựa chọn trong kỳ thi, môn thi
    // nó sẽ lấy thông tin của đề thi nếu có hoặc sẽ lấy mặc định
    $exam_info['template'] = !empty($examinations_subject['template']) ? $examinations_subject['template'] : (!empty($exam_info['template']) ? $exam_info['template'] : 9);

    $exam_info['groups'] = !empty($examinations_subject['groups']) ? $examinations_subject['groups'] : (!empty($exam_info['groups']) ? $exam_info['groups'] : 6);

    $exam_info['groups_comment'] = !empty($examinations_subject['groups_comment']) ? $examinations_subject['groups_comment'] : (!empty($exam_info['groups_comment']) ? $exam_info['groups_comment'] : 6);

    $exam_info['groups_result'] = !empty($examinations_subject['groups_result']) ? $examinations_subject['groups_result'] : (!empty($exam_info['groups_result']) ? $exam_info['groups_result'] : 6);

    $keys = array(
        'random_question' => 1,
        'random_answer' => 1,
        'rating' => 1,
        'history_save' => 1,
        'multiple_test' => 1,
        'save_max_score' => 1,
        'print' => 1,
        'check_result' => 0,
        'view_mark_after_test' => 1,
        'view_question_after_test' => 0,
        'preview_question_test' => 0
    );
    foreach ($keys as $key => $value) {
        $exam_info[$key] = !empty($examinations_subject[$key]) ? $examinations_subject[$key] : (!empty($exam_info[$key]) ? $exam_info[$key] : $value);
    }
}
$table_question = (!empty($exam_info['isbank']) ? $db_config['dbsystem'] . "." : '') . NV_PREFIXLANG . '_' . $module_data . '_question';
/*
kiểm tra trong admin khi xem đề, nếu đề đã hoàn thiện thì tải trang còn không thì thông báo đề chưa hoàn thiện
*/
$check_is_full = $nv_Request->get_int('check_is_full', 'post, get', 0);
if (defined('NV_IS_AJAX') && !empty($check_is_full)) {
    $sendResutl = 'OK';
    if (!$exam_info) {
        $sendResutl = 'ERROR';
    }
    die($sendResutl);
}
//========================

if (!$exam_info) {
    $redirect = '<meta http-equiv="Refresh" content="3;URL=' . nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name, true) . '" />';
    nv_info_die($nv_Lang->getGlobal('error_404_title'), $nv_Lang->getGlobal('error_404_title'), $nv_Lang->getGlobal('error_404_content') . $redirect);
}
$exam_info['alert'] = $exam_info['score_note'] = 0;
if (defined('NV_IS_MODADMIN')) {
    if ($exam_info['status'] != 1) {
        $exam_info['alert'] = 1;
        $my_footer .= "<script type=\"text/javascript\">alert('" . $nv_Lang->getModule('exam_active_alert') . "')</script>";
    }
} elseif ($exam_info['status'] != 1) {
    $redirect = '<meta http-equiv="Refresh" content="3;URL=' . nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name, true) . '" />';
    nv_info_die($nv_Lang->getGlobal('error_404_title'), $nv_Lang->getGlobal('error_404_title'), $nv_Lang->getGlobal('error_404_content') . $redirect);
}

$array_listcat_menu = array();
if ($client_info['is_mobile']) {
    $exam_info['parentid'] = $array_test_cat[$exam_info['catid']]['parentid'] ? $array_test_cat[$exam_info['catid']]['parentid'] : $exam_info['catid'];
    foreach ($array_test_cat as $cat) {
        if ($cat['id'] == $exam_info['parentid']) {
            $array_listcat_menu[$cat['id']] = $cat;
        }
    }
}

$topic_array = $array_keyword = $array_other = $related_array = $related_new_array = $array_question_highlight = array();
$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_test_cat[$exam_info['catid']]['alias'] . '/' . $exam_info['alias'] . '-' . $exam_info['id'] . $global_config['rewrite_exturl'];
$exam_info['allow_start'] = $exam_info['istesting'] = $exam_info['isdone'] = $exam_info['issave'] = $exam_info['btn_start_disabled'] = $exam_info['time_test'] = 0;
$exam_info['alert_permission'] = $exam_info['url_share'] = $exam_info['alert_payment'] = '';
$view_result = ($exam_info['check_result'] == 1);

// Nhóm câu hỏi chung
$group_question = array();
$result = $db->query('SELECT id, title, answer FROM ' . $table_question . ' WHERE examid =' . $exam_info['id'] . ' AND type = 3');
while (list($questionid, $title, $answer) = $result->fetch(3)) {
    $answer = unserialize($answer);
    $group_question[$questionid] = array(
        'from_question' => $answer['from_question'] - 1,
        'to_question' => $answer['to_question'] - 1
    );
    $group_question[$questionid]['title'] = $title;
}
$exam_info['group_question'] = $group_question;
$exam_info['group_question_point'] = array();
// Phân tích để khi hiện câu hỏi ở bài làm thì sẽ hiện thị câu hỏi chung tương ứng
foreach ($group_question as $k => $group) {
    for ($i = $group['from_question']; $i <= $group['to_question']; $i++) {
        $exam_info['group_question_point'][$i] = $k;
    }
}
// nộp bài
if ($nv_Request->isset_request('save_test', 'post')) {
    $exam_id = $nv_Request->get_int('exam_id', 'post', 0);
    $exam_info['true'] = $exam_info['false'] = $exam_info['skeep'] = 0;
     /*
        $exam_info['exams_type'] = 0 : chỉ có câu tự luận
        $exam_info['exams_type'] = 1 : chỉ có câu trắc nghiệm
        $exam_info['exams_type'] = 2 : cả tự luận và trắc nghiệm
        Sẽ được tính toán ở bên dưới
    */
    $exam_info['exams_type'] = 1;
    $total_question = 0;
    $total_question_div = 0; // Tổng số câu hỏi chia điểm.
    $total_mark_private = 0; // Tổng điểm riêng của các câu hỏi
    $total_question_have_not_mark = 0;
    $had_mark_private = 0; // Tổng điểm riêng của các câu hỏi mà thí sinh có được (bao gồm điểm ở dạng 5)
    /**
     * Tổng số câu hỏi "Đánh giá năng lực" làm đúng đáp án cao nhất.
     */
    $total_question_5_true = 0; 
    $total_question_private_mark_true = 0; //Tổng số câu hỏi có điểm riêng được đánh giá đúng
    $session_exam = $nv_Request->get_string($module_data . '_testing', 'session', '');
    if (!empty($session_exam)) {

        $session_exam = json_decode($session_exam, true);
        $tester_answer = $nv_Request->get_array('answer', 'post'); // mảng các lựa chọn của người thi
        $end_time = isset($session_exam['endtime']) ? $session_exam['endtime'] : NV_CURRENTTIME; // thời gian nộp bài
        $questionid = $session_exam['questionid']; // danh sách id câu hỏi của lượt thi này

        // lấy thông tin danh sách câu hỏi
        $array_question = array();
        $result = $db->query('SELECT * FROM ' . $table_question . ' WHERE id IN (' . implode(',', $questionid) . ') AND type != 3 ORDER BY FIELD(id, ' . implode(',', $questionid) . ')');
        while ($row = $result->fetch()) {
            $exam_info['exams_type'] *= (in_array($row['type'], array(1, 2, 4, 5)) ?  2 :   1 );
            $exam_info['exams_type'] *= (in_array($row['type'], array(6, 7)) ?  3 :   1 );

            $_answer = unserialize($row['answer']);
            $row['answer'] = array();
            $row['max_mark'] = 0;
            if (in_array($row['type'], array(1, 2, 5))) {
                foreach ($_answer as $answer) {
                    $row['answer'][$answer['id']] = $answer;
                }
            } else  if (in_array($row['type'], array(4))) {
                $row['answer'] = $_answer;
            }
            // Lấy điểm cao nhất của kiểu câu hỏi "đánh giá năng lực"
            if ($row['type'] == 5) {
                $row['max_mark'] = 0;
                foreach ($_answer as $item) {
                    $row['max_mark'] = $item['point'] > $row['max_mark'] ? $item['point']  : $row['max_mark'];
                }
            }
            $total_question ++;
            $total_question_div += (
                (in_array($row['type'], array(1,2,4,7)) && 
                empty($row['mark_max_constructed_response'])) ? 1 : 0
            );

            $total_mark_private += (
                (in_array($row['type'], array(1,2,4,6,7)) && 
                !empty($row['mark_max_constructed_response'])) ? $row['mark_max_constructed_response'] : 0
            );
            $total_mark_private += (($row['type'] == 5) ? $row['max_mark'] : 0);
            $array_question[$row['id']] = $row;
        }
       
        $exam_info['exams_type'] = ($exam_info['exams_type'] % 6 == 0) ? '2' : (($exam_info['exams_type'] % 2 == 0) ? '1' : '0');

        if (!empty($tester_answer) and !empty($array_question)) {
            // duyệt qua các câu trả lời của người thi
            foreach ($tester_answer as $questionid => $answerid) {
                $result = false;
                // Nếu không tồn tại câu hỏi đó thì bỏ qua
                if (!isset($array_question[$questionid])) {
                    continue;
                }
                // Nếu là câu hỏi loại Điền vào ô trống mà không có đáp án
                if (($array_question[$questionid]['type'] == 2) && (empty(array_diff($answerid, array(
                    ''
                ))))   ) {
                    unset($tester_answer[$questionid]);
                    continue;
                }

                if (in_array($array_question[$questionid]['type'], array(1,2,5))) {
                    $count_true = 0;
                    foreach ($array_question[$questionid]['answer'] as $qanswer) {
                        if ($array_question[$questionid]['type'] == 1) {
                            if ($array_question[$questionid]['count_true'] > 1) {
                                $answerid = array_map('intval', $answerid);
                                if (sizeof($answerid) == $array_question[$questionid]['count_true']) {
                                    foreach ($answerid as $_answerid) {
                                        if (intval($qanswer['id']) == $_answerid && $qanswer['is_true']) {
                                            $count_true++;
                                        }
                                    }
                                }
                            } else if (intval($qanswer['id']) == $answerid) {
                                $result = $qanswer['is_true'];
                                break;
                            }
                        } elseif ($array_question[$questionid]['type'] == 2) {
                            if (mb_strtolower($qanswer['is_true']) == mb_strtolower($answerid[$qanswer['id']])) {
                                $count_true++;
                            }
                        } elseif ($array_question[$questionid]['type'] == 5) {
                            if (intval($qanswer['id']) == $answerid) {
                                $result = ($qanswer['point'] == $array_question[$questionid]['max_mark']);
                                $had_mark_private += $qanswer['point'];
                                break;
                            }
                        }
                    }

                    if ($array_question[$questionid]['count_true'] > 1 or $array_question[$questionid]['type'] == 2) {
                        $result = $count_true == $array_question[$questionid]['count_true'];
                    }
                } 
                else if(in_array($array_question[$questionid]['type'], array(4))) {
                    $result = $array_question[$questionid]['answer'] == intval($answerid);
                } 
                else if(in_array($array_question[$questionid]['type'], array(6))) {
                    // nếu đề có ít nhất 1 câu tự luận thì hiện ghi chú "(Cho phần trả lời trắc nghiệm)"
                    $exam_info['score_note'] = 1;
                    // nếu nội dung trả lời rỗng thì xóa luôn
                    if (empty($answerid)) {
                        unset($tester_answer[$questionid]);
                        continue;
                    }
                } 
                else if(in_array($array_question[$questionid]['type'], array(7))) {
                    // nếu đề có ít nhất 1 câu tự luận thì hiện ghi chú "(Cho phần trả lời trắc nghiệm)"
                    $exam_info['score_note'] = 1;
                    // nếu nội dung trả lời rỗng thì xóa luôn
                    
                    $randon_file_name = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'), 0, 5);

                    if (!file_exists(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload . '/' . date('Y', NV_CURRENTTIME))) {
                        nv_mkdir(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload . '/', date('Y', NV_CURRENTTIME));
                    };
                    if (file_exists(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/test_' . $user_info['userid'] . '_' . $exam_info['id'] . '_' . $questionid . '.wav')) {
                        rename(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/test_' . $user_info['userid'] . '_' . $exam_info['id'] . '_' . $questionid . '.wav', NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload . '/' . date('Y', NV_CURRENTTIME) . '/test_' . $user_info['userid'] . '_' . $exam_info['id'] . '_' . $questionid . '_' .$randon_file_name . '.wav' );
                        $tester_answer[$questionid] = date('Y', NV_CURRENTTIME) . '/test_' . $user_info['userid'] . '_' . $exam_info['id'] . '_' . $questionid . '_' .$randon_file_name . '.wav';
                    }

                } 

                $array_question_highlight[$questionid] = !$view_result ? '' : ($result ? 'is_success' : 'is_danger');

                $had_mark_private += ($result && !empty($array_question[$questionid]['mark_max_constructed_response']) ? $array_question[$questionid]['mark_max_constructed_response'] : 0);

                $total_question_private_mark_true += ( $result && in_array($array_question[$questionid]['type'], array(1,2,4)) && !empty($array_question[$questionid]['mark_max_constructed_response']) ? 1: 0);
                $total_question_5_true += ( $result && $array_question[$questionid]['type'] == 5 ? 1 : 0);
                $exam_info['true'] += ($result ? 1 : 0);

                $total_question_have_not_mark += ($array_question[$questionid]['type'] == 6 || $array_question[$questionid]['type'] == 7? 1 : 0);
            }
        }
        $exam_info['skeep'] = $total_question - count($tester_answer);
        $exam_info['false'] = count($tester_answer) - $exam_info['true'] - $total_question_have_not_mark;
        $exam_info['total_question_have_not_mark'] = $total_question_have_not_mark;

        $exam_info['score'] = ($total_question_div > 0 ) ? round(($exam_info['ladder'] - $total_mark_private) / $total_question_div * ($exam_info['true'] - $total_question_5_true - $total_question_private_mark_true), 2) + $had_mark_private : $had_mark_private;
        $time_test = $end_time - $session_exam['begintime'];

        if ($time_test <= ($exam_info['timer'] * 60)) {
            // nếu nộp bài trước hoặc tự thu bài
            $exam_info['time_test'] = $time_test;
        } elseif (($time_test - ($exam_info['timer'] * 60)) <= 5) {
            // nếu tgian làm bài có chênh lệch trong 5 giây thì cũng chấp nhận
            $exam_info['time_test'] = $exam_info['timer'] * 60;
        } else {
            // nếu tgian vượt quá do người thi cố tình gian lận
            $examinations_subject_examid = $nv_Request->get_string($module_data . '_examinations_subject', 'session', '');
            nv_unset_session();
            $nv_Request->set_Session($module_data . '_examinations_subject', $examinations_subject_examid);
            $contents = nv_theme_alert($nv_Lang->getModule('error_timeover_title'), $nv_Lang->getModule('error_timeover_content'), 'danger');
            include NV_ROOTDIR . '/includes/header.php';
            echo nv_site_theme($contents);
            include NV_ROOTDIR . '/includes/footer.php';
        }
        $exam_info['time_test'] = nv_convertfromSec($exam_info['time_test']);

        if ($exam_info['rating']) {
            $percent = ($exam_info['true'] * 100) / $exam_info['num_question'];
            $exam_info['rating'] = nv_get_rating($percent);
        }
        if (!empty($session_exam['userid']) and $exam_info['history_save']) {
            try {

                $new_id = 0;
                $is_insert = true;
                if ($exam_info['save_max_score']) {
                    $history_max_score = $db->query('SELECT MAX(count_true) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_answer WHERE userid=' . $userid . ' AND exam_id=' . $exam_id)->fetchColumn();
                    if ($exam_info['true'] <= intval($history_max_score)) {
                        $is_insert = false;
                    }
                }

                list($exam_type) = $db->query('SELECT type FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams WHERE id="' . $session_exam['id'] . '"')->fetch(3);
                //Cấu hình cho phép lưu lịch sử ở các gói
                $is_insert = $is_insert && ($global_config['save_result'] == true);
                $is_insert = $is_insert && (
                    (!empty($user_idsite) && (in_array($user_idsite, $array_idsite))) ||
                    (empty($user_idsite) && ($exam_type == 0) && ($array_config['config_history_user_common'] == 1)) ||
                    (empty($user_idsite) && ($global_config['idsite'] == 0) && ($array_config['config_history_user_common'] == 1))
                );
                if ($is_insert) {
                    // xóa kết quả thấp hơn trong trường hợp chỉ lưu kết quả cao nhất
                    if ($exam_info['save_max_score'] && ($exam_info['true'] >= intval($history_max_score))) {
                        $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_answer WHERE userid=' . $userid . ' AND exam_id=' . $exam_id);
                    }
                    $_sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_answer(exam_id, exam_subject, userid, begin_time, end_time, test_time, count_true, count_false, count_skeep, score, answer, test_exam_question, test_exam_answer) VALUES(:exam_id, :exam_subject, :userid, :begin_time, ' . $end_time . ', :test_time, :count_true, :count_false, :count_skeep, :score, :answer, :test_exam_question, :test_exam_answer)';
                    $data_insert = array();
                    $data_insert['exam_id'] = $exam_id;
                    $data_insert['userid'] = $session_exam['userid'];
                    $data_insert['exam_subject'] = !empty($examinations_subject['id'])  ? $examinations_subject['id'] : 0;
                    $data_insert['begin_time'] = $session_exam['begintime'];
                    $data_insert['test_time'] = $time_test;
                    $data_insert['count_true'] = $exam_info['true'];
                    $data_insert['count_false'] = $exam_info['false'];
                    $data_insert['count_skeep'] = $exam_info['skeep'];
                    $data_insert['score'] = $exam_info['score'];
                    $data_insert['answer'] = serialize($tester_answer);
                    $data_insert['test_exam_question'] = nv_serialize($session_exam['questionid']);
                    $data_insert['test_exam_answer'] = nv_serialize($session_exam['answerid']);
                    $new_id = $db->insert_id($_sql, 'id', $data_insert);
                }

                if ($new_id > 0) {
                    $exam_info['issave'] = 1;
                    $exam_info['isdone'] = 1;
                    $exam_info['url_share'] = NV_MY_DOMAIN . nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=share&id=' . $new_id, true);

                    $nv_Request->set_Session($module_data . '_testing_aswer_id', $new_id);

                    $array_isdone = $session_exam;
                    nv_unset_session();
                } else {
                    $exam_info['isdone'] = 1;
                    $array_isdone = $session_exam;
                    nv_unset_session();
                }
            } catch (Exception $e) {
                trigger_error($e->getMessage());
            }
        } else {
            $exam_info['isdone'] = 1;
            $array_isdone = $session_exam;
            nv_unset_session();
        }
    }

    // cập nhật số lượt làm bài của đề thi
    if ($exam_info['isdone']) {
        $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_exams SET hittest=hittest+1 WHERE id=' . $exam_id);

        // trừ tiền tài khoản
        if (defined('NV_IS_USER') && !defined('NV_IS_MODADMIN') && defined('NV_TEST_PAYMENT') && $exam_info['price'] > 0) {
            require_once NV_ROOTDIR . '/modules/wallet/wallet.class.php';
            $wallet = new nukeviet_wallet();
            $link = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_test_cat[$exam_info['catid']]['alias'] . '/' . $exam_info['alias'] . '-' . $exam_info['id'] . $global_config['rewrite_exturl'];
            $message = sprintf($nv_Lang->getModule('exams_price_note'), $link, $exam_info['title']);
            $wallet->update($exam_info['price'], 'VND', $userid, $message);
        }
    }
}

// nếu bài thi chấm điểm, nhóm thi không phải là khách, thì buộc đăng nhập
if (!defined('NV_IS_USER') && $array_config['alert_type'] == 0 && ($exam_info['type'] == 1 || intval($exam_info['groups']) != 6 || (defined('NV_TEST_PAYMENT') && $exam_info['price'] > 0))) {
    $url_back = NV_BASE_SITEURL . 'index.php?' . NV_NAME_VARIABLE . '=users&' . NV_OP_VARIABLE . '=login&nv_redirect=' . nv_redirect_encrypt($client_info['selfurl']);

    $my_head .= '<title>' . $global_config['site_name'] . ' - ' . $exam_info['title'] . '</title>';

    $meta_property['og:title'] = $exam_info['title'];
    $meta_property['og:type'] = 'website';
    $meta_property['og:description'] = (!empty($exam_info['hometext'])) ? $exam_info['hometext'] : $exam_info['title'];
    $meta_property['og:site_name'] = $global_config['site_name'];
    $meta_property['og:url'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_test_cat[$exam_info['catid']]['alias'] . '/' . $exam_info['alias'] . '-' . $exam_info['id'] . $global_config['rewrite_exturl'];

    if (!empty($exam_info['image']) && file_exists(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $exam_info['image'])) {
        $exam_info['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $exam_info['image'];
        $meta_property['og:image'] = NV_MY_DOMAIN . $exam_info['image'];
    }

    $contents = nv_theme_alert($nv_Lang->getModule('is_user_title'), $nv_Lang->getModule('is_user_content'), 'info', $url_back, $nv_Lang->getModule('login'), 31556926); //settimeout 1 year
    include NV_ROOTDIR . '/includes/header.php';
    echo nv_site_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
}
// Những tài khoản không thuộc site quản lý thì không được phép làm bài thi có hình thức "chấm điểm"
if (defined('NV_IS_USER') && !empty($user_idsite) && (!in_array($user_idsite, $array_idsite)) && ($exam_info['type'] == 1)) {
    $contents = "<h3 class=\"disallow-history\">" . $nv_Lang->getModule('disallow_exam') . "</h3>";
    include NV_ROOTDIR . '/includes/header.php';
    echo nv_site_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
}
if (!empty($userid) and !$exam_info['multiple_test'] and !$exam_info['isdone'] and !empty($exam_info['id'])) {
    $count = $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_answer WHERE exam_id=' . $exam_info['id'] . ' AND userid=' . $userid)->fetchColumn();
    if ($count > 0) {
        $contents = nv_theme_alert($page_title, $nv_Lang->getModule('error_exam_tested_content'), 'danger');
        include NV_ROOTDIR . '/includes/header.php';
        echo nv_site_theme($contents);
        include NV_ROOTDIR . '/includes/footer.php';
    }
}
if (!nv_user_in_groups($exam_info['groups']) && $array_config['alert_type'] == 0 && empty($examinations_subject)) {
    $groups = array();
    $lang_login = $url_login = '';
    $groups_list = nv_exams_groups_list();
    $exam_info['groups'] = explode(',', $exam_info['groups']);
    foreach ($exam_info['groups'] as $group_id) {
        $groups[] = $groups_list[$group_id]['title'];
    }
    $nv_Lang->setModule('exams_premission_none_content', sprintf($nv_Lang->getModule('exams_premission_none_content'), implode(', ', $groups)));
    if (!defined('NV_IS_USER')) {
        $lang_login = $nv_Lang->getGlobal('loginsubmit');
        $url_login = NV_BASE_SITEURL . 'index.php?' . NV_NAME_VARIABLE . '=users&' . NV_OP_VARIABLE . '=login&nv_redirect=' . nv_redirect_encrypt($client_info['selfurl']);
    }
    $contents = nv_theme_alert($nv_Lang->getModule('exams_premission_none_title'), $nv_Lang->getModule('exams_premission_none_content'), 'warning', $url_login, $lang_login);
    include NV_ROOTDIR . '/includes/header.php';
    echo nv_site_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
}
$array_saved_data = $array_data = $array_tmp = array();
$exam_data = $nv_Request->get_string($module_data . '_testing', 'session', '');
if (!empty($exam_data)) {
    $exam_data = json_decode($exam_data, true);
    if ($exam_data['checkhash'] != md5($userid . $exam_info['id'] . $global_config['sitekey'] . $client_info['browser']['key'])) {
        nv_unset_session();
        $my_footer .= "<script type=\"text/javascript\">nv_test_unset_answer(); window.location.href = window.location.href;</script>";
    }
    $array_saved_data = $exam_data;
} elseif (!empty($array_isdone)) {
    $array_saved_data = $array_isdone;
}

$exam_info['view_answer'] = 0;
$exam_info['questionid'] = array();
$content_comment = '';
// nếu đã bắt đầu làm bài
if (!empty($array_saved_data) && !empty($array_saved_data['questionid']) && !empty($array_saved_data['answerid']) && !empty($array_saved_data['begintime'])) {
    $exam_info['question_total'] = 0;
    $questionid = $array_saved_data['questionid'];
    $answerid = $array_saved_data['answerid'];

    if (nv_user_in_groups($exam_info['groups_result']) and !empty($array_isdone)) {
        $exam_info['view_answer'] = 1;
    }

    if (!empty($array_saved_data['begintime'])) {
        $exam_info['istesting'] = 1;
    }

    $result = $db->query('SELECT * FROM ' . $table_question . ' WHERE id IN (' . implode(',', $questionid) . ') ORDER BY FIELD(id, ' . implode(',', $questionid) . ')');
    while ($row = $result->fetch()) {
        $answer = unserialize($row['answer']);

        $row['answer'] = array();
        if (!empty($answerid[$row['id']])) {
            foreach ($answerid[$row['id']] as $_answerid) {
                if ($row['type'] == 1 || $row['type'] == 2 || $row['type'] == 3 || $row['type'] == 5) {
                    $row['answer'][$_answerid] = $answer[$_answerid];
                } elseif ($row['type'] == 4) {
                    $row['answer'][$_answerid] = $answer;
                }
            }
        }

        if ($row['type'] != 4) {
            foreach ($row['answer'] as $index => $answer) {

                if ($row['type'] == 1 || $row['type'] == 5) {
                    $answer['is_true_highlight'] = 0;
                    $answer['is_true_string'] = '';
                    $answer['is_true_answer'] = '';
                    $answer['checked'] = '';

                    if (!empty($tester_answer)) {
                        if (isset($tester_answer[$row['id']])) {
                            if (is_array($tester_answer[$row['id']])) {
                                $tester_answer[$row['id']] = array_map('intval', $tester_answer[$row['id']]);
                                if (in_array($answer['id'], $tester_answer[$row['id']])) {
                                    $answer['checked'] = 'checked="checked"';
                                }
                            } else {
                                if ($answer['id'] == intval($tester_answer[$row['id']])) {
                                    $answer['checked'] = 'checked="checked"';
                                }
                            }
                        }
                    }

                    if (isset($answer['is_true']) && $answer['is_true'] && $exam_info['view_answer'] && $view_result) {
                        $answer['is_true_highlight'] = 1;
                    }
                } elseif ($row['type'] == 2) {
                    $answer['is_true_highlight'] = 0;
                    $answer['is_true_string'] = '';
                    $answer['is_true_answer'] = '';

                    if ($exam_info['view_answer'] && $view_result) {
                        $answer['is_true_string'] = $answer['is_true'];
                    }

                    if (!empty($tester_answer)) {
                        if (isset($tester_answer[$row['id']])) {
                            if (isset($tester_answer[$row['id']][$answer['id']])) {
                                $answer['is_true_answer'] = $tester_answer[$row['id']][$answer['id']];
                            }
                        }
                    }
                }
                $row['answer'][$index] = $answer;
            }

            if ($row['type'] == 6 && $row['answer_editor_type'] == 0) {
                if (!nv_function_exists('nv_aleditor') and file_exists(NV_ROOTDIR . '/' . NV_EDITORSDIR . '/ckeditor/ckeditor.js')) {
                    if (!defined('NV_EDITOR')) {
                        define('NV_EDITOR', true);
                    }
                    if (!defined('NV_IS_CKEDITOR')) {
                        define('NV_IS_CKEDITOR', true);
                    }
                    $my_head .= '<script type="text/javascript" src="' . NV_BASE_SITEURL . NV_EDITORSDIR . '/ckeditor/ckeditor.js"></script>';

                    function nv_aleditor($textareaname, $width = '100%', $height = '450px', $val = '', $customtoolbar = '')
                    {
                        global $module_data;
                        $return = '<textarea style="width: ' . $width . '; height:' . $height . ';" id="' . $module_data . '_' . $textareaname . '" name="' . $textareaname . '">' . $val . '</textarea>';
                        $return .= "<script type=\"text/javascript\">
                    		CKEDITOR.replace( '" . $module_data . "_" . $textareaname . "', {" . (!empty($customtoolbar) ? 'toolbar : "' . $customtoolbar . '",' : '') . " width: '" . $width . "',height: '" . $height . "', filebrowserUploadUrl : '/'});
                    		</script>";
                        return $return;
                    }
                }
            }
        } elseif ($row['type'] == 4) {
            $row['answer'] = array(
                'highlight' => 0,
                'checked' => 0
            );

            if (!empty($tester_answer)) {
                $row['answer']['checked'] = isset($tester_answer[$row['id']]) ? $tester_answer[$row['id']] : 0;
            }

            if ($exam_info['view_answer'] && $view_result) {
                $row['answer']['highlight'] = $answer;
            }
        }

        if ($exam_info['isdone']) {
            if (isset($array_question_highlight[$row['id']])) {
                $row['highlight'] = $array_question_highlight[$row['id']];
            } else {
                $row['highlight'] = 'is_danger';
            }
        }

        $exam_info['questionid'][] = $row['id'];
        $array_tmp[$row['id']] = $row;
    }
    unset($array_question_highlight);

    if (!empty($questionid)) {
        foreach ($questionid as $index) {
            $array_data[$index] = $array_tmp[$index];
        }
    }
} else {
    // nếu đang ở giao diện chờ làm bài
    // xử lý thời gian mở đề

    if (!empty($exam_info['begintime']) && !empty($exam_info['endtime'])) {
        if ($exam_info['begintime'] <= NV_CURRENTTIME && $exam_info['endtime'] >= NV_CURRENTTIME) {
            $nv_Lang->setModule('begintime_note', $nv_Lang->getModule('begintime_1'));
        } else {
            // $nv_Lang->getModule('begintime_note') = $nv_Lang->getModule('begintime_2');
            $nv_Lang->setModule('begintime_note', sprintf($nv_Lang->getModule('begintime_4'), nv_date('H:i, d/m/Y', $exam_info['begintime']), nv_date('H:i, d/m/Y', $exam_info['endtime'])));
            $exam_info['btn_start_disabled'] = 1;
        }
    } elseif (!empty($exam_info['begintime'])) {
        if ($exam_info['begintime'] <= NV_CURRENTTIME) {
            $nv_Lang->setModule('begintime_note', $nv_Lang->getModule('begintime_1'));
        } else {
            $nv_Lang->setModule('begintime_note', sprintf($nv_Lang->getModule('begintime_3'), nv_date('H:i d/m/Y', $exam_info['begintime'])));
            $exam_info['btn_start_disabled'] = 1;
        }
    } elseif (!empty($exam_info['endtime'])) {
        if ($exam_info['endtime'] >= NV_CURRENTTIME) {
            $nv_Lang->setModule('begintime_note', $nv_Lang->getModule('begintime_1'));
        } else {
            $nv_Lang->setModule('begintime_note', $nv_Lang->getModule('begintime_2'));
            $exam_info['btn_start_disabled'] = 1;
        }
    }
    // kiểm tra lượt thi nếu có giới hạn
    $db->sqlreset()
    ->select('COUNT(*)')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_answer')
    ->where('exam_id =' . $id . ' AND userid = '. $userid);
    $num_time_exam = $db->query($db->sql())->fetchColumn();
    if ($exam_info['type'] == 1  && !empty($exams_max_time) && !empty($userid) && $num_time_exam > $exams_max_time) {
        $url_history = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['history'];
            $exam_info['test_limit_note'] = sprintf($nv_Lang->getModule('test_limit_note'), vsprintf('%02s', $exam_info['test_limit']), $url_history);
            $exam_info['btn_start_disabled'] = 1;
    }

    // nếu dùng ngân hàng câu hỏi và check chọn "Tạo lại bộ câu hỏi theo cấu hình sau mỗi lượt thi"
    if ($exam_info['input_question'] == 2 && $exam_info['exams_reset_bank']) {
        $exam_info['question_list'] = nv_test_random_question($exam_info['exams_config']);
        $exam_info['question_list'] = implode(',', $exam_info['question_list']);
    }
    // Xử lý trường hợp đề thi không có câu hỏi
    if (empty($exam_info['question_list'])) {
        $xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
        $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
        $xtpl->parse('not_question');
        $contents = $xtpl->text('not_question');
        include NV_ROOTDIR . '/includes/header.php';
        echo nv_site_theme($contents);
        include NV_ROOTDIR . '/includes/footer.php';
    }

    $result = $db->query('SELECT id, answer, type, answer_fixed FROM ' . $table_question . ' WHERE id IN (' . $exam_info['question_list'] . ') AND type != 3 ORDER BY FIELD(id, ' . $exam_info['question_list'] . ')');
    
    while (list($questionid, $answer, $type, $answer_fixed) = $result->fetch(3)) {
        $answer = unserialize($answer);
        $exam_info['questionid'][] = $questionid;
        $answer_empty_count = 0;
        if (is_array($answer)) {
            foreach ($answer as $_answer) {
                $exam_info['answerid'][$questionid][] = intval($_answer['id']);
                $answer_empty_count += (empty(trim($_answer['content'])) ? 1 : 0 );
            }
        } else {
            $exam_info['answerid'][$questionid][] = intval($answer);
        }

        if ($exam_info['random_answer'] && empty($answer_fixed) && ($answer_empty_count == 0)) {
            $exam_info['answerid'][$questionid] = shuffle_assoc($exam_info['answerid'][$questionid]);
        }
    }
    $my_array = array("red", "green", "blue", "yellow", "purple");

    if (isset($exam_info['mix_question'])) {
        if ($exam_info['mix_question'] == '1') {
            if (!empty($group_question)) {
                $f_qs = 0;
                $shuffle_question = array();
                foreach ($group_question as $group) {
                    $shuffle_question = array_merge($shuffle_question, shuffle_assoc(array_slice($exam_info['questionid'], $f_qs, $group['from_question'] - $f_qs)));
                    $shuffle_question = array_merge($shuffle_question, shuffle_assoc(array_slice($exam_info['questionid'], $group['from_question'], $group['to_question'] - $group['from_question'] + 1)));
                    $f_qs = $group['to_question'] + 1;
                }
                $shuffle_question = array_merge($shuffle_question, shuffle_assoc(array_slice($exam_info['questionid'], $f_qs)));
                $exam_info['questionid'] = $shuffle_question;
            } else {
                $exam_info['questionid'] = shuffle_assoc($exam_info['questionid']);
            }

        } else if (strlen($exam_info['mix_question']) > 1) {
            $question_part = explode(',', $exam_info['mix_question']);
            foreach ($question_part as $part) {
                list($f, $l) = explode('-', $part);
                if (empty($f) || empty($l) || ($f == $l)) continue;
                $f--;
                $l--;
                $shuffle_question = array();
                if (!empty($group_question)) {
                    $f_qs = $f;
                    $shuffle_question = array();
                    foreach ($group_question as $group) {
                        if (($group['to_question'] < $f) || ($group['from_question'] > $l)) continue;
                        if ($group['from_question'] >= $f_qs) {
                            $shuffle_question = array_merge($shuffle_question, shuffle_assoc(array_slice($exam_info['questionid'], $f_qs, $group['from_question'] - $f_qs)));
                            $f_qs = $group['from_question'];
                        }
                        $group['to_question'] = $group['to_question'] > $l ? $l : $group['to_question'];
                        $shuffle_question = array_merge($shuffle_question, shuffle_assoc(array_slice($exam_info['questionid'], $f_qs, $group['to_question'] - $f_qs + 1)));
                        $f_qs = $group['to_question'] + 1;
                    }
                    $shuffle_question = array_merge($shuffle_question, shuffle_assoc(array_slice($exam_info['questionid'], $f_qs, $l - $f_qs + 1)));
                } else {
                    $shuffle_question = array_slice($exam_info['questionid'], $f, $l - $f + 1);
                    shuffle_assoc($shuffle_question);
                }
                array_splice($exam_info['questionid'], $f, $l - $f + 1, $shuffle_question);
            }
            
        }
    }
    $exam_data = array(
        'id' => $exam_info['id'],
        'userid' => $userid,
        'begintime' => 0,
        'questionid' => $exam_info['questionid'],
        'answerid' => $exam_info['answerid'],
        'duetime' => 0,
        'checkhash' => md5($userid . $exam_info['id'] . $global_config['sitekey'] . $client_info['browser']['key'])
    );
    
    $nv_Request->set_Session($module_data . '_testing', json_encode($exam_data));

    if (!$array_isdone and $exam_info['type'] == 0) {
        $result = $db->query('SELECT * FROM ' . $table_question . ' WHERE id IN (' . implode(',', $exam_info['questionid']) . ') ORDER BY FIELD(id, ' . implode(',', $exam_info['questionid']) . ')');
        while ($row = $result->fetch()) {
            $row['answer'] = unserialize($row['answer']);
            $array_data[$row['id']] = $row;
        }
    }
}

$exam_info['question_total'] = count($array_data);

if (!empty($exam_info['image']) && file_exists(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $exam_info['image'])) {
    $exam_info['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $exam_info['image'];
    $meta_property['og:image'] = NV_MY_DOMAIN . $exam_info['image'];
}

// đếm lượt xem
$time_set = $nv_Request->get_int($module_data . '_' . $op . '_' . $id, 'session');
if (empty($time_set) && !empty($exam_info['id'])) {
    $nv_Request->set_Session($module_data . '_' . $op . '_' . $exam_info['id'], NV_CURRENTTIME);
    $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_exams SET hitstotal=hitstotal+1 WHERE id=' . $exam_info['id']);
}
$exam_info['title_save_action'] = $nv_Lang->getModule('exam_save');
if (defined('NV_IS_USER') && !empty($exam_info['id'])) {
    list($_userid) = $db->query('SELECT userid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_usersave WHERE examid=' . $exam_info['id'] . ' AND userid=' . $user_info['userid'])->fetch(3);
    if ($_userid > 0) {
        $exam_info['title_save_action'] = '<i class="fa fa-check" aria-hidden="true"></i>&nbsp;' . $nv_Lang->getModule('exam_saved');
        $exam_info['disable_save_action'] = ' disabled=disabled';
    }
}

// thông tin tùy biến dữ liệu
if ($userid > 0) {
    $custom_fields = $array_field_config = array();
    $result_field = $db->query('SELECT * FROM ' . NV_USERS_GLOBALTABLE . '_field WHERE show_profile=1 ORDER BY weight ASC');
    while ($row_field = $result_field->fetch()) {
        $language = unserialize($row_field['language']);
        $row_field['title'] = (isset($language[NV_LANG_DATA])) ? $language[NV_LANG_DATA][0] : $row['field'];
        $row_field['description'] = (isset($language[NV_LANG_DATA])) ? nv_htmlspecialchars($language[NV_LANG_DATA][1]) : '';
        if (!empty($row_field['field_choices'])) {
            $row_field['field_choices'] = unserialize($row_field['field_choices']);
        } elseif (!empty($row_field['sql_choices'])) {
            $row_field['sql_choices'] = explode('|', $row_field['sql_choices']);
            $query = 'SELECT ' . $row_field['sql_choices'][2] . ', ' . $row_field['sql_choices'][3] . ' FROM ' . $row_field['sql_choices'][1];
            $result = $db->query($query);
            $weight = 0;
            while (list($key, $val) = $result->fetch(3)) {
                $row_field['field_choices'][$key] = $val;
            }
        }
        $array_field_config[$row_field['field']] = $row_field;
    }

    $sql = 'SELECT * FROM ' . NV_USERS_GLOBALTABLE . '_info WHERE userid=' . $userid;
    $result = $db->query($sql);
    $custom_fields = $result->fetch();
    foreach ($array_basic_key as $key) {
        if (isset($custom_fields[$key])) {
            $custom_fields[$key] = $user_info[$key];
        }
    }
}

if (!$exam_info['istesting']) {

    // kiểm tra quyền làm bài
    if (!nv_user_in_groups($exam_info['groups']) && $array_config['alert_type'] == 1) {
        $exam_info['btn_start_disabled'] = 1;
        $groups = array();
        $lang_login = $url_login = '';
        $groups_list = nv_exams_groups_list();
        $exam_info['groups'] = explode(',', $exam_info['groups']);
        foreach ($exam_info['groups'] as $group_id) {
            $groups[] = $groups_list[$group_id]['title'];
        }
        if (!defined('NV_IS_USER')) {
            $exam_info['alert_permission'] = sprintf($nv_Lang->getModule('exams_premission_none_content_login'), implode(', ', $groups));
        } else {
            $exam_info['alert_permission'] = sprintf($nv_Lang->getModule('exams_premission_none_content'), implode(', ', $groups));
        }
    }

    // kiểm tra tài khoản tiền
    // nếu không phải là người quản trị
    if (defined('NV_IS_USER') && !defined('NV_IS_MODADMIN')) {
        // nếu có tích hợp tk tiền và đề thi có thu tiền
        if (defined('NV_TEST_PAYMENT') && $exam_info['price'] > 0) {
            require_once NV_ROOTDIR . '/modules/wallet/wallet.class.php';
            $wallet = new nukeviet_wallet();

            // kiểm tra số dư
            $money = $wallet->my_money($user_info['userid']);
            if ($money['money_current'] < $exam_info['price']) {
                $exam_info['btn_start_disabled'] = 1;
                $exam_info['alert_payment'] = sprintf($nv_Lang->getModule('error_exams_price_payment'), nv_test_number_format($money['money_current']), $money['money_unit']);
            }

            $exam_info['price'] = nv_test_number_format($exam_info['price']);
            $exam_info['price_unit'] = $money['money_unit'];
        } else {
            $exam_info['price'] = 0;
        }
    } elseif (!empty($exam_info['price'])) {
        $exam_info['price'] = nv_test_number_format($exam_info['price']);
    }

    // comment
    if (isset($site_mods['comment']) and isset($array_config['activecomm'])) {
        define('NV_COMM_ID', $exam_info['id']);
        define('NV_COMM_AREA', $module_info['funcs'][$op]['func_id']);

        //check allow comemnt
        $allowed = $module_config[$module_name]['allowed_comm'];
        if ($allowed == '-1') {
            $allowed = $exam_info['groups_comment'];
        }

        define('NV_PER_PAGE_COMMENT', 5);

        // Số bản ghi hiển thị bình luận
        require_once NV_ROOTDIR . '/modules/comment/comment.php';
        $area = (defined('NV_COMM_AREA')) ? NV_COMM_AREA : 0;
        $checkss = md5($module_name . '-' . $area . '-' . NV_COMM_ID . '-' . $allowed . '-' . NV_CACHE_PREFIX);

        $url_info = parse_url($client_info['selfurl']);
        $content_comment = nv_comment_module($module_name, $checkss, $area, NV_COMM_ID, $allowed, 1);
    } else {
        $content_comment = '';
    }

    if ($st_links > 0 && empty($examinations_subject)) {
        // đề thi mới hơn
        $db->sqlreset()
            ->select('id, catid, title, alias, image, userid, num_question, addtime')
            ->from(NV_PREFIXLANG . '_' . $module_data . '_exams')
            ->where('status=1 AND isfull=1 AND addtime > ' . $exam_info['addtime'])
            ->order(nv_test_get_order_exams())
            ->limit($st_links);

        $related = $db->query($db->sql());
        while ($row = $related->fetch()) {
            if (!empty($data = nv_show_exams($row, $module_name))) {
                $related_new_array[$row['id']] = $data;
            }
        }

        // đề thi cũ hơn
        $db->sqlreset()
            ->select('id, catid, title, alias, image, userid, num_question, addtime')
            ->from(NV_PREFIXLANG . '_' . $module_data . '_exams')
            ->where('status=1 AND isfull=1 AND addtime < ' . $exam_info['addtime'])
            ->order(nv_test_get_order_exams())
            ->limit($st_links);

        $related = $db->query($db->sql());
        while ($row = $related->fetch()) {
            if (!empty($data = nv_show_exams($row, $module_name))) {
                $related_array[$row['id']] = $data;
            }
        }

        // đề thi cùng chủ đề
        $db->sqlreset()
            ->select('id, catid, title, alias, image, userid, num_question, addtime')
            ->from(NV_PREFIXLANG . '_' . $module_data . '_exams')
            ->where('status=1 AND isfull=1 AND catid=' . $exam_info['catid'] . ' AND id!=' . $exam_info['id'])
            ->order(nv_test_get_order_exams())
            ->limit($st_links);

        $related = $db->query($db->sql());
        while ($row = $related->fetch()) {
            if (!empty($data = nv_show_exams($row, $module_name))) {
                $array_other[$row['id']] = $data;
            }
        }
    }

    if ($exam_info['topicid'] > 0 & $st_links > 0 && empty($examinations_subject)) {
        list($topic_title, $topic_alias) = $db->query('SELECT title, alias FROM ' . NV_PREFIXLANG . '_' . $module_data . '_topics WHERE topicid = ' . $exam_info['topicid'])->fetch(3);

        $exam_info['topiclink'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['topic'] . '/' . $topic_alias;

        $db->sqlreset()
            ->select('id, catid, title, alias, image, userid, num_question, addtime')
            ->from(NV_PREFIXLANG . '_' . $module_data . '_exams')
            ->where('status=1 AND isfull=1 AND topicid = ' . $exam_info['topicid'] . ' AND id != ' . $exam_info['id'])
            ->order(nv_test_get_order_exams())
            ->limit($st_links);
        $topic = $db->query($db->sql());
        while ($row = $topic->fetch()) {
            if (!empty($data = nv_show_exams($row, $module_name))) {
                $topic_array[$row['id']] = $data;
            }
        }
        $topic->closeCursor();
        unset($topic, $rows);
    }
}

$key_words = array();
if (empty($examinations_subject)) {
    $_query = $db->query('SELECT a1.keyword, a2.alias FROM ' . NV_PREFIXLANG . '_' . $module_data . '_tags_id a1 INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_tags a2 ON a1.tid=a2.tid WHERE a1.id=' . $exam_info['id']);
    while ($row = $_query->fetch()) {
        $array_keyword[] = $row;
        $key_words[] = $row['keyword'];
        $meta_property['article:tag'][] = $row['keyword'];
    }
}

$page_title = $exam_info['title'];
$key_words = !empty($key_words) ? implode(',', $key_words) : '';
$description = $exam_info['hometext'];

$exam_info['help_content'] = $db->query('SELECT econtent FROM ' . NV_PREFIXLANG . '_' . $module_data . '_econtent WHERE action="helptest"')->fetchColumn();

// nguồn
$exam_info['source'] = '';
if ($exam_info['sourceid']) {
    $result = $db->query('SELECT title, link, logo FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sources WHERE sourceid = ' . $exam_info['sourceid']);
    list($sourcetext, $source_link, $source_logo) = $result->fetch(3);
    unset($sql, $result);
    if ($array_config['config_source'] == 0) {
        $exam_info['source'] = $sourcetext; // Hiển thị tiêu đề nguồn tin
    } elseif ($array_config['config_source'] == 1) {
        $exam_info['source'] = '<a title="' . $sourcetext . '" rel="nofollow" href="' . $exam_info['sourcetext'] . '">' . $source_link . '</a>'; // Hiển thị link của nguồn tin
    } elseif ($array_config['config_source'] == 3) {
        $exam_info['source'] = '<a title="' . $sourcetext . '" href="' . $exam_info['sourcetext'] . '">' . $source_link . '</a>'; // Hiển thị link của nguồn tin
    } elseif ($array_config['config_source'] == 2 and !empty($source_logo)) {
        $exam_info['source'] = '<img width="100px" src="' . NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/source/' . $source_logo . '">';
    }
}

$array_mod_title[] = array(
    'title' => $page_title,
    'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_test_cat[$exam_info['catid']]['alias'] . '/' . $exam_info['alias'] . '-' . $exam_info['id'] . $global_config['rewrite_exturl']
);

/**
 * @author dungpt
 * @link https://vinades.org/dauthau/dauthau.info/-/issues/864
 * @since 25/02/2022
 */
require NV_ROOTDIR . '/modules/' . $module_file . '/crm/set_user_dotest.php';

$exams_template = $array_config['examp_template'];
if ($exam_info['template'] != 9) {
    $exams_template = $exam_info['template'];
}
if ($exams_template == 0) {
    // hien thi theo danh sach duoc thiet lap trong cau hinh module
    $contents = nv_theme_test_detail($exam_info, $array_data, $array_saved_data, $tester_answer, $base_url, $content_comment, $array_keyword, $array_other, $related_new_array, $related_array, $topic_array, $array_listcat_menu, $examinations_subject);
} elseif ($exams_template == 1) {
    // hien thi tung cau hoi duoc thiet lap trong cau hinh module
    $contents = nv_theme_test_detail2($exam_info, $array_data, $array_saved_data, $tester_answer, $base_url, $content_comment, $array_keyword, $array_other, $related_new_array, $related_array, $topic_array, $array_listcat_menu, $examinations_subject);
}
include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
