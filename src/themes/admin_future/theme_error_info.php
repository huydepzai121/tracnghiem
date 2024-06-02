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
            'fa-solid fa-ban',
            'danger'
        ],
        E_WARNING => [
            $nv_Lang->getGlobal('error_warning'),
            'fa-solid fa-triangle-exclamation',
            'warning'
        ],
        E_PARSE => [
            $nv_Lang->getGlobal('error_error'),
            'fa-solid fa-ban',
            'danger'
        ],
        E_NOTICE => [
            $nv_Lang->getGlobal('error_notice'),
            'fa-solid fa-circle-exclamation',
            'info'
        ],
        E_CORE_ERROR => [
            $nv_Lang->getGlobal('error_error'),
            'fa-solid fa-ban',
            'danger'
        ],
        E_CORE_WARNING => [
            $nv_Lang->getGlobal('error_warning'),
            'fa-solid fa-triangle-exclamation',
            'warning'
        ],
        E_COMPILE_ERROR => [
            $nv_Lang->getGlobal('error_error'),
            'fa-solid fa-ban',
            'danger'
        ],
        E_COMPILE_WARNING => [
            $nv_Lang->getGlobal('error_warning'),
            'fa-solid fa-triangle-exclamation',
            'warning'
        ],
        E_USER_ERROR => [
            $nv_Lang->getGlobal('error_error'),
            'fa-solid fa-ban',
            'danger'
        ],
        E_USER_WARNING => [
            $nv_Lang->getGlobal('error_warning'),
            'fa-solid fa-triangle-exclamation',
            'warning'
        ],
        E_USER_NOTICE => [
            $nv_Lang->getGlobal('error_notice'),
            'fa-solid fa-circle-exclamation',
            'info'
        ],
        E_STRICT => [
            $nv_Lang->getGlobal('error_notice'),
            'fa-solid fa-circle-exclamation',
            'info'
        ],
        E_RECOVERABLE_ERROR => [
            $nv_Lang->getGlobal('error_error'),
            'fa-solid fa-ban',
            'danger'
        ],
        E_DEPRECATED => [
            $nv_Lang->getGlobal('error_notice'),
            'fa-solid fa-circle-exclamation',
            'info'
        ],
        E_USER_DEPRECATED => [
            $nv_Lang->getGlobal('error_warning'),
            'fa-solid fa-triangle-exclamation',
            'warning'
        ]
    ];

    $tpl_dir = get_tpl_dir($dir, 'default', '/system/error_info.tpl');

    $tpl = new \NukeViet\Template\NVSmarty();
    $tpl->setTemplateDir(NV_ROOTDIR . '/themes/' . $tpl_dir . '/system');
    $tpl->assign('LANG', $nv_Lang);
    $tpl->assign('ERRORS', $error_info);
    $tpl->assign('CONFIGS', $errortype);

    return $tpl->fetch('error_info.tpl');
}
