<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2023 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

namespace Tests\Unit;

use Tests\Support\UnitTester;

class NotificationTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    /**
     * Kiểm tra lưu thông báo vào CSDL
     */
    public function testInsertNotification()
    {
        $check = nv_insert_notification('settings', 'server_config_file_changed', ['file' => 'index.php'], 0, 0, 0, 1, 1);
        $this->assertGreaterThan(0, $check);

        $check = nv_insert_notification('users', 'remove_2step_request', [
            'title' => 'webmaster',
            'uid' => 1
        ], 1, 0, 0, 1, 1, 1);
        $this->assertGreaterThan(0, $check);
    }
}
