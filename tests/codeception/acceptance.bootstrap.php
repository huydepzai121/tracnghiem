<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2023 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

// Xóa để cài đặt site mới
if (is_file(NV_ROOTDIR . '/config.php')) {
    unlink(NV_ROOTDIR . '/config.php');
}

// Xóa error log
$files = scandir(NV_ROOTDIR . '/data/logs/error_logs');
if (!empty($files)) {
    foreach ($files as $file) {
        if (preg_match('/\.log$/i', $file)) {
            unlink(NV_ROOTDIR . '/data/logs/error_logs/' . $file);
        }
    }
}
$files = scandir(NV_ROOTDIR . '/data/logs/error_logs/tmp');
if (!empty($files)) {
    foreach ($files as $file) {
        if (preg_match('/\.log$/i', $file)) {
            unlink(NV_ROOTDIR . '/data/logs/error_logs/tmp/' . $file);
        }
    }
}

// Xóa file config_ini
$files = scandir(NV_ROOTDIR . '/data/config');
if (!empty($files)) {
    foreach ($files as $file) {
        if (preg_match('/^config\_ini\.(.*?)\.php$/i', $file)) {
            unlink(NV_ROOTDIR . '/data/config/' . $file);
        }
    }
}
