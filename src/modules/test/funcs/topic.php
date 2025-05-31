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

$array_mod_title[] = array(
    'catid' => 0,
    'title' => $module_info['funcs'][$op]['func_custom_name'],
    'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['topic']
);

$alias = isset($array_op[1]) ? trim($array_op[1]) : '';
$topic_array = array();

$topicid = 0;
if (!empty($alias)) {
    $page = (isset($array_op[2]) and substr($array_op[2], 0, 5) == 'page-') ? intval(substr($array_op[2], 5)) : 1;
    
    $sth = $db->prepare('SELECT topicid, title, alias, image, description, keywords FROM ' . NV_PREFIXLANG . '_' . $module_data . '_topics WHERE alias= :alias');
    $sth->bindParam(':alias', $alias, PDO::PARAM_STR);
    $sth->execute();
    
    $topic_info = $sth->fetch();
    if ($topic_info) {
        $page_title = $topic_info['title'];
        $description = $topic_info['description'];
        $key_words = $topic_info['keywords'];
        $base_url_rewrite = $base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['topic'] . '/' . $topic_info['alias'];
        if ($page > 1) {
            $page_title .= ' ' . NV_TITLEBAR_DEFIS . ' ' . $nv_Lang->getGlobal('page') . ' ' . $page;
            $base_url_rewrite .= '/page-' . $page;
        }
        $base_url_rewrite = nv_url_rewrite(str_replace('&amp;', '&', $base_url_rewrite), true);
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
            ->from(NV_PREFIXLANG . '_' . $module_data . '_exams')
            ->where('status=1 AND isfull=1 AND topicid = ' . $topic_info['topicid']);
        
        $all_page = $db->query($db->sql())
            ->fetchColumn();
        
        $db->select('*')
            ->order(nv_test_get_order_exams())
            ->limit($per_page)
            ->offset(($page - 1) * $per_page);
        
        $_query = $db->query($db->sql());
        $number = $page > 1 ? ($per_page * ($page - 1)) + 1 : 1;
        
        $array_user = $array_data = array();
        while ($row = $_query->fetch()) {
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
        
        if (!empty($topic_info['image'])) {
            $topic_info['image'] = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/topics/' . $topic_info['image'];
            $meta_property['og:image'] = NV_MY_DOMAIN . $topic_info['image'];
        }
        
        $generate_page = nv_alias_page($page_title, $base_url, $all_page, $per_page, $page);
        $contents = nv_theme_test_topic($topic_info, $array_data, $generate_page);
    } else {
        Header('Location: ' . nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['topic'], true));
        exit();
    }
} else {
    Header('Location: ' . NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
    die();
}

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';