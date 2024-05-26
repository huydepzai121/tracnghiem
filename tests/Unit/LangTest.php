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
 * Kiểm tra các vấn đề về ngôn ngữ
 */
class LangTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    /**
     * Kiểm tra file ngôn ngữ hệ thống không tồn tại trong các ngôn ngữ khác Tiếng Việt
     */
    public function testLangSystemNotExistsOtherLang()
    {
        $langs = array_diff(nv_scandir(NV_ROOTDIR . '/includes/language', '/^[a-z]{2}$/'), ['vi']);
        $files = nv_scandir(NV_ROOTDIR . '/includes/language/vi', '/^([a-z0-9\_]+)\.php$/');
        $fileNotExists = [];
        foreach ($files as $file) {
            foreach ($langs as $lang) {
                if (!file_exists(NV_ROOTDIR . '/includes/language/' . $lang . '/' . $file)) {
                    $fileNotExists[] = $lang . ':' . $file;
                }
            }
        }
        $this->assertCount(0, $fileNotExists, implode(PHP_EOL, $fileNotExists));
    }

    /**
     * Kiểm tra file ngôn ngữ module không tồn tại trong các ngôn ngữ khác Tiếng Việt
     */
    public function testLangModuleNotExistsOtherLang()
    {
        $langs = array_diff(nv_scandir(NV_ROOTDIR . '/includes/language', '/^[a-z]{2}$/'), ['vi']);
        $modules = nv_scandir(NV_ROOTDIR . '/modules', '/^([a-zA-Z0-9]+)$/');
        $fileNotExists = [];
        foreach ($modules as $module) {
            foreach ($langs as $lang) {
                if (file_exists(NV_ROOTDIR . '/modules/' . $module . '/language/admin_vi.php') and !file_exists(NV_ROOTDIR . '/modules/' . $module . '/language/admin_' . $lang . '.php')) {
                    $fileNotExists[] = $module . ':admin_' . $lang . '.php';
                }
                if (file_exists(NV_ROOTDIR . '/modules/' . $module . '/language/vi.php') and !file_exists(NV_ROOTDIR . '/modules/' . $module . '/language/' . $lang . '.php')) {
                    $fileNotExists[] = $module . ':' . $lang . '.php';
                }
            }
        }
        $this->assertCount(0, $fileNotExists, implode(PHP_EOL, $fileNotExists));
    }

    /**
     * Kiểm tra ngôn ngữ module bị thừa so với Tiếng Việt
     * Kiểm tra ngôn ngữ module chưa dịch so với Tiếng Việt
     */
    public function testLangModuleRedundantOrNotTranslated()
    {
        $langs = array_diff(nv_scandir(NV_ROOTDIR . '/includes/language', '/^[a-z]{2}$/'), ['vi']);
        $modules = nv_scandir(NV_ROOTDIR . '/modules', '/^([a-zA-Z0-9]+)$/');

        foreach ($modules as $module) {
            $checkLangAdmin = file_exists(NV_ROOTDIR . '/modules/' . $module . '/language/admin_vi.php');
            $checkLangSite = file_exists(NV_ROOTDIR . '/modules/' . $module . '/language/vi.php');

            $compareAdminLang1 = $compareSiteLang1 = [];
            if ($checkLangAdmin) {
                $lang_translator = $lang_module = [];
                require NV_ROOTDIR . '/modules/' . $module . '/language/admin_vi.php';
                $compareAdminLang1 = $lang_module;
            }
            if ($checkLangSite) {
                $lang_translator = $lang_module = [];
                require NV_ROOTDIR . '/modules/' . $module . '/language/vi.php';
                $compareSiteLang1 = $lang_module;
            }

            foreach ($langs as $lang) {
                if (file_exists(NV_ROOTDIR . '/modules/' . $module . '/language/admin_' . $lang . '.php') and $checkLangAdmin) {
                    $lang_translator = $lang_module = [];
                    require NV_ROOTDIR . '/modules/' . $module . '/language/admin_' . $lang . '.php';
                    $compareAdminLang2 = $lang_module;
                    $redundant = array_diff_key($compareAdminLang2, $compareAdminLang1);
                    $notTranslated = array_diff_key($compareAdminLang1, $compareAdminLang2);
                    $this->assertCount(0, $redundant, 'Redundant lang ' . $lang . ' module ' . $module . ':' . PHP_EOL . implode(PHP_EOL, array_keys($redundant)));
                    $this->assertCount(0, $notTranslated, 'Not Translated lang ' . $lang . ' module ' . $module . ':' . PHP_EOL . implode(PHP_EOL, array_keys($notTranslated)));
                }
                if (file_exists(NV_ROOTDIR . '/modules/' . $module . '/language/' . $lang . '.php') and $checkLangSite) {
                    $lang_translator = $lang_module = [];
                    require NV_ROOTDIR . '/modules/' . $module . '/language/' . $lang . '.php';
                    $compareSiteLang2 = $lang_module;
                    $redundant = array_diff_key($compareSiteLang2, $compareSiteLang1);
                    $notTranslated = array_diff_key($compareSiteLang1, $compareSiteLang2);
                    $this->assertCount(0, $redundant, 'Redundant lang ' . $lang . ' module ' . $module . ':' . PHP_EOL . implode(PHP_EOL, array_keys($redundant)));
                    $this->assertCount(0, $notTranslated, 'Not Translated lang ' . $lang . ' module ' . $module . ':' . PHP_EOL . implode(PHP_EOL, array_keys($notTranslated)));
                }
            }
        }
    }

    /**
     * Kiểm tra các biến $lang_module, $lang_global, $lang_block trong các file không phải ngôn ngữ + vendor
     * Nếu có chứng tỏ còn sót theo cách viết 4.5
     */
    public function testOldLangRedundant()
    {
        $allfiles = $this->tester->listPhpNotLangVendorFile(NV_ROOTDIR);

        foreach ($allfiles as $filepath) {
            $filecontents = file_get_contents(NV_ROOTDIR . '/' . $filepath);
            $this->assertEquals(0, preg_match("/\\$(lang_global|lang_module|lang_block)[\s]*\[/", $filecontents), 'File: ' . $filepath);
        }
    }
}
