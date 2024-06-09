<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2023 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_SITEINFO')) {
    exit('Stop!!!');
}

$widget_info = [
    'id' => 'statistics',
    'name' => $nv_Lang->getModule('moduleInfo'),
    'note' => '',
    'func' => function () {
        global $stat_info, $global_config, $module_file, $nv_Lang;

        $template = get_tpl_dir([$global_config['module_theme'], $global_config['admin_theme']], 'admin_default', '/modules/' . $module_file . '/widget_pendings.tpl');
        $tpl = new \NukeViet\Template\NVSmarty();
        $tpl->setTemplateDir(NV_ROOTDIR . '/themes/' . $template . '/modules/' . $module_file);
        $tpl->assign('LANG', $nv_Lang);
        $tpl->assign('STATS', $stat_info);

        return $tpl->fetch('widget_statistics.tpl');
    }
];
