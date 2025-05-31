<?php

/**
 * @Project NUKEVIET 4.x
 * @Author mynukeviet (contact@mynukeviet.net)
 * @Copyright (C) 2016 mynukeviet. All rights reserved
 * @Createdate Sun, 20 Nov 2016 07:31:04 GMT
 */
if (!defined('NV_IS_MOD_TEST')) die('Stop!!!');

if (isset($array_op[1])) {
    $alias = trim($array_op[1]);
    $page = (isset($array_op[2]) and substr($array_op[2], 0, 5) == 'page-') ? intval(substr($array_op[2], 5)) : 1;
    
    $stmt = $db->prepare('SELECT bid, title, alias, image, description, keywords FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block_cat WHERE alias= :alias');
    $stmt->bindParam(':alias', $alias, PDO::PARAM_STR);
    $stmt->execute();
    $group_info = $stmt->fetch();
    if ($group_info) {
        $page_title = $group_info['title'];
        $description = $group_info['description'];
        $key_words = $group_info['keywords'];
        $base_url_rewrite = $base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['groups'] . '/' . $group_info['alias'];
        
        if ($page > 1) {
            $page_title .= ' ' . NV_TITLEBAR_DEFIS . ' ' . $nv_Lang->getGlobal('page') . ' ' . $page;
            $base_url_rewrite .= '/page-' . $page;
        }
        $base_url_rewrite = nv_url_rewrite($base_url_rewrite, true);
        if ($_SERVER['REQUEST_URI'] != $base_url_rewrite and NV_MAIN_DOMAIN . $_SERVER['REQUEST_URI'] != $base_url_rewrite) {
            Header('Location: ' . $base_url_rewrite);
            die();
        }
        
        $array_mod_title[] = array(
            'catid' => 0,
            'title' => $page_title,
            'link' => $base_url
        );
        
        $db->sqlreset()
            ->select('COUNT(*)')
            ->from(NV_PREFIXLANG . '_' . $module_data . '_exams t1')
            ->join('INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_block t2 ON t1.id = t2.id')
            ->where('t2.bid= ' . $group_info['bid'] . ' AND t1.status=1 AND t1.isfull=1');
        
        $all_page = $db->query($db->sql())
            ->fetchColumn();
        
        $db->select('*')
            ->order(nv_test_get_order_exams('t1.'))
            ->limit($per_page)
            ->offset(($page - 1) * $per_page);
        
        $sth = $db->prepare($db->sql());
        $sth->execute();
        
        $array_data = array();
        while ($row = $sth->fetch()) {
            if (!empty($data = nv_show_exams($row, $module_name))) {
                if (!isset($array_user[$row['userid']])) {
                    $user = $db->query('SELECT first_name, last_name, username FROM ' . NV_USERS_GLOBALTABLE . ' WHERE userid=' . $row['userid'])->fetch();
                    $data['fullname'] = nv_show_name_user($user['first_name'], $user['last_name'], $user['username']);
                    $array_user[$row['userid']] = $data['fullname'];
                } else {
                    $data['fullname'] = $array_user[$row['userid']];
                }
                
                $array_data[$row['id']] = $data;
            }
        }
        
        if (!empty($group_info['image']) and file_exists(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $group_info['image'])) {
            $group_info['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $group_info['image'];
            $meta_property['og:image'] = NV_MY_DOMAIN . $group_info['image'];
        }
        
        $generate_page = nv_alias_page($page_title, $base_url, $all_page, $per_page, $page);
        $contents = nv_theme_test_topic($group_info, $array_data, $generate_page);
    }
} else {
    Header('Location: ' . nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name, true));
    die();
}

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';