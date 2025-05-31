<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 3-6-2010 0:14
 */
if (!defined('NV_IS_MOD_TEST')) {
    die('Stop!!!');
}

$alias_cat_url = $array_op[1];
$array_page = explode('-', $array_op[2]);
$id = $nv_Request->get_string($module_data . '_testing_aswer_id', 'session', '');
$exam_id = intval(end($array_page));

$answer_info = !empty($id) ? $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_answer WHERE id=' . $id)->fetch() : array();

$exams_info = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams WHERE id=' . ( !empty($answer_info) ?$answer_info['exam_id'] : $exam_id )  )->fetch();


$exams_info['type'] = $array_exam_type[$exams_info['type']];
$exams_info['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_test_cat[$exams_info['catid']]['alias'] . '/' . $exams_info['alias'] . '-' . $exams_info['id'] . $global_config['rewrite_exturl'];
$exams_info['istesting'] = 0;

if (!empty($answer_info)) {
    $user = $db->query('SELECT first_name, last_name, username, birthday, email FROM ' . NV_USERS_GLOBALTABLE . ' WHERE userid=' . $answer_info['userid'])->fetch();
    $answer_info['fullname'] = nv_show_name_user($user['first_name'], $user['last_name'], $user['username']);
    $answer_info['birthday'] = nv_date('d/n/Y', $user['birthday']);
    $answer_info['email'] = $user['email'];
    $time_test = $answer_info['end_time'] - $answer_info['begin_time'];
    $answer_info['time_test'] = nv_convertfromSec($time_test);
    
    $percent = ($answer_info['count_true'] * 100) / ($answer_info['count_true'] + $answer_info['count_false'] + $answer_info['count_skeep']);
    $answer_info['rating'] = nv_get_rating($percent);
    $test_exam_question = nv_unserialize($answer_info['test_exam_question']);
    $test_exam_answer = nv_unserialize($answer_info['test_exam_answer']);
    $tester_answer = nv_unserialize($answer_info['answer']);
} else {
    $table_question = (!empty($exams_info['isbank'])? $db_config['dbsystem'] . "." : '') . NV_PREFIXLANG . '_' . $module_data . '_question'; 
    $test_exam_question = explode(',', $exams_info['question_list']);
    $test_exam_answer = array();
    $result = $db->query('SELECT id, answer, type, answer_fixed FROM ' . $table_question . ' WHERE id IN (' . $exams_info['question_list'] . ') ORDER BY FIELD(id, ' . $exams_info['question_list'] . ')');
    while (list($questionid, $answer, $type, $answer_fixed) = $result->fetch(3)) {
        $answer = unserialize($answer);

        if (is_array($answer)) {
            foreach ($answer as $_answer) {
                $test_exam_answer[$questionid][] = intval($_answer['id']);
            }
        } else {
            $test_exam_answer[$questionid][] = intval($answer);
        }

        if ($exam_info['random_answer'] && empty($answer_fixed)) {
            $test_exam_answer[$questionid] = shuffle_assoc($test_exam_answer[$questionid]);
        }
    }
    $tester_answer = array();
}

if (empty($test_exam_question) || empty($test_exam_answer)) {
    return '';
}

$exams_info['isdone'] = 1;
$exams_info['view_answer'] = 1;

$array_data = $array_tmp = array();
$result = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_question WHERE id IN (' . implode(',', $test_exam_question) . ') ORDER BY FIELD(id, ' . implode(',', $test_exam_question) . ')');
while ($row = $result->fetch()) {
    $answer = unserialize($row['answer']);

    $row['answer'] = array();
    foreach ($test_exam_answer[$row['id']] as $_answerid) {
        $row['answer'][$_answerid] = $answer[$_answerid];
    }

    if ($row['type'] == 6) {
        $row['answer'] = '';
    } elseif ($row['type'] != 4) {
        foreach ($row['answer'] as $index => $answer) {
            $answer['is_true_highlight'] = 0;
            $answer['is_true_string'] = '';
            $answer['is_true_answer'] = '';
            if ($row['type'] == 1 or $row['type'] == 3 || $row['type'] == 5) {
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

                if (isset($answer['is_true']) && $answer['is_true'] && $exams_info['view_answer']) {
                    $answer['is_true_highlight'] = 1;
                }
            } elseif ($row['type'] == 2) {
                if ($exams_info['view_answer']) {
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
    } elseif ($row['type'] == 4) {
        $row['answer'] = array(
            'highlight' => 0,
            'checked' => 0
        );

        if (!empty($tester_answer)) {
            $row['answer']['checked'] = $tester_answer[$row['id']];
        }

        if ($exams_info['view_answer']) {
            $row['answer']['highlight'] = $answer;
        }
    }

    $array_tmp[$row['id']] = $row;
}

if (!empty($test_exam_question)) {
    foreach ($test_exam_question as $index) {
        $array_data[$index] = $array_tmp[$index];
    }
}

if ($array_data) {
    nv_print_questions($array_data, $exams_info, $tester_answer, "print", false, false);
} else {
    nv_info_die($nv_Lang->getGlobal('error_404_title'), $nv_Lang->getGlobal('error_404_title'), $nv_Lang->getGlobal('error_404_content'), 404);
}

header('Location: ' . $global_config['site_url']);
exit();