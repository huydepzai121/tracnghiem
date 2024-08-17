<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2023 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE') or !defined('NV_IS_MODADMIN')) {
    exit('Stop!!!');
}

$menu_top = [
    'title' => $module_name,
    'module_file' => '',
    'custom_title' => $nv_Lang->getGlobal('mod_themes')
];

define('NV_IS_FILE_THEMES', true);

// Document
$array_url_instruction['main'] = 'https://wiki.nukeviet.vn/nukeviet4:admin:themes';
$array_url_instruction['config'] = 'https://wiki.nukeviet.vn/nukeviet4:admin:themes:config';
$array_url_instruction['setuplayout'] = 'https://wiki.nukeviet.vn/nukeviet4:admin:themes:setuplayout';
$array_url_instruction['blocks'] = 'https://wiki.nukeviet.vn/nukeviet4:admin:themes:blocks';
$array_url_instruction['xcopyblock'] = 'https://wiki.nukeviet.vn/themes:xcopyblock';
$array_url_instruction['package_theme_module'] = 'https://wiki.nukeviet.vn/themes:package_theme_module';

/**
 * Hiển thị khoảng thời gian hiển thị block khi thêm/sửa block
 *
 * @param string $dtime_type
 * @param array $dtime_details
 * @return string
 */
function get_dtime_details($dtime_type, $dtime_details)
{
    global $global_config, $module_file, $nv_Lang, $module_name, $op;

    if ($dtime_type == 'regular') {
        return '';
    }

    $template = get_tpl_dir([$global_config['module_theme'], $global_config['admin_theme']], 'admin_default', '/modules/' . $module_file . '/block-dtime.tpl');
    $tpl = new \NukeViet\Template\NVSmarty();
    $tpl->setTemplateDir(NV_ROOTDIR . '/themes/' . $template . '/modules/' . $module_file);
    $tpl->registerPlugin('modifier', 'str_pad', 'str_pad');
    $tpl->assign('LANG', $nv_Lang);
    $tpl->assign('MODULE_NAME', $module_name);
    $tpl->assign('OP', $op);
    $tpl->assign('TEMPLATE', $template);

    $tpl->assign('DTIME_TYPE', $dtime_type);

    if ($dtime_type == 'specific') {
        if (isset($dtime_details[0]['start_date'])) {
            $keys = count($dtime_details);
        } else {
            $keys = 1;
            $dtime_details = [];
        }
    } elseif ($dtime_type == 'daily') {
        if (isset($dtime_details[0]['start_h']) and count($dtime_details[0]) == 4) {
            $keys = count($dtime_details);
        } else {
            $keys = 1;
            $dtime_details = [];
        }
    } elseif ($dtime_type == 'weekly') {
        if (isset($dtime_details[0]['day_of_week'])) {
            $keys = count($dtime_details);
        } else {
            $keys = 1;
            $dtime_details = [];
        }
    } elseif ($dtime_type == 'monthly') {
        if (isset($dtime_details[0]['day']) and count($dtime_details[0]) == 5) {
            $keys = count($dtime_details);
        } else {
            $keys = 1;
            $dtime_details = [];
        }
    } elseif ($dtime_type == 'yearly') {
        if (isset($dtime_details[0]['month'])) {
            $keys = count($dtime_details);
        } else {
            $keys = 1;
            $dtime_details = [];
        }
    }

    $tpl->assign('CFG_LINE', $keys);
    $tpl->assign('DETAILS', $dtime_details);

    return $tpl->fetch('block-dtime.tpl');
}

/**
 * Lấy danh sách option block của module/giao diện khi thêm/sửa block
 *
 * @param string $module
 * @param int $bid
 * @param string $selectthemes
 * @return string
 */
function loadblock($module, $bid, $selectthemes = '')
{
    global $db, $nv_Lang, $global_config, $site_mods;

    $row = ['theme' => '', 'file_name' => ''];
    if ($bid > 0) {
        $row = $db->query('SELECT theme, file_name FROM ' . NV_BLOCKS_TABLE . '_groups WHERE bid=' . $bid)->fetch();
    }

    $return = '<option value="">' . $nv_Lang->getModule('block_select') . '</option>';

    if ($module == 'theme') {
        if (empty($row['theme'])) {
            $row['theme'] = !empty($selectthemes) ? $selectthemes : $global_config['site_theme'];
        }

        $block_file_list = nv_scandir(NV_ROOTDIR . '/themes/' . $row['theme'] . '/blocks', $global_config['check_block_theme']);
        foreach ($block_file_list as $file_name) {
            if (preg_match($global_config['check_block_theme'], $file_name, $matches)) {
                $sel = ($file_name == $row['file_name']) ? ' selected="selected"' : '';
                $load_config = (file_exists(NV_ROOTDIR . '/themes/' . $row['theme'] . '/blocks/' . $matches[1] . '.' . $matches[2] . '.ini')) ? 1 : 0;
                $load_mod_array = [];
                if ($matches[1] != 'global') {
                    foreach ($site_mods as $mod => $row_i) {
                        if ($row_i['module_file'] == $matches[1]) {
                            $load_mod_array[] = $mod;
                        }
                    }
                }
                $return .= '<option value="' . $file_name . '|' . $load_config . '|' . implode('.', $load_mod_array) . '" ' . $sel . '>' . $matches[1] . ' ' . $matches[2] . ' </option>';
            }
        }
    } elseif (isset($site_mods[$module]['module_file'])) {
        $module_file = $site_mods[$module]['module_file'];
        if (!empty($module_file)) {
            if (file_exists(NV_ROOTDIR . '/modules/' . $module_file . '/blocks')) {
                $block_file_list = nv_scandir(NV_ROOTDIR . '/modules/' . $module_file . '/blocks', $global_config['check_block_module']);

                foreach ($block_file_list as $file_name) {
                    $sel = ($file_name == $row['file_name']) ? ' selected="selected"' : '';

                    unset($matches);
                    preg_match($global_config['check_block_module'], $file_name, $matches);

                    $load_config = (file_exists(NV_ROOTDIR . '/modules/' . $module_file . '/blocks/' . $matches[1] . '.' . $matches[2] . '.ini')) ? 1 : 0;

                    $return .= '<option value="' . $file_name . '|' . $load_config . '|" ' . $sel . '>' . $matches[1] . ' ' . $matches[2] . ' </option>';
                }
            }
        }
    }

    return $return;
}
