<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2023 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_MAINFILE')) {
    exit('Stop!!!');
}

use NukeViet\Client\Browser;

/**
 * @param string $contents
 * @param number $head_site
 * @return string
 */
function nv_admin_theme(?string $contents, $head_site = 1)
{
    global $admin_info, $nv_Lang, $global_config, $module_info, $page_title, $module_file, $module_name, $op, $browser, $client_info, $site_mods;

    $file_name_tpl = $head_site == 1 ? 'main.tpl' : 'content.tpl';
    $admin_info['admin_theme'] = get_tpl_dir($admin_info['admin_theme'], 'admin_default', '/system/' . $file_name_tpl);

    $tpl = new \NukeViet\Template\NVSmarty();
    $tpl->registerPlugin('modifier', 'implode', 'implode');
    $tpl->registerPlugin('modifier', 'date', 'nv_date');
    $tpl->setTemplateDir(NV_ROOTDIR . '/themes/' . $admin_info['admin_theme'] . '/system');
    $tpl->assign('LANG', $nv_Lang);
    $tpl->assign('GCONFIG', $global_config);
    $tpl->assign('MODULE_INFO', $module_info);
    $tpl->assign('PAGE_TITLE', $page_title);
    $tpl->assign('MODULE_FILE', $module_file);
    $tpl->assign('MODULE_NAME', $module_name);
    $tpl->assign('OP', $op);
    $tpl->assign('ADMIN_INFO', $admin_info);
    $tpl->assign('IS_IE', $browser->isBrowser(Browser::BROWSER_IE));
    $tpl->assign('CLIENT_INFO', $client_info);
    $tpl->assign('SITE_MODS', $site_mods);

    // Icon site
    $site_favicon = NV_BASE_SITEURL . 'favicon.ico';
    if (!empty($global_config['site_favicon']) and file_exists(NV_ROOTDIR . '/' . $global_config['site_favicon'])) {
        $site_favicon = NV_BASE_SITEURL . $global_config['site_favicon'];
    }
    $tpl->assign('FAVICON', $site_favicon);

    // CSS riêng của module
    $theme_tpl = get_tpl_dir([$admin_info['admin_theme'], 'admin_default'], '', '/css/' . $module_file . '.css');
    $css_module = '';
    if (!empty($theme_tpl)) {
        $css_module = NV_STATIC_URL . 'themes/' . $theme_tpl . '/css/' . $module_file . '.css';
    }
    $tpl->assign('CSS_MODULE', $css_module);

    // JS riêng của module
    $theme_tpl = get_tpl_dir([$admin_info['admin_theme'], 'admin_default'], '', '/js/' . $module_file . '.js');
    $js_module = '';
    if (!empty($theme_tpl)) {
        $js_module = NV_STATIC_URL . 'themes/' . $theme_tpl . '/js/' . $module_file . '.js';
    }
    $tpl->assign('JS_MODULE', $js_module);

    $whitelisted_attr = ['target'];
    if (!empty($global_config['allowed_html_tags']) and in_array('iframe', $global_config['allowed_html_tags'])) {
        $whitelisted_attr[] = 'frameborder';
        $whitelisted_attr[] = 'allowfullscreen';
    }
    $tpl->assign('WHITELISTED_ATTR', "['" . implode("', '", $whitelisted_attr). "']");

    $tpl->assign('MODULE_CONTENT', $contents);

    $sitecontent = $tpl->fetch($file_name_tpl);

    if (!empty($my_head)) {
        $sitecontent = preg_replace('/(<\/head>)/i', $my_head . '\\1', $sitecontent, 1);
    }
    if (!empty($my_footer)) {
        $sitecontent = preg_replace('/(<\/body>)/i', $my_footer . '\\1', $sitecontent, 1);
    }

    return $sitecontent;
}
