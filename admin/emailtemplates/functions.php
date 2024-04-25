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

define('NV_IS_FILE_EMAILTEMPLATES', true);

$allow_func = [
    'main',
    'categories',
    'contents',
    'test'
];

$menu_top = [
    'title' => $module_name,
    'module_file' => '',
    'custom_title' => $nv_Lang->getGlobal('mod_emailtemplates')
];

$sql = 'SELECT catid, time_add, time_update, weight, is_system, ' . NV_LANG_DATA . '_title title
FROM ' . NV_EMAILTEMPLATES_GLOBALTABLE . '_categories ORDER BY weight ASC';
$global_array_cat = $nv_Cache->db($sql, 'catid', $module_name);

// Lấy và cache các ngôn ngữ của module
$cacheFile = 'langs_' . NV_CACHE_PREFIX . '.cache';
$cacheTTL = 0; // Cache vĩnh viễn đến khi xóa

if (($cache = $nv_Cache->getItem($module_name, $cacheFile, $cacheTTL)) != false) {
    $global_module_languages = json_decode($cache, true);
} else {
    $columns = $db->columns_array(NV_EMAILTEMPLATES_GLOBALTABLE);

    $global_module_languages = [];
    foreach ($columns as $column => $column_info) {
        if (preg_match('/^([a-z]{2})\_subject$/i', $column, $m)) {
            $global_module_languages[] = $m[1];
        }
    }
    $nv_Cache->setItem($module_name, $cacheFile, json_encode($global_module_languages), $cacheTTL);
    unset($columns);
}
