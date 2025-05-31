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
        'title' => $nv_Lang->getModule('importexcel')
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

if (!class_exists('PhpOffice\PhpSpreadsheet\IOFactory')) {
    trigger_error('No PhpSpreadsheet, install: composer require phpoffice/phpspreadsheet', 256);
}

$form_action = NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $op;

// Tải về file mẫu
if ($nv_Request->isset_request('downfile', 'post,get')) {
    $filename = NV_ROOTDIR . '/modules/' . $module_file . '/template/importquestion.xlsx';
    $directory = NV_ROOTDIR . '/modules/' . $module_file;
    $file_basename = basename($filename);

    $download = new NukeViet\Files\Download($filename, $directory, $file_basename);
    $download->download_file();
    exit();
}

if ($nv_Request->isset_request('submit', 'post')) {
    $examid = $nv_Request->get_int('examid', 'post,get', 0);
    $typeid = $nv_Request->get_int('typeid', 'post,get', 0);
    $update_question = $nv_Request->get_int('update_question', 'post', 0);

    try{
        if (isset($_FILES['import_file']) and is_uploaded_file($_FILES['import_file']['tmp_name'])) {
            $upload = new NukeViet\Files\Upload(array(
                'documents'
            ), $global_config['forbid_extensions'], $global_config['forbid_mimes'], $global_config['nv_max_size'], NV_MAX_WIDTH, NV_MAX_HEIGHT);
            $upload_info = $upload->save_file($_FILES['import_file'], NV_ROOTDIR . '/' . NV_TEMP_DIR, false);
    
            @unlink($_FILES['import_file']['tmp_name']);
            if (empty($upload_info['error'])) {
                if ($sys_info['allowed_set_time_limit']) {
                    set_time_limit(0);
                }
                if ($sys_info['ini_set_support']) {
                    $memoryLimitMB = (integer) ini_get('memory_limit');
                    if ($memoryLimitMB < 1024) {
                        ini_set('memory_limit', '1024M');
                    }
                }
    
                $objPHPExcel = \PhpOffice\PhpSpreadsheet\IOFactory::load($upload_info['name']);
    
                $objWorksheet = $objPHPExcel->getActiveSheet();
                $highestRow = $objWorksheet->getHighestRow();
            
                $highestColumn = strtoupper($objWorksheet->getHighestColumn());
                $array_data_read = [];
                $weight = 1;
                $number = 0;
				
				// xóa câu hỏi cũ trước khi import
                if ($examid > 0) {
                    $count = $db->exec('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_question WHERE examid=' . $examid);
                    if ($count) {
                        $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams_question WHERE examsid=' . $examid);
                    }
                }
				
                for ($row = 6; $row <= $highestRow; ++ $row) {
    
                    if ($objWorksheet->getCellByColumnAndRow(2, $row)->getCalculatedValue() != '') {
                        $array_data_read[$row]['id'] = trim($objWorksheet->getCellByColumnAndRow(1, $row)->getCalculatedValue());
                        $array_data_read[$row]['quession'] = trim($objWorksheet->getCellByColumnAndRow(2, $row)->getCalculatedValue());
                        $array_data_read[$row]['trueanwser'] = trim($objWorksheet->getCellByColumnAndRow(3, $row)->getCalculatedValue());
                        $array_data_read[$row]['bank_type'] = trim($objWorksheet->getCellByColumnAndRow(4, $row)->getCalculatedValue());
                        $array_data_read[$row]['useguide'] = trim($objWorksheet->getCellByColumnAndRow(5, $row)->getCalculatedValue());
                        
                        $start_answer_col = 6;
                        $offset_col = 1;
                        while (1) {
                            $char = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($offset_col); 
                            $answer_value = trim($objWorksheet->getCellByColumnAndRow($start_answer_col, $row)->getCalculatedValue());
                            if (empty($answer_value)) {
                                break;
                            }
                            $array_data_read[$row]['answers'][$char] = $answer_value;
    
                            $start_answer_col++;
                            $offset_col++;
                            if ($start_answer_col > 100) {
                                break;
                            }
                        }
                    }
                }
                if (!empty($array_data_read)) {
                    // Duyệt các câu hỏi đã đọc và lưu CSDL
                    foreach ($array_data_read as $k => $v) {
                        // Loại bỏ các đáp án trống, reset key về 0
                        $v['answers'] = array_values(array_filter($v['answers']));
                        
                        if (empty($v['quession'])) {
                            $error = $nv_Lang->getModule('quession_error_null');
                        } else {
                            $type_answer = 0; // Câu hỏi một đáp án đúng mặc định
                            $trueanwser = array_filter(array_unique(array_map('intval', explode(',', $v['trueanwser']))));
                            $all_anwser = [];
                            $anwsers_serialize = [];
                            
                            foreach ($v['answers'] as $__kk => $__vv) {                           
                                $all_anwser[] = $__kk + 1;
                                $anwsers_serialize[$__kk + 1]['id'] = $__kk + 1;
                                $anwsers_serialize[$__kk + 1]['content'] = $__vv;
                                
                                foreach ($trueanwser as $value_true){
                                    if($anwsers_serialize[$__kk + 1]['id'] == $value_true){
                                        $anwsers_serialize[$__kk + 1]['is_true'] = 1;
                                        break;
                                    }else{
                                        $anwsers_serialize[$__kk + 1]['is_true'] = 0;
                                    }
                                }
                            }			                       
                            $max_answerid = count($anwsers_serialize);
                            if (sizeof($trueanwser) > 1) {
                                $type_answer = 1; // Câu hỏi nhiều đáp án đúng
                            }
                            // Replace <br /> description, datas                       
                            $anwsers_serialize = serialize($anwsers_serialize);
                            $v['quession'] = nv_editor_nl2br($v['quession']);
                            if (empty($update_question)) {
                                // Insert into database
                                $sql = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_question (
                                    `id`, `examid`, `typeid`, `bank_type`, `title`, `useguide`, `type`, `answer`, `note`, `weight`, 
                                    `answer_style`, `count_true`, `max_answerid`, `generaltext`, `answer_editor`, `answer_editor_type`, 
                                    `answer_fixed`, `point`, `addtime`, `edittime`, `userid`
                                ) VALUES (
                                    NULL,
                                    " . $examid . ",
                                    " . $typeid . ",
                                    " . $v['bank_type'] . ",
                                    " . $db->quote($v['quession']) . ",
                                    " . $db->quote($v['useguide']) . ",
                                    1,
                                    " . $db->quote($anwsers_serialize) . ",
                                    '',
                                    " . $weight . ",
                                    0,
                                    " . sizeof($trueanwser) . ",
                                    4,
                                    '', 0, 0, 0, 0,
                                    " . NV_CURRENTTIME . ",
                                    " . NV_CURRENTTIME . ",
                                    " . $admin_info['admin_id'] . "
                                )";
                                $new_id = $db->insert_id($sql, 'id');
                                if ($new_id) {  
                                    $number++;
                                    $array_questionid[] = $new_id;                                                   
                                    $nv_Cache->delMod($module_name);                         
                                    nv_insert_logs(NV_LANG_DATA, $module_name, $nv_Lang->getModule('questions'), $v['quession'], $admin_info['userid']);
                                    $error = $nv_Lang->getModule('file_import_ok');
                                } else {
                                    $error = $nv_Lang->getModule('error_save');
                                }
                            }
                            else {
                                if (empty($v['id'])) continue;
                                $_sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_question SET bank_type = :bank_type, title = :title, useguide = :useguide, type = :type, answer = :answer, count_true = :count_true, max_answerid = :max_answerid, edittime = ' . NV_CURRENTTIME . ' WHERE id = ' . $v['id'];
                                $stmt = $db->prepare($_sql);
                                $stmt->bindValue(':bank_type', $v['bank_type'], PDO::PARAM_INT);
                                $stmt->bindValue(':title', $v['quession'], PDO::PARAM_STR);
                                $stmt->bindValue(':useguide', $v['useguide'], PDO::PARAM_STR);
                                $stmt->bindValue(':type', 1, PDO::PARAM_INT);
                                $stmt->bindValue(':answer',  $anwsers_serialize, PDO::PARAM_STR);
                                $stmt->bindValue(':count_true', sizeof($trueanwser), PDO::PARAM_INT);
                                $stmt->bindValue(':max_answerid', $max_answerid, PDO::PARAM_INT);
                                $stmt->execute();
                                nv_insert_logs(NV_LANG_DATA, $module_name, $nv_Lang->getModule('update_question'), $v['quession'], $admin_info['userid']);
                            }

                            
                            
                        }
                        $weight ++;
                    }
                }
            } else {
                $error = $upload_info['error'];
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
                $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_exams SET num_question=' . ($number) . ', count_question=' . $number . ', question_list=' . $db->quote(implode(',', $array_questionid)) . ' WHERE id=' . $examid);
                nv_exam_question_status($examid);
            }
    
            if ($examid > 0) {                
                Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=question&examid=' . $examid);
                die();
            } else {
                Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=search_questions&typeid=' . $typeid);
                die();
            }

        }
    }catch (PDOException $e) {
        trigger_error($e->getMessage());
    }
}

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
$xtpl->assign('FORM_ACTION', $form_action);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('EXAMID', $examid);
$xtpl->assign('TYPEID', $typeid);
$xtpl->assign('DOWNLOAD', NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&downfile=1");

// Parse error
if (!empty($error)) {
    $xtpl->assign('ERROR', $error);
    $xtpl->parse('main.error');
}
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