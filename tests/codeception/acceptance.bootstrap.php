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
