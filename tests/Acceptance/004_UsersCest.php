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

class UsersCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    /**
     * @param AcceptanceTester $I
     *
     * @group install
     * @group all
     */
    public function addUserInAdminPanel(AcceptanceTester $I)
    {
        $I->wantTo('Add one user account in admin area');
        $I->login();

        $I->amOnUrl($I->getDomain() . '/admin/index.php?language=vi&nv=users&op=user_add');
        $I->seeElement('[name="username"]');

        $I->fillField(['name' => 'username'], 'spadmin');
        $I->fillField(['name' => 'email'], 'spadmin@nukeviet.vn');
        $I->fillField(['name' => 'password1'], $_ENV['NV_PASSWORD']);
        $I->fillField(['name' => 'password2'], $_ENV['NV_PASSWORD']);
        $I->fillField(['name' => 'first_name'], 'Super Admin');
        $I->fillField(['name' => 'birthday'], '20/10/2000');
        $I->fillField(['name' => 'question'], 'NukeViet');
        $I->fillField(['name' => 'answer'], 'NukeViet CMS');

        $I->click('[type="submit"]');
        $I->waitForText('Danh sách tài khoản', 5);
        $I->see('spadmin@nukeviet.vn');
    }
}
