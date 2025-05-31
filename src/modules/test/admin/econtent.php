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

if (defined('NV_EDITOR')) {
    require_once NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php';
}

if ($nv_Request->isset_request('submit', 'post')) {
    $row['helptest'] = $nv_Request->get_editor('econtent_helptest', '', NV_ALLOWED_HTML_TAGS);
    $stmt = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_econtent SET econtent = :econtent WHERE action=:action');
    foreach ($row as $config_name => $config_value) {
        $stmt->bindParam(':econtent', $config_value, PDO::PARAM_STR);
        $stmt->bindParam(':action', $config_name, PDO::PARAM_STR);
        $exc = $stmt->execute();
    }
    
    $nv_Cache->delMod($module_name);
    Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    die();
} else {
    $result = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_econtent');
    while ($_row = $result->fetch()) {
        $_row['econtent'] = htmlspecialchars(nv_editor_br2nl($_row['econtent']));
        if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
            $_row['econtent'] = nv_aleditor('econtent_' . $_row['action'], '100%', '300px', $_row['econtent']);
        } else {
            $_row['econtent'] = '<textarea style="width:100%;height:300px" name="econtent_' . $_row['action'] . '">' . $_row['econtent'] . '</textarea>';
        }
        $row[] = $_row;
    }
}

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);

if (!empty($row)) {
    foreach ($row as $value) {
        $value['title'] = $lang_module['econtent_' . $value['action']];
        $xtpl->assign('ROW', $value);
        $xtpl->parse('main.title');
        $xtpl->parse('main.content');
    }
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $nv_Lang->getModule('econtent');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';