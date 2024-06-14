/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2024 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

$(document).ready(function() {
    // Thiết lập bản địa hóa
    let tabRegion = $('#tab-region');
    if (tabRegion.length) {
        let prRegion = $('#preview-region');
        let frRegion = $('#form-region');

        $('[data-bs-toggle="tab"]', tabRegion).on('show.bs.tab', function(e) {
            let tab = $(e.target).data('tab');
            $('[data-toggle="preview"]', prRegion).addClass('d-none');
            $('[data-tab="' + tab + '"]', prRegion).removeClass('d-none');
            $('[name="tab"]', frRegion).val(tab);
        });

        // Hàm định dạng số
        let _format = (value, decimals = 0, decPoint = '.', thousandsSep = ',') => {
            let formatted = '';
            const formatter = new Intl.NumberFormat(
                'de',
                {
                    style: 'currency',
                    currency: 'eur',
                    minimumFractionDigits: decimals,
                    maximumFractionDigits: decimals
                }
            );
            const parts = formatter.formatToParts(value);

            parts.forEach(part => {
                if (part.type === 'integer' || part.type === 'fraction') {
                    formatted += part.value;
                } else if (part.type === 'group') {
                    formatted += thousandsSep;
                } else if (part.type === 'decimal') {
                    formatted += decPoint;
                }
            });

            return formatted;
        }

        let dt = luxon.DateTime;
        let php2luxon = (str) => {
            const formatMaps = {
                d: 'dd',
                D: 'ccc',
                j: 'd',
                l: 'cccc',
                N: 'c',
                W: 'WW',
                F: 'LLLL',
                m: 'LL',
                M: 'LLL',
                n: 'L',
                Y: 'yyyy',
                y: 'yy',
                a: 'a',
                A: 'a',
                g: 'h',
                G: 'H',
                h: 'hh',
                H: 'HH',
                i: 'mm',
                s: 'ss',
                v: 'X'
            };
            let arr = [...str];
            str = '';
            for (var i = 0; i < arr.length; i++) {
                str += formatMaps[arr[i]] || arr[i];
            }
            return str;
        }

        let demoNumber = () => {
            if ($('.is-invalid', $('#tab-numbers')).length > 0) {
                $('#lbl_demo_numbers_p').html('##########');
                $('#lbl_demo_numbers_n').html('##########');
                return;
            }
            let num = _format(123456789.100, parseInt($('[name="decimal_length"]', frRegion).val()), $('[name="decimal_symbol"]', frRegion).val(), $('[name="thousand_symbol"]', frRegion).val());
            if ($('[name="trailing_zero"]', frRegion).is(':checked')) {
                num = num.replace(/[0]+$/, '');
                num = num.replace(/[0]+$/, '');
            }

            $('#lbl_demo_numbers_p').html(num);
            $('#lbl_demo_numbers_n').html('-' + num);
        }

        let demoCurrency = () => {
            if ($('.is-invalid', $('#tab-currency')).length > 0) {
                $('#lbl_demo_currency_p').html('##########');
                $('#lbl_demo_currency_n').html('##########');
                return;
            }

            let num = _format(123456789.100, parseInt($('[name="currency_decimal_length"]', frRegion).val()), $('[name="currency_decimal_symbol"]', frRegion).val(), $('[name="currency_thousand_symbol"]', frRegion).val());
            if ($('[name="currency_trailing_zero"]', frRegion).is(':checked')) {
                num = num.replace(/[0]+$/, '');
                num = num.replace(/[0]+$/, '');
            }
            let symbol = $('[name="currency_symbol"]', frRegion).val();
            let type = parseInt($('[name="currency_display"]', frRegion).val());
            switch (type) {
                case 3: num = symbol + ' ' + num; break;
                case 2: num = symbol + num; break;
                case 1: num = num + ' ' + symbol; break;
                default: num = num + symbol;
            }

            $('#lbl_demo_currency_p').html(num);
            $('#lbl_demo_currency_n').html(num.replace('123', '-123'));
        }

        let demoDate = () => {
            if ($('.is-invalid', $('#tab-date')).length > 0) {
                $('#lbl_demo_date_short').html('##########');
                $('#lbl_demo_date_long').html('##########');
                $('#lbl_demo_date_get').html('##########');
                $('#lbl_demo_date_post').html('##########');
                return;
            }

            let fshort, fLong;
            fshort = php2luxon($('[name="date_short"]', frRegion).val());
            fLong = php2luxon($('[name="date_long"]', frRegion).val());

            $('#lbl_demo_date_short').html(dt.now().setLocale(nv_lang_data).toFormat(fshort));
            $('#lbl_demo_date_long').html(dt.now().setLocale(nv_lang_data).toFormat(fLong));

            let dget, dpost;
            dget = php2luxon($('[name="date_get"]', frRegion).val());
            dpost = php2luxon($('[name="date_post"]', frRegion).val());

            $('#lbl_demo_date_get').html(dt.now().setLocale(nv_lang_data).toFormat(dget));
            $('#lbl_demo_date_post').html(dt.now().setLocale(nv_lang_data).toFormat(dpost));
        }

        let demoTime = () => {
            if ($('.is-invalid', $('#tab-time')).length > 0) {
                $('#lbl_demo_time_short').html('##########');
                $('#lbl_demo_time_long').html('##########');
                return;
            }

            let fshort, fLong, am, pm;
            am = dt.fromRFC2822('Tue, 01 Nov 2016 01:23:12 +0630').setLocale(nv_lang_data).toFormat('a');
            pm = dt.fromRFC2822('Tue, 01 Nov 2016 13:23:12 +0630').setLocale(nv_lang_data).toFormat('a');

            fshort = php2luxon($('[name="time_short"]', frRegion).val());
            fLong = php2luxon($('[name="time_long"]', frRegion).val());

            $('#lbl_demo_time_short').html(dt.now().setLocale(nv_lang_data).toFormat(fshort).replace(am, $('[name="am_char"]', frRegion).val()));
            $('#lbl_demo_time_long').html(dt.now().setLocale(nv_lang_data).toFormat(fLong).replace(pm, $('[name="pm_char"]', frRegion).val()));
        }

        demoNumber();
        demoCurrency();
        demoDate();
        demoTime();

        $('[type="text"], select, [type="checkbox"]', frRegion).on('keyup change', function() {
            demoNumber();
            demoCurrency();
            demoDate();
            demoTime();
        });
    }
});
