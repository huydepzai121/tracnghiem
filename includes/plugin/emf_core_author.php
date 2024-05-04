<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2023 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

$callback = function ($vars, $from_data, $receive_data) {
    $merge_fields = [];
    $vars['pid'] = (int) $vars['pid'];
    $vars['setpids'] = array_map('intval', $vars['setpids']);

    if (in_array($vars['pid'], $vars['setpids'], true)) {
        global $nv_Lang;

        // Đọc ngôn ngữ tạm của module
        $nv_Lang->loadModule('authors', true, true);

        $merge_fields['site_name'] = [
            'name' => $nv_Lang->getGlobal('site_name'),
            'data' => ''
        ];
        $merge_fields['link'] = [
            'name' => $nv_Lang->getGlobal('link'),
            'data' => ''
        ];
        $merge_fields['time'] = [
            'name' => $nv_Lang->getGlobal('time'),
            'data' => 0
        ];
        $merge_fields['note'] = [
            'name' => $nv_Lang->getGlobal('note'),
            'data' => ''
        ];
        $merge_fields['email'] = [
            'name' => $nv_Lang->getGlobal('email'),
            'data' => ''
        ];
        $merge_fields['sig'] = [
            'name' => $nv_Lang->getModule('sig'),
            'data' => ''
        ];
        $merge_fields['position'] = [
            'name' => $nv_Lang->getModule('position'),
            'data' => ''
        ];
        $merge_fields['username'] = [
            'name' => $nv_Lang->getGlobal('username'),
            'data' => ''
        ];

        if ($vars['mode'] != 'PRE') {
            // Field dữ liệu cho các fields
            global $global_config, $db;

            $lang = !empty($vars['lang']) ? $vars['lang'] : NV_LANG_INTERFACE;

            // Tên website
            if ($lang != NV_LANG_DATA or empty($global_config['site_name'])) {
                // Trường hợp gửi khác ngôn ngữ hiện tại thì lấy tên site theo ngôn ngữ khác.
                $result = $db->query('SELECT config_value FROM ' . NV_CONFIG_GLOBALTABLE . " WHERE lang=" . $db->quote($lang) . " AND module='global' AND config_name='site_name'");
                $site_name = $result->fetchColumn() ?: '';
            } else {
                $site_name = $global_config['site_name'];
            }
            $merge_fields['site_name']['data'] = $site_name;

            // Các field dạng chuỗi thuần
            $direct_keys = ['link', 'note', 'email', 'sig', 'position', 'username'];
            foreach ($direct_keys as $key) {
                $merge_fields[$key]['data'] = $vars[$key] ?? '';
            }

            // Các field dạng thời gian
            $time_keys = ['time'];
            foreach ($time_keys as $key) {
                if (!empty($vars[$key]) and is_numeric($vars[$key])) {
                    $merge_fields[$key]['data'] = nv_date('H:i d/m/Y', $vars[$key]);
                }
            }
        }

        $nv_Lang->changeLang();
    }

    return $merge_fields;
};
nv_add_hook($module_name, 'get_email_merge_fields', $priority, $callback, $hook_module, $pid);
