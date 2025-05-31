<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 27-11-2010 14:43
 */
if (!defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

function create_merge_history($ids_question, $config, $number_exam, $exam_title) {
    global $db, $module_name, $module_data, $lang_module, $admin_info;
    // Lấy nội dung câu hỏi
    $question_list = array();
    $db->sqlreset()->select('title, answer, type')->from(NV_PREFIXLANG . '_' . $module_data . '_question')->where('id IN (' . implode(',', $ids_question) . ')');
    $result = $db->query($db->sql());
    while ($row = $result->fetch(2)) {
        $row['answer'] = unserialize($row['answer']);
        $question_list[] = $row;
    }
    $result = array();
    for ($i = 1; $i <= $number_exam; $i++) {
        $random_id = 'MDT: ' . $i;
        $result[$random_id] = array();
        $question_shuffle = shuffle_assoc($question_list);
        foreach ($question_shuffle as $k => $value) {
            $answer_shuffle = shuffle_assoc($value['answer']);
            $result[$random_id][$k] = array_keys($answer_shuffle);
        }
    }


    /* insert history data*/
    $data_insert = array();
    $sql_ins = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_history_merge (examid_list, title, content, number_exams, create_time) VALUES (:examid_list, :title, :content, :number_exams, :create_time)';

    $data_insert['examid_list'] = implode(',', array_keys($config));
    $data_insert['title'] = $exam_title;
    $data_insert['content'] = serialize(array(
        'question_list' => $question_list,
        'result' => $result,
        'config' => $config
    ));
    $data_insert['number_exams'] = $number_exam;
    $data_insert['create_time'] = NV_CURRENTTIME;
    $new_id = $db->insert_id($sql_ins, 'id', $data_insert);
    nv_insert_logs(NV_LANG_DATA, $module_name, $nv_Lang->getModule('merge_history'), $data_insert['title'] . " (id:#". $new_id . ")", $admin_info['userid']);
    return $new_id;
}

$idsite = $global_config['idsite'];

$messages_op1 = [];
$folder_merged = 'merged';
$folder_merged_path = NV_ROOTDIR . '/modules/' . $module_data . '/' . $folder_merged . '/';
$table_cats = $db_config['dbname'] . '.' . NV_PREFIXLANG . '_' . $module_data . '_cat';
$table_exams = $db_config['dbname'] . '.' . NV_PREFIXLANG . '_' . $module_data . '_exams';
$table_question = $db_config['dbname'] . '.' . NV_PREFIXLANG . '_' . $module_data . '_question';
$table_site = $db_config['dbsystem'] . '.' . $db_config['prefix'] . '_site';
$table_history = $db_config['dbname'] . '.' . NV_PREFIXLANG . '_' . $module_data . '_history_merge';

$exam_id = $nv_Request->get_int('exam_id', 'get, post', 0);

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);
$xtpl->assign('MERGE_OP1', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&merge_opt_1=1');
$xtpl->assign('MERGE_OP2', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&merge_opt_2=1');
$xtpl->assign('MERGE_HISTORY', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&merge_history');
$xtpl->assign('PACKAGE_NOTIICE', nv_package_notice(0));
$test_nav = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=exams';
$config_topcontent = sprintf($nv_Lang->getModule('top_content_info'), NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=config#top-content-exam');

if ($turn_off_msg) {
    $xtpl->parse('main.msg_none');
} else {
    $xtpl->parse('main.msg_show');
}

if ($global_config['merge_exams']) {
    $merge_opt_1 = $nv_Request->isset_request('merge_opt_1', 'get');
    $merge_opt_2 = $nv_Request->isset_request('merge_opt_2', 'get');
    $merge_history = $nv_Request->isset_request('merge_history', 'get');
    $number_question = $nv_Request->get_int('number_question', 'post', null);
    $number_exam = $nv_Request->get_int('number_exam', 'post', null);
    $config = array();
    $title_exam_opt_2 = '';
    if ($nv_Request->isset_request('reuse', 'get')) {
        $id = $nv_Request->get_int('id_history', 'get', 0);
        if ($id > 0) {
            $db->sqlreset()->select('*')->from('' . $table_history)->where('id=' . $id);
            $sth = $db->prepare($db->sql());
            $sth->execute();
            $row = $sth->fetch();
            $content = unserialize($row['content']);
            $config = $content['config'];
            $merge_opt_1 = count($content['config']) == 1 ? true : false;
            $merge_opt_2 = count($content['config']) > 1 ? true : false;
            $merge_history = false;
            $number_exam = $row['number_exams'];
            $title_exam_opt_2 = $row['title'];
            $number_question = array_reduce($content['config'], function($a, $b) {
                return $a + $b;
            }, 0);
            if ($merge_opt_1) {
                $exam_id = array_keys($content['config'])[0];
            }
        } else {
            $xtpl->assign('ERROR', $nv_Lang->getModule('error_reuse'));
            $xtpl->parse('main.is_paid.merge_exams_opt_2.messages_opt_2');
        }
    }

    /* shuffle mode 1 */
    if ($nv_Request->isset_request('create_exam', 'post')) {

        if (empty($number_question) or $number_question == 0) {
            $messages_op1 = [
                'class' => 'alert alert-danger',
                'message' => $nv_Lang->getModule('required_number_question')
            ];
        } elseif (empty($number_exam) or $number_exam == 0) {
            $messages_op1 = [
                'class' => 'alert alert-danger',
                'message' => $nv_Lang->getModule('required_number_exam')
            ];
        } else {
            $exam_title = $exam_alias = '';
            $db->sqlreset()->select('title,alias')->from('' . $table_exams)->where('id=' . $exam_id);
            $sth = $db->prepare($db->sql());
            $sth->execute();
            while ($exam_qry = $sth->fetch()) {
                $exam_title = $exam_qry['title'];
                $exam_alias = $exam_qry['alias'];
            }
            /* get id question from exam*/
            $question_arr = $data_shuffle = [];
            $db->sqlreset()->select('id')->from('' . $table_question)->where('examid=' . $exam_id);
            $sth = $db->prepare($db->sql());
            $sth->execute();
            while ($question_qry = $sth->fetch()) {
                $question_arr[] = $question_qry['id'];
            }
            $ids_question = [];
            if ($number_question <= count($question_arr)) {
                $random_keys = array_rand($question_arr, $number_question);
                if (count($random_keys) > 1) {
                    foreach ($random_keys as $random_key) {
                        $ids_question[] = $question_arr[$random_key];
                    }
                } else {
                    $ids_question[] = $question_arr[$random_keys];
                }

                $mh_id = create_merge_history($ids_question, array($exam_id => $number_question), $number_exam, $exam_title);
                export_word_from_merge_history($mh_id);
            } else {
                $messages_op1 = [
                    'class' => 'alert alert-danger',
                    'message' => $nv_Lang->getModule('number_question_too_big')
                ];
            }
        }
    }

    if ($merge_opt_1) {
        $xtpl->assign('NUMBER_QUESTION', $number_question ? $number_question : '');
        $xtpl->assign('NUMBER_EXAM', $number_exam ? $number_exam : '');
        $db->sqlreset()->select('title, num_question')->from('' . $table_exams)->where('status=1 AND id=' . $exam_id);
        $sth = $db->prepare($db->sql());
        $sth->execute();
        while ($exam = $sth->fetch()) {
            if (!empty($exam)) {
                $xtpl->assign('TITLE', $exam['title']);
                $xtpl->assign('exam_id', $exam_id);
                $xtpl->assign('QUESTIONS', $exam['num_question']);
                $xtpl->parse('main.is_paid.merge_exams_opt_1.loop');
            }
        }
        
        $xtpl->assign('style_messages_opt_1', (empty($exam_id) && empty($exam)) ? 'style="display: block"' : 'style="display: none"');

        $xtpl->assign('TOP_CONTENT', $config_topcontent);
        $xtpl->parse('main.is_paid.merge_exams_opt_1');
    }

    /* shuffle mode 2 */
    if ($nv_Request->isset_request('create_exam_2', 'post')) {

        $exams = $nv_Request->get_typed_array('exams', 'post', '');
        $title_exam = $nv_Request->get_title('title_exam', 'post', '');
       
        if (empty($number_question) or $number_question == 0) {
            $messages_op2 = [
                'class' => 'alert alert-danger',
                'message' => $nv_Lang->getModule('required_number_question')
            ];
        } elseif (empty($number_exam) or $number_exam == 0) {
            $messages_op2 = [
                'class' => 'alert alert-danger',
                'message' => $nv_Lang->getModule('required_number_exam')
            ];
        } elseif (empty($title_exam)) {
            $messages_op2 = [
                'class' => 'alert alert-danger',
                'message' => $nv_Lang->getModule('required_title_exam')
            ];
        } else {
            $question_arr = $random_keys = [];
            $id_question = $data_shuffle = [];

            /* get list questions from exam id */
            foreach ($exams as $key => $questions) {
                if (!empty($questions)) {
                    $db->sqlreset()->select('id')->from('' . $table_question)->where('examid=' . $key);
                    $sth = $db->prepare($db->sql());
                    $sth->execute();
                    while ($exam_qry = $sth->fetch()) {
                        $question_arr[$key][] = $exam_qry['id'];
                    }
                }
            }

            /** Kiểm tra xem số lượng câu hỏi cần lấy có vượt qua số lượng câu hỏi đang có không */
            $test_num_question_too_max = false;
            foreach ($exams as $key => $questions) {
                $test_num_question_too_max = ($test_num_question_too_max || $questions > count($question_arr[$key]));
            }
            if (!$test_num_question_too_max) {
                /* create random array from number question by exam id */
                $array_examid = [];
                foreach ($question_arr as $exam_id => $question_id) {
                    $array_examid[] = $exam_id;
                    $random_keys[$exam_id] = array_rand($question_id, $exams[$exam_id]);
                }
    
                /* push question id to new array */
                foreach ($random_keys as $examid => $random_key) {
                    if (is_array($random_key)) {
                        foreach ($random_key as $random_num) {
                            $id_question[] = $question_arr[$examid][$random_num];
                        }
                    } else {
                        $id_question[] = $question_arr[$examid][$random_key];
                    }
                }
    
                $mh_id = create_merge_history($id_question, $exams, $number_exam, $title_exam);
                export_word_from_merge_history($mh_id);
            } else {
                $error = $nv_Lang->getModule('error_num_question_too_max');
            }
        }
    }
    if ($merge_opt_2) {
        /* Constant default variable */
        $per_page = 10;
        $page = 1;
        $base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&merge_opt_2';

        $db->sqlreset()->select('COUNT(*)')->from($table_exams);
        $num_items = $db->query($db->sql())->fetchColumn();
        
        /* Request search by ajax */
        if ($nv_Request->isset_request('search_exams', 'post, get')) {
            $select_exam_arr = [];
            $search_key = $nv_Request->get_title('search_key', 'post,get', '');
            $db->sqlreset()->select('*')->from($table_exams)->where('title LIKE "%' . $search_key . '%" AND status = 1');
            $result = $db->query($db->sql());
            while ($row = $result->fetch()) {
                $select_exam_arr[] = $row;
            }
            nv_jsonOutput($select_exam_arr);
        }

        /* Submit search */
        if ($nv_Request->isset_request('submit_search', 'post, get')) {
            $examid = $nv_Request->get_int('examid', 'post', 0);
            $selected_examid = $nv_Request->get_int('selected_examid', 'post', 0);
            $db->sqlreset()->select('*')->from($table_exams)->where('id=' . $examid);
            $sth = $db->prepare($db->sql());
            $sth->execute();
            $result = [];
            while ($row = $sth->fetch()) {
                $xtpl->assign('STT', 1);
                $xtpl->assign('EXAMS', $row);
                if (!empty($selected_examid)) {
                    $xtpl->parse('main.is_paid.merge_exams_opt_2.loop.disable_click');
                } else {
                    $xtpl->parse('main.is_paid.merge_exams_opt_2.loop.btn_add_exam');
                }
                $xtpl->parse('main.is_paid.merge_exams_opt_2.loop');
                $result['html'] = $xtpl->text('main.is_paid.merge_exams_opt_2.loop');
            }
            $result['paginate'] = '';
            nv_jsonOutput($result);
        }

        /* Ajax pagination */
        if ($nv_Request->isset_request('paginate', 'post, get')) {
            $page = $nv_Request->get_int('page', 'post');
            $db->sqlreset()->select('*')->from($table_exams)->order('id DESC')->limit($per_page)->offset(($page - 1) * $per_page);
            $sth = $db->prepare($db->sql());
            $sth->execute();
            $e = 0;
            $result_page = [];
            while ($exams = $sth->fetch()) {
                $e++;
                if ($page > 1) {
                    $stt = $e + ($page - 1) * $per_page;
                } else {
                    $stt = $e;
                }
                $xtpl->assign('STT', $stt);
                $xtpl->assign('EXAMS', $exams);
                $xtpl->parse('main.is_paid.merge_exams_opt_2.loop.btn_add_exam');
                $xtpl->parse('main.is_paid.merge_exams_opt_2.loop');
                $result_page['html'] = $xtpl->text('main.is_paid.merge_exams_opt_2.loop');
            }

            $generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
            if (!empty($generate_page)) {
                $xtpl->assign('GENERATE_PAGE', $generate_page);
                $xtpl->parse('main.is_paid.merge_exams_opt_2.generate_page');
                $result_page['paginate'] = $xtpl->text('main.is_paid.merge_exams_opt_2.generate_page');
            }
            nv_jsonOutput($result_page);
        } else {
            $db->select('*')->order('id DESC')->limit($per_page)->offset(($page - 1) * $per_page);
            $sth = $db->prepare($db->sql());
            $sth->execute();

            $arr_exams = [];
            $e = 0;
            while ($exams = $sth->fetch()) {
                $arr_exams[] = $exams;
                $e++;
                if ($page > 1) {
                    $stt = $e + ($page - 1) * $per_page;
                } else {
                    $stt = $e;
                }
                $xtpl->assign('STT', $stt);
                $xtpl->assign('EXAMS', $exams);
                if (in_array($exams['id'], array_keys($config))) {
                    $xtpl->parse('main.is_paid.merge_exams_opt_2.loop.disable_click');
                } else {
                    $xtpl->parse('main.is_paid.merge_exams_opt_2.loop.btn_add_exam');
                }
                $xtpl->parse('main.is_paid.merge_exams_opt_2.loop');
            }

            $generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
            if (!empty($generate_page)) {
                $xtpl->assign('GENERATE_PAGE', $generate_page);
                $xtpl->parse('main.is_paid.merge_exams_opt_2.generate_page');
            }
            if (!empty($config)) {
                $db->select('id, title, num_question')->from($table_exams)->where('id IN (' . implode(',', array_keys($config)) . ')');
                $result = $db->query($db->sql());
                while ($row = $result->fetch(2)) {
                    $row['value'] = $config[$row['id']];
                    $xtpl->assign('ROW', $row);
                    $xtpl->parse('main.is_paid.merge_exams_opt_2.selected_exam');
                }
            }
            $xtpl->assign('list_selected', implode(',', array_keys($config)));
            $xtpl->assign('NUMBER_EXAM', $number_exam);
            $xtpl->assign('title_exam_opt_2', $title_exam_opt_2);
        }

        if (!empty($messages_op2)) {
            $xtpl->assign('MESSAGES', $messages_op2);
            $xtpl->parse('main.is_paid.merge_exams_opt_2.messages_opt_2');
        }
        
        $xtpl->assign('TOP_CONTENT', $config_topcontent);

        $xtpl->parse('main.is_paid.merge_exams_opt_2');
    }

    /* shuffle history */
    if ($merge_history) {
        $per_page = 20;
        $page = $nv_Request->get_int('page', 'get', 1);
        $base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&merge_history';
        $db->sqlreset()->select('COUNT(*)')->from($table_history);
        $num_items = $db->query($db->sql())->fetchColumn();

        $db->select('*')->order('create_time DESC')->limit($per_page)->offset(($page - 1) * $per_page);
        $sth = $db->prepare($db->sql());
        $sth->execute();
        $rows = [];
        while ($result = $sth->fetch()) {
            $rows[] = $result;
        }
        foreach ($rows as $key => $history) {
            $content = unserialize($history['content']);
            $history['create_time'] = nv_date('d/m/Y H:i', $history['create_time']);
            $questions_arr = explode(',', $history['question_list']);
            if ($page > 1) {
                $history['stt'] = $key + 1 + ($page - 1) * $per_page;
            } else {
                $history['stt'] = $key + 1;
            }
            $history['sum'] = array_reduce($content['config'], function($a, $b) {
                return $a + $b;
            }, 0);
            $history['link'] = $base_url . '&reuse=1&id_history=' . $history['id'] . '#anchor-form-multi';
            $history['download'] = $base_url . '&download=1&id_history=' . $history['id'];

            $xtpl->assign('HISTORY', $history);

            $db->sqlreset()->select('id, title')->from('' . $table_exams)->where('id IN (' . $history['examid_list'] . ')');
            $sth = $db->prepare($db->sql());
            $sth->execute();
            while ($exams = $sth->fetch()) {
                $exams['num_question'] = $content['config'][$exams['id']];
                $xtpl->assign('EXAMS', $exams);
                $xtpl->parse('main.is_paid.history.loop.exams');
            }

            $xtpl->parse('main.is_paid.history.loop');
        }

        $generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
        if (!empty($generate_page)) {
            $xtpl->assign('GENERATE_PAGE', $generate_page);
            $xtpl->parse('main.is_paid.history.generate_page');
        }
        if ($nv_Request->isset_request('download', 'get')) {
            $id = $nv_Request->get_int('id_history', 'get', 0);
            export_word_from_merge_history($id);
        }

        $xtpl->parse('main.is_paid.history');
    }
    $xtpl->parse('main.is_paid');
} else {
    $xtpl->parse('main.is_free');
}
if (!empty($error)) {
    $xtpl->assign('ERROR', $error);
    $xtpl->parse('main.error');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $nv_Lang->getModule('merge_exams');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
