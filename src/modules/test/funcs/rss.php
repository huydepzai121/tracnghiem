<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Apr 20, 2010 10:47:41 AM
 */
if (!defined('NV_IS_MOD_TEST')) {
    die('Stop!!!');
}

$channel = array();
$items = array();

$channel['title'] = $module_info['custom_title'];
$channel['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name;
$channel['description'] = !empty($module_info['description']) ? $module_info['description'] : $global_config['site_description'];

$catid = 0;
if (isset($array_op[1])) {
    $alias_cat_url = $array_op[1];
    $cattitle = '';
    foreach ($array_test_cat as $catid_i => $array_cat_i) {
        if ($alias_cat_url == $array_cat_i['alias']) {
            $catid = $catid_i;
            break;
        }
    }
}

$db->sqlreset()
    ->select('id, catid, addtime, title, alias, hometext, image')
    ->order(nv_test_get_order_exams())
    ->limit(30);

if (!empty($catid)) {
    $channel['title'] = $module_info['custom_title'] . ' - ' . $array_test_cat[$catid]['title'];
    $channel['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $alias_cat_url;
    $channel['description'] = $array_test_cat[$catid]['description'];
    $db->from(NV_PREFIXLANG . '_' . $module_data . '_exams')->where('status=1 AND isfull=1 AND catid=' . $catid);
} else {
    $db->from(NV_PREFIXLANG . '_' . $module_data . '_exams')->where('status=1 AND isfull=1');
}

if ($module_info['rss']) {
    $result = $db->query($db->sql());
    while (list ($id, $catid_i, $publtime, $title, $alias, $hometext, $image) = $result->fetch(3)) {
        $catalias = $array_test_cat[$catid_i]['alias'];
        
        if (!empty($image) and file_exists(NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $module_upload . '/' . $image)) {
            $rimages = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $image;
        } elseif (!empty($image) and file_exists(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $image)) {
            $rimages = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $image;
        } elseif (!empty($array_config['no_image'])) {
            if (file_exists(NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $module_upload . '/' . $array_config['no_image'])) {
                $rimages = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $array_config['no_image'];
            } elseif (file_exists(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $array_config['no_image'])) {
                $rimages = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $array_config['no_image'];
            } else {
                $rimages = '';
            }
        } else {
            $rimages = '';
        }
        $rimages = (!empty($rimages)) ? '<img src="' . $rimages . '" width="100" align="left" border="0">' : '';
        
        $items[] = array(
            'title' => $title,
            'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $catalias . '/' . $alias . '-' . $id . $global_config['rewrite_exturl'], //
            'guid' => $module_name . '_' . $id,
            'description' => $rimages . $hometext,
            'pubdate' => $publtime
        );
    }
}
nv_rss_generate($channel, $items);
die();