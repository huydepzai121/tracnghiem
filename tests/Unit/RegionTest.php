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

class RegionTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;

    protected function _before()
    {
    }

    /**
     * Kiểm tra định dạng số
     */
    public function testNumberFormat()
    {
        // Số nguyên
        $this->assertEquals('123.456.789', nv_number_format(123456789, 'vi'));
        $this->assertEquals('123,456,789', nv_number_format(123456789, 'en'));

        // Số thực
        $this->assertEquals('123.456.789,01', nv_number_format(123456789.0123, 'vi'));
        $this->assertEquals('123,456,789.01', nv_number_format(123456789.0123, 'en'));

        // Bỏ số 0 phía cuối
        $this->assertEquals('123.456.789', nv_number_format(123456789.003, 'vi'));
        $this->assertEquals('123,456,789', nv_number_format(123456789.003, 'en'));

        // Số 0 ở đầu
        $this->assertEquals('0,01', nv_number_format(0.01234, 'vi'));
        $this->assertEquals('0.01', nv_number_format(0.01234, 'en'));
    }

    /**
     * Kiểm tra định dạng tiền
     */
    public function testCurrencyFormat()
    {
        // Số nguyên
        $this->assertEquals('123.456.789đ', nv_currency_format(123456789, 'vi'));
        $this->assertEquals('$123,456,789', nv_currency_format(123456789, 'en'));

        // Số thực
        $this->assertEquals('123.456.789,01đ', nv_currency_format(123456789.0123, 'vi'));
        $this->assertEquals('$123,456,789.01', nv_currency_format(123456789.0123, 'en'));

        // Bỏ số 0 phía cuối
        $this->assertEquals('123.456.789đ', nv_currency_format(123456789.003, 'vi'));
        $this->assertEquals('$123,456,789', nv_currency_format(123456789.003, 'en'));

        // Số 0 ở đầu
        $this->assertEquals('0,01đ', nv_currency_format(0.01234, 'vi'));
        $this->assertEquals('$0.01', nv_currency_format(0.01234, 'en'));
    }

    /**
     * Kiểm tra định dạng ngày
     */
    public function testDateFormat()
    {
        $timestamp = 1718268338;

        $this->assertEquals('13/06/2024', nv_date_format(1, $timestamp, 'vi'));
        $this->assertEquals('06/13/2024', nv_date_format(1, $timestamp, 'en'));
    }

    /**
     * Kiểm tra định dạng giờ
     */
    public function testTimeFormat()
    {
    }
}
