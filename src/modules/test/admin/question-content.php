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

$row = array();
/*
* Nếu có clone_id thì nó sẽ lợi dụng tương tự có id để lấy dữ liệu.
* Sau khi lấy xong dữ liệu thì đưa $row['id'] về 0
*/
$clone_id = $nv_Request->get_int('clone_id', 'post,get', 0);
$row['id'] = empty($clone_id) ?  $nv_Request->get_int('id', 'post,get', 0) : $clone_id;
$row['typeid'] = $nv_Request->get_int('typeid', 'get', 0);

/**
 * Kiểm tra có sử dụng editor cho câu hỏi và đáp án không?
 * $user_editor = 'saved' : lấy thông tin đã lưu trong CSDL
 * $user_editor = 'user_editor' : sử dụng editor
 * $user_editor = 'not_editor' : không sử dụng editor
 * $row['type'] = 1: Câu hỏi lựa chọn
 * $row['type'] = 2: Điền vào ô trống
 * $row['type'] = 3: Câu hỏi chung
 * $row['type'] = 4: Câu hỏi đúng/sai
 * $row['type'] = 5: Câu hỏi đánh giá năng lực
 * $row['type'] = 6: Câu hỏi tự luận
 */
/**
 * field: mark_max_constructed_response
 * Đối với câu tự luận thì đây là giới hạn điểm được chấm.
 * Đối với câu hỏi trắc nghiệm thì đây là điểm dành cho câu hỏi đó. 
 * Nhưng câu không còn lại thì lấy điểm trung bình cộng những câu còn lại
 */
$user_editor_ajax = $nv_Request->get_title('user_editor_ajax', 'get, post', 'saved');

$bank = $nv_Request->get_int('bank', 'post,get', 0);
$table_exams = NV_PREFIXLANG . '_' . $module_data . '_exams';
$table_question = NV_PREFIXLANG . '_' . $module_data . '_question';
if($bank){
    $table_exams = tableSystem . '_exams_bank';
    $table_question = tableSystem . '_exams_bank_question';
}

$username_alias = change_alias($admin_info['username']);
$upload_user_path = nv_upload_user_path($username_alias);
$currentpath = $upload_user_path['currentpath'];
$uploads_dir_user = $upload_user_path['uploads_dir_user'];
if (defined('NV_EDITOR')) {
    require_once NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php';
}

if ($nv_Request->isset_request('get_answer', 'post')) {
    $questionid = $nv_Request->get_int('questionid', 'post', 0);
    $answer_editor = $nv_Request->get_int('answer_editor', 'post', 0);
    $question_type = $nv_Request->get_int('question_type', 'post', 1);
    $question_answer = array();

    if (!empty($questionid)) {
        list ($question_type, $question_answer) = $db->query('SELECT type, answer FROM ' . $table_question . ' WHERE id=' . $questionid)->fetch(3);
        $question_answer = unserialize($question_answer);
    }

    $html = nv_question_type_answer($questionid, $question_type, $question_answer, $answer_editor);

    $db->query('UPDATE ' . $table_question . ' SET answer_editor=' . $answer_editor . ' WHERE id=' . $questionid);

    nv_htmlOutput($html);
}

if ($nv_Request->isset_request('get_answer_editor', 'post')) {
    $name = nv_unhtmlspecialchars($nv_Request->get_title('name', 'post', ''));

    if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
        $editor = nv_aleditor($name, '100%', '100px', '', 'Question', $currentpath);
    } else {
        $editor = '<textarea class="form-control" style="width:100%;height:100px" name="' . $name . '"></textarea>';
    }
    nv_htmlOutput($editor);
}

if ($row['id'] > 0) {
    $page_title = $nv_Lang->getModule('question_edit');
    $row = $db->query('SELECT * FROM ' . $table_question . ' WHERE id=' . $row['id'])->fetch();
    if (empty($row)) {
        Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
        die();
    }
    $row['answer'] = unserialize($row['answer']);
} else {
    $row['examid'] = $nv_Request->get_int('examid', 'post,get', 0);
    $row['title'] = '';
    $row['useguide'] = '';
    $row['type'] = $nv_Request->get_int('type', 'post,get', (isset($_COOKIE[$module_data]['question_content']['type']) ? $_COOKIE[$module_data]['question_content']['type'] : 1));
    $row['count_true'] = 0;
    $row['answer_style'] = 0;
    $row['answer_fixed'] = 0;
    $row['answer'] = array();
    $row['answer_old'] = $row['answer_old'] = array();
    $row['max_answerid'] = 0;
    $row['answer_editor'] = $nv_Request->get_int('use_editor', 'post,get', 0);
    $row['userid'] = $admin_info['userid'];
    $row['bank_type'] = 1;
    $row['point'] = 0;
    $row['answer_editor_type'] = 0;
    $row['limit_time_audio'] = 0;
    $row['mark_max_constructed_response'] = 0;
    $page_title = $nv_Lang->getModule('question_add');
}

$row['ajax'] = $nv_Request->get_int('ajax', 'get,post', 0);
$row['number'] = $nv_Request->get_int('number', 'post,get', 0);
$row['redirect'] = $nv_Request->get_string('redirect', 'get,post');

$exam_info = $db->query('SELECT * FROM ' . $table_exams . ' WHERE id=' . $row['examid'])->fetch();

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
/**
 * Lấy thứ tự của câu hỏi
 * Trong danh sách các câu hỏi thì có câu hỏi dạng "Câu hỏi chung". 
 * Câu hỏi này là để bổ sung thông tin vào cho các câu hỏi tiếp theo nên sẽ không được tính là câu hỏi thực sự.
 * Nhưng nó vẫn được tính trong câu hỏi dẫn đến thứ tự các câu hỏi bị sai nên cần phải trừ đi các câu hỏi đó.
 */
$db->sqlreset()
    ->select('COUNT(*)')
    ->from($table_question)
    ->where('examid=' . $row['examid'] . ' AND weight <' . $row['number'] . ' AND type = 3');
$count_type_3 = $db->query($db->sql())->fetchColumn();

if ($nv_Request->isset_request('submit', 'post')) {
    $row['examid'] = $nv_Request->get_int('examid', 'post,get', 0);
    $row['typeid'] = $nv_Request->get_int('typeid', 'post,get', 0);
    $row['answer_editor'] = $nv_Request->get_int('use_editor', 'post,get', 0);
    $row['answer_editor_type'] = $nv_Request->get_int('answer_editor_type', 'post', 0);
    $row['limit_time_audio'] = $nv_Request->get_int('limit_time_audio', 'post', 0);
    $row['mark_max_constructed_response'] = $nv_Request->get_int('mark_max_constructed_response', 'post', 0);

    $row['from_question'] = $nv_Request->get_int('from_question', 'post', 0);
    $row['to_question'] = $nv_Request->get_int('to_question', 'post', 0);
    if ($array_config['enable_editor'] && $row['answer_editor']) {
        $row['title'] = $nv_Request->get_editor('title', '', NV_ALLOWED_HTML_TAGS);
        $row['useguide'] = $nv_Request->get_editor('useguide', '', NV_ALLOWED_HTML_TAGS);
    } else {
        $row['title'] = $nv_Request->get_textarea('title', '', NV_ALLOWED_HTML_TAGS);
        $row['useguide'] = $nv_Request->get_textarea('useguide', '', NV_ALLOWED_HTML_TAGS);
    }
    $row['title'] = trim($row['title']);
    $row['answer_style'] = $nv_Request->get_int('answer_style', 'post', 0);
    $row['answer_fixed'] = $nv_Request->get_int('answer_fixed', 'post', 0);
    $row['point'] = $nv_Request->get_title('point', 'post', 0);
    $row['point'] = floatval($row['point']);

    if (empty($row['id'])) {
        $row['type'] = $nv_Request->get_int('type', 'post,get', 1);
        $row['bank_type'] = $nv_Request->get_int('bank_type', 'post,get', 0);
    }

    $answer = '';
    $row['answer'] = array();
    $count_true = 0;
    if ($row['type'] == 1 || $row['type'] == 2 || $row['type'] == 5) {
        $answer = $nv_Request->get_array('answer', 'post');
        if (!empty($answer)) {
            /**
             * $answer_empty xử lý trường hợp không điền nội dung câu trả lời nó sẽ lấy mặc định là A,B,C, D
             */
            $i = 0;
            $answer_empty = array();
            foreach ($answer as $key => $value) {
                if ($value['content'] != '') {
                    if (empty($value['id'])) {
                        $row['max_answerid'] = $row['max_answerid'] + 1;
                        $value['id'] = $row['max_answerid'];
                    }

                    if ($row['type'] == 1) {
                        if (isset($value['is_true']) and $value['is_true']) {
                            $count_true++;
                            $value['is_true'] = intval($value['is_true']);
                        } else {
                            $value['is_true'] = 0;
                        }
                    } elseif ($row['type'] == 2) {
                        if (empty($value['is_true'])) {
                            die(json_encode(array(
                                'error' => 1,
                                'msg' => sprintf($nv_Lang->getModule('error_required_type_2_is_true'), $value['content']),
                                'input' => 'answer'
                            )));
                        } else {
                            $count_true++;
                        }
                    }

                    $row['answer'][$value['id']] = array(
                        'id' => $value['id'],
                        'content' => $value['content']
                    );

                    // nếu loại câu hỏi 5 - điểm từng đáp án thì thêm dữ liệu điểm vào
                    if ($row['type'] == 5) {
                        $row['answer'][$value['id']]['point'] = floatval($value['point']);
                    } else {
                        // nếu là các loại câu hỏi khác thì thêm đáp án đúng vô
                        $row['answer'][$value['id']]['is_true'] = $value['is_true'];
                    }
                } else if ($row['type'] == 1) {
                    $i ++;
                    $count_true += ((isset($value['is_true']) and $value['is_true']) ? 1 : 0);
                    $answer_empty['answer'][$i] = array(
                        'id' => $i,
                        'content' => '',
                        'is_true' => (isset($value['is_true']) and $value['is_true']) ? intval($value['is_true']) : 0
                    );
                }
            }
            /**
             * Nếu tất cả đáp án đều không có dữ liệu thì sẽ lấy dữ liệu mặc định
             */
            if ($i == count($answer)) {
                $row['answer'] = $answer_empty['answer'];
            }
        }
    } elseif ($row['type'] == 4) {
        $row['answer'] = $nv_Request->get_int('answer', 'post', 0);
        if (!empty($row['answer'])) {
            $count_true = 1;
        }
    } elseif ($row['type'] == 3) {
        $row['answer'] = array(
            'from_question' => $row['from_question'], 
            'to_question' => $row['to_question'], 
        );
    }

    $total_mark_type_5 = 0;
    $total_mark_type_6 = 0;
    if ($row['type'] == 5 || !empty($row['mark_max_constructed_response'])) {
        list($ladder) = $db->query('SELECT ladder FROM ' . $table_exams . ' WHERE id=' . $row['examid'])->fetch(3);
        $ladder = !empty($ladder) ? $ladder : 0;

        list($total_mark_type_6) = $db->query('SELECT SUM(mark_max_constructed_response)  FROM ' . $table_question . ' WHERE examid=' . $row['examid'] . ' AND id != ' . $row['id'])->fetch(3);
        $total_mark_type_6 = !empty($total_mark_type_6) ? $total_mark_type_6 : 0;

        $total_mark_type_5 = 0;
        $result = $db->query('SELECT answer FROM ' . $table_question . ' WHERE examid=' . $row['examid'] . ' AND type = 5 AND id != ' . $row['id']);
        while(list($answer) = $result->fetch(3)) {
            $answer = nv_unserialize($answer);
            $max_mark_5=array_reduce($answer, function($item1, $item2){
                return $item1['point'] > $item2['point'] ? $item1['point'] : $item2['point'];
            }, array('point'=>0));
            $total_mark_type_5 += $max_mark_5;
        }
        $total_mark_type_5_6 = $total_mark_type_5 + $total_mark_type_6 + (($row['type'] == 5) ? array_reduce($row['answer'], function($item1, $item2){
            return $item1['point'] > $item2['point'] ? $item1['point'] : $item2['point'];
        }, array('point'=>0)) : $row['mark_max_constructed_response']);
    }
    
    if (($row['type'] == 5  || !empty($row['mark_max_constructed_response'])) && $total_mark_type_5_6 > $ladder) {
        die(json_encode(array(
            'error' => 1,
            'msg' => $nv_Lang->getModule('error_mark_greater'),
            'input' => 'answer'
        )));
    }elseif ($row['type'] == 1 && count($row['answer']) < 2) {
        die(json_encode(array(
            'error' => 1,
            'msg' => $nv_Lang->getModule('error_required_answer'),
            'input' => 'answer'
        )));
    } elseif ($row['type'] != 3 && $row['type'] != 5 && $row['type'] != 6 && $row['type'] != 7 && empty($count_true)) {
        die(json_encode(array(
            'error' => 1,
            'msg' => $nv_Lang->getModule('error_required_answer_is_true'),
            'input' => 'answer'
        )));
    } elseif ($array_config['allow_question_point'] && !empty($row['examid']) && isset($exam_info['ladder']) && empty($exam_info['ladder']) && empty($row['point'])) {
        die(json_encode(array(
            'error' => 1,
            'msg' => $nv_Lang->getModule('error_required_point'),
            'input' => 'point'
        )));
    } elseif (empty($row['title'])) {
        die(json_encode(array(
            'error' => 1,
            'msg' => $nv_Lang->getModule('error_required_point'),
            'input' => 'test_title'
        )));
    } elseif(empty($row['typeid']) && empty($row['examid'])) {
        die(json_encode(array(
            'error' => 1,
            'msg' => $nv_Lang->getModule('error_required_bank_cat'),
            'input' => 'test_title'
        )));
    }
    try {
        $new_id = 0;
        $answer = !empty($row['answer']) ? serialize($row['answer']) : '';
        if (empty($row['id'])) {
            $_sql = 'INSERT INTO ' . $table_question . ' (examid, typeid, bank_type, title, useguide, type, answer, weight, answer_style, answer_fixed, point, count_true, max_answerid, generaltext, answer_editor, answer_editor_type, addtime, edittime, userid, note, limit_time_audio, mark_max_constructed_response) VALUES (:examid, :typeid, :bank_type, :title, :useguide, :type, :answer, :weight, :answer_style, :answer_fixed, :point, :count_true, :max_answerid, :generaltext, :answer_editor, :answer_editor_type, ' . NV_CURRENTTIME . ',' . NV_CURRENTTIME . ', :userid,"", :limit_time_audio, :mark_max_constructed_response )';
            $data_insert = array();
            $data_insert['examid'] = $row['examid'];
            $data_insert['typeid'] = $row['typeid'];
            $data_insert['bank_type'] = $row['bank_type'];
            $data_insert['title'] = $row['title'];
            $data_insert['type'] = $row['type'];
            $data_insert['useguide'] = $row['useguide'];
            $data_insert['answer'] = $answer;
            $data_insert['weight'] = $row['number'];
            $data_insert['answer_style'] = $row['answer_style'];
            $data_insert['answer_fixed'] = $row['answer_fixed'];
            $data_insert['point'] = $row['point'];
            $data_insert['count_true'] = $count_true;
            $data_insert['max_answerid'] = $row['max_answerid'];
            $data_insert['generaltext'] = ' ';
            $data_insert['answer_editor'] = $row['answer_editor'];
            $data_insert['answer_editor_type'] = $row['answer_editor_type'];
            $data_insert['userid'] = $row['userid'];
            $data_insert['limit_time_audio'] = $row['limit_time_audio'];
            $data_insert['mark_max_constructed_response'] = $row['mark_max_constructed_response'];
            $new_id = $db->insert_id($_sql, 'id', $data_insert);
            nv_insert_logs(NV_LANG_DATA, $module_name, $nv_Lang->getModule('question_add') , $nv_Lang->getModule('question') . " (id#". $new_id . ")" , $admin_info['userid']);
        } else {
            $update_question = '';
            if(!$bank){
                list($examinationsid, $examid) = $db->query('SELECT examinationsid, examid FROM ' . $table_question . ' WHERE id=' .  $row['id'])->fetch(3);
                if (!empty($examinationsid)) {
                    die(json_encode(array(
                        'error' => 1,
                        'msg' => empty($examid) ? $nv_Lang->getModule('not_update_question_for_examinations1') : $nv_Lang->getModule('not_update_question_for_examinations2')
                    )));
                }
                $update_question = ', limit_time_audio = :limit_time_audio, mark_max_constructed_response = :mark_max_constructed_response';
            }
            $stmt = $db->prepare('UPDATE ' . $table_question . ' SET typeid = :typeid, bank_type = :bank_type, title = :title, useguide=:useguide, type = :type, answer = :answer, answer_style = :answer_style, answer_fixed=:answer_fixed, point = :point, count_true = :count_true, max_answerid = :max_answerid, answer_editor = :answer_editor, answer_editor_type = :answer_editor_type, edittime = ' . NV_CURRENTTIME . $update_question . ' WHERE id=' . $row['id']);
            $stmt->bindParam(':typeid', $row['typeid'], PDO::PARAM_INT);
            $stmt->bindParam(':bank_type', $row['bank_type'], PDO::PARAM_INT);
            $stmt->bindParam(':title', $row['title'], PDO::PARAM_STR);
            $stmt->bindParam(':useguide', $row['useguide'], PDO::PARAM_STR);
            $stmt->bindParam(':type', $row['type'], PDO::PARAM_INT);
            $stmt->bindParam(':answer', $answer, PDO::PARAM_STR);
            $stmt->bindParam(':answer_style', $row['answer_style'], PDO::PARAM_INT);
            $stmt->bindParam(':answer_fixed', $row['answer_fixed'], PDO::PARAM_INT);
            $stmt->bindParam(':point', $row['point'], PDO::PARAM_STR);
            $stmt->bindParam(':count_true', $count_true, PDO::PARAM_INT);
            $stmt->bindParam(':max_answerid', $row['max_answerid'], PDO::PARAM_INT);
            $stmt->bindParam(':answer_editor', $row['answer_editor'], PDO::PARAM_INT);
            $stmt->bindParam(':answer_editor_type', $row['answer_editor_type'], PDO::PARAM_INT);
            if(!$bank){
                $stmt->bindParam(':limit_time_audio', $row['limit_time_audio'], PDO::PARAM_INT);
                $stmt->bindParam(':mark_max_constructed_response', $row['mark_max_constructed_response'], PDO::PARAM_INT);
            }
            if ($stmt->execute()) {
                $new_id = $row['id'];
                nv_insert_logs(NV_LANG_DATA, $module_name, $nv_Lang->getModule('question_edit') , $nv_Lang->getModule('question') . " (id:#". $new_id . ")" , $admin_info['userid']);
            }
        }

        if (!empty($new_id)) {

            if (empty($row['id'])) {

                $_COOKIE[$module_data]['question_content'] = array(
                    'type' => $row['type']
                );

                // nếu nhập từng câu hỏi cho đề thì cập nhật lại trạng thái
                if ($row['examid'] > 0) {
                    $sth = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_exams_question (examsid, questionid) VALUES(:examsid, :questionid)');
                    $sth->bindParam(':examsid', $row['examid'], PDO::PARAM_INT);
                    $sth->bindParam(':questionid', $new_id, PDO::PARAM_INT);
                    $sth->execute();
                }
            }

            // Nếu là câu hỏi chung type = 3 thì cập nhật lại thứ tự
            if ($row['type'] == 3) {
                change_question_order($row['examid'], $new_id, $row['from_question'] + $count_type_3);
                $db->query('UPDATE '  . NV_PREFIXLANG . '_' . $module_data . '_exams SET num_question = num_question -1 WHERE id = ' . $row['examid']);
            }
            // cập nhật trạng thái đề thi dựa vào số lượng câu hỏi đáp ứng
            nv_exam_question_status($row['examid']);
            $nv_Cache->delMod($module_name);

            $array_data = array(
                'error' => 0,
                'msg' => $nv_Lang->getModule('save_success'),
                'number' => $row['number'],
                'id' => $new_id,
                'ajax' => $row['ajax'],
                'bank' => !empty($row['typeid']) ? 1 : 0,
                'redirect' => !empty($row['redirect']) ? nv_redirect_decrypt($row['redirect']) : NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=question-list&typeid=' . $row['typeid']
            );

            if (empty($row['id'])) {
                $array_data['next_number'] = $row['number'] + 1;
                $array_data['next_id'] = (int) $db->query('SELECT id FROM ' . $table_question . ' WHERE weight=' . ($row['number'] + 1) . ' AND examid=' . $row['examid'])->fetchColumn();
            }

            die(json_encode($array_data));
        }
    } catch (PDOException $e) {
        trigger_error($e->getMessage());
        die(json_encode(array(
            'error' => 1,
            'msg' => $nv_Lang->getModule('error_unknow')
        )));
    }
}
$row['answer_editor'] = $user_editor_ajax == 'user_editor' ? 1 : ($user_editor_ajax == 'not_editor' ? 0 : $row['answer_editor']);

if ($array_config['enable_editor'] && ($row['answer_editor'] == 1)) {
    $row['title'] = htmlspecialchars(nv_editor_br2nl($row['title']));
    $row['useguide'] = htmlspecialchars(nv_editor_br2nl($row['useguide']));
    if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
        $row['title'] = nv_aleditor('title', '100%', '200px', $row['title'], '', $uploads_dir_user, $currentpath, 'autosave');
        $row['useguide'] = nv_aleditor('useguide', '100%', '200px', $row['useguide'], 'Basic', $uploads_dir_user, $currentpath);
    } else {
        $row['title'] = '<textarea class="form-control" style="width:100%;height:60px" name="title">' . $row['title'] . '</textarea>';
        $row['useguide'] = '<textarea class="form-control" style="width:100%;height:100px" name="useguide">' . $row['useguide'] . '</textarea>';
    }
} else {
    $row['title'] = strip_tags($row['title']);
    $row['useguide'] = strip_tags($row['useguide']);
    $row['title'] = '<textarea class="form-control" style="width:100%;height:100px" name="title">' . $row['title'] . '</textarea>';
    $row['useguide'] = '<textarea class="form-control" style="width:100%;height:100px" name="useguide">' . $row['useguide'] . '</textarea>';
}
$row['editor'] = $array_config['enable_editor'] && ($row['answer_editor'] == 1);
$row['answer_fixed'] = $row['answer_fixed'] ? 'checked="checked"' : '';
$row['point'] = !empty($row['point']) ? $row['point'] : '';

$row['number_question_view'] = $row['number'] - $count_type_3;
/*
* trả row['id'] về 0 để chương trình hiểu đây là câu mới chứ không phải cập nhật câu cũ
*/
if (!empty($clone_id)) {
    $row['id'] = 0;
}
$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);
$xtpl->assign('ROW', $row);
$xtpl->assign('TEMPLATE', $global_config['module_theme']);
$xtpl->assign('BANKEXAM', $bank ? 1 : 0);
$xtpl->assign('CK_EDITOR_TITLE', $row['answer_editor'] ? 'checked="checked"' : '');
$xtpl->assign('QUESTIONID', $row['id']);

$array_config['allow_question_type'] = !empty($array_config['allow_question_type']) ? explode(',', $array_config['allow_question_type']) : array();
foreach ($array_question_type as $index => $value) {
    if (!in_array($index, $array_config['allow_question_type'])) continue;
    $sl = $index == $row['type'] ? 'checked="checked"' : '';
    $xtpl->assign('TYPE', array(
        'index' => $index,
        'value' => $value,
        'checked' => $sl,
        'disabled' => !empty($row['id']) ? 'disabled="disabled"' : ''
    ));
    $xtpl->parse('main.question_type');
}
if (empty($row['examid'])) {
    $xtpl->parse('main.bank_editor');
    foreach ($array_bank_type as $index => $value) {
        $sl = $index == $row['bank_type'] ? 'checked="checked"' : '';
        $xtpl->assign('BANK_TYPE', array(
            'index' => $index,
            'value' => $value['title'],
            'checked' => $sl,
            'disabled' => !empty($row['id']) ? 'disabled="disabled"' : ''
        ));
        $xtpl->parse('main.bank_type.loop');
    }
    $xtpl->parse('main.bank_type');
    foreach ($list_bank as $item_group) {
        $xtpl->assign('option_group', $item_group['title']);
        foreach ($item_group['children'] as $option) {
            $xtpl->assign('OPTION', array(
                'id' => $option['id'],
                'title' => '  |--->'. $option['title'],
                'selected' => $option['id'] == $row['typeid'] ? 'selected' : '',
            ));
            $xtpl->parse('main.typeid.bank_option_group.bank_option');
        }
        $xtpl->parse('main.typeid.bank_option_group');
    }
    $xtpl->parse('main.typeid');

}


if ($global_config['solution_hint']) {
    $xtpl->parse('main.useguide');
}

if ($array_config['allow_question_point'] && (empty($exam_info['ladder']) || empty($row['examid']))) {
    $xtpl->parse('main.point');
}

if ($row['ajax']) {
    $xtpl->assign('number_question_view_title', ($row['type'] !==3) ? $nv_Lang->getModule('question') . " " . $row['number_question_view'] : $nv_Lang->getModule('question_type_3'));
    $xtpl->parse('main.number');
    $xtpl->parse('main.in_exam_script');
} else {
    $xtpl->parse('main.question_content_id');
    $xtpl->parse('main.not_exam_script');
}
$xtpl->assign('lang_title', $row['type'] === 3 ? $nv_Lang->getModule('question_type_3_content') : $nv_Lang->getModule('title'));
if (in_array($row['type'], array(1,2,4,5,6,7))) {
    $xtpl->parse('main.config_advanced');
}

if (in_array($row['type'], array(1,2,4,7))) {
    $xtpl->parse('main.show_type_private_mark');
}

// nếu loại câu hỏi không phải 4, 6 thì mới cho chọn trình bày đáp án
if (in_array($row['type'], array(1,2,3,5))) {
    $array_answer_style = array(
        0 => $nv_Lang->getModule('answer_style_0'),
        1 => $nv_Lang->getModule('answer_style_1'),
        2 => $nv_Lang->getModule('answer_style_2')
    );
    foreach ($array_answer_style as $index => $value) {
        $sl = $index == $row['answer_style'] ? 'selected="selected"' : '';
        $xtpl->assign('ANSWER_STYLE', array(
            'index' => $index,
            'value' => $value,
            'selected' => $sl
        ));
        $xtpl->parse('main.answer_style.loop');
    }
    $xtpl->parse('main.answer_style');
    $xtpl->parse('main.answer_fixed');
}

// nếu câu hỏi trắc nghiệm thì mới hiện phần đáp án
if ($row['type'] === 3) {
    $xtpl->assign('from_question', $row['answer']['from_question'] ? $row['answer']['from_question'] : 0);
    $xtpl->assign('to_question', $row['answer']['to_question'] ? $row['answer']['to_question'] : 0);
    $xtpl->parse('main.limit_question');

} else if ($row['type'] === 6) {
    // nếu loại câu hỏi 6 (tự luận) thì hiện tùy chọn soạn thảo trả lời
    $array_answer_editor_type = array(
        0 => $nv_Lang->getModule('answer_editor_type_0'),
        1 => $nv_Lang->getModule('answer_editor_type_1')
    );
    foreach ($array_answer_editor_type as $index => $value) {
        $xtpl->assign('ANSWER_EDITOR_TYPE', array(
            'index' => $index,
            'value' => $value,
            'checked' => $index == $row['answer_editor_type'] ? 'checked="checked"' : ''
        ));
        $xtpl->parse('main.answer_editor_type.loop');
    }
    $xtpl->parse('main.answer_editor_type');
} else if ($row['type'] === 7) {
    // Nếu loại câu hỏi 7 (vấn đáp)
}
else {
    $xtpl->assign('ANSWER', nv_question_type_answer($row['id'], $row['type'], $row['answer'], $row['answer_editor'], 1));
    $xtpl->parse('main.answer_area');
}

if (!empty($row['id']) && empty($row['examid'])) {
    $xtpl->assign('link_clone_question', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=question-content&amp;clone_id=' . $row['id']);
    $xtpl->parse('main.clone_question');
}
$xtpl->parse('main');
$contents = $xtpl->text('main');

if ($row['ajax']) {
    nv_htmlOutput($contents);
}

$set_active_op = 'bank';

$array_mod_title[] = array(
    'title' => $page_title
);

if (!empty($row['typeid'])) {
    $parentid = $row['typeid'];
    while ($parentid > 0) {
        $array_cat_i = $array_test_bank[$parentid];
        $array_mod_title[] = [
            'id' => $parentid,
            'title' => $array_cat_i['title'],
            'link' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=bank' . ($array_cat_i['parentid'] > 0 ? '&amp;parentid=' . $array_cat_i['id'] : '')
        ];
        $parentid = $array_cat_i['parentid'];
    }
    $array_mod_title[] = array(
        'title' => $nv_Lang->getModule('bank'),
        'link' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=bank'
    );
}
if (!empty($row['examid'])) {
    $db->sqlreset()
    ->select('id, title')
    ->from(NV_PREFIXLANG . '_' . $module_data . '_exams')
    ->where('id = ' . $row['examid']);
    list($examid, $exam_title) = $db->query($db->sql())->fetch(3);
    if (!empty($examid)) {
        
        $array_mod_title[] = array(
            'title' => $exam_title,
            'link' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=exams-content&id=' . $examid
        );
        $array_mod_title[] = array(
            'title' => $nv_Lang->getModule('exams_question1') . ': ',
        );
    }
}

krsort($array_mod_title, SORT_NUMERIC);

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents, !$row['ajax']);
include NV_ROOTDIR . '/includes/footer.php';