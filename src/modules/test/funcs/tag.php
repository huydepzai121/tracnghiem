<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 3-6-2010 0:14
 */
if (!defined('NV_IS_MOD_TEST')) {
    die('Stop!!!');
}

$alias = $nv_Request->get_title('alias', 'get');
$array_op = explode('/', $alias);
$alias = $array_op[0];

if (isset($array_op[1])) {
    if (sizeof($array_op) == 2 and preg_match('/^page\-([0-9]+)$/', $array_op[1], $m)) {
        $page = intval($m[1]);
    } else {
        $alias = '';
    }
}
$page_title = trim(str_replace('-', ' ', $alias));

if (!empty($page_title) and $page_title == strip_punctuation($page_title)) {
    $stmt = $db->prepare('SELECT tid, image, description, keywords FROM ' . NV_PREFIXLANG . '_' . $module_data . '_tags WHERE alias= :alias');
    $stmt->bindParam(':alias', $alias, PDO::PARAM_STR);
    $stmt->execute();
    
    $tags_info = $stmt->fetch();
    if ($tags_info) {
        $base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=tag/' . $alias;
        if ($page > 1) {
            $page_title .= ' ' . NV_TITLEBAR_DEFIS . ' ' . $nv_Lang->getGlobal('page') . ' ' . $page;
        }
        
        $array_mod_title[] = array(
            'catid' => 0,
            'title' => $page_title,
            'link' => $base_url
        );
        
        $item_array = array();
        $end_publtime = 0;
        $show_no_image = $array_config['no_image'];
        $description = $tags_info['description'];
        $tags_info['title'] = $key_words = $tags_info['keywords'];
        
        $db->sqlreset()
            ->select('COUNT(*)')
            ->from(NV_PREFIXLANG . '_' . $module_data . '_exams')
            ->where('status=1 AND isfull=1 AND id IN (SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_tags_id WHERE tid=' . $tags_info['tid'] . ')');
        
        $num_items = $db->query($db->sql())
            ->fetchColumn();
        
        $db->select('*')
            ->order(nv_test_get_order_exams())
            ->limit($per_page)
            ->offset(($page - 1) * $per_page);
        
        $result = $db->query($db->sql());
        $array_user = array();
        while ($item = $result->fetch()) {
            if (!empty($data = nv_show_exams($item, $module_name))) {
                
                if (!isset($array_user[$item['userid']])) {
                    $user = $db->query('SELECT first_name, last_name, username FROM ' . NV_USERS_GLOBALTABLE . ' WHERE userid=' . $item['userid'])->fetch();
                    $data['fullname'] = nv_show_name_user($user['first_name'], $user['last_name'], $user['username']);
                    $array_user[$item['userid']] = $data['fullname'];
                } else {
                    $data['fullname'] = $array_user[$item['userid']];
                }
                
                $item_array[$item['id']] = $data;
            }
        }
        $result->closeCursor();
        unset($query, $row);
        
        $generate_page = nv_alias_page($page_title, $base_url, $num_items, $per_page, $page);
        
        if (!empty($tags_info['image'])) {
            $tags_info['image'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $tags_info['image'];
        }
        
        $contents = nv_theme_test_topic($tags_info, $item_array, $generate_page);
        
        if ($page > 1) {
            $page_title .= ' ' . NV_TITLEBAR_DEFIS . ' ' . $nv_Lang->getGlobal('page') . ' ' . $page;
        }
        include NV_ROOTDIR . '/includes/header.php';
        echo nv_site_theme($contents);
        include NV_ROOTDIR . '/includes/footer.php';
    }
}

$redirect = '<meta http-equiv="Refresh" content="3;URL=' . nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name, true) . '" />';
nv_info_die($nv_Lang->getGlobal('error_404_title'), $nv_Lang->getGlobal('error_404_title'), $nv_Lang->getGlobal('error_404_content') . $redirect, 404);