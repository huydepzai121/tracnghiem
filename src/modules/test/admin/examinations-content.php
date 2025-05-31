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

if ($nv_Request->isset_request('get_alias_title', 'post')) {
    $alias = $nv_Request->get_title('get_alias_title', 'post', '');
    $alias = change_alias($alias);
    if ($array_config['tags_alias_lower']) {
        $alias = strtolower($alias);
    }
    die($alias);
}

$row = array(
    'id' => 0,
    'title' => '',
    'alias' => '',
    'image' => '',
    'begintime' => '',
    'endtime' => '',
    'description' => ''
);
$id = $nv_Request->get_int('id', 'post,get',0);
if (!empty($id)) {
    $db->sqlreset()
    ->select('id, title, alias, image, begintime, endtime, description')
    ->from( NV_PREFIXLANG . '_' . $module_data . '_examinations')
    ->where("id = $id");
    $_row = $db->query($db->sql())->fetch(2);
    if (!empty($_row)){
        $_row['begintime'] = date('d/m/Y', $_row['begintime']);
        $_row['endtime'] = date('d/m/Y', $_row['endtime']);
        $row = $_row;
    }
}
$error = '';


if ($nv_Request->isset_request('submit', 'post')) {
    try {
        $row['title'] = $nv_Request->get_title('title', 'post', '');
        $row['alias'] = $nv_Request->get_title('alias', 'post', '');
        $row['image'] = $nv_Request->get_title('image', 'post', '');
        $row['begintime'] = $nv_Request->get_title('begintime', 'post', '');
        $row['endtime'] = $nv_Request->get_title('endtime', 'post', '');
        $row['description'] = $nv_Request->get_title('description', 'post', '');
        if (empty($row['alias'])) {
            $row['alias'] = $row['title'];
        }
        $row['alias'] = change_alias($row['alias']);
        if (empty($row['title'])) {
            $error=$nv_Lang->getModule('error_required_title');
        }
        elseif (empty($row['begintime'])) {
            $error=$nv_Lang->getModule('error_required_examinations_begintime');
        }
        elseif (empty($row['endtime'])) {
            $error=$nv_Lang->getModule('error_required_examinations_endtime');
        }else {
            $row['begintime'] = strtotime(date_format(date_create_from_format("j/n/Y", $row['begintime']), "Y-m-d"));
            $row['endtime'] = strtotime(date_format(date_create_from_format("j/n/Y", $row['endtime']), "Y-m-d"));
            if (empty($row['id'])) {
                $_sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_examinations (title, alias, image, begintime, endtime, description) VALUES (:title, :alias, :image, :begintime, :endtime, :description)';

                $data_insert = array();
                $data_insert['title'] = $row['title'];
                $data_insert['alias'] = $row['alias'];
                $data_insert['image'] = $row['image'];
                $data_insert['begintime'] = $row['begintime'];
                $data_insert['endtime'] = $row['endtime'];
                $data_insert['description'] = $row['description'];
                $new_id = $db->insert_id($_sql, 'id', $data_insert);
                nv_insert_logs(NV_LANG_DATA, $module_name, $nv_Lang->getModule('examinations_add') , $row['title'] . "(#". $new_id . ")" , $admin_info['userid']);
            }
            else {
                list($code) = $db->query('SELECT code FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exam_subject WHERE exam_id = ' . $id . ' AND (code IS NOT NULL  OR code != "")  LIMIT 1')->fetch(3);
                if (!empty($code)) {
                    Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=examinations-content&id=' . $row['id']. '&not_del_examinations=' . $row['id']);
                    die();
                }
                $stmt = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_examinations SET title = :title, alias = :alias, image = :image, begintime = :begintime, endtime = :endtime, description = :description WHERE id=' . $row['id']);
                $stmt->bindParam(':title', $row['title'], PDO::PARAM_STR);
                $stmt->bindParam(':alias', $row['alias'], PDO::PARAM_STR);
                $stmt->bindParam(':image', $row['image'], PDO::PARAM_STR);
                $stmt->bindParam(':begintime', $row['begintime'], PDO::PARAM_INT);
                $stmt->bindParam(':endtime', $row['endtime'], PDO::PARAM_INT);
                $stmt->bindParam(':description', $row['description'], PDO::PARAM_STR);
                if ($stmt->execute()) {
                    $new_id = $row['id'];
                    nv_insert_logs(NV_LANG_DATA, $module_name, $nv_Lang->getModule('examinations_edit') , $row['title'] . "(#". $new_id . ")" , $admin_info['userid']);
                }
            }
            if ($new_id > 0) {
                $nv_Cache->delMod($module_name);
                Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=examinations' );
                die();
            }
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }

}
$not_del_examinations = $nv_Request->get_int('not_del_examinations', 'post,get', 0);
$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
$xtpl->assign('NV_ASSETS_DIR', NV_ASSETS_DIR);
$xtpl->assign('NV_LANG_INTERFACE', NV_LANG_INTERFACE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('MODULE_UPLOAD', $module_upload);
$xtpl->assign('OP', $op);
if (!empty($error)) {
    $xtpl->assign('ERROR', $error);
    $xtpl->parse('main.error');
}
if (!empty($not_del_examinations)) {
    $xtpl->parse('main.examinations_title');
}
$xtpl->assign('ROW', $row);
$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $nv_Lang->getModule('examinations_add');
include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';