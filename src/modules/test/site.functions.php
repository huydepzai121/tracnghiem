<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 12/31/2009 0:51
 */
if (!defined('NV_MAINFILE')) {
    die('Stop!!!');
}

if (file_exists(NV_ROOTDIR . '/modules/' . $module_name . '/private_config_site.xml')) {
    $private_config_site = nv_object2array(simplexml_load_file(NV_ROOTDIR . '/modules/' . $module_name . '/private_config_site.xml'));
}


function nv_show_exams($row, $module)
{
    global $global_config, $array_config, $array_test_cat, $site_mods;

    $array_data = array();
    if (empty($array_test_cat[$row['catid']])) return $array_data;

    if (!empty($row['image']) and file_exists(NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $site_mods[$module]['module_upload'] . '/' . $row['image'])) {
        $row['image'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $site_mods[$module]['module_upload'] . '/' . $row['image'];
    } elseif (!empty($row['image']) and file_exists(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $site_mods[$module]['module_upload'] . '/' . $row['image'])) {
        $row['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $site_mods[$module]['module_upload'] . '/' . $row['image'];
    } elseif (!empty($array_config['no_image'])) {
        if (file_exists(NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $site_mods[$module]['module_upload'] . '/' . $array_config['no_image'])) {
            $row['image'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $site_mods[$module]['module_upload'] . '/' . $array_config['no_image'];
        } elseif (file_exists(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $site_mods[$module]['module_upload'] . '/' . $array_config['no_image'])) {
            $row['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $site_mods[$module]['module_upload'] . '/' . $array_config['no_image'];
        } else {
            $row['image'] = '';
        }
    } else {
        $row['image'] = '';
    }
    $row['newday'] = $row['addtime'] + (86400 * $array_test_cat[$row['catid']]['newday']);
    $row['addtime'] = nv_date('H:i d/m/Y', $row['addtime']);
    $row['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=' . $array_test_cat[$row['catid']]['alias'] . '/' . $row['alias'] . '-' . $row['id'] . $global_config['rewrite_exturl'];
    $array_data = $row;

    return $array_data;
}

function nv_test_get_order_exams($prefix = '')
{
    global $array_config;

    return $array_config['order_exams'] ? $prefix . 'weight ASC' : $prefix . 'addtime DESC';
}
