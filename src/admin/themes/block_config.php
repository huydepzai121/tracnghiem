<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2023 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_THEMES')) {
    exit('Stop!!!');
}

if (!defined('NV_IS_AJAX')) {
    nv_htmlOutput('Wrong ajax!');
}
$respon = [
    'error' => 1,
    'text' => 'Wrong session!!!'
];
if ($nv_Request->get_title('checkss', 'post', '') !== NV_CHECK_SESSION) {
    nv_jsonOutput($respon);
}

$file_name = $nv_Request->get_string('file_name', 'post');
if (empty($file_name)) {
    $respon['text'] = 'No block file name!';
    nv_jsonOutput($respon);
}

$module = $nv_Request->get_string('module', 'post', '');
$selectthemes = $nv_Request->get_string('selectthemes', 'post', '');

// Xác định tồn tại của block
$path_file_php = $path_file_ini = $block_type = $block_dir = '';

if ($module == 'theme' and (preg_match($global_config['check_theme'], $selectthemes, $mtheme) or preg_match($global_config['check_theme_mobile'], $selectthemes, $mtheme)) and preg_match($global_config['check_block_theme'], $file_name, $matches) and file_exists(NV_ROOTDIR . '/themes/' . $selectthemes . '/blocks/' . $file_name)) {
    if (file_exists(NV_ROOTDIR . '/themes/' . $selectthemes . '/blocks/' . $matches[1] . '.' . $matches[2] . '.ini')) {
        $path_file_php = NV_ROOTDIR . '/themes/' . $selectthemes . '/blocks/' . $file_name;
        $path_file_ini = NV_ROOTDIR . '/themes/' . $selectthemes . '/blocks/' . $matches[1] . '.' . $matches[2] . '.ini';
        $block_type = 'theme';
        $block_dir = $selectthemes;
    }
} elseif (isset($site_mods[$module]) and preg_match($global_config['check_block_module'], $file_name, $matches)) {
    $module_file = $site_mods[$module]['module_file'];

    if (file_exists(NV_ROOTDIR . '/modules/' . $module_file . '/blocks/' . $file_name) and file_exists(NV_ROOTDIR . '/modules/' . $module_file . '/blocks/' . $matches[1] . '.' . $matches[2] . '.ini')) {
        $path_file_php = NV_ROOTDIR . '/modules/' . $module_file . '/blocks/' . $file_name;
        $path_file_ini = NV_ROOTDIR . '/modules/' . $module_file . '/blocks/' . $matches[1] . '.' . $matches[2] . '.ini';
        $block_type = 'module';
        $block_dir = $module_file;
    }
} else {
    $respon['text'] = 'Block not exists!';
    nv_jsonOutput($respon);
}

if (empty($path_file_php) or empty($path_file_ini) or ($block_type != 'module' and $block_type != 'theme')) {
    $respon['error'] = 0;
    $respon['html'] = '';
    nv_jsonOutput($respon);
}

// Neu ton tai file config cua block
$xml = simplexml_load_file($path_file_ini);
if ($xml === false) {
    $respon['text'] = $nv_Lang->getModule('block_error_bconfig');
    nv_jsonOutput($respon);
}

$function_name = trim($xml->datafunction);
if (empty($function_name)) {
    // Không chỉ ra hàm xử lý
    $respon['error'] = 0;
    $respon['html'] = '';
    nv_jsonOutput($respon);
}

include_once $path_file_php;
if (!nv_function_exists($function_name)) {
    // Chỉ ra hàm nhưng trong file php lại không có
    $respon['error'] = 0;
    $respon['html'] = '';
    nv_jsonOutput($respon);
}

// Đọc cấu hình mặc định của block
$xmlconfig = $xml->xpath('config');
$config = (array) $xmlconfig[0];
$array_config = [];
foreach ($config as $key => $value) {
    $array_config[$key] = trim($value);
}

$data_block = $array_config;
$bid = $nv_Request->get_int('bid', 'get,post', 0);

if ($bid > 0) {
    $row_config = $db->query('SELECT module, file_name, config FROM ' . NV_BLOCKS_TABLE . '_groups WHERE bid=' . $bid)->fetch();
    if ($row_config['file_name'] == $file_name and $row_config['module'] == $module) {
        $data_block = unserialize($row_config['config']);
    }
}

if ($block_type == 'module') {
    $nv_Lang->loadModule($block_dir, false, true);
} else {
    $nv_Lang->loadTheme($block_dir, true);
}

$xmllanguage = $xml->xpath('language');
if (!empty($xmllanguage)) {
    $language = (array) $xmllanguage[0];
    if (isset($language[NV_LANG_INTERFACE])) {
        $lang_block = (array) $language[NV_LANG_INTERFACE];
    } elseif (isset($language['en'])) {
        $lang_block = (array) $language['en'];
    } else {
        $key = array_keys($array_config);
        $lang_block = array_combine($key, $key);
    }
    $nv_Lang->setModule($lang_block, '', true);
}

// Gọi hàm xử lý hiển thị cấu hình block
$contents = call_user_func($function_name, $module, $data_block);

// Xóa lang tạm giải phóng bộ nhớ
$nv_Lang->changeLang();

$respon['error'] = 0;
$respon['html'] = $contents;
nv_jsonOutput($respon);
