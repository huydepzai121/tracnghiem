<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_MODULES')) {
    exit('Stop!!!');
}

require NV_ROOTDIR . '/includes/fontawesome.php';

// Lấy icon
if ($nv_Request->get_title('ajax_icon', 'post', '') === NV_CHECK_SESSION) {
    $respon = [
        'results' => [],
        'pagination' => [
            'more' => false
        ]
    ];

    $q = str_replace('-', '', strtolower(change_alias($nv_Request->get_title('q', 'post', ''))));
    $page = $nv_Request->get_absint('page', 'post', 1);

    $icons = [];
    if (strlen($q) >= 1) {
        foreach ($fontawesome_icons as $icon) {
            if (strpos($icon['search'], $q) === false) {
                continue;
            }
            $icons[] = $icon;
        }
    }
    $per_page = 10;
    $offset = ($page - 1) * $per_page;
    $more = false;
    if (isset($icons[$offset])) {
        $respon['results'] = array_slice($icons, $offset, $per_page);
        $next_offset = $offset + $per_page;
        if (isset($icons[$next_offset])) {
            $more = true;
        }
    }

    $respon['pagination']['more'] = $more;
    nv_jsonOutput($respon);
}

$data = [];
$mod = $nv_Request->get_title('mod', 'get');

if (empty($mod) or !preg_match($global_config['check_module'], $mod)) {
    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

$sth = $db->prepare('SELECT * FROM ' . NV_MODULES_TABLE . ' WHERE title= :title');
$sth->bindParam(':title', $mod, PDO::PARAM_STR);
$sth->execute();
$row = $sth->fetch();
if (empty($row)) {
    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

$page_title = $nv_Lang->getModule('edit', $mod);
$checkss = md5(NV_CHECK_SESSION . '_' . $module_name . '_' . $op . '_' . $admin_info['userid']);

$tpl = new \NukeViet\Template\NVSmarty();
$tpl->setTemplateDir(get_module_tpl_dir('edit.tpl'));
$tpl->assign('LANG', $nv_Lang);
$tpl->assign('MODULE_NAME', $module_name);
$tpl->assign('OP', $op);
$tpl->assign('CHECKSS', $checkss);

$theme_site_array = $theme_mobile_array = [];
$theme_array = scandir(NV_ROOTDIR . '/themes');

$theme_mobile_default = [];
$theme_mobile_default[''] = [
    'key' => '',
    'title' => $nv_Lang->getModule('theme_mobiledefault')
];
$theme_mobile_default[':pcsite'] = [
    'key' => ':pcsite',
    'title' => $nv_Lang->getModule('theme_mobile_bysite')
];
$theme_mobile_default[':pcmod'] = [
    'key' => ':pcmod',
    'title' => $nv_Lang->getModule('theme_mobile_bymod')
];

foreach ($theme_array as $dir) {
    if (preg_match($global_config['check_theme'], $dir)) {
        if (file_exists(NV_ROOTDIR . '/themes/' . $dir . '/config.ini')) {
            $theme_site_array[] = $dir;
        }
    } elseif (preg_match($global_config['check_theme_mobile'], $dir)) {
        if (file_exists(NV_ROOTDIR . '/themes/' . $dir . '/config.ini')) {
            $theme_mobile_array[] = $dir;
        }
    }
}

$theme_list = $theme_mobile_list = $array_theme = [];

// Chi nhung giao dien da duoc thiet lap layout moi duoc them
$result = $db->query('SELECT DISTINCT theme FROM ' . NV_PREFIXLANG . '_modthemes WHERE func_id=0');
while ([$theme] = $result->fetch(3)) {
    if (in_array($theme, $theme_site_array, true)) {
        $array_theme[] = $theme;
        $theme_list[] = $theme;
    } elseif (in_array($theme, $theme_mobile_array, true)) {
        $array_theme[] = $theme;
        $theme_mobile_list[] = $theme;
    }
}

$groups_list = nv_groups_list();
$feature_rss = file_exists(NV_ROOTDIR . '/modules/' . $row['module_file'] . '/funcs/rss.php');
$feature_sitemap = count(nv_scandir(NV_ROOTDIR . '/modules/' . $row['module_file'] . '/funcs', '/^sitemap(.*?)\.php$/')) > 0;

if (empty($row['custom_title'])) {
    $row['custom_title'] = $row['title'];
}
$row['groups_view'] = empty($row['groups_view']) ? [] : explode(',', $row['groups_view']);

// Xử lý khi lưu
if ($checkss == $nv_Request->get_string('checkss', 'post')) {
    $respon = [
        'status' => 'error',
        'mess' => '',
    ];

    $custom_title = $nv_Request->get_title('custom_title', 'post', '', 1);
    if (empty($custom_title)) {
        $respon['input'] = 'custom_title';
        $respon['mess'] = $nv_Lang->getGlobal('required_invalid');
        nv_jsonOutput($respon);
    }

    $site_title = $nv_Request->get_title('site_title', 'post', '');
    $admin_title = $nv_Request->get_title('admin_title', 'post', '', 1);
    $theme = $nv_Request->get_title('theme', 'post', '', 1);
    $module_theme = $nv_Request->get_title('module_theme', 'post', '', 1);
    $mobile = $nv_Request->get_title('mobile', 'post', '', 0);
    $description = $nv_Request->get_title('description', 'post', '', 1);
    $description = nv_substr($description, 0, 255);
    $keywords = $nv_Request->get_title('keywords', 'post', '', 1);
    $act = $nv_Request->get_int('act', 'post', 0);
    $rss = $nv_Request->get_int('rss', 'post', 0);
    $sitemap = $nv_Request->get_int('sitemap', 'post', 0);
    $icon = $nv_Request->get_title('icon', 'post', '');

    if (!empty($theme) and !in_array($theme, $theme_list, true)) {
        $theme = '';
    }
    if (!empty($mobile) and !in_array($mobile, $theme_mobile_list, true) and !isset($theme_mobile_default[$mobile])) {
        $mobile = '';
    }
    if (!isset($fontawesome_packs[$icon])) {
        $icon = '';
    }
    if (!empty($keywords)) {
        $keywords = explode(',', $keywords);
        $keywords = array_map('trim', $keywords);
        $keywords = implode(', ', $keywords);
    }

    if ($mod != $global_config['site_home_module']) {
        $groups_view = $nv_Request->get_array('groups_view', 'post', []);
        $groups_view[] = 1;
        $groups_view[] = 2;
        $groups_view = !empty($groups_view) ? implode(',', nv_groups_post(array_intersect(array_unique($groups_view), array_keys($groups_list)))) : '';
    } else {
        $act = 1;
        $groups_view = '6';
    }

    $array_layoutdefault = $error = [];
    foreach ($array_theme as $_theme) {
        $xml = simplexml_load_file(NV_ROOTDIR . '/themes/' . $_theme . '/config.ini');
        $layoutdefault = (string) $xml->layoutdefault;

        if (!empty($layoutdefault) and file_exists(NV_ROOTDIR . '/themes/' . $_theme . '/layout/layout.' . $layoutdefault . '.tpl')) {
            $array_layoutdefault[$_theme] = $layoutdefault;
        } else {
            $error[] = $_theme;
        }
    }
    if (!empty($error)) {
        $respon['mess'] = $nv_Lang->getModule('edit_error_update_theme', implode(', ', $error));
        nv_jsonOutput($respon);
    }

    foreach ($array_layoutdefault as $selectthemes => $layoutdefault) {
        $array_func_id = [];
        $sth = $db->prepare('SELECT func_id FROM ' . NV_PREFIXLANG . '_modthemes WHERE theme= :theme');
        $sth->bindParam(':theme', $selectthemes, PDO::PARAM_STR);
        $sth->execute();
        while ([$func_id] = $sth->fetch(3)) {
            $array_func_id[] = $func_id;
        }

        $sth = $db->prepare('SELECT func_id FROM ' . NV_MODFUNCS_TABLE . ' WHERE in_module= :in_module AND show_func=1 ORDER BY subweight ASC');
        $sth->bindParam(':in_module', $mod, PDO::PARAM_STR);
        $sth->execute();
        while ([$func_id] = $sth->fetch(3)) {
            if (!in_array((int) $func_id, array_map('intval', $array_func_id), true)) {
                $sth2 = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_modthemes (func_id, layout, theme) VALUES (' . $func_id . ', :layout, :theme)');
                $sth2->bindParam(':layout', $layoutdefault, PDO::PARAM_STR);
                $sth2->bindParam(':theme', $selectthemes, PDO::PARAM_STR);
                $sth2->execute();
            }
        }
    }

    // Check module_theme
    $_theme_check = (!empty($theme)) ? $theme : $global_config['site_theme'];
    if (!empty($_theme_check) and file_exists(NV_ROOTDIR . '/themes/' . $_theme_check . '/theme.php')) {
        if (!file_exists(NV_ROOTDIR . '/themes/' . $_theme_check . '/modules/' . $module_theme)) {
            $module_theme = $row['module_file'];
        }
    } else {
        $module_theme = $row['module_file'];
    }

    nv_insert_logs(NV_LANG_DATA, $module_name, $nv_Lang->getModule('edit', $mod), '', $admin_info['userid']);

    $sth = $db->prepare('UPDATE ' . NV_MODULES_TABLE . ' SET
        module_theme=:module_theme, custom_title=:custom_title, site_title=:site_title, admin_title=:admin_title, theme= :theme, mobile= :mobile, description= :description,
        keywords= :keywords, groups_view= :groups_view, act=' . $act . ', rss=' . $rss . ', sitemap=' . $sitemap . ', icon=:icon
    WHERE title= :title');
    $sth->bindParam(':module_theme', $module_theme, PDO::PARAM_STR);
    $sth->bindParam(':custom_title', $custom_title, PDO::PARAM_STR);
    $sth->bindParam(':site_title', $site_title, PDO::PARAM_STR);
    $sth->bindParam(':admin_title', $admin_title, PDO::PARAM_STR);
    $sth->bindParam(':theme', $theme, PDO::PARAM_STR);
    $sth->bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $sth->bindParam(':description', $description, PDO::PARAM_STR);
    $sth->bindParam(':keywords', $keywords, PDO::PARAM_STR);
    $sth->bindParam(':groups_view', $groups_view, PDO::PARAM_STR);
    $sth->bindParam(':title', $mod, PDO::PARAM_STR);
    $sth->bindParam(':icon', $icon, PDO::PARAM_STR);
    $sth->execute();

    $mod_name = change_alias($nv_Request->get_title('mod_name', 'post'));
    if ($mod_name != $mod and preg_match($global_config['check_module'], $mod_name)) {
        $module_version = [];
        $version_file = NV_ROOTDIR . '/modules/' . $row['module_file'] . '/version.php';
        if (file_exists($version_file)) {
            include $version_file;
            if (isset($module_version['virtual']) and $module_version['virtual']) {
                $sth = $db->prepare('UPDATE ' . NV_MODULES_TABLE . ' SET title= :mod_name WHERE title= :mod_old');
                $sth->bindParam(':mod_name', $mod_name, PDO::PARAM_STR);
                $sth->bindParam(':mod_old', $mod, PDO::PARAM_STR);
                if ($sth->execute()) {
                    // Change module name
                    $sth = $db->prepare('UPDATE ' . NV_MODFUNCS_TABLE . ' SET in_module= :mod_name WHERE in_module= :mod_old');
                    $sth->bindParam(':mod_name', $mod_name, PDO::PARAM_STR);
                    $sth->bindParam(':mod_old', $mod, PDO::PARAM_STR);
                    $sth->execute();

                    // Change site_home_module
                    if ($mod == $global_config['site_home_module']) {
                        $sth = $db->prepare('UPDATE ' . NV_CONFIG_GLOBALTABLE . " SET config_value= :config_value WHERE config_name = 'site_home_module' AND lang = '" . NV_LANG_DATA . "' AND module='global'");
                        $sth->bindParam(':config_value', $mod_name, PDO::PARAM_STR);
                        $sth->execute();
                    }

                    // Change block
                    $sth = $db->prepare('UPDATE ' . NV_BLOCKS_TABLE . '_groups SET module= :mod_name WHERE module= :mod_old');
                    $sth->bindParam(':mod_name', $mod_name, PDO::PARAM_STR);
                    $sth->bindParam(':mod_old', $mod, PDO::PARAM_STR);
                    $sth->execute();

                    // Change config
                    $sth = $db->prepare('UPDATE ' . NV_CONFIG_GLOBALTABLE . " SET module= :mod_name WHERE lang = '" . NV_LANG_DATA . "' AND module= :mod_old");
                    $sth->bindParam(':mod_name', $mod_name, PDO::PARAM_STR);
                    $sth->bindParam(':mod_old', $mod, PDO::PARAM_STR);
                    $sth->execute();

                    // Change comment
                    $sth = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_comment SET module= :mod_name WHERE module= :mod_old');
                    $sth->bindParam(':mod_name', $mod_name, PDO::PARAM_STR);
                    $sth->bindParam(':mod_old', $mod, PDO::PARAM_STR);
                    $sth->execute();

                    // Change logs
                    $sth = $db->prepare('UPDATE ' . $db_config['prefix'] . "_logs SET module_name= :mod_name WHERE lang = '" . NV_LANG_DATA . "' AND module_name= :mod_old");
                    $sth->bindParam(':mod_name', $mod_name, PDO::PARAM_STR);
                    $sth->bindParam(':mod_old', $mod, PDO::PARAM_STR);
                    $sth->execute();
                }
            }
        }
    }
    $nv_Cache->delAll();

    $respon['status'] = 'success';
    $respon['mess'] = $nv_Lang->getGlobal('save_success');
    $respon['redirect'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name;
    nv_jsonOutput($respon);
}

$tpl->assign('DATA', $row);
$tpl->assign('THEME_LIST', $theme_list);
$tpl->assign('DTHEME_MOBILE', $theme_mobile_default);
$tpl->assign('THEME_MOBILE', $theme_mobile_list);
$tpl->assign('FEATURE_RSS', $feature_rss);
$tpl->assign('FEATURE_SITEMAP', $feature_sitemap);
$tpl->assign('GCONFIG', $global_config);
$tpl->assign('GROUPS_LIST', $groups_list);
$tpl->assign('ICON_PACKS', $fontawesome_packs);

$contents = $tpl->fetch('edit.tpl');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
