<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2023 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

class InstallCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function installStep1(AcceptanceTester $I)
    {
        $I->wantTo('Install NukeViet for testing');

        $domain = ($_ENV['HTTPS'] == 'on' ? 'https://' : 'http://') . $_ENV['HTTP_HOST'];

        $I->amOnUrl($domain);
        $I->amOnPage('/install/index.php');
        $I->seeElement('#lang');

        // Step 1
        $I->selectOption('#lang', $_ENV['NV_LANG']);
        $I->click('.next_step a');

        // Step 2
        $I->waitForElement('#checkchmod', 5);
        $I->seeElement('.next_step a');
        $I->click('.next_step a');

        // Step 3
        $I->waitForElement('#license', 5);
        $I->seeElement('.next_step a');
        $I->click('.next_step a');

        // Step 4
        $I->waitForElement('#checkserver', 5);
        $I->seeElement('.next_step a');
        $I->click('.next_step a');

        // Step 5: CSDL
        $I->waitForElement('#database_config', 5);

        $I->fillField(['name' => 'dbuname'], $_ENV['DB_UNAME']);
        $I->fillField(['name' => 'dbpass'], $_ENV['DB_UPASS']);
        $I->fillField(['name' => 'dbname'], $_ENV['DB_NAME']);

        $I->click('[type="submit"]');

        // Db đã có thì xóa nó rồi click next
        if ($I->tryToSeeElement('#db_detete')) {
            $I->checkOption('#db_detete');
            $I->click('[type="submit"]');
        }

        // Step 6 nhập cấu hình site
        $I->waitForElement('#site_config', 10);

        $I->fillField(['name' => 'site_name'], $_ENV['NV_SITE_NAME']);
        $I->fillField(['name' => 'nv_login'], $_ENV['NV_USERNAME']);
        $I->fillField(['name' => 'nv_email'], $_ENV['NV_EMAIL']);
        $I->fillField(['name' => 'nv_password'], $_ENV['NV_PASSWORD']);
        $I->fillField(['name' => 're_password'], $_ENV['NV_PASSWORD']);
        $I->fillField(['name' => 'question'], $_ENV['NV_QUESTION']);
        $I->fillField(['name' => 'answer_question'], $_ENV['NV_ANSWER']);
        $I->checkOption('[name="lang_multi"]');
        $I->checkOption('[name="dev_mode"]');

        $I->click('[type="submit"]');

        // Step 7 thành công
        $I->waitForElement('.home', 5);
        $I->seeElement('.okay');
    }
}
