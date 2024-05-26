<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2023 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

$_SERVER['HTTP_HOST'] = $_ENV['HTTP_HOST'];
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '';
$_SERVER['SERVER_NAME'] = $_ENV['HTTP_HOST'];
$_SERVER['SERVER_PORT'] = '80';
$_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
$_SERVER['HTTP_USER_AGENT'] = 'NUKEVIET CMS. Developed by VINADES. Url: http://nukeviet.vn';
$_SERVER['SERVER_SOFTWARE'] = 'Apache';

define('NV_ADMIN', true);
define('NV_MAINFILE', true);

require NV_ROOTDIR . '/includes/core/filesystem_functions.php';
