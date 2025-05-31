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
if ($nv_Request->isset_request('bank_list', 'post, get')) {
    $dataReturn = array();
    $search = $nv_Request->get_title('search', 'post,get', '');
    $parentid = $nv_Request->get_int('parentid', 'post,get', 0);

    $db->sqlreset()
        ->select('id, title AS text')
        ->from($db_config['dbsystem'] . "." . NV_PREFIXLANG . '_' . $module_data . '_bank')
        ->order('title ASC')
        ->limit(10)
        ->where('parentid = ' . $parentid . ' AND title LIKE "%' . $search . '%" AND status = 1');
    $sth = $db->prepare($db->sql());
    $sth->execute();
    while ($row = $sth->fetch(2)) {
        $dataReturn[] = $row;
    }
    nv_jsonOutput($dataReturn);
    exit();
}

if ($nv_Request->isset_request('list_template_bank_type', 'post, get')) {
    echo list_template_bank_type();
    exit();
}

if ($nv_Request->isset_request('total_question_bank_type', 'post, get')) {
    $typeid = $nv_Request->get_int('typeid', 'post,get', 0);
    $dataReturn = array();
    if (!empty($typeid)) {
        if (!empty($typeid)) {
            $result = $db->query('SELECT COUNT(id) AS sum, bank_type FROM ' . $db_config['dbsystem'] . "." . NV_PREFIXLANG . '_' . $module_data . '_question WHERE typeid = ' . $typeid . ' GROUP BY bank_type');
            while ($row = $result->fetch(2)) {
                $dataReturn[] = $row;
            }
        }
    }
    nv_jsonOutput($dataReturn);
    exit();
}

if ($nv_Request->isset_request('load_bank_sub', 'post')) {
    $bankid = $nv_Request->get_int('bankid', 'post', 0);
    if (!isset($array_test_bank_common[$bankid])) {
        nv_jsonOutput(array(
            'error' => 1,
            'msg' => $nv_Lang->getModule('error_unknow')
        ));
    }
    $array_data = array();
    $subid = $array_test_bank_common[$bankid]['subid'];
    if (!empty($subid)) {
        $subid = explode(',', $subid);
        foreach ($subid as $id) {
            $array_data[] = array(
                'id' => $id,
                'title' => $array_test_bank_common[$id]['title']
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
    $p = $nv_Lang->getModule('exams_edit');
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
    $row['isbank'] = $nv_Request->get_int('isbank', 'post', 0);
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
            $stmt = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_exams_config (isbank, title, timer, num_question, ladder, config, random_question, random_answer, addtime, userid) VALUES (:isbank, :title, :timer, :num_question, :ladder, :config, :random_question, :random_answer, ' . NV_CURRENTTIME . ', ' . $admin_info['userid'] . ')');
        } else {
            $stmt = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_exams_config SET isbank = :isbank, title = :title, timer = :timer, num_question = :num_question, ladder = :ladder, config = :config, random_question = :random_question, random_answer = :random_answer WHERE id=' . $row['id']);
        }
        $config = nv_serialize($row['config']);
        $stmt->bindParam(':isbank', $row['isbank'], PDO::PARAM_STR);
        $stmt->bindParam(':title', $row['title'], PDO::PARAM_STR);
        $stmt->bindParam(':timer', $row['timer'], PDO::PARAM_INT);
        $stmt->bindParam(':num_question', $row['num_question'], PDO::PARAM_INT);
        $stmt->bindParam(':ladder', $row['ladder'], PDO::PARAM_INT);
        $stmt->bindParam(':config', $config, PDO::PARAM_STR);
        $stmt->bindParam(':random_question', $row['random_question'], PDO::PARAM_INT);
        $stmt->bindParam(':random_answer', $row['random_answer'], PDO::PARAM_INT);
        $exc = $stmt->execute();
        if ($exc) {
            nv_insert_logs(NV_LANG_DATA, $module_name, empty($row['id']) ? $nv_Lang->getModule('exams_config_bank_add') : $nv_Lang->getModule('exams_config_bank_edit') , $row['title'] , $admin_info['userid']);
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

$num_question = 0;
$num_question_column = array();
foreach ($array_bank_type as $index => $value) {
    $num_question_column[$index] = 0;
}
$config_list_bank = '';
if (!empty($row['config'])) {
    $row['config'] = nv_unserialize($row['config']);
    foreach ($row['config'] as $class_id => $cl) {
        $data = array();
        $data['class_id'] = $class_id;
        foreach ($cl as $cat_id => $cat) {
            $data['cat_id'] = $cat_id;
            $data['sum'] = $cat;
            $config_list_bank .= list_template_bank_type($data);
            foreach ($cat as $index=>$vl) {
                $num_question_column[$index] +=$vl;
                $num_question +=$vl;
            }
        }
    }
} else {
    $config_list_bank = list_template_bank_type();
}
$xtpl->assign('CONFIG_LIST_BANK', $config_list_bank);
$xtpl->parse('main.class');

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
