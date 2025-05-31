<?php

/**
 * @Project NUKEVIET 4.x
 * @Author hongoctrien (contact@mynukeviet.net)
 * @Copyright (C) 2016 hongoctrien. All rights reserved
 * @Createdate Wed, 27 Apr 2016 07:24:36 GMT
 */
if (!defined('NV_ADMIN'))
    die('Stop!!!');

global $array_premission;
require_once NV_ROOTDIR . '/modules/test/premission.functions.php';

if (!function_exists('nv_news_array_cat_admin')) {

    /**
     * nv_news_array_cat_admin()
     *
     * @return
     */
    function nv_news_array_cat_admin($module_data)
    {
        global $db_slave;

        $array_cat_admin = array();
        $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_admins ORDER BY userid ASC';
        $result = $db_slave->query($sql);

        while ($row = $result->fetch()) {
            $array_cat_admin[$row['userid']][$row['catid']] = $row;
        }

        return $array_cat_admin;
    }
}

$is_refresh = false;
$array_cat_admin = nv_news_array_cat_admin($module_data);

if (!empty($module_info['admins'])) {
    $module_admin = explode(',', $module_info['admins']);
    foreach ($module_admin as $userid_i) {
        if (!isset($array_cat_admin[$userid_i])) {
            $db->query('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_admins (userid, catid, admin, add_content, edit_content, del_content) VALUES (' . $userid_i . ', 0, 1, 1, 1, 1)');
            $is_refresh = true;
        }
    }
}
if ($is_refresh) {
    $array_cat_admin = nv_news_array_cat_admin($module_data);
}

$admin_id = $admin_info['admin_id'];
$NV_IS_ADMIN_MODULE = false;
$NV_IS_ADMIN_FULL_MODULE = false;
if (defined('NV_IS_SPADMIN')) {
    $NV_IS_ADMIN_MODULE = true;
    $NV_IS_ADMIN_FULL_MODULE = true;
} else {
    if (isset($array_cat_admin[$admin_id][0])) {
        $NV_IS_ADMIN_MODULE = true;
        if (intval($array_cat_admin[$admin_id][0]['admin']) == 2) {
            $NV_IS_ADMIN_FULL_MODULE = true;
        }
    }
}

$submenu['examinations'] = $nv_Lang->getModule('examinations');
$submenu['exams'] = $nv_Lang->getModule('exams');
$submenu['cat'] = $nv_Lang->getModule('cat');
$submenu['merge-exams&merge_opt_1=1'] = $nv_Lang->getModule('merge_exams');
$submenu['history'] = $nv_Lang->getModule('history');

if ($array_premission['bank']) {
    if ($global_config['question_bank_owns']) {
        $submenu['search_questions'] = $nv_Lang->getModule('bank');
    }
    $submenu['exams-config'] = $nv_Lang->getModule('exams_config');
}

if (defined('NV_IS_SPADMIN') || $NV_IS_ADMIN_FULL_MODULE) {

    if (!empty($global_config['aztest_questions_bank']) && defined('NV_CONFIG_DIR')) {
        $submenu['exams_bank'] = $nv_Lang->getModule('exams_bank');
    }

    // $submenu['exams_bank'] = $nv_Lang->getModule('exams_bank');

    $submenu['groups'] = $nv_Lang->getModule('groups');
    $submenu['topics'] = $nv_Lang->getModule('topics');
    // $submenu['tags'] = $nv_Lang->getModule('tags');

    $submenu['rating'] = $nv_Lang->getModule('rating');
    $submenu['sources'] = $nv_Lang->getModule('sources');
    if ($global_config['permissions_anagement']) {
        $submenu['admins'] = $nv_Lang->getModule('admin');
    }
    $submenu['econtent'] = $nv_Lang->getModule('econtent');
    $submenu['statistics_testing'] = $nv_Lang->getModule('statistics_testing');
    $submenu['config'] = $nv_Lang->getModule('config');
}
