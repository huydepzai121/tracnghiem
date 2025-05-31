<?php

/**
 * @Project NUKEVIET 4.x
 * @Author hongoctrien (contact@mynukeviet.net)
 * @Copyright (C) 2016 hongoctrien. All rights reserved
 * @Createdate Wed, 27 Apr 2016 07:24:36 GMT
 */
if (!defined('NV_IS_FILE_ADMIN')) die('Stop!!!');

global $nv_Lang;

function get_catid_from_title($title) {
    global $array_cat;
    $catid_return = 0;
    foreach ($array_cat as $catid => $cat) {
        $keywords = $cat['keywords'];
        foreach ($keywords as $key) {
            if (mb_strripos($title, $key, 0,"utf-8") !== false) {
                $catid_return = $catid;
                break;
            }
        }
        if ($catid_return > 0) break;
    }
    return $catid_return;
}
// Lấy danh sách các chủ đề của ngân hàng đề thi và từ khóa của nó
$array_cat = array();
$db->sqlreset()
->select('id, title, keywords')
->from($db_config['dbsystem'] . "." . NV_PREFIXLANG . '_test_exams_bank_cats')
->where('parentid > 0');


$result = $db->query($db->sql());
while ($row = $result->fetch(2)) {
    $row['keywords'] = explode(',', $row['keywords']);
    $array_cat[$row['id']] = $row;
}
if ($nv_Request->isset_request('update_bank_cat', 'post,get')) {
    $id_exam_offset = 0;
    $id_exam_file = NV_ROOTDIR . '/modules/test/id_exam.log';
    if (is_file($id_exam_file)) {
        $id_exam_offset = file_get_contents($id_exam_file);
        $id_exam_offset = intval($id_exam_offset);
        $id_exam_offset = ($id_exam_offset > 0) ? $id_exam_offset : 0;
    }
    
    $num_row = 0;
    $kt = true;
    while ($kt) {
        $db->sqlreset()
        ->select('COUNT(*)')
        ->from($db_config['dbsystem'] . '.' . NV_PREFIXLANG . '_' . $module_data . '_exams_bank')
        ->where('catid = 0 AND id >' . $id_exam_offset)
        ->limit(1000);
        $num_row = $db->query($db->sql())->fetchColumn();
        $kt = ($num_row == 0) && ($id_exam_offset > 0);
        if ($num_row == 0) {
            $id_exam_offset = 0;
        }
    }
    
    if (($num_row == 0) && ($id_exam_offset == 0)) {
        nv_htmlOutput('<h2>Tất cả đề thi đã có chủ đề thích hợp</h2>');
        exit();
    }
    
    $db->select('id, title');
    $result = $db->query($db->sql());

    $data_result = array();
    $id_exam_f = 0;
    while (list($id, $title) = $result->fetch(3)) {
        $id_exam_offset = $id;
        if ($id_exam_f == 0) {
            $id_exam_f = $id;
        }
        $catid = get_catid_from_title($title);
        $data_result[] = array(
            'title' => $title,
            'catid' => $catid,
            'cat' => !empty($array_cat[$catid]) ? $array_cat[$catid]['title'] : $nv_Lang->getModule('had_not_identified')
        );
        if (!empty($catid)) {
            $db->query('UPDATE ' . $db_config['dbsystem'] . '.' . NV_PREFIXLANG . '_' . $module_data . '_exams_bank SET catid = ' . $catid . ' WHERE id = ' . $id);
        }
    }

    file_put_contents($id_exam_file , $id_exam_offset, LOCK_EX);
    uasort($data_result,function($a, $b) {
        if ($a['catid'] == $b['catid']) return 0;
        return ($a['catid'] < $b['catid']) ? 1 : -1;
    });
    $xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('caption',  "Cập nhật từ đề thi có id: " . $id_exam_f .  " đến đề thi có id: " . $id_exam_offset);
    $xtpl->assign('OP', $op);
    $tt = 0;
    foreach ($data_result as $row) {
        $row['tt'] = ++$tt;
        $xtpl->assign('ROW', $row);
        $xtpl->parse('result_update.loop');
    }
    $xtpl->parse('result_update');
    $contents = $xtpl->text('result_update');
    nv_htmlOutput($contents);
    exit();
}

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $nv_Lang->getModule('update_bank_cat');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
