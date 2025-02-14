<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

/**
 *
 */
class UsersSiteCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    /**
     * @param AcceptanceTester $I
     * @link https://github.com/nukeviet/nukeviet/issues/3807
     *
     * @group users
     * @group all
     */
    public function testErrorUrlEditInfo(AcceptanceTester $I)
    {
        $I->wantTo('Check for errors when entering arbitrary parameters into the URL while editing account information');
        $I->userLogin();

        $I->amOnUrl($I->getDomain() . '/vi/users/editinfo/basic//');

        // Không được phép xuất hiện json này
        $I->cantSee('"error"');
    }
}
