<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2023 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_MAINFILE')) {
    exit('Stop!!!');
}

/**
 * @param string $dir
 * @return string
 */
function nv_error_info_theme($dir)
{
    global $nv_Lang, $error_info;

    $errortype = [
        E_ERROR => [
            $nv_Lang->getGlobal('error_error'),
            'bad.png'
        ],
        E_WARNING => [
            $nv_Lang->getGlobal('error_warning'),
            'warning.png'
        ],
        E_PARSE => [
            $nv_Lang->getGlobal('error_error'),
            'bad.png'
        ],
        E_NOTICE => [
            $nv_Lang->getGlobal('error_notice'),
            'comment.png'
        ],
        E_CORE_ERROR => [
            $nv_Lang->getGlobal('error_error'),
            'bad.png'
        ],
        E_CORE_WARNING => [
            $nv_Lang->getGlobal('error_warning'),
            'warning.png'
        ],
        E_COMPILE_ERROR => [
            $nv_Lang->getGlobal('error_error'),
            'bad.png'
        ],
        E_COMPILE_WARNING => [
            $nv_Lang->getGlobal('error_warning'),
            'warning.png'
        ],
        E_USER_ERROR => [
            $nv_Lang->getGlobal('error_error'),
            'bad.png'
        ],
        E_USER_WARNING => [
            $nv_Lang->getGlobal('error_warning'),
            'warning.png'
        ],
        E_USER_NOTICE => [
            $nv_Lang->getGlobal('error_notice'),
            'comment.png'
        ],
        E_STRICT => [
            $nv_Lang->getGlobal('error_notice'),
            'comment.png'
        ],
        E_RECOVERABLE_ERROR => [
            $nv_Lang->getGlobal('error_error'),
            'bad.png'
        ],
        E_DEPRECATED => [
            $nv_Lang->getGlobal('error_notice'),
            'comment.png'
        ],
        E_USER_DEPRECATED => [
            $nv_Lang->getGlobal('error_warning'),
            'warning.png'
        ]
    ];

    $tpl_dir = get_tpl_dir($dir, 'default', '/system/error_info.tpl');
    $image_path = NV_STATIC_URL . 'themes/' . $tpl_dir . '/images/icons/';

    $xtpl = new XTemplate('error_info.tpl', NV_ROOTDIR . '/themes/' . $tpl_dir . '/system');
    $xtpl->assign('TPL_E_CAPTION', $nv_Lang->getGlobal('error_info_caption'));

    $a = 0;
    foreach ($error_info as $key => $value) {
        $xtpl->assign('TPL_E_CLASS', ($a % 2) ? ' class="second"' : '');
        $xtpl->assign('TPL_E_ALT', $errortype[$value['errno']][0]);
        $xtpl->assign('TPL_E_SRC', $image_path . $errortype[$value['errno']][1]);
        $xtpl->assign('TPL_E_ERRNO', $errortype[$value['errno']][0]);
        $xtpl->assign('TPL_E_MESS', $value['info']);
        $xtpl->set_autoreset();
        $xtpl->parse('error_info.error_item');
        ++$a;
    }

    $xtpl->parse('error_info');
    return $xtpl->text('error_info');
}
