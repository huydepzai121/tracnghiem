<?php

/**
 * NUKEVIET Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

// Các trường dữ liệu khi gửi email thông tin kích hoạt tài khoản đến email của thành viên
$callback = function ($vars, $from_data, $receive_data) {
    $merge_fields = [];
    $vars['pid'] = (int) $vars['pid'];
    $vars['setpids'] = array_map('intval', $vars['setpids']);

    if (in_array($vars['pid'], $vars['setpids'], true)) {
        global $nv_Lang;

        // Đọc ngôn ngữ tạm của module
        if (!empty($receive_data)) {
            // Trường hợp gửi email async không load ra cái này bởi chưa load đến $sys_mod
            $nv_Lang->loadModule($receive_data['module_info']['module_file'], false, true);
        }

        $merge_fields['site_name'] = [
            'name' => $nv_Lang->getGlobal('site_name'),
            'data' => ''
        ];
        $merge_fields['greeting_user'] = [
            'name' => $nv_Lang->getModule('mf_greeting_user'),
            'data' => ''
        ];
        $merge_fields['full_name'] = [
            'name' => $nv_Lang->getModule('full_name'),
            'data' => ''
        ];
        $merge_fields['username'] = [
            'name' => $nv_Lang->getGlobal('username'),
            'data' => ''
        ];
        $merge_fields['email'] = [
            'name' => $nv_Lang->getGlobal('email'),
            'data' => ''
        ];
        $merge_fields['active_deadline'] = [
            'name' => $nv_Lang->getModule('merge_field_active_deadline'),
            'data' => ''
        ];
        $merge_fields['link'] = [
            'name' => $nv_Lang->getModule('merge_field_link'),
            'data' => ''
        ];
        $merge_fields['new_code'] = [
            'name' => $nv_Lang->getModule('user_2step_newcodes'),
            'data' => []
        ];
        $merge_fields['oauth_name'] = [
            'name' => $nv_Lang->getModule('openid_server'),
            'data' => ''
        ];
        $merge_fields['pass_reset'] = [
            'name' => $nv_Lang->getModule('pass_reset_request'),
            'data' => 0
        ];
        $merge_fields['password'] = [
            'name' => $nv_Lang->getModule('password'),
            'data' => ''
        ];
        $merge_fields['code'] = [
            'name' => $nv_Lang->getModule('code'),
            'data' => ''
        ];
        $merge_fields['send_newvalue'] = [
            'name' => $nv_Lang->getModule('mf_send_newvalue'),
            'data' => 0
        ];
        $merge_fields['newvalue'] = [
            'name' => $nv_Lang->getModule('editcensor_new'),
            'data' => ''
        ];
        $merge_fields['label'] = [
            'name' => $nv_Lang->getModule('mf_label'),
            'data' => ''
        ];
        $merge_fields['deadline'] = [
            'name' => $nv_Lang->getModule('mf_deadline'),
            'data' => ''
        ];
        $merge_fields['group_name'] = [
            'name' => $nv_Lang->getModule('group_name'),
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

            // Họ tên và câu chào
            if (isset($vars['username'], $vars['first_name'])) {
                $merge_fields['greeting_user']['data'] = greeting_for_user_create($vars['username'], $vars['first_name'], $vars['last_name'] ?? '', $vars['gender'] ?? '', $lang);
                $merge_fields['full_name']['data'] = nv_show_name_user($vars['first_name'], $vars['last_name'] ?? '', $vars['username'], $lang);
            }

            // Các field dạng chuỗi thuần
            $direct_keys = ['username', 'email', 'link', 'oauth_name', 'password', 'code', 'label', 'newvalue', 'group_name'];
            foreach ($direct_keys as $key) {
                $merge_fields[$key]['data'] = $vars[$key] ?? '';
            }

            // Các field dạng số, mặc định 0
            $number_keys = ['send_newvalue', 'pass_reset'];
            foreach ($number_keys as $key) {
                $merge_fields[$key]['data'] = $vars[$key] ?? 0;
            }

            // Các field dạng thời gian
            $time_keys = ['active_deadline', 'deadline'];
            foreach ($time_keys as $key) {
                if (!empty($vars[$key]) and is_numeric($vars[$key])) {
                    $merge_fields[$key]['data'] = nv_date('H:i d/m/Y', $vars[$key]);
                }
            }

            if (isset($vars['new_code']) and is_array($vars['new_code'])) {
                $merge_fields['new_code']['data'] = $vars['new_code'];
            }
        }

        $nv_Lang->changeLang();
    }

    return $merge_fields;
};
nv_add_hook($module_name, 'get_email_merge_fields', $priority, $callback, $hook_module, $pid);
