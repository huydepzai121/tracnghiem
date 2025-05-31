<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2017 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Tue, 11 Apr 2017 08:36:28 GMT
 */
if (!defined('NV_IS_FILE_ADMIN')) die('Stop!!!');

global $nv_Lang;

if ($nv_Request->isset_request('load_bank_sub', 'post')) {
    $bankid = $nv_Request->get_int('bankid', 'post', 0);
    if (!isset($array_test_bank[$bankid])) {
        nv_jsonOutput(array(
            'error' => 1,
            'msg' => $nv_Lang->getModule('error_unknow')
        ));
    }
    $array_data = array();
    $subid = $array_test_bank[$bankid]['subid'];
    if (!empty($subid)) {
        $subid = explode(',', $subid);
        foreach ($subid as $id) {
            $array_data[] = array(
                'id' => $id,
                'title' => $array_test_bank[$id]['title']
            );
        }
    }
    nv_jsonOutput(array(
        'error' => 0,
        'data' => $array_data
    ));
}

$row = array();
$error = array();
$row['id'] = $nv_Request->get_int('id', 'post,get', 0);

if ($row['id'] > 0) {
    $page_title = $nv_Lang->getModule('exams_edit');
    $row = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams_config WHERE id=' . $row['id'])->fetch();
    if (empty($row)) {
        Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=exams-config');
        die();
    }
} else {
    $page_title = $nv_Lang->getModule('exams_add');
    $row['id'] = 0;
    $row['title'] = '';
    $row['timer'] = -1;
    $row['num_question'] = '';
    $row['ladder'] = 0;
    $row['config'] = '';
    $row['random_question'] = 1;
    $row['random_answer'] = 1;
}

$row['redirect'] = $nv_Request->get_title('redirect', 'get', '');

if ($nv_Request->isset_request('submit', 'post')) {
    $row['title'] = $nv_Request->get_title('title', 'post', '');
    $row['timer'] = $nv_Request->get_int('timer', 'post', 0);
    $row['ladder'] = $nv_Request->get_int('ladder', 'post', 0);
    $row['random_question'] = $nv_Request->get_int('random_question', 'post', 0);
    $row['random_answer'] = $nv_Request->get_int('random_answer', 'post', 0);
    $row['num_question'] = 0;

    $row['config'] = array();
    $config = $nv_Request->get_array('config', 'post');

    if (empty($row['title'])) {
        die(json_encode(array(
            'error' => 1,
            'input' => 'title',
            'msg' => $nv_Lang->getModule('error_required_exams_config_title')
        )));
    } elseif (empty($row['timer'])) {
        die(json_encode(array(
            'error' => 1,
            'input' => 'timer',
            'msg' => $nv_Lang->getModule('error_required_timer')
        )));
    } elseif (empty($config)) {
        die(json_encode(array(
            'error' => 1,
            'input' => 'config',
            'msg' => $nv_Lang->getModule('error_required_exams_config')
        )));
    }

    // xử lý số liệu cấu hình
    $total = 0;
    foreach ($config as $classid => $value) {
        foreach ($value as $catid => $value) {
            $m = array_map('intval', $value);
            $row['config'][$classid][$catid] = $m;
            $total += array_sum($m);
        }
    }
    $row['num_question'] = $total;

    if (empty($row['num_question'])) {
        die(json_encode(array(
            'error' => 1,
            'msg' => $nv_Lang->getModule('error_required_num_question')
        )));
    }
    unset($config);

    try {
        if (empty($row['id'])) {
            $stmt = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_exams_config (title, timer, num_question, ladder, config, random_question, random_answer, addtime, userid) VALUES (:title, :timer, :num_question, :ladder, :config, :random_question, :random_answer, ' . NV_CURRENTTIME . ', ' . $admin_info['userid'] . ')');
        } else {
            $stmt = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_exams_config SET title = :title, timer = :timer, num_question = :num_question, ladder = :ladder, config = :config, random_question = :random_question, random_answer = :random_answer WHERE id=' . $row['id']);
        }
        $config = nv_serialize($row['config']);
        $stmt->bindParam(':title', $row['title'], PDO::PARAM_STR);
        $stmt->bindParam(':timer', $row['timer'], PDO::PARAM_INT);
        $stmt->bindParam(':num_question', $row['num_question'], PDO::PARAM_INT);
        $stmt->bindParam(':ladder', $row['ladder'], PDO::PARAM_INT);
        $stmt->bindParam(':config', $config, PDO::PARAM_STR);
        $stmt->bindParam(':random_question', $row['random_question'], PDO::PARAM_INT);
        $stmt->bindParam(':random_answer', $row['random_answer'], PDO::PARAM_INT);
        $exc = $stmt->execute();
        if ($exc) {
            nv_insert_logs(NV_LANG_DATA, $module_name, empty($row['id']) ? $nv_Lang->getModule('exams_config_content_add') : $nv_Lang->getModule('exams_config_content_edit') , $row['title'] , $admin_info['userid']);
            if (!empty($row['id'])) {
                $question_list = '';
                $row['config'] = $config;
                $row['question_list'] = nv_test_random_question($row, 1);
                if (empty($row['question_list'])) {
                    nv_jsonOutput(array(
                        'error' => 1,
                        'msg' => $nv_Lang->getModule('error_invaild_question_list')
                    ));
                }
                $question_list = implode(',', $row['question_list']);
//                 var_dump($question_list); die;

                $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_exams SET num_question = ' . $row['num_question'] . ', count_question = ' . $row['num_question'] . ', question_list = "' . $question_list . '" WHERE exams_config = ' . $row['id']);
            }
            $nv_Cache->delMod($module_name);
            die(json_encode(array(
                'error' => 0,
                'redirect' => !empty($row['redirect']) ? nv_redirect_decrypt($row['redirect']) : ''
            )));
        }
    } catch (PDOException $e) {
        trigger_error($e->getMessage());
        die(json_encode(array(
            'error' => 1,
            'msg' => $nv_Lang->getModule('error_unknow')
        )));
    }
}

$row['ck_random_question'] = $row['random_question'] ? 'checked="checked"' : '';
$row['ck_random_answer'] = $row['random_answer'] ? 'checked="checked"' : '';
$row['timer'] = $row['timer'] >= 0 ? $row['timer'] : '';

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('MODULE_UPLOAD', $module_upload);
$xtpl->assign('OP', $op);
$xtpl->assign('ROW', $row);
$xtpl->assign('PACKAGE_NOTIICE', nv_package_notice());

if (!empty($row['config'])) {
    $row['config'] = nv_unserialize($row['config']);
} else {
    $row['config'] = array();
    if (!empty($array_test_bank)) {
        foreach ($array_test_bank as $classid => $value) {
            if (!empty($value['subid'])) {
                $value['subid'] = explode(',', $value['subid']);
                foreach ($value['subid'] as $catid) {
                    foreach ($array_bank_type as $typeid => $bank_type) {
                        $row['config'][$classid][$catid][$typeid] = '';
                    }
                }
            }
        }
    }
}

$num_question = 0;
$num_question_column = array();
foreach ($array_bank_type as $index => $value) {
    $num_question_column[$index] = 0;
}

foreach ($array_test_bank as $classid => $value) {
    if (!empty($value['numsub'])) {
        if ($value['lev'] == 0) {
            $subid = $value['subid'];
            // Kiểm tra tồn tại chuyên đề và đang kích hoạt
            $sub0_numsub = $db->query('SELECT COUNT(*) as numsub FROM ' . NV_PREFIXLANG . '_' . $module_data . '_bank WHERE id IN (' . $subid . ') AND status=1')->fetch();
            if ($sub0_numsub['numsub']) {
                // Kiểm tra tồn tại câu hỏi
                $rows = $db->query('SELECT COUNT(*) as numsub FROM ' . NV_PREFIXLANG . '_' . $module_data . '_question WHERE typeid IN (' . $subid . ') AND examid=0')->fetch();
                if ($rows['numsub']) {
                    $xtpl->assign('CLASS', $value);
                    if (!empty($value['subid'])) {
                        $value['subid'] = explode(',', $value['subid']);
                        $dem = 0;
                        foreach ($value['subid'] as $catid) {
                            $sub_0 = $db->query('SELECT COUNT(*) as numsub FROM ' . NV_PREFIXLANG . '_' . $module_data . '_question WHERE typeid=' . $catid . ' AND examid=0')->fetch();
                            if ($sub_0['numsub']) {
                                if (isset($array_test_bank[$catid])) {
                                    $dem++;
                                    $xtpl->assign('CAT', $array_test_bank[$catid]);
                                    $sum = 0;
                                    if (isset($row['config'][$classid][$catid])) {
                                        $sum = array_sum($row['config'][$classid][$catid]);
                                        $num_question += $sum;
                                    }
                                    $total = 0;
                                    foreach ($array_bank_type as $bank_type) {
                                        $count = $db->query('SELECT COUNT(*) count FROM ' . NV_PREFIXLANG . '_' . $module_data . '_question WHERE typeid=' . $array_test_bank[$catid]['id'] . ' AND bank_type=' . $bank_type['id'])->fetch();
                                        if ($count['count']) {
                                            if (isset($row['config'][$classid][$catid])) {
                                                $value = $row['config'][$classid][$catid][$bank_type['id']];
                                                if (!empty($value)) {
                                                    $num_question_column[$bank_type['id']] += $value;
                                                    $total += $value;
                                                    $bank_type['value'] = $value;
                                                }
                                            }
                                            $xtpl->assign('COUNT_MAX', $count['count']);
                                            $xtpl->assign('BANK_TYPE', $bank_type);
                                            $xtpl->parse('main.class.sub_0.bank_type.had_ques');
                                        } else {
                                            $xtpl->parse('main.class.sub_0.bank_type.no_ques');
                                        }
                                        $xtpl->parse('main.class.sub_0.bank_type');
                                    }
                                    $xtpl->assign('TOTAL', $total);
                                    $xtpl->parse('main.class.sub_0');
                                }
                            }
                        }
                    }
                    $xtpl->assign('ROWSPAN', $dem + 1);
                    $xtpl->parse('main.class');
                }
            }
        }
    }
}

$xtpl->assign('NUM_QUESTION', $num_question);

foreach ($array_bank_type as $index => $bank_type) {
    $bank_type['sum'] = $num_question_column[$index];
    $xtpl->assign('BANK_TYPE', $bank_type);
    $xtpl->parse('main.bank_type_header');
    $xtpl->parse('main.bank_type_foter');
}

if (!empty($error)) {
    $xtpl->assign('ERROR', implode('<br />', $error));
    $xtpl->parse('main.error');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$set_active_op = 'exams';
$page_title = $nv_Lang->getModule('exams_config_add');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';