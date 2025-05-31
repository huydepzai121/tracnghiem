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

if ($nv_Request->isset_request('clone_id', 'get')) {
    $clone_id = $nv_Request->get_int('clone_id', 'get', 0);
    $db->sqlreset()
        ->select('id, input_question')
        ->from(NV_PREFIXLANG . '_' . $module_data . '_exams')
        ->where('id = ' . $clone_id);
    list($id, $input_question) = $db->query($db->sql())->fetch(3);
    // chỉ clone các đề thi không lấy đề từ ngân hàng
    if (!empty($id) && $input_question != 4) {
        $exam_id = clone_exam($id);
        if (!empty($exam_id)) {
            Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&id=' . $exam_id . '&clone_success=1');
            die();
        }
        Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=exams');
        die();
    }
}
if ($nv_Request->isset_request('download_word', 'get')) {
    $exam_id = $nv_Request->get_int('download_word', 'get', 0);
    export_word_from_exam($exam_id);
    die();
}

/*
* cập nhật lại lượt sử dụng câu hỏi
*/
if ($nv_Request->isset_request('update_total_use', 'post, get')) {
    //xóa các câu hỏi liên kết với đề thi ở _exams_question mà đề thi đã bị xóa
    $examsid = array();
    $result = $db->query('SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams');
    while (list($id) = $result->fetch(3)) {
        $examsid[] = $id;
    }
    if (!empty($examsid)) {
        $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams_question WHERE examsid NOT IN (' . implode(',', $examsid) . ')');
    }
    //thông kê lượt sử dụng các câu hỏi
    $total_use = array();
    $result = $db->query('SELECT questionid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams_question');
    while (list($questionid) = $result->fetch(3)) {
        if (empty($total_use[$questionid])) {
            $total_use[$questionid] = 0;
        }
        $total_use[$questionid]++;
    }
    foreach ($total_use as $questionid => $total_use) {
        $result = $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_question SET total_use = ' . $total_use . ' WHERE id = ' . $questionid);
    }
    echo 'OK';
    exit();
}

if ($nv_Request->isset_request('get_source_json', 'post, get')) {
    $q = $nv_Request->get_title('q', 'post, get', '');

    $db->sqlreset()
        ->select('sourceid, title, link, logo')
        ->from(NV_PREFIXLANG . '_' . $module_data . '_sources')
        ->where('(title LIKE "%' . $q . '%"
            OR link LIKE "%' . $q . '%"
            OR logo LIKE "%' . $q . '%"
        )')
        ->order('title ASC')
        ->limit(20);

    $sth = $db->prepare($db->sql());
    $sth->execute();

    $array_data = array();
    while (list($sourceid, $title, $link, $logo) = $sth->fetch(3)) {
        $array_data[] = array(
            'id' => $title,
            'title' => $title,
            'link' => $link
        );
    }

    header('Cache-Control: no-cache, must-revalidate');
    header('Content-type: application/json');

    ob_start('ob_gzhandler');
    echo json_encode($array_data);
    exit();
}

if ($nv_Request->isset_request('load_exams_config', 'post')) {
    $id = $nv_Request->get_int('id', 'post', 0);
    if (isset($array_test_exams_config[$id])) {
        nv_jsonOutput(array(
            'error' => 0,
            'data' => $array_test_exams_config[$id]
        ));
    }
    nv_jsonOutput(array(
        'error' => 1,
        'msg' => $nv_Lang->getModule('error_unknow')
    ));
}

if ($nv_Request->isset_request('get_alias_title', 'post')) {
    $alias = $nv_Request->get_title('get_alias_title', 'post', '');
    $alias = change_alias($alias);
    if ($array_config['tags_alias_lower']) {
        $alias = strtolower($alias);
    }
    die($alias);
}
/*
* su dung trong topicsnews lay cac exam
*/
if ($nv_Request->isset_request('get_exams', 'post,get')) {
    $q = $nv_Request->get_title('title', 'post,get', '');
    $array_data = array();
    if (!empty($q)) {
        $db->sqlreset()
            ->select('id, title')
            ->from(NV_PREFIXLANG . '_' . $module_data . '_exams')
            ->where('title LIKE :title')
            ->order('alias ASC')
            ->limit(10);

        $sth = $db->prepare($db->sql());
        $sth->bindValue(':title', '%' . $q . '%', PDO::PARAM_STR);
        $sth->execute();

        while (list($id, $title) = $sth->fetch(3)) {
            $array_data[] = array(
                'id' => $id,
                'text' => $title
            );
        }
    }
    header('Cache-Control: no-cache, must-revalidate');
    header('Content-type: application/json');
    ob_start('ob_gzhandler');
    echo json_encode($array_data);
    exit();
}
if ($nv_Request->isset_request('get_keywords', 'post,get')) {
    $q = $nv_Request->get_title('q', 'post, get', '');

    if (empty($q)) {
        return;
    }

    $db->sqlreset()
        ->select('tid, keywords')
        ->from(NV_PREFIXLANG . '_' . $module_data . '_tags')
        ->where('alias LIKE :alias OR keywords LIKE :keywords')
        ->order('alias ASC')
        ->limit(50);

    $sth = $db->prepare($db->sql());
    $sth->bindValue(':alias', '%' . $q . '%', PDO::PARAM_STR);
    $sth->bindValue(':keywords', '%' . $q . '%', PDO::PARAM_STR);
    $sth->execute();

    $array_data = array();
    while (list($id, $keywords) = $sth->fetch(3)) {
        $array_data[] = array(
            'id' => $keywords,
            'text' => $keywords
        );
    }

    header('Cache-Control: no-cache, must-revalidate');
    header('Content-type: application/json');

    ob_start('ob_gzhandler');
    echo json_encode($array_data);
    exit();
}

$groups_list = nv_test_groups_list();

$row = array();
$row['id'] = $nv_Request->get_int('id', 'post,get', 0);
$row['bankExam'] = $nv_Request->get_int('bankExam', 'post,get', 0);
$array_keywords_old = array();
$id_block_content = array();

$username_alias = change_alias($admin_info['username']);
$upload_user_path = nv_upload_user_path($username_alias);
$currentpath = $upload_user_path['currentpath'];
$uploads_dir_user = $upload_user_path['uploads_dir_user'];

$array_block_cat_module = array();
$sql = 'SELECT bid, adddefault, title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block_cat ORDER BY weight ASC';
$result = $db->query($sql);
while (list($bid_i, $adddefault_i, $title_i) = $result->fetch(3)) {
    $array_block_cat_module[$bid_i] = $title_i;
    if ($adddefault_i) {
        $id_block_content[] = $bid_i;
    }
}

if ($row['id'] > 0) {
    \NukeViet\Core\Language::$lang_module['exams_add'] = $nv_Lang->getModule('exams_edit');

    $where = '';
    if (!defined('NV_IS_ADMIN_MODULE')) {
        $where = ' AND userid=' . $admin_info['userid'];
    }

    $row = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams WHERE id=' . $row['id'] . $where)->fetch();
    if (empty($row)) {
        Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=exams');
        die();
    }
    $row['way_record'] = explode(',', $row['way_record']);

    $check_edit = false;

    if (defined('NV_IS_ADMIN_MODULE')) {
        $check_edit = true;
    } else {
        if (isset($array_cat_admin[$admin_id][$row['catid']])) {
            if ($array_cat_admin[$admin_id][$row['catid']]['admin'] == 1) {
                $check_edit = true;
            } else {
                if ($array_cat_admin[$admin_id][$row['catid']]['edit_content'] == 1) {
                    $check_edit = true;
                }
            }
        }
    }

    if (empty($check_edit)) {
        Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=exams');
        die();
    }

    if (!empty($row['image']) and file_exists(NV_UPLOADS_REAL_DIR)) {
        $currentpath = NV_UPLOADS_DIR . '/' . $module_upload . '/' . dirname($row['image']);
    }

    // Từ khóa
    $_query = $db->query('SELECT tid, keyword FROM ' . NV_PREFIXLANG . '_' . $module_data . '_tags_id WHERE id=' . $row['id'] . ' ORDER BY keyword ASC');
    while ($_row = $_query->fetch()) {
        $array_keywords_old[$_row['tid']] = $_row['keyword'];
    }
    $row['keywords'] = implode(', ', $array_keywords_old);
    $row['keywords_old'] = $row['keywords'];

    $id_block_content = array();
    $sql = 'SELECT bid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block where id=' . $row['id'];
    $result = $db->query($sql);
    while (list($bid_i) = $result->fetch(3)) {
        $id_block_content[] = $bid_i;
    }

    $row['num_question_old'] = $row['num_question'];
} else {
    $row['isbank'] = 0;
    $row['catid'] = 0;
    $row['topicid'] = 0;
    $row['sourceid'] = 0;
    $row['title'] = '';
    $row['alias'] = '';
    $row['code'] = '';
    $row['hometext'] = '';
    $row['description'] = '';
    $row['sourcetext'] = '';
    $row['groups'] = 6;
    $row['groups_comment'] = 6;
    $row['groups_result'] = 6;
    $row['num_question'] = 0;
    $row['num_question_old'] = 0;
    $row['timer'] = 0;
    $row['ladder'] = 10;
    $row['per_page'] = 0;
    $row['type'] = 0;
    $row['exams_config'] = 0;
    $row['exams_reset_bank'] = 0;
    $row['image'] = '';
    $row['image_position'] = $array_config['imgposition'];
    $row['keywords'] = '';
    $row['keywords_old'] = '';
    $row['random_answer'] = 1;
    $row['check_result'] = 1;
    $row['view_mark_after_test'] = 1;
    $row['view_question_after_test'] = 1;
    $row['preview_question_test'] = 0;
    $row['rating'] = 1;
    $row['history_save'] = 1;
    $row['multiple_test'] = 1;
    $row['print'] = 1;
    $row['useguide'] = 0;
    $row['type_useguide'] = 0;
    $row['input_question'] = 0;
    $row['save_max_score'] = 0;
    $row['begintime'] = NV_CURRENTTIME;
    $row['endtime'] = 0;
    $row['count_question'] = 0;
    $row['isfull'] = 0;
    $row['test_limit'] = 0;
    $row['template'] = 9;
    $row['price'] = 0;
    $row['mix_question'] = 1;
    $row['block_copy_paste'] = 1;
    $row['way_record'] = array(1,2);
    $row['exams_max_time'] = 0;
}
$row['redirect'] = $nv_Request->get_string('redirect', 'post,get', '');

if (!empty($row['bankExam'])) {
    $bankRows = $db->query('SELECT * FROM ' . $db_config['dbsystem'] . '.' . NV_PREFIXLANG . '_' . $module_data . '_exams_bank WHERE id = ' . $row['bankExam'])->fetch();
    $row['title'] = $bankRows['title'];
    $row['hometext'] = $bankRows['hometext'];
    $row['description'] = $bankRows['description'];
    $row['question_list'] = $bankRows['question_list'];
    $row['num_question'] = $bankRows['num_question'];
    $row['count_question'] = $bankRows['count_question'];
    $row['timer'] = $bankRows['timer'];
    $row['ladder'] = $bankRows['ladder'];
}

$array_cat_add_content = $array_cat_edit_content = array();
foreach ($array_test_cat as $catid_i => $array_value) {
    $check_add_content = $check_edit_content = false;
    if (defined('NV_IS_ADMIN_MODULE')) {
        $check_add_content = $check_edit_content = true;
    } elseif (isset($array_cat_admin[$admin_id][$catid_i])) {
        if ($array_cat_admin[$admin_id][$catid_i]['admin'] == 1) {
            $check_add_content = $check_edit_content = true;
        } else {
            if ($array_cat_admin[$admin_id][$catid_i]['add_content'] == 1) {
                $check_add_content = true;
            }

            if ($array_cat_admin[$admin_id][$catid_i]['edit_content'] == 1) {
                $check_edit_content = true;
            }
        }
    }
    if ($check_add_content) {
        $array_cat_add_content[] = $catid_i;
    }

    if ($check_edit_content) {
        $array_cat_edit_content[] = $catid_i;
    }
}

// Khởi tạo biến error
$error = '';

if ($nv_Request->isset_request('submit', 'post')) {
    $row['catid'] = $nv_Request->get_int('catid', 'post', 0);
    $row['title'] = $nv_Request->get_textarea('title', 'br', 1);
    $row['code'] = $nv_Request->get_title('code', 'post', '');
    $row['hometext'] = $nv_Request->get_textarea('hometext', '', NV_ALLOWED_HTML_TAGS);
    $row['description'] = $nv_Request->get_editor('description', '', NV_ALLOWED_HTML_TAGS);
    $row['num_question'] = $nv_Request->get_int('num_question', 'post', 0);
    $row['timer'] = $nv_Request->get_int('timer', 'post', 0);
    $row['ladder'] = $nv_Request->get_int('ladder', 'post', 10);
    $row['per_page'] = $nv_Request->get_int('per_page', 'post', 0);
    $row['type'] = $nv_Request->get_int('type', 'post', 0);
    $row['bankExam'] = $nv_Request->get_int('bankExam', 'post,get', 0);
    $row['block_copy_paste'] = $nv_Request->get_int('block_copy_paste', 'post,get');
    $row['way_record'] = $nv_Request->get_array('way_record', 'post,get', array());
    $row['exams_max_time'] = $nv_Request->get_int('exams_max_time', 'post', 0);
    $mix_question = $nv_Request->get_int('mix_question', 'post,get', 0);
    $mix_question_value = $nv_Request->get_title('mix_question_value', 'post,get', '');
    if (!empty($mix_question_value)) {
        $mix_question_value = str_replace(' ', '', $mix_question_value);
        while (strpos($mix_question_value, '--') !== FALSE) {
            $mix_question_value = str_replace('--', '-', $mix_question_value);
        }
    }

    $row['mix_question'] = $mix_question == 2 ? $mix_question_value : $mix_question;
    $row['mix_question'] = !empty($row['mix_question']) ? $row['mix_question'] : 0;

    if (empty($row['id'])) {
        if (!empty($row['bankExam'])) {
            $row['input_question'] = 4;
        } else {
            $row['input_question'] = $nv_Request->get_int('input_question', 'post', 0);
        }
        $row['exams_config'] = $nv_Request->get_int('exams_config', 'post', 0);
    }

    $row['exams_reset_bank'] = $nv_Request->get_int('exams_reset_bank', 'post', 0);
    $row['random_answer'] = $nv_Request->get_int('random_answer', 'post', 0);
    $row['check_result'] = $nv_Request->get_int('check_result', 'post', 0);
    $row['view_mark_after_test'] = $nv_Request->get_int('view_mark_after_test', 'post', 0);
    $row['view_question_after_test'] = $nv_Request->get_int('view_question_after_test', 'post', 0);
    $row['preview_question_test'] = $nv_Request->get_int('preview_question_test', 'post', 0);
    $row['rating'] = $nv_Request->get_int('rating', 'post', 0);
    $row['multiple_test'] = $nv_Request->get_int('multiple_test', 'post', 0);
    $row['history_save'] = $nv_Request->get_int('history_save', 'post', 0);
    $row['save_max_score'] = $nv_Request->get_int('save_max_score', 'post', 0);
    $row['print'] = $nv_Request->get_int('print', 'post', 0);
    $row['useguide'] = $nv_Request->get_int('useguide', 'post', 0);
    $row['type_useguide'] = $nv_Request->get_int('type_useguide', 'post', 0);
    $row['image_position'] = $nv_Request->get_int('image_position', 'post', 0);
    $row['test_limit'] = $nv_Request->get_int('test_limit', 'post', 0);
    $row['price'] = $nv_Request->get_title('price', 'post', 0);
    $row['price'] = nv_test_price_format($row['price']);
    $row['sourcetext'] = $nv_Request->get_title('sourcetext', 'post', '');
    $row['template'] = $nv_Request->get_int('template', 'post', 9);

    $row['keywords'] = $nv_Request->get_array('keywords', 'post', '');
    $row['keywords'] = implode(', ', $row['keywords']);

    $row['image'] = $nv_Request->get_title('image', 'post', '');
    if (is_file(NV_DOCUMENT_ROOT . $row['image'])) {
        $row['image'] = substr($row['image'], strlen(NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/'));
    } else {
        $row['image_position'] = 0;
        $row['image'] = '';
    }
    
    $row['topicid'] = $nv_Request->get_title('topicid', 'post', '');
    $row['alias'] = $nv_Request->get_title('alias', 'post', '', 1);
    if (empty($row['alias'])) {
        $row['alias'] = $row['title'];
    }
    $row['alias'] = change_alias($row['alias']);
    $stmt = $db->prepare('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams WHERE id !=' . $row['id'] . ' AND alias = :alias');
    $stmt->bindParam(':alias', $row['alias'], PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->fetchColumn()) {
        $weight = $db->query('SELECT MAX(id) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams')->fetchColumn();
        $weight = intval($weight) + 1;
        $row['alias'] = $row['alias'] . '-' . $weight;
    }

    $_groups = $nv_Request->get_array('groups', 'post', array());
    $row['groups'] = !empty($_groups) ? implode(',', nv_groups_post(array_intersect($_groups, array_keys($groups_list)))) : '';

    $_groups = $nv_Request->get_array('groups_comment', 'post', array());
    $row['groups_comment'] = !empty($_groups) ? implode(',', nv_groups_post(array_intersect($_groups, array_keys($groups_list)))) : '';

    $_groups = $nv_Request->get_array('groups_result', 'post', array());
    $row['groups_result'] = !empty($_groups) ? implode(',', nv_groups_post(array_intersect($_groups, array_keys($groups_list)))) : '';

    $row['id_block_content_post'] = array_unique($nv_Request->get_typed_array('bids', 'post', 'int', array()));

    if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $nv_Request->get_string('begindate', 'post'), $m)) {
        $begintime = $nv_Request->get_string('begintime', 'post');
        $begintime = !empty($begintime) ? explode(':', $begintime) : array(
            0,
            0
        );
        $row['begintime'] = mktime($begintime[0], $begintime[1], 0, $m[2], $m[1], $m[3]);
    } else {
        $row['begintime'] = 0;
    }

    if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $nv_Request->get_string('enddate', 'post'), $m)) {
        $endtime = $nv_Request->get_string('endtime', 'post');
        $endtime = !empty($endtime) ? explode(':', $endtime) : array(
            23,
            59
        );
        $row['endtime'] = mktime($endtime[0], $endtime[1], 0, $m[2], $m[1], $m[3]);
    } else {
        $row['endtime'] = 0;
    }

    if (empty($row['type'])) {
        $row['begintime'] = !empty($row['begintime']) ? 0 : $row['begintime'];
        $row['endtime'] = !empty($row['endtime']) ? 0 : $row['endtime'];
    }

    if (empty($row['title'])) {
        $error = $nv_Lang->getModule('error_required_exams_name');
    } elseif (empty($row['alias'])) {
        $error = $nv_Lang->getModule('error_required_alias');
    } elseif (empty($row['catid'])) {
        $error = $nv_Lang->getModule('error_required_catid');
    } elseif ($row['input_question'] == 0 && empty($row['num_question'])) {
        $error = $nv_Lang->getModule('error_required_num_question');
    } elseif (empty($row['ladder']) && empty($array_config['allow_question_point'])) {
        $error = $nv_Lang->getModule('error_required_ladder');
    } elseif (empty($row['timer'])) {
        $error = $nv_Lang->getModule('error_required_timer');
    } elseif (empty($row['groups'])) {
        $error = $nv_Lang->getModule('error_required_groups');
    } elseif (!empty($row['begintime']) && !empty($row['endtime']) && $row['begintime'] >= $row['endtime']) {
        $error = $nv_Lang->getModule('error_exam_time_error');
    } elseif ($row['input_question'] == 2 && empty($row['exams_config'])) {
        $error = $nv_Lang->getModule('error_required_exams_config');
    } else if (!preg_match('/^[0-9,-]*$/', $row['mix_question'], $m)) {
        $error = $nv_Lang->getModule('error_pattern_mix_question');
    } else if (in_array($row['input_question'], $global_config['input_question_disable_exam'] ?? [])) {
        $error = $nv_Lang->getModule('let_upgrade');
    }
    // Kiểm tra khi sửa đảm bảo số lượng câu hỏi luôn lớn hơn hoặc bằng số lượng câu hỏi hiện có
    if (empty($error) && !empty($row['id'])) {
        list($count_question) = $db->query('SELECT count_question FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams WHERE id = "' . $row['id'] . '"')->fetch(3);
        if ($row['num_question'] < $count_question) {
            $error = $nv_Lang->getModule('error_num_question_lesser_count_question');
        }
    }
    // kiểm tra xem đề thi có thuộc kỳ thi nào không
    if (empty($error)) {
        $db->sqlreset()
            ->select('COUNT(*)')
            ->from(NV_PREFIXLANG . '_' . $module_data . '_subject_questions')
            ->where('examsid = ' . $row['id']);
        $uses_examinations = $db->query($db->sql())->fetchColumn();
        if (!empty($uses_examinations)) {
            $error = $nv_Lang->getModule('not_update_exam_for_examinations');
        }
    }
    // bắt đầu tạo danh sách câu hỏi từ ngân hàng
    $question_list = '';
    if (empty($error) && empty($row['id']) && $row['input_question'] == 2) {
        $row['isfull'] = 1;
        $row['count_question'] = $row['num_question'] = $array_test_exams_config[$row['exams_config']]['num_question'];
        $row['question_list'] = nv_test_random_question($row['exams_config']);
        $row['isbank'] = $array_test_exams_config[$row['exams_config']]['isbank'];
        if (empty($row['question_list'])) {
            $error = $nv_Lang->getModule('error_invaild_question_list');
        } else {
            $question_list = implode(',', $row['question_list']);
        }
    }

    if (!empty($row['sourcetext'])) {
        $url_info = @parse_url($row['sourcetext']);
        if (isset($url_info['scheme']) and isset($url_info['host'])) {
            $sourceid_link = $url_info['scheme'] . '://' . $url_info['host'];
            $stmt = $db->prepare('SELECT sourceid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sources WHERE link= :link');
            $stmt->bindParam(':link', $sourceid_link, PDO::PARAM_STR);
            $stmt->execute();
            $row['sourceid'] = $stmt->fetchColumn();

            if (empty($row['sourceid'])) {
                $weight = $db->query('SELECT max(weight) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sources')->fetchColumn();
                $weight = intval($weight) + 1;
                $_sql = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_sources (title, link, logo, weight, add_time, edit_time) VALUES ( :title ,:sourceid_link, '', :weight, " . NV_CURRENTTIME . ", " . NV_CURRENTTIME . ")";

                $data_insert = array();
                $data_insert['title'] = $url_info['host'];
                $data_insert['sourceid_link'] = $sourceid_link;
                $data_insert['weight'] = $weight;

                $row['sourceid'] = $db->insert_id($_sql, 'sourceid', $data_insert);
            }
        } else {
            $stmt = $db->prepare('SELECT sourceid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sources WHERE title= :title');
            $stmt->bindParam(':title', $row['sourcetext'], PDO::PARAM_STR);
            $stmt->execute();
            $row['sourceid'] = $stmt->fetchColumn();

            if (empty($row['sourceid'])) {
                $weight = $db->query('SELECT max(weight) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sources')->fetchColumn();
                $weight = intval($weight) + 1;
                $_sql = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_sources (title, link, logo, weight, add_time, edit_time) VALUES ( :title, '', '', " . $weight . " , " . NV_CURRENTTIME . ", " . NV_CURRENTTIME . ")";
                $data_insert = array();
                $data_insert['title'] = $row['sourcetext'];

                $row['sourceid'] = $db->insert_id($_sql, 'sourceid', $data_insert);
            }
        }
    }

    $new_id = 0;

    // Nếu có lỗi thì không xử lý tiếp
    if (!empty($error)) {
        // Không làm gì, để hiển thị lỗi ở cuối file
    } else {
    // Tu dong xac dinh keywords
    if (!empty($row['description']) and $row['keywords'] == '' and !empty($array_config['auto_tags'])) {
        $keywords = $row['description'];
        $keywords = nv_get_keywords($keywords, 100);
        $keywords = explode(',', $keywords);

        // Ưu tiên lọc từ khóa theo các từ khóa đã có trong tags thay vì đọc từ từ điển
        $keywords_return = array();
        foreach ($keywords as $keyword_i) {
            $sth = $db->prepare('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_tags_id where keyword = :keyword');
            $sth->bindParam(':keyword', $keyword_i, PDO::PARAM_STR);
            $sth->execute();
            if ($sth->fetchColumn()) {
                $keywords_return[] = $keyword_i;
                if (sizeof($keywords_return) > 20) {
                    break;
                }
            }
        }

        if (sizeof($keywords_return) < 20) {
            foreach ($keywords as $keyword_i) {
                if (!in_array($keyword_i, $keywords_return)) {
                    $keywords_return[] = $keyword_i;
                    if (sizeof($keywords_return) > 20) {
                        break;
                    }
                }
            }
        }
        $row['keywords'] = implode(',', $keywords_return);
    }

    // cập nhật dòng sự kiện
    if (!empty($row['topicid']) and !is_numeric($row['topicid'])) {
        $weightopic = $db->query('SELECT max(weight) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_topics')->fetchColumn();
        $weightopic = intval($weightopic) + 1;
        $aliastopic = get_mod_alias($row['topicid'], 'topics');
        $_sql = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_topics (title, alias, description, image, weight, keywords, add_time, edit_time) VALUES ( :title, :alias, :description, '', :weight, :keywords, " . NV_CURRENTTIME . ", " . NV_CURRENTTIME . ")";
        $data_insert = array();
        $data_insert['title'] = $row['topicid'];
        $data_insert['alias'] = $aliastopic;
        $data_insert['description'] = $row['topictext'];
        $data_insert['weight'] = $weightopic;
        $data_insert['keywords'] = $row['topictext'];
        $row['topicid'] = $db->insert_id($_sql, 'topicid', $data_insert);
    }
    if (empty($row['id'])) {
        $_weight = $db->query('SELECT max(weight) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams')->fetchColumn();
        $_weight = intval($_weight) + 1;

        $_sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_exams (isbank, catid, topicid, sourceid, title, alias, code, image, image_position, hometext, description, groups, groups_comment, groups_result, begintime, endtime, num_question, count_question, timer, ladder, per_page, type, input_question, exams_config, exams_reset_bank, question_list, addtime, userid, isfull, random_answer, rating, history_save, save_max_score, print, useguide, type_useguide, multiple_test, template, weight, test_limit, price, check_result, view_mark_after_test, view_question_after_test, preview_question_test, mix_question, block_copy_paste, way_record, exams_max_time) VALUES (:isbank, :catid, :topicid, :sourceid, :title, :alias, :code, :image, :image_position, :hometext, :description, :groups, :groups_comment, :groups_result, :begintime, :endtime, :num_question, :count_question, :timer, :ladder, :per_page, :type, :input_question, :exams_config, :exams_reset_bank, :question_list, ' . NV_CURRENTTIME . ', ' . $admin_info['userid'] . ', :isfull, :random_answer, :rating, :history_save, :save_max_score, :print, :useguide, :type_useguide, :multiple_test, :template, :weight, :test_limit, :price, :check_result, :view_mark_after_test, :view_question_after_test, :preview_question_test, :mix_question, :block_copy_paste, :way_record, :exams_max_time)';
        $data_insert = array();
        $data_insert['isbank'] = $row['isbank'];
        $data_insert['catid'] = $row['catid'];
        $data_insert['topicid'] = $row['topicid'];
        $data_insert['sourceid'] = $row['sourceid'];
        $data_insert['title'] = $row['title'];
        $data_insert['alias'] = $row['alias'];
        $data_insert['code'] = $row['code'];
        $data_insert['image'] = $row['image'];
        $data_insert['image_position'] = $row['image_position'];
        $data_insert['hometext'] = $row['hometext'];
        $data_insert['description'] = $row['description'];
        $data_insert['groups'] = $row['groups'];
        $data_insert['groups_comment'] = $row['groups_comment'];
        $data_insert['groups_result'] = $row['groups_result'];
        $data_insert['begintime'] = $row['begintime'];
        $data_insert['endtime'] = $row['endtime'];
        $data_insert['num_question'] = $row['num_question'];
        $data_insert['count_question'] = $row['count_question'];
        $data_insert['timer'] = $row['timer'];
        $data_insert['ladder'] = $row['ladder'];
        $data_insert['per_page'] = $row['per_page'];
        $data_insert['type'] = $row['type'];
        $data_insert['input_question'] = $row['input_question'];
        $data_insert['exams_config'] = $row['exams_config'];
        $data_insert['exams_reset_bank'] = $row['exams_reset_bank'];
        $data_insert['question_list'] = $question_list;
        $data_insert['isfull'] = $row['isfull'];
        $data_insert['random_answer'] = $row['random_answer'];
        $data_insert['check_result'] = $row['check_result'];
        $data_insert['view_mark_after_test'] = $row['view_mark_after_test'];
        $data_insert['view_question_after_test'] = $row['view_question_after_test'];
        $data_insert['preview_question_test'] = $row['preview_question_test'];
        $data_insert['rating'] = $row['rating'];
        $data_insert['multiple_test'] = $row['multiple_test'];
        $data_insert['history_save'] = $row['history_save'];
        $data_insert['save_max_score'] = $row['save_max_score'];
        $data_insert['print'] = $row['print'];
        $data_insert['useguide'] = $row['useguide'];
        $data_insert['type_useguide'] = $row['type_useguide'];
        $data_insert['template'] = $row['template'];
        $data_insert['weight'] = $_weight;
        $data_insert['test_limit'] = $row['test_limit'];
        $data_insert['price'] = $row['price'];
        $data_insert['mix_question'] = $row['mix_question'];
        $data_insert['block_copy_paste'] = $row['block_copy_paste'];
        $data_insert['way_record'] = implode(',', $row['way_record']);
        $data_insert['exams_max_time'] = $row['exams_max_time'];
        $new_id = $db->insert_id($_sql, 'id', $data_insert);
        nv_insert_logs(NV_LANG_DATA, $module_name, $nv_Lang->getModule('exams_add'), $row['title'] . "(#" . $new_id . ")", $admin_info['userid']);
    } else {
        $stmt = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_exams SET isbank = :isbank, catid = :catid, topicid = :topicid, sourceid = :sourceid, title = :title, alias = :alias, code = :code, image = :image, image_position = :image_position, hometext = :hometext, description = :description, groups = :groups, groups_comment = :groups_comment, groups_result = :groups_result, begintime = :begintime, endtime = :endtime, num_question = :num_question, timer = :timer, ladder = :ladder, per_page = :per_page, type = :type, random_answer = :random_answer, rating = :rating, multiple_test = :multiple_test, history_save = :history_save, save_max_score = :save_max_score, print = :print, useguide = :useguide, type_useguide = :type_useguide, exams_reset_bank = :exams_reset_bank, template = :template, test_limit = :test_limit, price = :price, check_result = :check_result, view_mark_after_test = :view_mark_after_test, view_question_after_test = :view_question_after_test, preview_question_test = :preview_question_test, mix_question = :mix_question, block_copy_paste = :block_copy_paste, way_record = :way_record, exams_max_time = :exams_max_time WHERE id=' . $row['id']);
        $stmt->bindParam(':isbank', $row['isbank'], PDO::PARAM_INT);
        $stmt->bindParam(':catid', $row['catid'], PDO::PARAM_INT);
        $stmt->bindParam(':topicid', $row['topicid'], PDO::PARAM_INT);
        $stmt->bindParam(':sourceid', $row['sourceid'], PDO::PARAM_INT);
        $stmt->bindParam(':title', $row['title'], PDO::PARAM_STR);
        $stmt->bindParam(':alias', $row['alias'], PDO::PARAM_STR);
        $stmt->bindParam(':code', $row['code'], PDO::PARAM_STR);
        $stmt->bindParam(':image', $row['image'], PDO::PARAM_STR);
        $stmt->bindParam(':image_position', $row['image_position'], PDO::PARAM_INT);
        $stmt->bindParam(':hometext', $row['hometext'], PDO::PARAM_STR);
        $stmt->bindParam(':description', $row['description'], PDO::PARAM_STR);
        $stmt->bindParam(':groups', $row['groups'], PDO::PARAM_STR);
        $stmt->bindParam(':groups_comment', $row['groups_comment'], PDO::PARAM_STR);
        $stmt->bindParam(':groups_result', $row['groups_result'], PDO::PARAM_STR);
        $stmt->bindParam(':begintime', $row['begintime'], PDO::PARAM_INT);
        $stmt->bindParam(':endtime', $row['endtime'], PDO::PARAM_INT);
        $stmt->bindParam(':num_question', $row['num_question'], PDO::PARAM_INT);
        $stmt->bindParam(':timer', $row['timer'], PDO::PARAM_INT);
        $stmt->bindParam(':ladder', $row['ladder'], PDO::PARAM_INT);
        $stmt->bindParam(':per_page', $row['per_page'], PDO::PARAM_INT);
        $stmt->bindParam(':type', $row['type'], PDO::PARAM_INT);
        $stmt->bindParam(':random_answer', $row['random_answer'], PDO::PARAM_INT);
        $stmt->bindParam(':check_result', $row['check_result'], PDO::PARAM_INT);
        $stmt->bindParam(':view_mark_after_test', $row['view_mark_after_test'], PDO::PARAM_INT);
        $stmt->bindParam(':view_question_after_test', $row['view_question_after_test'], PDO::PARAM_INT);
        $stmt->bindParam(':preview_question_test', $row['preview_question_test'], PDO::PARAM_INT);
        $stmt->bindParam(':rating', $row['rating'], PDO::PARAM_INT);
        $stmt->bindParam(':multiple_test', $row['multiple_test'], PDO::PARAM_INT);
        $stmt->bindParam(':history_save', $row['history_save'], PDO::PARAM_INT);
        $stmt->bindParam(':save_max_score', $row['save_max_score'], PDO::PARAM_INT);
        $stmt->bindParam(':print', $row['print'], PDO::PARAM_INT);
        $stmt->bindParam(':useguide', $row['useguide'], PDO::PARAM_INT);
        $stmt->bindParam(':type_useguide', $row['type_useguide'], PDO::PARAM_INT);
        $stmt->bindParam(':exams_reset_bank', $row['exams_reset_bank'], PDO::PARAM_INT);
        $stmt->bindParam(':test_limit', $row['test_limit'], PDO::PARAM_INT);
        $stmt->bindParam(':price', $row['price'], PDO::PARAM_STR);
        $stmt->bindParam(':template', $row['template'], PDO::PARAM_INT);
        $stmt->bindParam(':mix_question', $row['mix_question'], PDO::PARAM_STR);
        $stmt->bindParam(':block_copy_paste', $row['block_copy_paste'], PDO::PARAM_INT);
        $stmt->bindParam(':way_record', implode(',', $row['way_record']), PDO::PARAM_STR);
        $stmt->bindParam(':exams_max_time', $row['exams_max_time'], PDO::PARAM_INT);

        if ($stmt->execute()) {
            $new_id = $row['id'];
            nv_insert_logs(NV_LANG_DATA, $module_name, $nv_Lang->getModule('exams_edit'), $row['title'] . "(#" . $new_id . ")", $admin_info['userid']);
        }
    }

    if ($new_id > 0) {

        if (empty($row['id'])) {
            if ($row['input_question'] == 2) {
                // thêm câu hỏi vào bảng exams_question
                $sth = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_exams_question (examsid, questionid) VALUES(:examsid, :questionid)');
                foreach ($row['question_list'] as $questionid) {
                    $sth->bindParam(':examsid', $new_id, PDO::PARAM_INT);
                    $sth->bindParam(':questionid', $questionid, PDO::PARAM_INT);
                    $sth->execute();
                }
                //chức năng thống kê lượt sử dụng câu hỏi
                $sth = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_question SET total_use= total_use+1 WHERE id = :questionid');
                foreach ($row['question_list'] as $questionid) {
                    $sth->bindParam(':questionid', $questionid, PDO::PARAM_INT);
                    $sth->execute();
                }
            }

            if ($row['input_question'] == 4) {
                // Copy các câu hỏi
                $arr_question = array();
                $result = $db->query('SELECT examid, typeid, bank_type, title, useguide, type, answer, note, weight, answer_style, count_true, max_answerid, generaltext, answer_editor, answer_editor_type, answer_fixed, point, addtime, userid FROM ' . $db_config['dbsystem'] . '.' .  NV_PREFIXLANG . '_' . $module_data . '_exams_bank_question where examid=' . $row['bankExam']);
                while ($item_question = $result->fetch(2)) {
                    $arr_question[] = $item_question;
                }
                $sth = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_question (examid, typeid, bank_type, title, useguide, type, answer, note, weight, answer_style, count_true, max_answerid, generaltext, answer_editor, answer_editor_type, answer_fixed, point, addtime,edittime, userid) VALUES (:examid, :typeid, :bank_type, :title, :useguide, :type, :answer, :note, :weight, :answer_style, :count_true, :max_answerid, :generaltext, :answer_editor, :answer_editor_type, :answer_fixed, :point, :addtime, :edittime, :userid)');

                foreach ($arr_question as $item_question) {
                    $sth->bindValue(':examid', $new_id);
                    $sth->bindValue(':typeid', $item_question['typeid'], PDO::PARAM_INT);
                    $sth->bindValue(':bank_type', $item_question['bank_type'], PDO::PARAM_INT);
                    $sth->bindValue(':title', $item_question['title']);
                    $sth->bindValue(':useguide', $item_question['useguide']);
                    $sth->bindValue(':type', $item_question['type'], PDO::PARAM_INT);
                    $sth->bindValue(':answer', $item_question['answer']);
                    $sth->bindValue(':note', $item_question['note']);
                    $sth->bindValue(':weight', $item_question['weight'], PDO::PARAM_INT);
                    $sth->bindValue(':answer_style', $item_question['answer_style']);
                    $sth->bindValue(':count_true', $item_question['count_true']);
                    $sth->bindValue(':max_answerid', $item_question['max_answerid']);
                    $sth->bindValue(':generaltext', $item_question['generaltext']);
                    $sth->bindValue(':answer_editor', $item_question['answer_editor']);
                    $sth->bindValue(':answer_editor_type', $item_question['answer_editor_type']);
                    $sth->bindValue(':answer_fixed', $item_question['answer_fixed']);
                    $sth->bindValue(':point', $item_question['point'], PDO::PARAM_INT);
                    $sth->bindValue(':addtime', $item_question['addtime'], PDO::PARAM_INT);
                    $sth->bindValue(':edittime', NV_CURRENTTIME, PDO::PARAM_INT);
                    $sth->bindValue(':userid', $item_question['userid'], PDO::PARAM_INT);
                    $sth->execute();
                }
                // thêm câu hỏi vào bảng exams_question
                $sth = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_exams_question (examsid, questionid) VALUES(:examsid, :questionid)');
                $row['question_list'] = explode(',', $row['question_list']);
                foreach ($row['question_list'] as $questionid) {
                    $sth->bindParam(':examsid', $new_id, PDO::PARAM_INT);
                    $sth->bindParam(':questionid', $questionid, PDO::PARAM_INT);
                    $sth->execute();
                }
                nv_exam_question_status($new_id);
            }
        }

        // Cap nhat tu khoa
        if ($row['keywords'] != $row['keywords_old']) {
            $keywords = explode(',', $row['keywords']);
            $keywords = array_map('strip_punctuation', $keywords);
            $keywords = array_map('trim', $keywords);
            $keywords = array_diff($keywords, array(
                ''
            ));
            $keywords = array_unique($keywords);

            foreach ($keywords as $keyword) {
                $keyword = str_replace('&', ' ', $keyword);
                if (!in_array($keyword, $array_keywords_old)) {
                    $alias_i = ($array_config['tags_alias']) ? change_alias($keyword) : str_replace(' ', '-', $keyword);
                    $alias_i = nv_strtolower($alias_i);
                    $sth = $db->prepare('SELECT tid, alias, description, keywords FROM ' . NV_PREFIXLANG . '_' . $module_data . '_tags where alias= :alias OR FIND_IN_SET(:keyword, keywords)>0');
                    $sth->bindParam(':alias', $alias_i, PDO::PARAM_STR);
                    $sth->bindParam(':keyword', $keyword, PDO::PARAM_STR);
                    $sth->execute();

                    list($tid, $alias, $keywords_i) = $sth->fetch(3);
                    if (empty($tid)) {
                        $array_insert = array();
                        $array_insert['alias'] = $alias_i;
                        $array_insert['keyword'] = $keyword;

                        $tid = $db->insert_id("INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_tags (numnews, alias, description, image, keywords) VALUES (1, :alias, '', '', :keyword)", "tid", $array_insert);
                    } else {
                        if ($alias != $alias_i) {
                            if (!empty($keywords_i)) {
                                $keyword_arr = explode(',', $keywords_i);
                                $keyword_arr[] = $keyword;
                                $keywords_i2 = implode(',', array_unique($keyword_arr));
                            } else {
                                $keywords_i2 = $keyword;
                            }
                            if ($keywords_i != $keywords_i2) {
                                $sth = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_tags SET keywords= :keywords WHERE tid =' . $tid);
                                $sth->bindParam(':keywords', $keywords_i2, PDO::PARAM_STR);
                                $sth->execute();
                            }
                        }
                        $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_tags SET numnews = numnews+1 WHERE tid = ' . $tid);
                    }

                    // insert keyword for table _tags_id
                    try {
                        $sth = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_tags_id (id, tid, keyword) VALUES (' . $new_id . ', ' . intval($tid) . ', :keyword)');
                        $sth->bindParam(':keyword', $keyword, PDO::PARAM_STR);
                        $sth->execute();
                    } catch (PDOException $e) {
                        $sth = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_tags_id SET keyword = :keyword WHERE id = ' . $new_id . ' AND tid=' . intval($tid));
                        $sth->bindParam(':keyword', $keyword, PDO::PARAM_STR);
                        $sth->execute();
                    }
                    unset($array_keywords_old[$tid]);
                }
            }

            foreach ($array_keywords_old as $tid => $keyword) {
                if (!in_array($keyword, $keywords)) {
                    $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_tags SET numnews = numnews-1 WHERE tid = ' . $tid);
                    $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_tags_id WHERE id = ' . $new_id . ' AND tid=' . $tid);
                }
            }
        }

        $id_block_content_new = !empty($row['id']) ? array_diff($row['id_block_content_post'], $id_block_content) : $row['id_block_content_post'];
        $id_block_content_del = !empty($row['id']) ? array_diff($id_block_content, $row['id_block_content_post']) : array();

        $array_block_fix = array();
        foreach ($id_block_content_new as $bid_i) {
            $db->query('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_block (bid, id, weight) VALUES (' . $bid_i . ', ' . $new_id . ', 0)');
            $array_block_fix[] = $bid_i;
        }

        foreach ($id_block_content_del as $bid_i) {
            $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block WHERE id = ' . $new_id . ' AND bid = ' . $bid_i);
            $array_block_fix[] = $bid_i;
        }

        $array_block_fix = array_unique($array_block_fix);
        foreach ($array_block_fix as $bid_i) {
            nv_fix_block($bid_i, false);
        }

        if (!empty($row['id']) and $row['num_question'] != $row['num_question_old']) {
            nv_exam_question_status($row['id']);
        }

        $nv_Cache->delMod($module_name);
        if (empty($row['id']) && $row['input_question'] == 0) {
            $url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=question&examid=' . $new_id;
        } elseif (empty($row['id']) && $row['input_question'] == 1) {
            $url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=questionword&examid=' . $new_id;
        } elseif (empty($row['id']) && $row['input_question'] == 3) {
            $url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=questionexcel&examid=' . $new_id;
        } elseif (!empty($row['redirect'])) {
            $url = nv_redirect_decrypt($row['redirect']);
        } elseif (empty($row['id']) && $row['input_question'] == 4) {
            $url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=question&bankExam=' . $row['bankExam'] . '&examid=' . $new_id;
        } else {
            $url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=exams';
        }
    }


        if (empty($error)) {
            $error = $nv_Lang->getModule('error_unknow');
        }
    } 
}

$row['timer'] = !empty($row['timer']) ? $row['timer'] : '';
$row['num_question'] = !empty($row['num_question']) ? $row['num_question'] : '';
$row['type_checked'] = $row['type'] ? 'checked="checked"' : '';
$row['random_answer_checked'] = $row['random_answer'] ? 'checked="checked"' : '';
$row['check_result_checked'] = $row['check_result'] ? 'checked="checked"' : '';
$row['view_mark_after_test_checked'] = $row['view_mark_after_test'] ? 'checked="checked"' : '';
$row['view_question_after_test_checked'] = $row['view_question_after_test'] ? 'checked="checked"' : '';
$row['preview_question_test_checked'] = $row['preview_question_test'] ? 'checked="checked"' : '';
$row['rating_checked'] = $row['rating'] ? 'checked="checked"' : '';
$row['history_save_checked'] = $row['history_save'] ? 'checked="checked"' : '';
$row['useguide_checked'] = $row['useguide'] ? 'checked="checked"' : '';
$row['print_checked'] = $row['print'] ? 'checked="checked"' : '';

$row['multiple_test_checked'] = $row['multiple_test'] ? 'checked="checked"' : '';
$row['save_max_score_checked'] = $row['save_max_score'] ? 'checked="checked"' : '';
if ($row['history_save'] && $row['multiple_test']) {
    $row['save_max_score_class'] = '';
    $row['save_max_score_disabled'] = '';
} else {
    $row['save_max_score_class'] = 'text-through';
    $row['save_max_score_disabled'] = 'disabled="disabled"';
}

if (defined('NV_EDITOR')) require_once NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php';
$row['description'] = htmlspecialchars(nv_editor_br2nl($row['description']));
if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
    $row['description'] = nv_aleditor('description', '100%', '200px', $row['description'], 'Basic', $uploads_dir_user, $currentpath);
} else {
    $row['description'] = '<textarea style="width:100%;height:200px" name="description">' . $row['description'] . '</textarea>';
}

$array_topic_module = array();
$array_topic_module[0] = $nv_Lang->getModule('topic_sl');
$db->sqlreset()
    ->select('topicid, title')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_topics');

$result = $db->query($db->sql());

while (list($topicid_i, $title_i) = $result->fetch(3)) {
    $array_topic_module[$topicid_i] = $title_i;
}

if (!empty($row['image']) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $row['image'])) {
    $row['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $row['image'];
}

if ($row['id']) {
    $array_cat_check_content = $array_cat_edit_content;
} else {
    $array_cat_check_content = $array_cat_add_content;
}

if (empty($array_cat_check_content)) {
    $redirect = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=cat';
    $contents = nv_theme_alert($nv_Lang->getModule('note_cat_title'), $nv_Lang->getModule('note_cat_content'), 'warning', $redirect, $nv_Lang->getModule('go_cat'));
    include NV_ROOTDIR . '/includes/header.php';
    echo nv_admin_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
}
$contents = '';

$row['begindate'] = !empty($row['begintime']) ? date('d/m/Y', $row['begintime']) : '';
$row['begintime'] = !empty($row['begintime']) ? date('H:i', $row['begintime']) : '';
$row['enddate'] = !empty($row['endtime']) ? date('d/m/Y', $row['endtime']) : '';
$row['endtime'] = !empty($row['endtime']) ? date('H:i', $row['endtime']) : '';
$row['price'] = !empty($row['price']) ? $row['price'] : '';
$row['style_num_question'] = ($row['input_question'] == 1 || $row['input_question'] == 2) ? 'hidden' : '';
$row['style_exams_config'] = ($row['input_question'] == 0 || $row['input_question'] == 1) ? 'hidden' : '';
$row['ck_exams_reset_bank'] = $row['exams_reset_bank'] ? 'checked="checked"' : '';

$row['source'] = array();
if ($row['sourceid'] > 0) {
    $source = $db->query('SELECT sourceid, title, link FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sources WHERE sourceid=' . $row['sourceid'])->fetch();
    if ($source) {
        $row['source'] = $source;
    }
}

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('TEMPLATE', $global_config['module_theme']);
$xtpl->assign('MODULE_UPLOAD', $module_upload);
$xtpl->assign('CURENTPATH', $currentpath);
$xtpl->assign('OP', $op);
$xtpl->assign('ROW', $row);
$xtpl->assign('PACKAGE_NOTIICE', nv_package_notice());

// Gán biến error cho template
if (!empty($error)) {
    $xtpl->assign('ERROR', $error);
    $xtpl->parse('main.error');
}

if (isset($global_config['guider']) && $global_config['guider']) {
    $xtpl->assign('link_test_cat', sprintf($nv_Lang->getModule('link_test_cat'), NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=cat#create_cat'));
    $xtpl->parse('main.guider_1');
}

if (!empty($global_config['input_question_disable_exam'])) {
    $xtpl->assign('unallow_input_question', implode(',', $global_config['input_question_disable_exam']));
    $xtpl->parse('main.unallow_input_question');
}

$xtpl->assign('mix_question_checked0', empty($row['mix_question']) ? 'checked="checked"' : '');
$xtpl->assign('mix_question_checked1', ($row['mix_question'] == '1') ? 'checked="checked"' : '');
$xtpl->assign('mix_question_checked2', !empty($row['mix_question']) && ($row['mix_question'] != '1') ? 'checked="checked"' : '');

$xtpl->assign('way_record_1_checked', in_array(1, $row['way_record']) ? 'checked="checked"' : '');
$xtpl->assign('way_record_2_checked', in_array(2, $row['way_record']) ? 'checked="checked"' : '');
$show_hide_mix_question = 'style="display: none"';
if (!empty($row['mix_question']) && ($row['mix_question'] != '1')) {
    $xtpl->assign('mix_question_value', $row['mix_question']);
    $show_hide_mix_question = 'style="display: block"';
}
$xtpl->assign('show_hide_mix_question', $show_hide_mix_question);

if (!empty($array_test_cat)) {
    foreach ($array_test_cat as $catid => $value) {
        if (defined('NV_IS_ADMIN_MODULE')) {
            $check_show = 1;
        } else {
            $array_test_cat = nv_GetCatidInParent($catid);
            $check_show = array_intersect($array_test_cat, $array_cat_check_content);
        }
        if (!empty($check_show)) {
            $value['space'] = '';
            if ($value['lev'] > 0) {
                for ($i = 1; $i <= $value['lev']; $i++) {
                    $value['space'] .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                }
            }
            $value['selected'] = $catid == $row['catid'] ? ' selected="selected"' : '';
            $xtpl->assign('CAT', $value);
            $xtpl->parse('main.cat');
        }
    }
}
// sap xep lai $groups_list de $groups_list[6] len dau
if (!empty($groups_list[6])) {
    $group_first_6 = array(6 => $groups_list[6]);
    unset($groups_list[6]);
    foreach ($groups_list as $k => $value) {
        $group_first_6[$k] = $value;
    }
    $groups_list = $group_first_6;
}

$array_groups = explode(',', $row['groups']);

//kiem tra xem trong $array_groups co nhom tat ca khong
$group6_checked = false;
foreach ($array_groups as $g) {
    $group6_checked |= $g == 6;
}

foreach ($groups_list as $_group_id => $_title) {
    $xtpl->assign('OPTION', array(
        'value' => $_group_id,
        'checked' => in_array($_group_id, $array_groups) || $group6_checked ? ' checked="checked"' : '',
        'title' => $_title,
        'disabled' => ($_group_id == 5 || $_group_id == 6) && !empty($row['type']) ? 'disabled="disabled"' : '',
        'class' => ($_group_id == 5 || $_group_id == 6) && !empty($row['type']) ? 'text-through' : ''
    ));
    $xtpl->parse('main.groups');
}

$array_groups = explode(',', $row['groups_comment']);
$group6_checked = false;
foreach ($array_groups as $g) {
    $group6_checked |= $g == 6;
}
foreach ($groups_list as $_group_id => $_title) {
    $xtpl->assign('OPTION', array(
        'value' => $_group_id,
        'checked' => in_array($_group_id, $array_groups) || $group6_checked ? ' checked="checked"' : '',
        'title' => $_title
    ));
    $xtpl->parse('main.groups_comment');
}

$array_groups = explode(',', $row['groups_result']);
$group6_checked = false;
foreach ($array_groups as $g) {
    $group6_checked |= $g == 6;
}
foreach ($groups_list as $_group_id => $_title) {
    $xtpl->assign('OPTION', array(
        'value' => $_group_id,
        'checked' => in_array($_group_id, $array_groups) || $group6_checked ? ' checked="checked"' : '',
        'title' => $_title
    ));
    $xtpl->parse('main.groups_result');
}

foreach ($array_exam_type as $index => $value) {
    $ck = $row['type'] == $index ? 'checked="checked"' : '';
    $xtpl->assign('TYPE', array(
        'index' => $index,
        'value' => $value,
        'checked' => $ck,
    ));
    $xtpl->parse('main.question_type');
}

if ($global_config['solution_hint']) {
    $array_type_useguide = array(
        '0' => $nv_Lang->getModule('type_useguide_0'),
        '3' => $nv_Lang->getModule('type_useguide_3'),
        '2' => $nv_Lang->getModule('type_useguide_2')
    );

    foreach ($array_type_useguide as $index => $value) {
        $ck = $row['useguide'] == $index ? 'checked="checked"' : '';
        $xtpl->assign('TYPE_USEGUIDE', array(
            'index' => $index,
            'value' => $value,
            'checked' => $ck
        ));
        $xtpl->parse('main.display_useguide.loop');
    }

    $array_typeuseguide = array(
        '1' => $nv_Lang->getModule('type_useguide1'),
        '2' => $nv_Lang->getModule('type_useguide2')
    );

    foreach ($array_typeuseguide as $index => $value) {
        $ck = ($row['type_useguide'] ? $row['type_useguide'] : 1) == $index ? 'checked="checked"' : '';
        $xtpl->assign('TYPE_USEGUIDE', array(
            'index' => $index,
            'value' => $value,
            'checked' => $ck
        ));
        $xtpl->parse('main.display_useguide.loop_type');
    }

    $xtpl->parse('main.display_useguide');
}

if ($row['block_copy_paste'] == 1) {
    $xtpl->assign('block_copy_paste_checked', 'checked="true"');
} else {
    $xtpl->assign('block_copy_paste_checked', '');
}

// topic
foreach ($array_topic_module as $topicid_i => $title_i) {
    $sl = ($topicid_i == $row['topicid']) ? ' selected="selected"' : '';
    $xtpl->assign('topicid', $topicid_i);
    $xtpl->assign('topic_title', $title_i);
    $xtpl->assign('sl', $sl);
    $xtpl->parse('main.rowstopic');
}

if (!empty($row['keywords'])) {
    $keywords_array = explode(',', $row['keywords']);
    foreach ($keywords_array as $keywords) {
        $xtpl->assign('KEYWORDS', $keywords);
        $xtpl->parse('main.keywords');
    }
}

if (sizeof($array_block_cat_module)) {
    foreach ($array_block_cat_module as $bid_i => $block_title) {
        $xtpl->assign('BLOCKS', array(
            'title' => $block_title,
            'bid' => $bid_i,
            'checked' => in_array($bid_i, $id_block_content) ? 'checked="checked"' : ''
        ));
        $xtpl->parse('main.block_cat.loop');
    }
    $xtpl->parse('main.block_cat');
}

$array_imgposition = array(
    0 => $nv_Lang->getModule('config_imgposition_0'),
    1 => $nv_Lang->getModule('config_imgposition_1'),
    2 => $nv_Lang->getModule('config_imgposition_2')
);
foreach ($array_imgposition as $index => $value) {
    $sl = $index == $row['image_position'] ? 'selected="selected"' : '';
    $xtpl->assign('IMGPOS', array(
        'index' => $index,
        'value' => $value,
        'selected' => $sl
    ));
    $xtpl->parse('main.imgposition');
}

$array_input_question = array();
$array_input_question[0] = $nv_Lang->getModule('type_input_question_0');
if ($array_premission['bank']) {
    $array_input_question[2] = $nv_Lang->getModule('type_input_question_2');
}
$array_input_question[1] = $nv_Lang->getModule('type_input_question_1');
$array_input_question[3] = $nv_Lang->getModule('type_input_question_3');
$array_input_question[4] = $nv_Lang->getModule('type_input_question_4');

foreach ($array_input_question as $index => $value) {
    if (!empty($row['bankExam'])) {
        $row['input_question'] = 4;
    }
    $xtpl->assign('INPUT_QUES', array(
        'index' => $index,
        'value' => $value,
        'checked' => $index == $row['input_question'] ? 'checked="checked"' : '',
        'disabled' => !empty($row['id']) || !empty($row['bankExam']) ? 'disabled="disabled"' : ''
    ));
    $xtpl->parse('main.input_question');
}

if (!empty($array_test_exams_config)) {
    foreach ($array_test_exams_config as $exams_config) {
        $exams_config['selected'] = $exams_config['id'] == $row['exams_config'] ? 'selected="selected"' : '';
        $xtpl->assign('CONFIG', $exams_config);
        $xtpl->parse('main.exams_config');
    }
}

if ($row['type'] == 0) {
    $xtpl->assign('HIDDEN', 'style="display: none"');
}

if (!empty($row['id'])) {
    $xtpl->assign('DISABLED', 'disabled="disabled"');
} else {
    $xtpl->parse('main.auto_get_alias');
}

if (!empty($row['source'])) {
    $xtpl->assign('SOURCE', $row['source']);
    $xtpl->parse('main.source');
}

if ($array_config['allow_question_point']) {
    $xtpl->parse('main.ladder_note');
}

$array_exams_template = array(
    9 => $nv_Lang->getModule('examp_template_by_config'),
    0 => $nv_Lang->getModule('examp_template_list'),
    1 => $nv_Lang->getModule('examp_template_each_question')
);
foreach ($array_exams_template as $index => $value) {
    $sl = $index == $row['template'] ? 'selected="selected"' : '';
    $xtpl->assign('EXAMS_TEMPLATE', array(
        'index' => $index,
        'value' => $value,
        'selected' => $sl
    ));
    $xtpl->parse('main.template');
}

if (defined('NV_TEST_PAYMENT')) {
    $xtpl->parse('main.price');
    $xtpl->parse('main.price_js');
}
if ($nv_Request->isset_request('clone_success', 'get')) {
    $xtpl->parse('main.clone_success');
}
$xtpl->parse('main');
$contents = $xtpl->text('main');

$set_active_op = 'exams';
if (!isset($page_title)) {
    $page_title = $nv_Lang->getModule('exams_add');
}

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
