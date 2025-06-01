<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 12/31/2009 0:51
 */
if (!defined('NV_MAINFILE')) {
    die('Stop!!!');
}

require_once NV_ROOTDIR . '/modules/test/premission.functions.php';
/*
// Ket noi cache với web mẹ
if ($global_config['cached'] == 'memcached') {
    $nv_Cache_main = new NukeViet\Cache\Memcached(NV_MEMCACHED_HOST, NV_MEMCACHED_PORT, NV_LANG_DATA, NV_CACHE_PREFIX);
} elseif ($global_config['cached'] == 'redis') {
    $nv_Cache_main = new NukeViet\Cache\Redis(NV_REDIS_HOST, NV_REDIS_PORT, NV_REDIS_TIMEOUT, NV_REDIS_PASSWORD, NV_REDIS_DBINDEX, NV_LANG_DATA, NV_CACHE_PREFIX);
} else {
    $nv_Cache_main = new NukeViet\Cache\Files(NV_ROOTDIR . '/' . NV_CACHEDIR, NV_LANG_DATA, NV_CACHE_PREFIX);
}
nên kết nối như trên nhưng cấu hình khá phức tạp nên trước mắt tạm thời kết nối đúng với hệ thống đang có như ở dưới
*/
// Chú ý vì đây là code cứng nên khi fix các vấn đề liên quan đến "Ngân hàng đề thi" thì chú ý để thay đổi cho đúng
$nv_Cache_main = new NukeViet\Cache\Files(NV_ROOTDIR . '/' . SYSTEM_CACHEDIR . '/aztest.vn' , NV_LANG_DATA, md5($global_config['sitekey'] . 'admin.aztest.vn'));
$nv_Cache_main->setDb($db);

// Xác định thư mục mẹ để lấy lấy file từ site con về khi thực hiện lấy đề thi
$main_upload_dir = 'aztest.vn';

define('tableSystem', $db_config['dbsystem'] . "." . NV_PREFIXLANG . '_' . $module_data);
$array_config = $module_config[$module_name];

$_sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat WHERE status=1 ORDER BY sort';
$array_test_cat = $nv_Cache->db($_sql, 'id', $module_name);

$_sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_bank ORDER BY sort';
$array_test_bank_nstatus = $nv_Cache->db($_sql, 'id', $module_name);
$array_test_bank = array_filter($array_test_bank_nstatus, function($bank) {
    return $bank['status'] == 1;
});

$_sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams_config WHERE active=1 ORDER BY id DESC';
$array_test_exams_config = $nv_Cache->db($_sql, 'id', $module_name);

$_sql = 'SELECT * FROM ' . tableSystem . '_bank_type ORDER BY weight';
$array_bank_type = $nv_Cache->db($_sql, 'id', $module_name);

$global_config['site_dir_main'] = 'aztest.vn';
if (!defined('NV_CACHEDIR_MAIN')) {
    define('NV_CACHEDIR_MAIN', SYSTEM_CACHEDIR . '/' . $global_config['site_dir_main']);
}
$nv_Cache_Main = new NukeViet\Cache\Files(NV_ROOTDIR . '/' . NV_CACHEDIR_MAIN, NV_LANG_DATA, NV_CACHE_PREFIX);
$nv_Cache_Main->setDb($db);

$_sql = 'SELECT * FROM ' . tableSystem . '_cat WHERE status=1 ORDER BY sort';
$array_test_cat_main = $nv_Cache_Main->db($_sql, 'id', $module_name);

$_sql = 'SELECT * FROM ' . tableSystem . '_bank ORDER BY sort';
$array_test_bank_nstatus_main = $nv_Cache_Main->db($_sql, 'id', $module_name);
$array_test_bank_main =  array_filter($array_test_bank_nstatus_main, function($bank) {
    return $bank['status'] == 1;
});

$array_exam_type = array(
    '0' => $nv_Lang->getModule('exams_type_0'),
    '1' => $nv_Lang->getModule('exams_type_1')
);

$array_question_type_4_option = array(
    1 => $nv_Lang->getModule('question_type_4_1'),
    2 => $nv_Lang->getModule('question_type_4_2')
);

$array_basic_key = array(
    'first_name',
    'last_name',
    'gender',
    'birthday',
    'sig'
);

if (!empty($array_config['payment']) && isset($array_config['payment'])) {
    define('NV_TEST_PAYMENT', true);
}

/**
 * nv_link_edit_page()
 *
 * @param mixed $id
 * @return
 */
function nv_link_edit_page($id)
{
    global $nv_Lang, $module_name, $client_info;
    $link = "<a class=\"btn btn-default btn-xs btn_edit\" href=\"" . NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=exams-content&amp;id=" . $id . "&amp;redirect=" . nv_redirect_encrypt($client_info['selfurl']) . "\" data-toggle=\"tooltip\" data-original-title=\"" . $nv_Lang->getGlobal('edit') . "\"><em class=\"fa fa-edit\"></em></a>";
    return $link;
}

/**
 * nv_link_delete_page()
 *
 * @param mixed $id
 * @return
 */
function nv_link_delete_page($id)
{
    global $nv_Lang, $module_name, $client_info, $op;
    $link = "<a class=\"btn btn-danger btn-xs\" href=\"" . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_id=' . $id . '&amp;delete_checkss=' . md5($id . NV_CACHE_PREFIX . $client_info['session_id']) . '&amp;redirect=' . nv_redirect_encrypt($client_info['selfurl']) . "\" onclick=\"return confirm(nv_is_del_confirm[0]);\" data-toggle=\"tooltip\" data-original-title=\"" . $nv_Lang->getGlobal('delete') . "\"><em class=\"fa fa-trash-o\"></em></a>";
    return $link;
}

function nv_upload_user_path($username_alias)
{
    global $db, $module_upload, $array_config;

    $array_structure_image = array();
    $array_structure_image[''] = $module_upload;
    $array_structure_image['Y'] = $module_upload . '/' . date('Y');
    $array_structure_image['Ym'] = $module_upload . '/' . date('Y_m');
    $array_structure_image['Y_m'] = $module_upload . '/' . date('Y/m');
    $array_structure_image['Ym_d'] = $module_upload . '/' . date('Y_m/d');
    $array_structure_image['Y_m_d'] = $module_upload . '/' . date('Y/m/d');
    $array_structure_image['username'] = $module_upload . '/' . $username_alias;
    $array_structure_image['username_Y'] = $module_upload . '/' . $username_alias . '/' . date('Y');
    $array_structure_image['username_Ym'] = $module_upload . '/' . $username_alias . '/' . date('Y_m');
    $array_structure_image['username_Y_m'] = $module_upload . '/' . $username_alias . '/' . date('Y/m');
    $array_structure_image['username_Ym_d'] = $module_upload . '/' . $username_alias . '/' . date('Y_m/d');
    $array_structure_image['username_Y_m_d'] = $module_upload . '/' . $username_alias . '/' . date('Y/m/d');
    $structure_upload = isset($array_config['structure_upload']) ? $array_config['structure_upload'] : 'Ym';

    $currentpath = isset($array_structure_image[$structure_upload]) ? $array_structure_image[$structure_upload] : '';

    if (file_exists(NV_UPLOADS_REAL_DIR . '/' . $currentpath)) {
        $upload_real_dir_page = NV_UPLOADS_REAL_DIR . '/' . $currentpath;
    } else {
        $upload_real_dir_page = NV_UPLOADS_REAL_DIR . '/' . $module_upload;
        $e = explode('/', $currentpath);
        if (!empty($e)) {
            $cp = '';
            foreach ($e as $p) {
                if (!empty($p) and !is_dir(NV_UPLOADS_REAL_DIR . '/' . $cp . $p)) {
                    $mk = nv_mkdir(NV_UPLOADS_REAL_DIR . '/' . $cp, $p);
                    if ($mk[0] > 0) {
                        $upload_real_dir_page = $mk[2];
                        try {
                            $db->query("INSERT INTO " . NV_UPLOAD_GLOBALTABLE . "_dir (dirname, time) VALUES ('" . NV_UPLOADS_DIR . "/" . $cp . $p . "', 0)");
                        } catch (PDOException $e) {
                            // trigger_error($e->getMessage());
                        }
                    }
                } elseif (!empty($p)) {
                    $upload_real_dir_page = NV_UPLOADS_REAL_DIR . '/' . $cp . $p;
                }
                $cp .= $p . '/';
            }
        }
        $upload_real_dir_page = str_replace('\\', '/', $upload_real_dir_page);
    }

    $currentpath = str_replace(NV_ROOTDIR . '/', '', $upload_real_dir_page);
    $uploads_dir_user = NV_UPLOADS_DIR . '/' . $module_upload;
    if (!defined('NV_IS_SPADMIN') and strpos($structure_upload, 'username') !== false) {
        $array_currentpath = explode('/', $currentpath);
        if ($array_currentpath[2] == $username_alias) {
            $uploads_dir_user = NV_UPLOADS_DIR . '/' . $module_upload . '/' . $username_alias;
        }
    }

    return array(
        'currentpath' => $currentpath,
        'uploads_dir_user' => $uploads_dir_user
    );
}

/**
 * isfull = 2: nội dung câu hỏi còn thiếu
 * isfull = 0: số câu hỏi chưa đầy đủ
 * isfull = 1: câu hỏi đã đầy đủ
 */
function nv_exam_question_status($examid)
{
    global $db, $module_data;

    // tổng số câu hỏi theo cấu hình
    $num_question = $db->query('SELECT num_question FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams WHERE id=' . $examid)->fetchColumn();
    $check_empty_content = false;
    // danh sách câu hỏi hiện có của đề
    $count_type_3 = 0;
    $array_questionid = array();
    $result = $db->query('SELECT id, title, type FROM ' . NV_PREFIXLANG . '_' . $module_data . '_question WHERE examid=' . $examid . ' ORDER BY weight');
    while (list ($questionid, $title, $type) = $result->fetch(3)) {
        $check_empty_content = $check_empty_content || empty($title);
        $array_questionid[] = $questionid;
        $count_type_3 += ($type == 3 ? 1: 0);
    }
    // $isfull 
    /**
     * 0: chưa đủ số câu hỏi theo khai báo
     * 1: đã đầy đủ
     * 2: đã đầy đủ nhưng tồn tại câu hỏi chưa có tiêu đề.
     */
    $count_question = sizeof($array_questionid) - $count_type_3;
    // $num_question -= $count_type_3;
    $isfull = ($count_question < $num_question) ? 0 : (
       $check_empty_content ? 2 : 1
    );
    $stmt = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_exams SET isfull=:isfull,num_question = :num_question, count_question=:count_question, question_list = :question_list WHERE id=' . $examid);
    $stmt->bindValue(':isfull', $isfull , PDO::PARAM_INT);
    $stmt->bindValue(':num_question', $num_question > $count_question ? $num_question : $count_question, PDO::PARAM_INT);
    $stmt->bindValue(':count_question', $count_question, PDO::PARAM_INT);
    $stmt->bindValue(':question_list', implode(',', $array_questionid), PDO::PARAM_STR);
    $stmt->execute();
    /**
     * Xử lý trường hợp do dữ liệu không thống nhất ở table _question đã có câu hỏi mà ở table _exams_question lại không có ánh xạ tương ứng
     */
    $num = $db->query('SELECT COUNT(*) FROM '  . NV_PREFIXLANG . '_' . $module_data . '_exams_question WHERE examsid=' . $examid)->fetchColumn();
    if ($num != count($array_questionid)) {
        $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams_question WHERE examsid=' . $examid);
        $stmt = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_exams_question VALUES (' . $examid . ', :questionid)');
        foreach($array_questionid as $questionid) {
            $stmt->bindValue(':questionid',  $questionid, PDO::PARAM_INT);
            $stmt->execute();
        }
    }
    /**
     * Cập nhật lại weight xử lý trường hợp người sử dụng bấm cập nhật liên tục hoặc lỗi mạng làm sai lệch weight
     */
    $weight = 0;
    foreach ($array_questionid as $questionid) {
        $weight++;
        $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_question SET weight = "' . $weight . '" WHERE id = ' . $questionid);
    }

}

function nv_question_type_answer($questionid, $question_type, $question_answer = array(), $answer_editor = 0, $admin_area = 1)
{
    global $global_config, $module_info, $module_file, $lang_module, $array_config, $currentpath, $uploads_dir_user, $array_question_type_4_option;

    if ($admin_area) {
        $xtpl = new XTemplate('question-answer.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
    } else {
        $xtpl = new XTemplate('question-answer.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    }
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('QUESTIONID', $questionid);
    $xtpl->assign('CK_EDITOR', $answer_editor ? 'checked="checked"' : '');

    if (empty($question_answer)) {
        $question_answer[] = array(
            'id' => 0,
            'content' => '',
            'is_true' => 0
        );
    }

    $xtpl->assign('NUMFILE', sizeof($question_answer));
    $array_letters = range('A', 'Z');
    $i = 0;
    $answer_add = 1;
    $answer_editor_use = 1;
    if ($question_type == 1 || $question_type == 3 || $question_type == 5) {
        if (!empty($question_answer)) {
            foreach ($question_answer as $answer) {
                $answer['letter'] = $array_letters[$i];
                $answer['index'] = $i;
                $answer['checked'] = $answer['is_true'] ? 'checked="checked"' : '';

                if ($answer_editor) {
                    $type = 'answer_editor';
                    if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
                        $answer['content'] = nv_aleditor('answer[' . $i . '][content]', '100%', '100px', $answer['content'], 'Question', $uploads_dir_user, $currentpath);
                    } else {
                        $answer['content'] = '<textarea class="form-control" style="width:100%;height:100px" name="answer[' . $i . '][content]">' . $answer['content'] . '</textarea>';
                    }
                } else {
                    $type = 'answer_input';
                    $answer['content'] = strip_tags($answer['content']);
                }

                $xtpl->assign('ANSWER', $answer);

                // nếu loại câu hỏi 5 - điểm từng đáp án
                if ($question_type == 5) {
                    $xtpl->parse('main.question_type_1.' . $type . '.loop.point');
                } else {
                    $xtpl->parse('main.question_type_1.' . $type . '.loop.is_true');
                }
                $xtpl->parse('main.question_type_1.' . $type . '.loop');
                $i++;
            }

            if ($question_type == 5) {
                $xtpl->parse('main.question_type_1.' . $type . '.point_js');
            } else {
                $xtpl->parse('main.question_type_1.' . $type . '.is_true_js');
            }

            if ($answer_editor) {
                $xtpl->parse('main.question_type_1.answer_editor');
            } else {
                $xtpl->parse('main.question_type_1.answer_input');
            }
        }
        $xtpl->parse('main.question_type_1');
    } elseif ($question_type == 2) {
        if (!empty($question_answer)) {
            foreach ($question_answer as $answer) {
                $answer['letter'] = $array_letters[$i];
                $answer['index'] = $i;
                $answer['is_true'] = !empty($answer['is_true']) ? $answer['is_true'] : '';

                if ($answer_editor) {
                    $type = 'answer_editor';
                    if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
                        $answer['content'] = nv_aleditor('answer[' . $i . '][content]', '100%', '100px', $answer['content'], 'Basic', $uploads_dir_user, $currentpath);
                    } else {
                        $answer['content'] = '<textarea class="form-control" style="width:100%;height:100px" name="answer[' . $i . '][content]">' . $answer['content'] . '</textarea>';
                    }
                } else {
                    $type = 'answer_input';
                    $answer['content'] = strip_tags($answer['content']);
                }

                $xtpl->assign('ANSWER', $answer);

                $xtpl->parse('main.question_type_2.' . $type . '.loop');
                $i++;
            }

            if ($answer_editor) {
                $xtpl->parse('main.question_type_2.answer_editor');
            } else {
                $xtpl->parse('main.question_type_2.answer_input');
            }
        }
        $xtpl->parse('main.question_type_2');
    } elseif ($question_type == 4) {
        // loại câu hỏi đúng sai
        $answer_add = 0;
        $answer_editor_use = 0;

        foreach ($array_question_type_4_option as $index => $value) {
            $xtpl->assign('OPTION', array(
                'index' => $index,
                'value' => $value,
                'checked' => $index == $question_answer ? 'checked="checked"' : ''
            ));
            $xtpl->parse('main.question_type_4.loop');
        }
        $xtpl->parse('main.question_type_4');
    }

    if ($answer_add) {
        $xtpl->parse('main.answer_add');
    }

    if ($answer_editor_use) {
        $xtpl->parse('main.answer_editor');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

function nv_get_rating($percent, $type = 1)
{
    global $nv_Cache, $module_name, $module_data;

    $_sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rating WHERE status=1 ORDER BY weight';
    $array_rating = $nv_Cache->db($_sql, 'id', $module_name);

    foreach ($array_rating as $rating) {
        $operator = nv_unhtmlspecialchars($rating['operator']);
        if ($operator == '<') {
            if ($percent < $rating['percent']) {
                if ($type == 2) {
                    return $rating['id'];
                }
                return $rating;
            }
        } elseif ($operator == '<=') {
            if ($percent <= $rating['percent']) {
                if ($type == 2) {
                    return $rating['id'];
                }
                return $rating;
            }
        }
    }
    return '';
}

function nv_exam_toword($exam_info, $array_data)
{
    if (class_exists('\PhpOffice\PhpWord\PhpWord')) {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->createSection();

        $array_letters = range('A', 'Z');
        $fontStyleName = 'title';
        $phpWord->addFontStyle($fontStyleName, array(
            'bold' => true
        ));

        if (!empty($array_data)) {
            $i = 0;
            foreach ($array_data as $data) {

                if ($data['type'] == 3) {
                    $section->addText($data['title'], $fontStyleName);
                    $section->addTextBreak();
                }

                $section->addText($data['weight'] . $data['title'], $fontStyleName);

                if (!empty($data['answer'])) {
                    foreach ($data['answer'] as $answer) {}
                }

                $section->addTextBreak();
                $i++;
            }
        }

        $file = 'HelloWorld.docx';
        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename="' . $file . '"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $xmlWriter->save("php://output");
        exit();
    }
}

/**
 * nv_GetCatidInParent()
 *
 * @param mixed $catid
 * @return
 *
 */
function nv_GetCatidInParent($catid, $current = true)
{
    global $array_test_cat;

    $_array_cat = array();
    if ($current) {
        $_array_cat[] = $catid;
    }
    $subcatid = !empty($array_test_cat[$catid]['subid']) ? explode(',', $array_test_cat[$catid]['subid']) : array();

    if (!empty($subcatid)) {
        foreach ($subcatid as $id) {
            if ($id > 0) {
                if ($array_test_cat[$id]['numsub'] == 0) {
                    $_array_cat[] = intval($id);
                } else {
                    $array_cat_temp = nv_GetCatidInParent($id);
                    foreach ($array_cat_temp as $catid_i) {
                        $_array_cat[] = intval($catid_i);
                    }
                }
            }
        }
    }
    return array_unique($_array_cat);
}

function nv_test_history_view_answer($exam_info, $answer_info, $print_view = 0)
{
    global $db, $module_data, $db_config;

    if (!nv_user_in_groups($exam_info['groups_result']) && !defined('NV_ADMIN')) {
        return '';
    }

    $test_exam_question = nv_unserialize($answer_info['test_exam_question']);
    $test_exam_answer = nv_unserialize($answer_info['test_exam_answer']);
    $tester_answer = nv_unserialize($answer_info['answer']);

    if (empty($test_exam_question) || empty($test_exam_answer)) {
        return '';
    }

    $exam_info['isdone'] = 1;
    $exam_info['view_answer'] = 1;

    $array_data = $array_tmp = array();
    $result = $db->query('SELECT * FROM ' . (!empty($exam_info['isbank']) ? $db_config['dbsystem'] . "." : '') . NV_PREFIXLANG . '_' . $module_data . '_question WHERE id IN (' . implode(',', $test_exam_question) . ') ORDER BY FIELD(id, ' . implode(',', $test_exam_question) . ')');
    while ($row = $result->fetch()) {
        $answer = unserialize($row['answer']);

        $row['answer'] = array();
        foreach ($test_exam_answer[$row['id']] as $_answerid) {
            $row['answer'][$_answerid] = $answer[$_answerid];
        }

        if ($row['type'] == 6 || $row['type'] == 7) {
            $row['answer'] = '';
            $row['mark'] = $answer_info['constructed_response'][$row['id']]['result'];
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

                    if (isset($answer['is_true']) && $answer['is_true'] && $exam_info['view_answer']) {
                        $answer['is_true_highlight'] = 1;
                    }
                } elseif ($row['type'] == 2) {
                    if ($exam_info['view_answer']) {
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

            if ($exam_info['view_answer']) {
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
    return nv_theme_test_testing(0, $exam_info, $array_data, array(), $tester_answer, '', 1, 0, $print_view);
}

function nv_print_questions($array_data, $exam_info, $array_answer, $display_answer = false, $return = true)
{
    global $db, $module_data, $module_name, $module_info, $array_test_cat, $global_config, $base_url_rewrite, $module_file, $lang_module, $array_question_type_4_option, $nv_Request;


    if ($exam_info && (defined('NV_IS_MODADMIN') || $exam_info['print'])) {
        $base_url_rewrite = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['print'] . '/' . $array_test_cat[$exam_info['catid']]['alias'] . '/' . $exam_info['alias'] . '-' . $exam_info['id'] . $global_config['rewrite_exturl'], true);

        $array_site_info = array(
            'site_name' => $global_config['site_name'],
            'site_email' => $global_config['site_email'],
            'site_url' => $global_config['site_url'],
            'url' => NV_MY_DOMAIN . nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_test_cat[$exam_info['catid']]['alias'] . '/' . $exam_info['alias'] . '-' . $exam_info['id'] . $global_config['rewrite_exturl'], true)
        );

        $contents = nv_theme_test_print(0, $array_site_info, $exam_info, $array_data, $array_answer, $display_answer);
        if ($return) {
            return $contents;
        } else {
            include NV_ROOTDIR . '/includes/header.php';
            echo call_user_func((defined('NV_ADMIN') ? 'nv_admin_theme' : 'nv_site_theme'), $contents, false);
            include NV_ROOTDIR . '/includes/footer.php';
        }
    }
}

function nv_review_questions($bank, $id, $display_answer = false, $return = true)
{
    global $db, $module_data, $module_name, $module_info, $array_test_cat, $global_config, $base_url_rewrite, $module_file, $lang_module, $array_question_type_4_option, $nv_Request;

    $table_exams = NV_PREFIXLANG . '_' . $module_data . '_exams';
    $table_question = NV_PREFIXLANG . '_' . $module_data . '_question';
    if($bank){
        $table_exams = tableSystem . '_exams_bank';
        $table_question = tableSystem . '_exams_bank_question';
    }

    $new_id = $nv_Request->get_string($module_data . '_testing_aswer_id', 'session', '');

    $aswer_id_list = implode(',', nv_unserialize($db->query('SELECT test_exam_question FROM ' . NV_PREFIXLANG . '_' . $module_data . '_answer WHERE id =' . ($new_id ? $new_id : $id))->fetchColumn()));

    $exam_info = $db->query('SELECT * FROM ' . $table_exams . ' WHERE id =' . $id)->fetch();

    if ($exam_info && (defined('NV_IS_MODADMIN') || $exam_info['print'])) {
        $base_url_rewrite = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['print'] . '/' . $array_test_cat[$exam_info['catid']]['alias'] . '/' . $exam_info['alias'] . '-' . $exam_info['id'] . $global_config['rewrite_exturl'], true);

        if (!defined('NV_ADMIN')) {
            if ($_SERVER['REQUEST_URI'] != $base_url_rewrite and NV_MAIN_DOMAIN . $_SERVER['REQUEST_URI'] != $base_url_rewrite) {
                Header('Location: ' . $base_url_rewrite);
                die();
            }
            $base_url_rewrite = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_test_cat[$exam_info['catid']]['alias'] . '/' . $exam_info['alias'] . '-' . $exam_info['id'] . $global_config['rewrite_exturl'], true);
            $canonicalUrl = NV_MAIN_DOMAIN . $base_url_rewrite;
            $meta_tags = nv_html_meta_tags();
        }

        $array_data = $array_answer = array();
        if ($display_answer == "view_content") {
            if($bank){
                $result = $db->query('SELECT * FROM ' . $table_question . ' WHERE qsIdSite IN (' . $exam_info['question_list'] . ') ORDER BY FIELD(qsIdSite, ' . $exam_info['question_list'] . ')');
            }else{
                $result = $db->query('SELECT * FROM ' . $table_question . ' WHERE id IN (' . $exam_info['question_list'] . ') ORDER BY FIELD(id, ' . $exam_info['question_list'] . ')');
            }
        }elseif ($display_answer == "print") {
            $result = $db->query('SELECT * FROM ' . $table_question . ' WHERE id IN (' . $aswer_id_list . ') ORDER BY FIELD(id, ' . $aswer_id_list . ')');
        }
        //         $result = $db->query('SELECT * FROM ' . $table_question . ' WHERE id IN (' . ($exam_info['question_list'] ?? $aswer_id_list ) . ') ORDER BY FIELD(id, ' . ($exam_info['question_list'] ?? $aswer_id_list) . ')');
        while ($row = $result->fetch()) {
            $row['answer'] = unserialize($row['answer']);
            if ($display_answer && ( nv_user_in_groups($exam_info['groups_result']) || defined('NV_ADMIN'))) {
                if ($row['type'] != 4) {
                    $i = 0;
                    foreach ($row['answer'] as $answer) {
                        if ($answer['is_true']) {
                            if ($row['type'] == 1 || $row['type'] == 3 || $row['type'] == 5) {
                                $array_answer[$row['id']][] = $i;
                            } elseif ($row['type'] == 2) {
                                $array_answer[$row['id']][] = array(
                                    'index' => $i,
                                    'content' => $answer['content'],
                                    'is_true' => $answer['is_true']
                                );
                            }
                        }
                        $i++;
                    }
                } else {
                    $array_answer[$row['id']][] = $row['answer'];
                }
            }
            $array_data[$row['id']] = $row;
        }
        $array_site_info = array(
            'site_name' => $global_config['site_name'],
            'site_email' => $global_config['site_email'],
            'site_url' => $global_config['site_url'],
            'url' => NV_MY_DOMAIN . nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_test_cat[$exam_info['catid']]['alias'] . '/' . $exam_info['alias'] . '-' . $exam_info['id'] . $global_config['rewrite_exturl'], true)
        );
        $contents = nv_theme_test_print($bank, $array_site_info, $exam_info, $array_data, $array_answer, $display_answer);
        if ($return) {
            return $contents;
        } else {
            include NV_ROOTDIR . '/includes/header.php';
            echo call_user_func((defined('NV_ADMIN') ? 'nv_admin_theme' : 'nv_site_theme'), $contents, false);
            include NV_ROOTDIR . '/includes/footer.php';
        }
    }
}

function nv_test_htmltoword($file_name, $html)
{
    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    $section = $phpWord->addSection();
    \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);

    $temp_file_uri = NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $file_name . '.docx';

    // Saving the document as OOXML file...
    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
    $objWriter->save($temp_file_uri);

    //download code
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . $file_name . '.docx');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Content-Length: ' . filesize($temp_file_uri));
    readfile($temp_file_uri);
    unlink($temp_file_uri); // deletes the temporary file
    exit();
}

/**
 * nv_theme_test_print()
 *
 * @param mixed $array_site_info
 * @param mixed $exam_info
 * @param mixed $array_data
 * @param mixed $array_answer
 * @param mixed $display_answer
 * @return
 *
 */
function nv_theme_test_print($bank, $array_site_info, $exam_info, $array_data, $array_answer, $display_answer)
{
    global $module_file, $lang_module, $array_config, $array_question_type_4_option;

    $xtpl = new XTemplate('print.tpl', NV_ROOTDIR . '/themes/default/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('EXAM', $exam_info);
    $xtpl->assign('DATA', $array_site_info);
    $xtpl->assign('CONTENT', nv_theme_test_testing($bank, $exam_info, $array_data, array(), array(), '', 0, 1, 0));

    if (!empty($display_answer) && !empty($array_data) and !empty($array_answer)) {
        $array_letters = range('A', 'Z');
        $i = 1;
        foreach ($array_data as $data) {
            if (isset($array_answer[$data['id']])) {
                foreach ($array_answer[$data['id']] as $index) {
                    $answer = array();
                    if ($data['type'] != 4) {
                        if (isset($index['content'])) {
                            $answer[] = $array_letters[$index['index']] . '. ' . $index['is_true'];
                        } else {
                            $answer[] = $array_letters[$index];
                        }
                    } else {
                        $answers = $array_question_type_4_option[$index];
                    }
                }

                if ($data['type'] == 1 or $data['type'] == 3) {
                    $xtpl->assign('ANSWER', array(
                        'number' => $i,
                        'answer' => implode(', ', $answer)
                    ));
                    $xtpl->parse('main.answer.loop.answer_1');
                } elseif ($data['type'] == 2) {
                    $xtpl->assign('ANSWER', array(
                        'number' => $i,
                        'answer' => implode('<br />', $answer)
                    ));
                    $xtpl->parse('main.answer.loop.answer_2');
                } elseif ($data['type'] == 4) {
                    $xtpl->assign('ANSWER', array(
                        'number' => $i,
                        'answer' => $answers
                    ));
                    $xtpl->parse('main.answer.loop.answer_4');
                }

                $xtpl->parse('main.answer.loop');
            }
            $i++;
        }
        $xtpl->parse('main.answer');
    }
    if(!$bank){
        $xtpl->parse('main.notbank');
    }
    if (!defined('NV_ADMIN')) {
        $xtpl->parse('main.print');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_theme_test_testing()
 *
 * @param mixed $exam_info
 * @param mixed $array_data
 * @param mixed $array_saved_data
 * @param mixed $base_url
 * @param mixed $istest
 * @param mixed $isprint
 * @return
 *
 */
function nv_theme_test_testing($bank, $exam_info, $array_data, $array_saved_data = array(), $tester_answer = array(), $base_url = '', $istest = 1, $isprint = 0, $print_view = 0)
{
    global $module_name, $module_file, $lang_module, $module_info, $op, $array_config, $array_premission, $themeConfig, $array_question_type_4_option, $user_info;
    $template = defined('NV_ADMIN') ? 'default' : $module_info['template'];
    if ($print_view) {
        $exam_info['per_page'] = 0;
    }

    // Tính điểm trung bình cho các câu hỏi không có câu hỏi riêng.
    $total_question_div = 0;
    $total_mark_private = 0;
    foreach ($array_data as $row) {
        if ($row['type'] == 5) {
            $max_mark = 0;
            foreach ($row['answer'] as $item) {
                $max_mark = $item['point'] > $max_mark ? $item['point']  : $max_mark;
            }
        }
        $total_question_div += (
            (in_array($row['type'], array(1,2,4,7)) && 
            empty($row['mark_max_constructed_response'])) ? 1 : 0
        );
        $total_mark_private += (
            (in_array($row['type'], array(1,2,4,6,7)) && 
            !empty($row['mark_max_constructed_response'])) ? $row['mark_max_constructed_response'] : 0
        );
        $total_mark_private += (($row['type'] == 5) ? $max_mark : 0);
    }
    $evg = round(($exam_info['ladder'] - $total_mark_private) / $total_question_div, 2);
    $xtpl = new XTemplate('testing.tpl', NV_ROOTDIR . '/themes/' . $template . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('DATA', $exam_info);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('OP', $op);
    $xtpl->assign('BASE_URL', $base_url);
    $xtpl->assign('TEMPLATE', $template);

    if (isset($exam_info['isdone']) && $exam_info['isdone']) {
        $xtpl->assign('DISABLED', 'disabled="disabled"');
        if (!$exam_info['view_answer']) {
            $array_group = array();
            $array_groupid = nv_user_groups($exam_info['groups_result']);
            $array_groups_list = nv_test_groups_list();
            if (!empty($array_groupid)) {
                foreach ($array_groupid as $groupid) {
                    $array_group[] = $array_groups_list[$groupid];
                }
            }
            $xtpl->assign('RESULT_NOTE', sprintf($lang_module['groups_result_note'], implode(', ', $array_group)));
            $xtpl->parse('main.groups_result_note');
        }
    }

    $editor_change_event_js = 0;
    $check_group_view = nv_user_in_groups($exam_info['groups_result']);
    $common_question_have_view = array();
    if (!empty($array_data)) {
        $i = $j = $z = 1;
        foreach ($array_data as $data) {
            $data['number'] = $i;
            $xtpl->assign('QUESTION', $data);

            if (($istest && $exam_info['type'] == 0 || $exam_info['type'] == 1 && $check_group_view) && !empty($data['useguide'])) {

                // sau khi lam bai
                if (($exam_info['useguide'] == 2 && $exam_info['isdone']) || $exam_info['useguide'] == 3) {
                    // hien thi popup
                    if($exam_info['type_useguide'] == 1){
                        $xtpl->parse('main.questionlist.question.groups_result');
                    }

                    // hien thi ben duoi cau hoi
                    if($exam_info['type_useguide'] == 2){
                        $xtpl->parse('main.questionlist.question.groups_result1');
                    }
                }
            }

            if (!empty($exam_info['group_question_point'][$i-1]) && empty($common_question_have_view[$exam_info['group_question_point'][$i-1]]) ) {
                $common_question_have_view[$exam_info['group_question_point'][$i-1]] = true;
                $xtpl->assign('question_common', $exam_info['group_question'][$exam_info['group_question_point'][$i-1]]['title']);
                $xtpl->parse('main.questionlist.question.question_general');
            }

            if (in_array($data['type'], array(1,2,5))) {
                $array_letters = range('A', 'Z');
                $k = 0;
                foreach ($data['answer'] as $answer) {
                    $answer['letter'] = $array_letters[$k];
                    $xtpl->assign('ANSWER', $answer);
                    if ($data['type'] == 1 or $data['type'] == 3 or $data['type'] == 5) {
                        if ($istest) {
                            if ($data['count_true'] > 1) {
                                $xtpl->parse('main.questionlist.question.question_type_1.answer.checkbox');
                            } else {
                                $xtpl->parse('main.questionlist.question.question_type_1.answer.radio');
                            }

                            if (!empty($answer['checked'])) {
                                $xtpl->parse('main.questionlist.question.question_type_1.answer.checked');
                            }

                            if ($answer['is_true_highlight']) {
                                $xtpl->parse('main.questionlist.question.question_type_1.answer.is_true_highlight');
                            }

                            if ($data['count_true'] > 1) {
                                $xtpl->parse('main.questionlist.question.question_type_1.answer_multiple');
                            }
                        }

                        $xtpl->parse('main.questionlist.question.question_type_1.answer.answer_style_' . $data['answer_style']);
                        $xtpl->parse('main.questionlist.question.question_type_1.answer');

                        $xtpl->parse('main.questionlist.question.question_type_1');
                    } elseif ($data['type'] == 2) {
                        if ($istest) {
                            if ($answer['is_true_highlight']) {
                                $xtpl->parse('main.questionlist.question.question_type_2.answer.is_true_highlight');
                            }
                            $xtpl->parse('main.questionlist.question.question_type_2.answer.textbox');
                        } else {
                            $xtpl->parse('main.questionlist.question.question_type_2.answer.space');
                        }
                        $xtpl->parse('main.questionlist.question.question_type_2.answer.answer_style_' . $data['answer_style']);
                        $xtpl->parse('main.questionlist.question.question_type_2.answer');
                        $xtpl->parse('main.questionlist.question.question_type_2');
                    }
                    $k++;
                }
            }
            else if (in_array($data['type'], array(4))) {
                $check = $exam_info['isdone'] ? !($exam_info['isdone']) : $istest;
                foreach ($array_question_type_4_option as $index => $value) {
                    $xtpl->assign('OPTION', array(
                        'index' => $index,
                        'value' => $value,
                        'checked' => $data['answer']['checked'] == $index ? 'checked="checked"' : '',
                        'disabled' => $check ? '' : 'disabled="disabled"',
                        'highlight' => $data['answer']['highlight'] == $index ? 'istrue' : ''
                    ));
                    if (!empty($data['answer']['checked'] == $index)) {
                        $xtpl->parse('main.questionlist.question.question_type_4.loop.checked');
                    }
                    $xtpl->parse('main.questionlist.question.question_type_4.loop');
                }

                $xtpl->parse('main.questionlist.question.question_type_4');
            }
            else if (in_array($data['type'], array(6))) {
                $answer['content'] = isset($tester_answer[$data['id']]) ? $tester_answer[$data['id']] : '';
                if ($data['answer_editor_type'] == 0) {
                    if ($exam_info['istesting'] && empty($exam_info['isdone'])) {
                        $editor_change_event_js = 1;
                        $answer['content'] = htmlspecialchars(nv_editor_br2nl($answer['content']));
                        if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
                            $answer['content'] = nv_aleditor('answer[' . $data['id'] . ']', '100%', '200px', $answer['content'], 'Basic');
                        } else {
                            $answer['content'] = '<textarea style="width:100%;height:300px" name="answer[' . $data['id'] . ']">' . $answer['content'] . '</textarea>';
                        }
                        $xtpl->assign('ANSWER', $answer['content']);
                        $xtpl->parse('main.questionlist.question.question_type_6.editor');
                    } else {
                        $xtpl->assign('ANSWER', $answer['content']);
                        $xtpl->parse('main.questionlist.question.question_type_6.label');
                    }
                } elseif ($data['answer_editor_type'] == 1) {
                    $xtpl->assign('ANSWER', nv_nl2br($answer['content']));
                    if ($exam_info['istesting'] && empty($exam_info['isdone'])) {
                        $xtpl->parse('main.questionlist.question.question_type_6.textarea');
                    } else {
                        $xtpl->parse('main.questionlist.question.question_type_6.label');
                    }
                }
                if (defined('NV_ADMIN')  && isset($tester_answer[$data['id']])) {
                    
                    $xtpl->parse('main.questionlist.question.question_type_6.mark');
                }
                $xtpl->parse('main.questionlist.question.question_type_6');
            }
            else if (in_array($data['type'], array(7))) {
                if (defined('NV_ADMIN') && isset($tester_answer[$data['id']])) {
                    $xtpl->assign('max', !empty($data['mark_max_constructed_response']) ? $data['mark_max_constructed_response'] : $evg );
                    $xtpl->assign('enable', !empty($data['mark_max_constructed_response']) ? 'enable' : '' );

                    $xtpl->assign('HIDE_RECORD', 'style="display: none"');
                    $xtpl->parse('main.questionlist.question.question_type_7.agree');
                    $xtpl->parse('main.questionlist.question.question_type_7.mark');
                } 
                if (strpos($exam_info['way_record'], '1') !== false) {
                    $xtpl->parse('main.questionlist.question.question_type_7.way_record_1');
                }
                if (strpos($exam_info['way_record'], '2') !== false) {
                    $xtpl->parse('main.questionlist.question.question_type_7.way_record_2');
                }
                if (file_exists(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/test_' . $user_info['userid'] . '_' . $exam_info['id'] . '_' . $data['id'] . '.wav' )) {
                    $xtpl->assign('audio_record_name', NV_BASE_SITEURL . NV_TEMP_DIR . '/test_' . $user_info['userid'] . '_' . $exam_info['id'] . '_' . $data['id'] . '.wav');
                } else if(isset($tester_answer[$data['id']])) {
                    $xtpl->assign('audio_record_name',  NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/' . $tester_answer[$data['id']]);
                } else {
                    $xtpl->assign('audio_record_name', '');
                }; 
                $xtpl->parse('main.questionlist.question.question_type_7');
            }

            if (!$isprint and $exam_info['per_page'] > 0) {
                if ($i > $exam_info['per_page']) {
                    $xtpl->assign('HIDE', 'style="display: none"');
                }
            }

            if ($istest) {
                $_posAllowed = array();
                if (isset($themeConfig['positions']['position'])) {
                    foreach ($themeConfig['positions']['position'] as $_pos) {
                        $_pos = trim((string) $_pos['tag']);
                        if (preg_match('/^\[([^\]]+)\]$/is', $_pos, $matches)) {
                            $_posAllowed[] = $matches[1];
                        }
                    }
                }

                if (in_array('ADSBLOCK_' . $j, $_posAllowed)) {
                    if ($z == $array_config['question_ads']) {
                        $xtpl->assign('ADSNUMBER', $j);
                        $xtpl->parse('main.questionlist.question.adsblock');
                        $j++;
                        $z = 0;
                    }
                }
            }

            $xtpl->parse('main.questionlist.question');
            $i++;
            $z++;
        }
    }
    if (defined('NV_ADMIN')) {
        if(!$bank){
            $xtpl->parse('main.nv_save_admin_test.notbank');
        }
        $xtpl->parse('main.nv_save_admin_test');
    }
    if (empty($array_saved_data)) {
        $xtpl->parse('main.questionlist');
    } else {
        if (!$exam_info['isdone']) {
            $xtpl->parse('main.questionlist.btn_exam_save_top');
            if (empty($exam_info['type'])) {
                $xtpl->parse('main.btn_exam_save_bottom.btn_exit_test');
            }
            $xtpl->parse('main.btn_exam_save_bottom');
        }
        if (!$exam_info['isdone'] || ($exam_info['view_question_after_test'])) {
            $xtpl->parse('main.questionlist');
        }

        if ($exam_info['isdone']) {
            if ($exam_info['rating']) {
                if (!empty($exam_info['rating']['note'])) {
                    $xtpl->parse('main.result.rating.note');
                }
                $xtpl->parse('main.result.rating');
            }
            if ($exam_info['view_mark_after_test']) {
                $xtpl->assign('score_title', $exam_info['exams_type'] == 1? $lang_module['score'] : $lang_module['score_multiple_choice']);
                $xtpl->assign('result_title', $exam_info['exams_type'] == 2? $lang_module['result_multiple_choice'] : $lang_module['result']);
                $xtpl->parse('main.result.question_true');
                $xtpl->parse('main.result.question_false');
                $xtpl->parse('main.result.question_skeep');
                $xtpl->parse('main.result.total_question_have_not_mark');
                $xtpl->parse('main.result.score_box');
            }

            $xtpl->assign('URL_SHARE', $exam_info['url_share']);
            if (!$exam_info['issave']) {
                $xtpl->assign('URL_SHARE_DISABLED', 'not-active');
                $xtpl->parse('main.result.share_note');
            } else {
                if (!empty($array_config['oaid'])) {
                    $xtpl->assign('OAID', $array_config['oaid']);
                    $xtpl->parse('main.result.zalo_share_button');
                }
            }

            $xtpl->parse('main.result');
        } else {
            if ($editor_change_event_js) {
                $xtpl->parse('main.istesting.editor_change_event_js');
            }
            $xtpl->parse('main.istesting');
        }
    }

    if (!$isprint and $exam_info['per_page'] > 0 and count($array_data) > $exam_info['per_page']) {
        $xtpl->assign('show_per_page', $exam_info['per_page']);
        $xtpl->parse('main.page');
        $xtpl->parse('main.pagejs');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

function nv_serialize($data)
{
    return base64_encode(serialize($data));
}

function nv_unserialize($data)
{
    if (is_base64($data)) {
        return unserialize(base64_decode($data));
    }
    return @unserialize($data);
}

function is_base64($str)
{
    if (base64_encode(base64_decode($str, true)) === $str) {
        return true;
    } else {
        return false;
    }
}

function nv_test_custom_fileds_render($array_field_config, $custom_fields, $display_system = 0, $display_empty = 0)
{
    $array_data = array();

    if (!empty($array_field_config)) {
        foreach ($array_field_config as $row) {
            if (empty($display_system) && $row['system']) continue;
            $row['value'] = (isset($custom_fields[$row['field']])) ? $custom_fields[$row['field']] : $row['default_value'];
            if (empty($display_empty) && empty($row['value'])) continue;
            if ($row['field_type'] == 'date') {
                if (!preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $row['value'], $m)) {
                    $row['value'] = (empty($row['value'])) ? '' : date('d/m/Y', $row['value']);
                }
            } elseif ($row['field_type'] == 'textarea') {
                $row['value'] = nv_htmlspecialchars(nv_br2nl($row['value']));
            } elseif ($row['field_type'] == 'editor') {
                $row['value'] = htmlspecialchars(nv_editor_br2nl($row['value']));
            } elseif ($row['field_type'] == 'select' || $row['field_type'] == 'radio') {
                $row['value'] = isset($row['field_choices'][$row['value']]) ? $row['field_choices'][$row['value']] : '';
            } elseif ($row['field_type'] == 'checkbox' || $row['field_type'] == 'multiselect') {
                $row['value'] = !empty($row['value']) ? explode(',', $row['value']) : array();
                $str = array();
                if (!empty($row['value'])) {
                    foreach ($row['value'] as $value) {
                        if (isset($row['field_choices'][$value])) {
                            $str[] = $row['field_choices'][$value];
                        }
                    }
                }
                $row['value'] = implode(', ', $str);
            }
            $array_data[$row['field']] = $row;
        }
    }
    return $array_data;
}

function shuffle_assoc($list)
{
    if (!is_array($list)) return $list;

    $keys = array_keys($list);
    shuffle($keys);
    $random = array();
    foreach ($keys as $key) {
        $random[$key] = $list[$key];
    }
    return $random;
}
function nv_test_random_question($exams_config_id, $update_banks=0)
{
    global $db, $module_data, $db_config, $array_test_bank, $array_test_bank_main, $array_test_exams_config, $array_bank_type;

    if (!empty($update_banks)) {
        $check = 1;
        $exams_config_info = $exams_config_id;
    }else{
        if (isset($array_test_exams_config[$exams_config_id])) {
            $check = 1;
            $exams_config_info = $array_test_exams_config[$exams_config_id];
        }
    }
    $list_test_bank = !empty($exams_config_info['isbank']) ? $array_test_bank_main : $array_test_bank;

    if ($check==1) {
        $array_tmp = array();
        $config = nv_unserialize($exams_config_info['config']);
        if (!empty($list_test_bank)) {
            foreach ($list_test_bank as $classid => $value) {
                if (!empty($value['subid'])) {
                    $value['subid'] = explode(',', $value['subid']);
                    foreach ($value['subid'] as $catid) {
                        foreach ($array_bank_type as $typeid => $bank_type) {
                            $number = !empty($config[$classid]) && !empty($config[$classid][$catid]) && !empty($config[$classid][$catid][$typeid]) ? $config[$classid][$catid][$typeid] : 0;
                            if (!empty($number)) {
                                $array_tmp[$classid][$catid][$typeid] = $number;
                            }
                        }
                    }
                }
            }
        }
        $array_question = array();
        if (!empty($array_tmp)) {
            $array_tmp = shuffle_assoc($array_tmp);
            foreach ($array_tmp as $classid => $value) {
                foreach ($value as $catid => $value) {
                    foreach ($value as $bank_type => $number) {
                        $db->sqlreset()
                        ->select('id')
                        ->from( (!empty($exams_config_info['isbank']) ? $db_config['dbsystem'] . "." : '') .  NV_PREFIXLANG . '_' . $module_data . '_question' )
                        ->where('typeid=' . $catid . ' AND bank_type=' . $bank_type )
                        ->order('RAND()')
                        ->limit($number);
                        $result = $db->query($db->sql());
                        while (list ($id) = $result->fetch(3)) {
                            $array_question[] = $id;
                        }
                    }
                }
            }
        }

        if (count($array_question) < $exams_config_info['num_question']) {
            return array();
        }
        return $array_question;
    }
    return array();
}

/**
 * nv_test_price_format()
 *
 * @param mixed $val
 * @return
 */
function nv_test_price_format($val)
{
    $val = str_replace(",", ".", $val);
    $val = preg_replace('/\.(?=.*\.)/', '', $val);
    return floatval($val);
}

/**
 * nv_test_number_format()
 *
 * @param mixed $number
 * @param integer $decimals
 * @return
 */
function nv_test_number_format($number, $decimals = 0, $dec_point = ",", $thousands_sep = ".")
{
    if (!empty($number) && is_numeric($number)) {
        $number = number_format($number, $decimals, $dec_point, $thousands_sep);
    }
    return $number;
}


/**
 * Vì code dưới lấy dữ liệu ở module site. 
 * Để đảm bảo module Test hoạt động tốt khi đứng độc lập 
 * Nên để sử dụng trong trường hợp này cần kiểm tra có module site không. 
 * Nếu có thì sử dụng nếu không thì thôi.
 */
$array_idsite = array();
if (file_exists(NV_ROOTDIR . '/admin/site/functions.php')) {
    $array_idsite = array($global_config['idsite']);
    // Lấy $idsite cha.
    list($pidsite) = $db->query('SELECT pidsite FROM ' . $db_config['dbsystem'] . '.' . $db_config['prefix'] . '_site WHERE idsite="' . $global_config['idsite'] . '"')->fetch(3);
    if (!empty($pidsite)) {
        $array_idsite[] = $pidsite;
    }
    // Lấy $idsite con
    $result = $db->query('SELECT idsite FROM ' . $db_config['dbsystem'] . '.' . $db_config['prefix'] . '_site WHERE pidsite="' . $global_config['idsite'] . '"');
    while (list($id_child) = $result->fetch(3)) {
        $array_idsite[] = $id_child;
    }
}

/**
 * Hàm xuất file word theo mẫu để sửa
 * Đưa vào có thể là một mãng id của các câu hỏi hoặc đầy đủ thông tin câu hỏi
 * @param $array_question_id danh sách id các câu hỏi.
 * @param $array_question các câu hỏi đầy đủ thông tin
 */
function exportWordforEdit($filename, $array_question_id, $array_question) {
    global $db, $module_data, $array_bank_type;
    if (!empty($array_question_id) && empty($array_question)) {
        $array_question = array();
        $db->sqlreset()
            ->select('*')
            ->from(NV_PREFIXLANG . '_' . $module_data . '_question')
            ->where('id IN (' . implode(',', $array_question_id) . ')');
        $result = $db->query($db->sql());
        while ($row = $result->fetch(2)) {
            $array_question[] = $row;
        }
    }
    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    $section = $phpWord->addSection();


    foreach ($array_question as $row) {
        $bank_type = '';
        if (!empty($row['bank_type'])) {
            $bank_type = '[' . $array_bank_type[$row['bank_type']]['code'] . ']';
        }
        $row['title'] = strip_tags($row['title']);
        $row['title'] = str_replace(PHP_EOL, "", $row['title']);
        $row['title'] = str_replace('&nbsp', " ", $row['title']);
        $section->addText('[#' . $row['id'] . ']'. $bank_type . $row['title']);
        $row['answer'] = unserialize($row['answer']);
        /**
         * 1. Câu hỏi lựa chọn
         * 2. Điền vào ô trống   
         * 3. Câu hỏi chung   
         * 4. Câu hỏi đúng/sai   
         * 5. Câu hỏi đánh giá năng lực     
         * 6. Câu hỏi tự luận   
         */
        if ($row['type'] == 1) {
            foreach ($row['answer'] as $answer) {
                $answer['content'] = strip_tags($answer['content']);
                $answer['content'] = str_replace(PHP_EOL, "", $answer['content']);
                $answer['content'] = str_replace('&nbsp', " ", $answer['content']);
                $section->addText(($answer['is_true'] ? '*' : '') . $answer['content']);
            }
        }
        if (!empty($row['useguide'])) {
            $section->addText('>' . strip_tags($row['useguide']));
        }
        $section->addText('');
    }
    
    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

    try {
        $objWriter->save($filename);
        $content = file_get_contents($filename);
    } catch (\Exception $e) {
        exit($e->getMessage());
    }
    header("Content-Disposition: attachment; filename=" . $filename);
    unlink($filename);
    exit($content);
}
/**
 * Hàm xuất file excel theo mẫu để sửa
 * Đưa vào có thể là một mãng id của các câu hỏi hoặc đầy đủ thông tin câu hỏi
 * @param $array_question_id danh sách id các câu hỏi.
 * @param $array_question các câu hỏi đầy đủ thông tin
 */
function exportExcelforEdit($filename, $array_question_id, $array_question) {
    global $db, $module_data, $array_bank_type;
    if (!empty($array_question_id) && empty($array_question)) {
        $array_question = array();
        $db->sqlreset()
            ->select('*')
            ->from(NV_PREFIXLANG . '_' . $module_data . '_question')
            ->where('id IN (' . implode(',', $array_question_id) . ')');
        $result = $db->query($db->sql());
        while ($row = $result->fetch(2)) {
            $array_question[] = $row;
        }
    }
    
    $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'DANH SÁCH CÂU HỎI THUỘC NGÂN HÀNG CÂU HỎI');
    $row_index = $row_first = 5;
    $max_count_answer = 0;
    foreach ($array_question as $row) {
        $row_index++;
        $row['title'] = strip_tags($row['title']);
        $row['title'] = str_replace(PHP_EOL, "", $row['title']);
        $row['title'] = str_replace('&nbsp', " ", $row['title']);
        $row['answer'] = unserialize($row['answer']);
        $max_count_answer = count($row['answer']) > $max_count_answer ? count($row['answer']) : $max_count_answer;
        $answer_true = array();
        foreach ($row['answer'] as  $item) {
            if ($item['is_true'] == 1) {
                $answer_true[] = $item['id'];
            }
        }
        
        $sheet->setCellValue('A' . $row_index, $row['id']);
        $sheet->setCellValue('B' . $row_index, $row['title']);
        $sheet->setCellValue('C' . $row_index, implode(',', $answer_true));
        $sheet->setCellValue('D' . $row_index, $row['bank_type']);
        $sheet->setCellValue('E' . $row_index, $row['useguide']);
        for ($i = 0; $i <= count($row['answer']); $i++) {
            $sheet->setCellValueByColumnAndRow($i + 5, $row_index, $row['answer'][$i]['content']);
        }

    }
    $header_column_title = array(
        'Mã câu hỏi', 
        'Câu hỏi', 
        'Câu Trả lời đúng', 
        'Loại câu hỏi', 
        'Lời giải', 
    );
    for ($i = 0; $i < $max_count_answer; $i++) {
        $header_column_title[] = PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i + 1);
    }
    $sheet->fromArray($header_column_title, null, 'A5');
    // Format
    $column_after = PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(5 + $max_count_answer);
    $styleArray = [
        'font' => [
            'size' => 12,
            'name' => 'Times new Roman'
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT, 
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP, 
            'wrapText' => true,
        ]
    ];
    $sheet->getStyle('A1:' . $column_after . ($row_index))->applyFromArray($styleArray);
    $sheet->getStyle('A1')
                ->getFont()
                ->setSize(18)
                ->setBold(true);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    $sheet->mergeCells('A1:' . $column_after . '1');
    $sheet->getRowDimension(1)->setRowHeight(30);
    // Kẻ bảng
    $styleArray = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => [
                    'rgb' => '000000'
                ]
            ]
        ]
    ];
    $sheet->getStyle('A5:' . $column_after . $row_index)->applyFromArray($styleArray);
    $sheet->getStyle('A5:' . $column_after . '5')
                ->getFont()
                ->setBold(true);
    $sheet->getStyle('A5:' . $column_after . '5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);        
    $array_column = [
        'A' => 10,
        'B' => 30,
        'C' => 10,
        'D' => 10,
        'E' => 30,
    ];
    for ($i = 0; $i < $max_count_answer; $i++) {
        $array_column[ PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(6 + $i)] = 30;
    }
    foreach ($array_column as $key => $value) {
        $sheet->getColumnDimension($key)->setAutoSize(false);
        $sheet->getColumnDimension($key)->setWidth($value);
    }

    $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    try {
        $writer->save($filename);
        $content = file_get_contents($filename);
    } catch (\Exception $e) {
        exit($e->getMessage());
    }

    header("Content-Disposition: attachment; filename=" . $filename);
    unlink($filename);
    exit($content);
}
/**
 * nv_test_groups_list()
 *
 * @param string $mod_data
 * @return
 *
 */
function nv_test_groups_list($mod_data = 'users')
{
    global $nv_Cache, $db, $db_config, $global_config, $nv_Lang;


    $groups = [];
    $_mod_table = ($mod_data == 'users') ? NV_USERS_GLOBALTABLE : $db_config['prefix'] . '_' . $mod_data;

    $sql = 'SELECT g.group_id, gd.title, g.group_type, g.exp_time, g.idsite
            FROM ' . $_mod_table . '_groups g
            LEFT JOIN ' . $_mod_table . '_groups_detail gd ON (g.group_id = gd.group_id AND gd.lang = \'' . NV_LANG_DATA . '\')
            WHERE g.act=1 AND (g.idsite = ' . $global_config['idsite'] . ' OR (g.idsite =0 AND g.siteus = 1)) AND g.group_id != 7
            ORDER BY g.idsite, g.weight';

    $result = $db->query($sql);
    while ($row = $result->fetch()) {
        if ($row['group_id'] < 9) {
            $row['title'] = $nv_Lang->getGlobal('level' . $row['group_id']);
        }
        $groups[$row['group_id']] = ($global_config['idsite'] > 0 and empty($row['idsite'])) ? '<strong>' . $row['title'] . '</strong>' : $row['title'];
    }
    return $groups;
}

