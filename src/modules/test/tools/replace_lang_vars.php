<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2015 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Tue, 02 Jun 2015 07:53:31 GMT
 */

// Công cụ thay thế biến ngôn ngữ trong module test
// Thay thế $lang_module thành $nv_Lang->getModule()
// Thay thế $lang_global thành $nv_Lang->getGlobal()
// Thay thế $xtpl->assign('LANG', $lang_module) thành $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module)
// Thay thế $xtpl->assign('GLANG', $lang_global) thành $xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global)

// Định nghĩa đường dẫn gốc
define('NV_ROOTDIR', str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../../')));

// Các mẫu cần thay thế
$patterns = [
    // Thay thế $xtpl->assign('LANG', $lang_module)
    [
        'pattern' => '/\$xtpl->assign\(\'LANG\',\s*\$lang_module\);/',
        'replacement' => '$xtpl->assign(\'LANG\', \NukeViet\Core\Language::$lang_module);'
    ],
    // Thay thế $xtpl->assign('GLANG', $lang_global)
    [
        'pattern' => '/\$xtpl->assign\(\'GLANG\',\s*\$lang_global\);/',
        'replacement' => '$xtpl->assign(\'GLANG\', \NukeViet\Core\Language::$lang_global);'
    ],
    // Thay thế $lang_module['key'] thành $nv_Lang->getModule('key')
    [
        'pattern' => '/\$lang_module\[\'([a-zA-Z0-9_]+)\'\]/',
        'replacement' => '$nv_Lang->getModule(\'$1\')'
    ],
    // Thay thế $lang_global['key'] thành $nv_Lang->getGlobal('key')
    [
        'pattern' => '/\$lang_global\[\'([a-zA-Z0-9_]+)\'\]/',
        'replacement' => '$nv_Lang->getGlobal(\'$1\')'
    ],
    // Thêm global $nv_Lang nếu chưa có
    [
        'pattern' => '/(if\s*\(\s*!\s*defined\s*\(\s*\'NV_IS_FILE_ADMIN\'\s*\)\s*\)\s*die\s*\(\s*\'Stop!!!\'\s*\);)/',
        'replacement' => '$1' . PHP_EOL . PHP_EOL . 'global $nv_Lang;'
    ]
];

// Các file cần bỏ qua
$exclude_files = [
    'global.functions.php',
    'replace_lang_vars.php'
];

// Hàm quét thư mục và xử lý các file
function processDirectory($dir, $patterns, $exclude_files) {
    $files = scandir($dir);
    
    foreach ($files as $file) {
        if ($file == '.' || $file == '..') {
            continue;
        }
        
        $path = $dir . '/' . $file;
        
        if (is_dir($path)) {
            processDirectory($path, $patterns, $exclude_files);
        } else {
            if (pathinfo($path, PATHINFO_EXTENSION) == 'php' && !in_array($file, $exclude_files)) {
                processFile($path, $patterns);
            }
        }
    }
}

// Hàm xử lý file
function processFile($file, $patterns) {
    echo "Đang xử lý file: $file\n";
    
    $content = file_get_contents($file);
    $original_content = $content;
    
    foreach ($patterns as $pattern) {
        $content = preg_replace($pattern['pattern'], $pattern['replacement'], $content);
    }
    
    if ($content != $original_content) {
        file_put_contents($file, $content);
        echo "  -> Đã cập nhật file\n";
    } else {
        echo "  -> Không có thay đổi\n";
    }
}

// Thư mục cần xử lý
$module_dir = NV_ROOTDIR . '/modules/test';

// Bắt đầu xử lý
echo "Bắt đầu quét và thay thế biến ngôn ngữ trong module test\n";
processDirectory($module_dir, $patterns, $exclude_files);
echo "Hoàn thành!\n";
