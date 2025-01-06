<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_SEOTOOLS')) {
    exit('Stop!!!');
}

$page_title = $nv_Lang->getModule('robots');

$checkss = md5(NV_CHECK_SESSION . '_' . $module_name . '_' . $op . '_' . $admin_info['userid']);
$cache_file = NV_ROOTDIR . '/' . NV_DATADIR . '/robots.php';

$template = get_tpl_dir([$global_config['module_theme'], $global_config['admin_theme']], 'admin_default', '/modules/' . $module_file . '/robots.tpl');
$tpl = new \NukeViet\Template\NVSmarty();
$tpl->registerPlugin('modifier', 'array_merge', 'array_merge');
$tpl->setTemplateDir(NV_ROOTDIR . '/themes/' . $template . '/modules/' . $module_file);
$tpl->assign('LANG', $nv_Lang);
$tpl->assign('MODULE_NAME', $module_name);
$tpl->assign('OP', $op);

if ($checkss == $nv_Request->get_string('checkss', 'post')) {
    $robots_data = $nv_Request->get_array('filename', 'post');
    $fileother = $nv_Request->get_array('fileother', 'post');
    $optionother = $nv_Request->get_array('optionother', 'post');
    $robots_other = [];
    foreach ($fileother as $key => $value) {
        if (!empty($value)) {
            $robots_other[$value] = (int) ($optionother[$key]);
        }
    }

    $content_config = "<?php\n\n";
    $content_config .= NV_FILEHEAD . "\n\n";
    $content_config .= "if (!defined('NV_MAINFILE')) {\n    exit('Stop!!!');\n}\n\n";
    $content_config .= "\$cache = '" . serialize($robots_data) . "';\n\n";
    $content_config .= "\$cache_other = '" . serialize($robots_other) . "';\n";

    file_put_contents($cache_file, $content_config, LOCK_EX);

    // Không hỗ trợ rewrite thì ghi trực tiếp vào file txt. Không thì dùng rewrite để đọc trong php
    if (!$global_config['check_rewrite_file'] or !$global_config['rewrite_enable']) {
        $rbcontents = [];
        $rbcontents[] = 'User-agent: *';

        foreach ($robots_data as $key => $value) {
            if ($value == 0) {
                $rbcontents[] = 'Disallow: ' . $key;
            } elseif ($value == 2) {
                $rbcontents[] = 'Allow: ' . $key;
            }
        }

        $rbcontents[] = 'Sitemap: ' . $global_config['site_url'] . '/index.php?' . NV_NAME_VARIABLE . '=SitemapIndex' . $global_config['rewrite_endurl'];

        $rbcontents = implode("\n", $rbcontents);

        if (is_writable(NV_ROOTDIR . '/robots.txt')) {
            file_put_contents(NV_ROOTDIR . '/robots.txt', $rbcontents, LOCK_EX);
        } else {
            $tpl->assign('CONTENT', nv_htmlspecialchars($rbcontents));
            $contents = $tpl->fetch('robots-error.tpl');

            include NV_ROOTDIR . '/includes/header.php';
            echo nv_admin_theme($contents);
            include NV_ROOTDIR . '/includes/footer.php';
        }
    }
    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&rand=' . nv_genpass());
}

$tpl->assign('CHECKSS', $checkss);

$robots_data = [];
$robots_other = [];

if (file_exists($cache_file)) {
    include $cache_file;
    $robots_data = unserialize($cache);
    $robots_other = unserialize($cache_other);
} else {
    $robots_data['/' . NV_DATADIR . '/'] = 0;
    $robots_data['/includes/'] = 0;
    $robots_data['/install/'] = 0;
    $robots_data['/modules/'] = 0;
    $robots_data['/robots.php'] = 0;
    $robots_data['/web.config'] = 0;
}
if ($global_config['rewrite_enable']) {
    foreach ($site_mods as $key => $value) {
        if ($value['module_file'] == 'users' or $value['module_file'] == 'statistics') {
            $_url = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $key, true);
            if (!isset($robots_other[$_url])) {
                $robots_other[$_url] = 0;
            }
        }
    }
}
$files = scandir(NV_ROOTDIR, true);
sort($files);
$array_files = [];
foreach ($files as $file) {
    if (!preg_match('/^\.(.*)$/', $file)) {
        if (is_dir(NV_ROOTDIR . '/' . $file)) {
            $file = '/' . $file . '/';
        } else {
            $file = '/' . $file;
        }
        $array_files[] = [
            'filename' => $file,
            'type' => $robots_data[$file] ?? 1
        ];
    }
}
$tpl->assign('FILES', $array_files);
$tpl->assign('ROBOTS_OTHER', $robots_other);

$contents = $tpl->fetch('robots.tpl');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
