<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2023 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_SITEINFO')) {
    exit('Stop!!!');
}

$page_title = $nv_Lang->getGlobal('mod_siteinfo');

$template = get_tpl_dir([$global_config['module_theme'], $global_config['admin_theme']], 'admin_default', '/modules/' . $module_file . '/main.tpl');
$tpl = new \NukeViet\Template\NVSmarty();
$tpl->setTemplateDir(NV_ROOTDIR . '/themes/' . $template . '/modules/' . $module_file);
$tpl->assign('LANG', $nv_Lang);

// Gói cập nhật
$package_update = 0;
if (defined('NV_IS_GODADMIN') and file_exists(NV_ROOTDIR . '/install/update_data.php')) {
    $package_update = 1;
}
$tpl->assign('PACKAGE_UPDATE', $package_update);

// Cấu hình giao diện
$sql = "SELECT config_name, config_value FROM " . NV_AUTHORS_GLOBALTABLE . "_vars WHERE admin_id=" . $admin_info['admin_id'] . "
AND theme=" . $db->quote($admin_info['admin_theme']) . " AND (lang='all' OR lang=" . $db->quote(NV_LANG_DATA) . ")";
$theme_config = $db->query($sql)->fetchAll(PDO::FETCH_KEY_PAIR);
$theme_config['widgets'] = empty($theme_config['widgets']) ? [] : json_decode($theme_config['widgets'], true);
if (!is_array($theme_config['widgets'])) {
    $theme_config['widgets'] = [];
}
if (empty($theme_config['widgets'])) {
    // Thứ tự mặc định của các widget trong hệ thống
    $theme_config['widgets'] = [
        'usr_statistics_hour',
        'adm_siteinfo_statistics',
        'adm_siteinfo_pendings',
    ];
}

// Lấy các widgets
$html_widgets  = $array_widgets = [];
$nv_widget_trigger = 0;
$mbackup = $module_name;
$mibackup = $module_info;
$mfbackup = $module_file;
$mubackup = $module_upload;
$mdbackup = $module_data;
$get_widget = 1;

foreach ($admin_mods as $module_name => $module_info) {
    $module_file = $module_upload = $module_data = $module_name;

    $widgets = nv_scandir(NV_ROOTDIR . '/' . NV_ADMINDIR . '/' . $module_name . '/widgets', '/^(.*)\.php$/i');
    if (empty($widgets)) {
        continue;
    }

    foreach ($widgets as $widget) {
        $widget_info = [];
        $content = '';
        $nv_Lang->loadModule($module_name, true, true);

        require NV_ROOTDIR . '/' . NV_ADMINDIR . '/' . $module_name . '/widgets/' . $widget;

        if (empty($widget_info['id']) or !preg_match('/^[a-zA-Z0-9\_]+$/i', $widget_info['id']) or !isset($widget_info['func']) or !is_callable($widget_info['func'])) {
            continue;
        }

        $widget_id = 'adm_' . $module_name . '_' . $widget_info['id'];
        $array_widgets[$widget_id] = [
            'admin' => 1,
            'module_name' => $module_name,
            'file_name' => $widget,
            'data' => $widget_info
        ];
        unset($widget_info);

        if ($get_widget and in_array($widget_id, $theme_config['widgets'])) {
            $html_widgets[$widget_id] = $array_widgets[$widget_id]['data']['func']();
        }
    }
}
foreach ($site_mods as $module_name => $module_info) {
    $module_file = $module_info['module_file'];
    $module_upload = $module_info['module_upload'];
    $module_data = $module_info['module_data'];

    $widgets = nv_scandir(NV_ROOTDIR . '/modules/' . $module_name . '/widgets', '/^(.*)\.php$/i');
    if (empty($widgets)) {
        continue;
    }

    foreach ($widgets as $widget) {
        $widget_info = [];
        $nv_Lang->loadModule($module_name, false, true);

        require NV_ROOTDIR . '/modules/' . $module_name . '/widgets/' . $widget;

        if (empty($widget_info['id']) or !preg_match('/^[a-zA-Z0-9\_]+$/i', $widget_info['id']) or !isset($widget_info['func']) or !is_callable($widget_info['func'])) {
            continue;
        }

        $widget_id = 'usr_' . $module_name . '_' . $widget_info['id'];
        $array_widgets[$widget_id] = [
            'admin' => 0,
            'module_name' => $module_name,
            'file_name' => $widget,
            'data' => $widget_info
        ];
        unset($widget_info);

        if ($get_widget and in_array($widget_id, $theme_config['widgets'])) {
            $html_widgets[$widget_id] = $array_widgets[$widget_id]['data']['func']();
        }
    }
}

$module_name = $mbackup;
$module_info = $mibackup;
$module_file = $mfbackup;
$module_upload = $mubackup;
$module_data = $mdbackup;
unset($mbackup, $mibackup, $mfbackup, $mubackup, $mdbackup);
$nv_Lang->changeLang();

$tpl->assign('TCONFIG', $theme_config);
$tpl->assign('WIDGETS', $html_widgets);

$contents = $tpl->fetch('main.tpl');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';

//Noi dung chinh cua trang
$info = $pending_info = [];

foreach ($site_mods as $mod => $value) {
    if (file_exists(NV_ROOTDIR . '/modules/' . $value['module_file'] . '/siteinfo.php')) {
        $siteinfo = $pendinginfo = [];
        $mod_data = $value['module_data'];

        // Đọc tạm ngôn ngữ của module
        $nv_Lang->loadModule($value['module_file'], false, true);

        include NV_ROOTDIR . '/modules/' . $value['module_file'] . '/siteinfo.php';

        // Xóa ngôn ngữ đã đọc tạm
        $nv_Lang->changeLang();

        if (!empty($siteinfo)) {
            $info[$mod]['caption'] = $value['custom_title'];
            $info[$mod]['field'] = $siteinfo;
        }

        if (!empty($pendinginfo)) {
            $pending_info[$mod]['caption'] = $value['custom_title'];
            $pending_info[$mod]['field'] = $pendinginfo;
        }
    }
}

$xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);

// Thong tin thong ke tu cac module
if (!empty($info) or !empty($pending_info)) {
    if (!empty($info)) {
        $i = 0;
        foreach ($info as $if) {
            foreach ($if['field'] as $field) {
                $xtpl->assign('KEY', $field['key']);
                $xtpl->assign('VALUE', $field['value']);
                $xtpl->assign('MODULE', $if['caption']);

                if (!empty($field['link'])) {
                    $xtpl->assign('LINK', $field['link']);
                    $xtpl->parse('main.info.loop.link');
                } else {
                    $xtpl->parse('main.info.loop.text');
                }

                $xtpl->parse('main.info.loop');
            }
        }

        $xtpl->parse('main.info');
    }

    // Thong tin dang can duoc xu ly tu cac module
    if (!empty($pending_info)) {
        $i = 0;
        foreach ($pending_info as $if) {
            foreach ($if['field'] as $field) {
                $xtpl->assign('KEY', $field['key']);
                $xtpl->assign('VALUE', $field['value']);
                $xtpl->assign('MODULE', $if['caption']);

                if (!empty($field['link'])) {
                    $xtpl->assign('LINK', $field['link']);
                    $xtpl->parse('main.pendinginfo.loop.link');
                } else {
                    $xtpl->parse('main.pendinginfo.loop.text');
                }

                $xtpl->parse('main.pendinginfo.loop');
            }
        }

        $xtpl->parse('main.pendinginfo');
    }
} elseif (!defined('NV_IS_SPADMIN') and !empty($site_mods)) {
    $arr_mod = array_keys($site_mods);
    $module_name = $arr_mod[0];

    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

// Thong tin phien ban NukeViet
if (defined('NV_IS_GODADMIN')) {
    $field = [];
    $field[] = ['key' => $nv_Lang->getModule('version_user'), 'value' => $global_config['version']];
    if (file_exists(NV_ROOTDIR . '/' . NV_CACHEDIR . '/nukeviet.version.' . NV_LANG_INTERFACE . '.xml')) {
        $new_version = simplexml_load_file(NV_ROOTDIR . '/' . NV_CACHEDIR . '/nukeviet.version.' . NV_LANG_INTERFACE . '.xml');
    } else {
        $new_version = [];
    }

    $info = '';
    if (!empty($new_version)) {
        $field[] = [
            'key' => $nv_Lang->getModule('version_news'),
            'value' => $nv_Lang->getModule('newVersion_detail', (string) $new_version->version, nv_date('d/m/Y H:i', strtotime($new_version->date)))
        ];

        if (nv_version_compare($global_config['version'], $new_version->version) < 0) {
            $info = $nv_Lang->getModule('newVersion_info', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=webtools&amp;' . NV_OP_VARIABLE . '=checkupdate');
        }
    }

    $xtpl->assign('ULINK', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=webtools&amp;' . NV_OP_VARIABLE . '=checkupdate');
    $xtpl->assign('CHECKVERSION', $nv_Lang->getModule('checkversion'));

    foreach ($field as $key => $value) {
        $xtpl->assign('KEY', $value['key']);
        $xtpl->assign('VALUE', $value['value']);
        $xtpl->parse('main.version.loop');
    }

    if (!empty($info)) {
        $xtpl->assign('INFO', $info);
        $xtpl->parse('main.version.inf');
    }

    $xtpl->parse('main.version');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
