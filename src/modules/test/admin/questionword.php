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

$examid = $nv_Request->get_int('examid', 'post,get', 0);
$typeid = $nv_Request->get_int('typeid', 'post,get', 0);
$update_question = $nv_Request->get_int('update_question', 'post,get', 0);
if ($examid > 0) {
    $exams_info = $db->query('SELECT title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams WHERE id=' . $examid)->fetch();
    if (!$exams_info) {
        Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=exams');
        die();
    }
}

$db->sqlreset()
->select('id, title, parentid')
->from(NV_PREFIXLANG . '_' . $module_data . '_bank')
->order('parentid ASC');
$result = $db->query($db->sql());
$list_bank = array();
while ($bank_row = $result->fetch(2)) {
    if (empty($bank_row['parentid'])) {
        $bank_row['children'] = array();
        $list_bank[$bank_row['id']] = $bank_row;
    } else {
        $list_bank[$bank_row['parentid']]['children'][$bank_row['id']] = $bank_row;
    }
}

if (!empty($examid)) {
    $set_active_op = 'exams';
    $page_title = sprintf($nv_Lang->getModule('exams_question'), $exams_info['title']);
} else {
    $set_active_op = 'bank';
    $array_mod_title[] = [
        'title' => $nv_Lang->getModule('importword')
    ];
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
        'title' => $nv_Lang->getModule('bank'),
        'link' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=bank'
    );
    krsort($array_mod_title, SORT_NUMERIC);
}
$error = '';
if ($nv_Request->isset_request('submit_word', 'post')) {
    $examid = $nv_Request->get_int('examid', 'post', 0);
    $typeid = $nv_Request->get_int('typeid', 'post', 0);
    $update_question = $nv_Request->get_int('update_question', 'post', 0);
    
    
    $array_question = $nv_Request->get_string($module_data . '_array_question', 'session');
    if (empty($typeid) && empty($examid) && empty($update_question)) {
        $error = $nv_Lang->getModule('error_required_bank_cat');
    }
    if (!empty($array_question) && empty($error)) {
        $array_question = unserialize($array_question);
        $array_question = $array_question['data'];
        try {
            $username_alias = change_alias($admin_info['username']);
            $upload_user_path = nv_upload_user_path($username_alias);
            $currentpath = $upload_user_path['currentpath'];
            $uploads_dir_user = $upload_user_path['uploads_dir_user'];

            // xóa câu hỏi cũ trước khi import
            if ($examid > 0) {
                $count = $db->exec('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_question WHERE examid=' . $examid);
                if ($count) {
                    $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams_question WHERE examsid=' . $examid);
                }
            }

            $number = 1;
            $array_questionid = array();
            //Xử lý trường hợp 1 hình ảnh lại được sử dụng ở nhiều câu hỏi 
            //=> đang copy và delete ở vị trí này lại tiếp tục copy và delete ở vị trí khác => lỗi
            $haved_move_image = array();
            // insert câu hỏi mới
            foreach ($array_question as $question) {
                // copy ảnh trong nội dung câu hỏi sang thư mục uploads
                if (preg_match_all("/\<img[^\>]*src=\"([^\"]*)\"[^\>]*\>/is", $question['question'], $match)) {
                    foreach ($match[0] as $key => $_m) {
                        $image_url = $image_url_tmp = $match[1][$key];
                        if (!nv_is_url($image_url)) {
                            $image_url = NV_ROOTDIR . '/' . $currentpath . '/' . basename($image_url);
                            if (!$haved_move_image[$image_url_tmp]) {
                                rename(NV_ROOTDIR . $image_url_tmp, $image_url);
                            }
                            $image_url = str_replace(NV_ROOTDIR, '', $image_url);
                            $question['question'] = str_replace($image_url_tmp, $image_url, $question['question']);
                        }
                        $haved_move_image[$image_url_tmp] = true;
                    }
                }

                if (!empty($question['answer'])) {
                    foreach ($question['answer'] as $index => $answer) {
                        // copy ảnh trong nội dung đáp án sang thư mục uploads
                        if (preg_match_all("/\<img[^\>]*src=\"([^\"]*)\"[^\>]*\>/is", $answer['content'], $match)) {
                            foreach ($match[0] as $key => $_m) {
                                $image_url = $image_url_tmp = $match[1][$key];
                                $image_url = NV_ROOTDIR . '/' . $currentpath . '/' . basename($image_url);
                                // Di chuyên ảnh từ tmp sang thư mục uploads
                                if (!$haved_move_image[$image_url_tmp]) {
                                    rename(NV_ROOTDIR . $image_url_tmp, $image_url);
                                }
                                // Thay đổi url trong image
                                $image_url = str_replace(NV_ROOTDIR, '', $image_url);
                                $question['answer'][$index]['content'] = str_replace($image_url_tmp, $image_url, $answer['content']);
                              
                                $haved_move_image[$image_url_tmp] = true;
                            }
                        }
                    }
                }
                $max_answerid = count($question['answer']);
                $answer = !empty($question['answer']) ? serialize($question['answer']) : '';
                $answer_editor = 1;
                $answer_style = 0;
                $count_true = $question['count_true'];
                if (empty($update_question)) {
                    $_sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_question
                    (examid, typeid, bank_type, title, useguide, type, answer, note, weight, answer_style, count_true, max_answerid, generaltext, answer_editor, addtime, edittime,userid) VALUES
                    (' . $examid . ', ' . $typeid . ', ' . $question['bank_type'] . ', ' . $db->quote($question['question']) . ', ' . $db->quote($question['useguide']) . ', ' . $question['type'] . ', ' . $db->quote($answer) . ', \'\', ' . $number . ', ' . $answer_style . ',
                    ' . $count_true . ', ' . $max_answerid . ', ' . $db->quote($question['generaltext']) . ', ' . $answer_editor . ', ' . NV_CURRENTTIME . ', ' . NV_CURRENTTIME . ', 0)';
                    $new_id = $db->insert_id($_sql, 'id');
                    if ($new_id) {
                        $number++;
                        $array_questionid[] = $new_id;
                        nv_insert_logs(NV_LANG_DATA, $module_name, $nv_Lang->getModule('questions'), $question['question'], $admin_info['userid']);
                    }
                } else {
                    if (empty($question['id'])) continue;
                    $_sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_question SET bank_type = :bank_type, title = :title, useguide = :useguide, type = :type, answer = :answer, count_true = :count_true, max_answerid = :max_answerid, generaltext = :generaltext, answer_editor = :answer_editor, edittime = ' . NV_CURRENTTIME . ' WHERE id = ' . $question['id'];
                    $stmt = $db->prepare($_sql);
                    $stmt->bindValue(':bank_type', $question['bank_type'], PDO::PARAM_INT);
                    $stmt->bindValue(':title', $question['question'], PDO::PARAM_STR);
                    $stmt->bindValue(':useguide', $db->quote($question['useguide']), PDO::PARAM_STR);
                    $stmt->bindValue(':type', $question['type'], PDO::PARAM_INT);
                    $stmt->bindValue(':answer', $answer, PDO::PARAM_STR);
                    $stmt->bindValue(':count_true', $count_true, PDO::PARAM_INT);
                    $stmt->bindValue(':max_answerid', $max_answerid, PDO::PARAM_INT);
                    $stmt->bindValue(':generaltext', $db->quote($question['generaltext']), PDO::PARAM_STR);
                    $stmt->bindValue(':answer_editor', $answer_editor, PDO::PARAM_INT);
                    $stmt->execute();
                    nv_insert_logs(NV_LANG_DATA, $module_name, $nv_Lang->getModule('update_question'), $question['question'], $admin_info['userid']);
                }
            }
            if (!empty($array_questionid)) {
                // thêm câu hỏi vào bảng exams_question
                if ($examid > 0) {
                    $sth = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_exams_question (examsid, questionid) VALUES(:examsid, :questionid)');
                    foreach ($array_questionid as $questionid) {
                        $sth->bindParam(':examsid', $examid, PDO::PARAM_INT);
                        $sth->bindParam(':questionid', $questionid, PDO::PARAM_INT);
                        $sth->execute();
                    }
                }
            }

            if ($examid > 0) {
                $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_exams SET num_question=' . ($number - 1) . ', count_question=' . $number . ', question_list=' . $db->quote(implode(',', $array_questionid)) . ' WHERE id=' . $examid);
                nv_exam_question_status($examid);
            }

            $nv_Request->unset_request($module_data . '_array_question', 'session');
            $nv_Cache->delMod($module_name);

            if ($examid > 0) {
                $url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=question&examid=' . $examid;
            } else {
                $url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=search_questions&typeid=' . $typeid;
            }


            nv_jsonOutput(array(
                'error' => 0,
                'redirect' => $url
            ));
        } catch (PDOException $e) {
            trigger_error($e->getMessage());
            nv_jsonOutput(array(
                'error' => 1,
                'msg' => $nv_Lang->getModule('error_unknow')
            ));
        }
    }
}

if ($nv_Request->isset_request('review', 'post')) {
    $examid = $nv_Request->get_int('examid', 'post', 0);
    $typeid = $nv_Request->get_int('typeid', 'post', 0);
    $type_file_word = $nv_Request->get_title('type_file_word', 'post', 'old');
    if (empty($typeid) && empty($examid) && empty($update_question)) {
        $error = $nv_Lang->getModule('error_required_bank_cat');
    }
    if (empty($error)) {
        $array_question = ($type_file_word == 'old') ? nv_test_read_msword_old($_FILES['upload_fileupload']['tmp_name'], $examid) 
        : nv_test_read_msword_new($_FILES['upload_fileupload']['tmp_name'], $examid);
        $contents = nv_preview_import_word($array_question, $examid, $typeid, $update_question);
        include NV_ROOTDIR . '/includes/header.php';
        echo nv_admin_theme($contents);
        include NV_ROOTDIR . '/includes/footer.php';
        exit();
    }
}

$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);
$xtpl->assign('EXAMID', $examid);
$xtpl->assign('TYPEID', $typeid);

if (!empty($error)) {
    $xtpl->assign('ERROR', $error);
    $xtpl->parse('main.error');
}
if (empty($import_word_to_exam->imagick)) {
    $xtpl->parse('main.not_imagick');
};
if (empty($examid)) {
    foreach ($list_bank as $item_group) {
        $xtpl->assign('option_group', $item_group['title']);
        foreach ($item_group['children'] as $option) {
            $xtpl->assign('OPTION', array(
                'id' => $option['id'],
                'title' => '  |--->'. $option['title'],
                'selected' => $option['id'] == $typeid ? 'selected' : '',
            ));
            $xtpl->parse('main.typeid.bank_option_group.bank_option');
        }
        $xtpl->parse('main.typeid.bank_option_group');
    }
    $xtpl->parse('main.typeid');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';