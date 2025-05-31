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

// kiểm tra quyền xem chủ đề
if (!nv_user_in_groups($array_test_cat[$catid]['groups_view'])) {
    $contents = nv_theme_alert($nv_Lang->getModule('exams_premission_none_title'), sprintf($nv_Lang->getModule('cat_premission_none_content'), $array_test_cat[$catid]['title']));
    include NV_ROOTDIR . '/includes/header.php';
    echo nv_site_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
}

$page_title = (!empty($array_test_cat[$catid]['custom_title'])) ? $array_test_cat[$catid]['custom_title'] : $array_test_cat[$catid]['title'];
$key_words = $array_test_cat[$catid]['keywords'];
$description = $array_test_cat[$catid]['description'];
$base_url = $array_test_cat[$catid]['link'];

if (!empty($array_test_cat[$catid]['image'])) {
    $meta_property['og:image'] = NV_MY_DOMAIN . NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $array_test_cat[$catid]['image'];
}

$base_url_rewrite = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $array_test_cat[$catid]['alias'];
if ($page > 1) {
    $base_url_rewrite .= '/page-' . $page;
}
$base_url_rewrite = nv_url_rewrite($base_url_rewrite, true);
if ($_SERVER['REQUEST_URI'] != $base_url_rewrite and NV_MAIN_DOMAIN . $_SERVER['REQUEST_URI'] != $base_url_rewrite) {
    Header('Location: ' . $base_url_rewrite);
    die();
}

if ($array_test_cat[$catid]['viewtype'] == 1 || $array_test_cat[$catid]['viewtype'] == 6) {
    $array_catid = nv_GetCatidInParent($catid);

    if (empty($array_config['order_exams'])) {
        $order = 'id DESC';
        if ($array_test_cat[$catid]['viewtype'] == 6) {
            $order = 'id ASC';
        }
    } else {
        $order = nv_test_get_order_exams();
    }

    $db->sqlreset()
        ->select('COUNT(*)')
        ->from(NV_PREFIXLANG . '_' . $module_data . '_exams')
        ->where('status=1 AND isfull=1 AND catid IN (' . implode(',', $array_catid) . ')');

    $all_page = $db->query($db->sql())
        ->fetchColumn();

    $db->select('*')
        ->order($order)
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

    $array_top_score = array();
    if (!empty($array_test_cat[$catid]['topscore'])) {
        $db->sqlreset()
            ->select('t1.id, t1.exam_id, t1.userid, t1.score, t1.begin_time, t1.end_time, t1.count_true, t2.username, t2.first_name, t2.last_name, t3.id examid, t3.title, t3.alias, t3.catid')
            ->from(NV_PREFIXLANG . '_' . $module_data . '_answer AS t1')
            ->join('INNER JOIN ' . NV_USERS_GLOBALTABLE . ' AS t2 ON t1.userid=t2.userid INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_exams AS t3 ON t1.exam_id=t3.id')
            ->where('t3.catid IN (' . implode(',', $array_catid) . ') AND score > 0')
            ->group('t1.userid')
            ->order('t1.score DESC, ' . nv_test_get_order_exams('t3.'))
            ->limit($array_test_cat[$catid]['topscore']);

        $result = $db->query($db->sql());
        while ($row = $result->fetch()) {
            $row['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_test_cat[$row['catid']]['alias'] . '/' . $row['alias'] . '-' . $row['examid'] . $global_config['rewrite_exturl'];
            $row['fullname'] = nv_show_name_user($row['first_name'], $row['last_name'], $row['username']);
            $array_top_score[$row['id']] = $row;
        }
    }
}

$generate_page = nv_alias_page($page_title, $base_url, $all_page, $per_page, $page);
$contents = nv_theme_test_viewcat($array_test_cat[$catid], $array_data, $generate_page);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';