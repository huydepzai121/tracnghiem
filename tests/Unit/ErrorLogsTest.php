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

/**
 * Kiểm tra không sinh ra error log trong quá trình test
 */
class ErrorLogsTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    /**
     * Error log không sinh ra trong quá trình test
     */
    public function testFileErrorLogNotExists()
    {
        $files = nv_scandir(NV_ROOTDIR . '/data/logs/error_logs', '/^.*\.log$/');
        $this->assertEquals(0, sizeof($files));
    }
}
