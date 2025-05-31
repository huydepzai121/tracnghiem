<?php

/**
 * @Project NUKEVIET 4.x
 * @Author hongoctrien (contact@mynukeviet.net)
 * @Copyright (C) 2016 hongoctrien. All rights reserved
 * @Createdate Wed, 27 Apr 2016 07:24:36 GMT
 */
if (!defined('NV_IS_MOD_TEST')) die('Stop!!!');

$page_title = $module_info['custom_title'];
$key_words = $module_info['keywords'];
$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name;
$alias_page = '';
$indexfile = $array_config['indexfile'];
$array_data = array();

// danh sách, mới lên trên
if ($indexfile == 1) {
    $where = 'status=1 AND isfull=1 AND' . (!empty($array_test_cat) ? (' catid IN (' . implode(',', array_keys($array_test_cat)) . ') AND') : '')  . ' (
        type=0 OR (
            (begintime=0 OR begintime<=' . NV_CURRENTTIME . ') AND
            (endtime=0 OR endtime>' . NV_CURRENTTIME . ')
        ) 
    )';

    $db->sqlreset()
        ->select('COUNT(*)')
        ->from(NV_PREFIXLANG . '_' . $module_data . '_exams')
        ->where($where);

    $all_page = $db->query($db->sql())
        ->fetchColumn();

    $db->select('*')
        ->order(nv_test_get_order_exams())
        ->limit($per_page)
        ->offset(($page - 1) * $per_page);

    $_query = $db->query($db->sql());

    $array_user = array();
    while ($row = $_query->fetch()) {
        if (!empty($data = nv_show_exams($row, $module_name))) {
            if (!isset($array_user[$row['userid']])) {
                $user = $db->query('SELECT first_name, last_name, username FROM ' . NV_USERS_GLOBALTABLE . ' WHERE userid=' . $row['userid'])->fetch();
                if (!empty($user)) {
                    $data['fullname'] = nv_show_name_user($user['first_name'], $user['last_name'], $user['username']);
                } else {
                    $data['fullname'] = '--';
                }
                $array_user[$row['userid']] = $data['fullname'];
            } else {
                $data['fullname'] = $array_user[$row['userid']];
            }

            $array_data[$row['id']] = $data;
        }
    }

    if ($page > 1) {
        $page_title = $page_title . ' - ' . $nv_Lang->getGlobal('page') . ' ' . $page;
    }

    $alias_page = nv_alias_page($page_title, $base_url, $all_page, $per_page, $page);
} elseif ($indexfile == 2 or $indexfile == 3 or $indexfile == 4) {
    if (!empty($array_test_cat)) {
        foreach ($array_test_cat as $index => $value) {
            if (nv_user_in_groups($value['groups_view']) && $value['parentid'] == 0 and $value['inhome']) {
                $array_item = $array_user = array();
                $catid_parrent = implode(', ', nv_GetCatidInParent($index));
                $result = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams WHERE status=1 AND isfull=1 AND catid IN (' . $catid_parrent . ') ORDER BY ' . nv_test_get_order_exams() . ' LIMIT ' . $value['numlinks']);
                while ($row = $result->fetch()) {
                    if (!empty($data = nv_show_exams($row, $module_name))) {
                        if (!isset($array_user[$row['userid']])) {
                            $user = $db->query('SELECT first_name, last_name, username FROM ' . NV_USERS_GLOBALTABLE . ' WHERE userid=' . $row['userid'])->fetch();
                            $data['fullname'] = nv_show_name_user($user['first_name'], $user['last_name'], $user['username']);
                            $array_user[$row['userid']] = $data['fullname'];
                        } else {
                            $data['fullname'] = $array_user[$row['userid']];
                        }
                        $array_item[] = $data;
                    }
                }

                if (!empty($array_item)) {
                    $array_data[$index] = array(
                        'id' => $index,
                        'title' => $value['title'],
                        'link' => $value['link'],
                        'data' => $array_item
                    );
                    if ($module_info['rss']) {
                        $array_data[$index]['link_rss'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $module_info['alias']['rss'] . "/" . $value['alias'];
                    }
                }
            }
        }
    }
} elseif ($indexfile == 5) {
    if (!empty($array_test_cat)) {
        foreach ($array_test_cat as $index => $value) {
            if (nv_user_in_groups($value['groups_view']) && $value['parentid'] == 0 and $value['inhome']) {
                if (!empty($value['image']) && file_exists(NV_ROOTDIR . '/' . NV_ASSETS_DIR . '/' . $module_upload . '/' . $value['image'])) {
                    $value['image'] = NV_BASE_SITEURL . NV_ASSETS_DIR . '/' . $module_upload . '/' . $value['image'];
                } elseif (!empty($value['image']) && file_exists(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $value['image'])) {
                    $value['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $value['image'];
                } else {
                    $value['image'] = '';
                }

                if ($module_info['rss']) {
                    $value['link_rss'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $module_info['alias']['rss'] . "/" . $value['alias'];
                }
                $array_data[$value['id']] = $value;
            }
        }
    }
}

$contents = nv_theme_test_main($indexfile, $array_data, $alias_page);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
