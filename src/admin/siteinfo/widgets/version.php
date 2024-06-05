<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2023 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_SITEINFO')) {
    exit('Stop!!!');
}

$widget_info = [
    'id' => 'version',
    'name' => $nv_Lang->getModule('version'),
    'note' => '',
    'func' => function () {
        return "<h5 class='card-title'>Thông tin phiên bản</h5><div style='height: 100%;'>HTML version</div>";
    }
];
