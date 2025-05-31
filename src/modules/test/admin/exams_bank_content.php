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


$id = $nv_Request->get_int('id', 'post,get', 0);
$page = $nv_Request->get_int('page', 'post,get', 1);
/**
 * Các đề thi ở trong ngân hàng đề thi là được đưa lên ở site con nên nó luôn luôn có id
 * Nếu không có thì chuyển về lại trang ngân hàng đề thi
 * Sửa đề thi ở ngân hàng đề thi chỉ được sửa ở web mẹ
 * Web con không được sửa, chỉ có thể tải về thành đề thi riêng thì mới có thể sửa được
 */
$row = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams_bank WHERE id=' . $id )->fetch();
if (empty($row['id'])) {
    Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=exams_bank');
    die();
}

$username_alias = change_alias($admin_info['username']);
$upload_user_path = nv_upload_user_path($username_alias);
$uploads_dir_user = $upload_user_path['uploads_dir_user'];

$nv_Lang->getModule('exams_add') = $nv_Lang->getModule('exams_edit');
$error = '';
if ($nv_Request->isset_request('submit', 'post')) {
    $row['title'] = $nv_Request->get_title('title', 'post', '');
    $row['alias'] = $nv_Request->get_title('alias', 'post', '', 1);
    $row['catid'] = $nv_Request->get_int('catid', 'post', 0);
    $row['hometext'] = $nv_Request->get_textarea('hometext', '', NV_ALLOWED_HTML_TAGS);
    $row['description'] = $nv_Request->get_editor('description', '', NV_ALLOWED_HTML_TAGS);
    
    if (empty($row['alias'])) {
        $row['alias'] = $row['title'];
    }
    $row['alias'] = change_alias($row['alias']);


    if (empty($row['title'])) {
        $error = $nv_Lang->getModule('error_required_exams_name');
    } 
    if (empty($row['catid'])) {
        $error = $nv_Lang->getModule('error_required_monhoc');
    } 

    if (empty($error)) {
        $stmt = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_exams_bank SET title = :title, alias = :alias, catid = :catid, hometext = :hometext, description = :description WHERE id=' . $row['id']);
        $stmt->bindParam(':title', $row['title'], PDO::PARAM_STR);
        $stmt->bindParam(':alias', $row['alias'], PDO::PARAM_STR);
        $stmt->bindParam(':catid', $row['catid'], PDO::PARAM_INT);
        $stmt->bindParam(':hometext', $row['hometext'], PDO::PARAM_STR);
        $stmt->bindParam(':description', $row['description'], PDO::PARAM_STR);
        if ($stmt->execute()) {
            nv_insert_logs(NV_LANG_DATA, $module_name, $nv_Lang->getModule('exams_edit') , $row['title'] . "(#". $row['id'] . ")" , $admin_info['userid']);
            $nv_Cache->delMod($module_name);
            Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=exams_bank&page=' . $page);
            die();
        }
    }
}

$row['type_checked'] =  !empty($row['type']) ? 'checked="checked"' : '';
$row['useguide_checked'] = !empty($row['useguide']) ? 'checked="checked"' : '';

if (defined('NV_EDITOR')) require_once NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php';
$row['description'] = htmlspecialchars(nv_editor_br2nl($row['description']));
if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
    $row['description'] = nv_aleditor('description', '100%', '200px', $row['description'], 'Basic', $uploads_dir_user, !empty($currentpath) ? $currentpath : '');
} else {
    $row['description'] = '<textarea style="width:100%;height:200px" name="description">' . $row['description'] . '</textarea>';
}
$contents = '';

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('TEMPLATE', $global_config['module_theme']);
$xtpl->assign('MODULE_UPLOAD', $module_upload);
$xtpl->assign('OP', $op);
$xtpl->assign('ROW', $row);
$xtpl->assign('PACKAGE_NOTIICE', nv_package_notice());

if (!empty($error)) {
    $xtpl->assign('ERROR', $error);
    $xtpl->parse('main.error');
}
if (!empty($row['id'])) {
    $xtpl->assign('DISABLED', 'disabled="disabled"');
} else {
    $xtpl->parse('main.auto_get_alias');
}

foreach($array_exams_bank_cats as $bank_cats){
    $xtpl->assign('CAT', $bank_cats);
    $xtpl->assign('selected', $bank_cats['id'] == $row['catid'] ? 'selected="selected"' : '');
    $xtpl->parse('main.bank_cats');    
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$set_active_op = 'exams';
$page_title = $nv_Lang->getModule('exams_add');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
