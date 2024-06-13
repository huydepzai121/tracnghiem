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
    'id' => 'hour',
    'name' => $nv_Lang->getModule('statbyhour'),
    'note' => '',
    'func' => function () {
        global $global_config, $module_file, $nv_Lang, $db;

        $template = get_tpl_dir([$global_config['module_theme'], $global_config['admin_theme']], 'admin_default', '/modules/' . $module_file . '/widget_hour.tpl');
        $tpl = new \NukeViet\Template\NVSmarty();
        $tpl->setTemplateDir(NV_ROOTDIR . '/themes/' . $template . '/modules/' . $module_file);
        $tpl->assign('LANG', $nv_Lang);
        $tpl->assign('MODULE_FILE', $module_file);
        $tpl->assign('JS_DIR', get_tpl_dir([$global_config['module_theme'], $global_config['admin_theme']], 'admin_default', '/js/' . $module_file . '.js'));

        $sql = 'SELECT c_val, c_count FROM ' . NV_COUNTER_GLOBALTABLE . " WHERE c_type='hour' ORDER BY c_val";
        $result = $db->query($sql);

        $categories = $data = $data_formatted = [];
        while ($row = $result->fetch()) {
            $categories[] = $row['c_val'];
            $data[] = $row['c_count'];
            $data_formatted[] = nv_number_format($row['c_count']);
        }

        $tpl->assign('DATA', json_encode([
            'categories' => $categories,
            'data' => $data,
            'data_formatted' => $data_formatted,
            'unit' => $nv_Lang->getModule('hits1'),
            'hour' => $nv_Lang->getGlobal('hour'),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        return $tpl->fetch('widget_hour.tpl');
    }
];
