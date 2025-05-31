<?php

/**
 * @Project NUKEVIET 4.x
 * @Author hongoctrien (contact@mynukeviet.net)
 * @Copyright (C) 2016 hongoctrien. All rights reserved
 * @Createdate Wed, 27 Apr 2016 07:24:36 GMT
 */
if (!defined('NV_SYSTEM')) die('Stop!!!');

define('NV_IS_MOD_TEST', true);

require_once NV_ROOTDIR . '/modules/' . $module_file . '/site.functions.php';
require_once NV_ROOTDIR . '/modules/' . $module_file . '/global.functions.php';

// Cấu hình Header để cho phép thu âm
$global_config['others_headers']['Feature-Policy'] = "microphone 'self'";

$examinations_subject = array();
if (!nv_user_in_groups($array_config['groups_use'])) {
    $op_file = $module_info['funcs'][$op]['func_name'];
    $contents = nv_theme_alert($nv_Lang->getModule('groups_use_title'), $nv_Lang->getModule('groups_use_content'), 'warning');
    include NV_ROOTDIR . '/includes/header.php';
    echo nv_site_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
}

$page = 1;
$per_page = $array_config['per_page'];
$alias_cat_url = isset($array_op[0]) ? $array_op[0] : '';

//$id gan id de phat hien khi vao xem chi tiet - su dung o block topscore
$id = $catid = 0;

if (!empty($array_test_cat)) {
    foreach ($array_test_cat as $index => $value) {
        $array_test_cat[$index]['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $value['alias'];
        if ($alias_cat_url == $value['alias']) {
            $catid = $index;
            $parentid = $value['parentid'];
        }
    }
}

$count_op = sizeof($array_op);
if (!empty($array_op) and $op == 'main') {
    $op = 'main';
    if ($count_op == 1 or substr($array_op[1], 0, 5) == 'page-') {
        if ($count_op > 1 or $catid > 0) {
            $op = 'viewcat';
            if (isset($array_op[1]) and substr($array_op[1], 0, 5) == 'page-') {
                $page = intval(substr($array_op[1], 5));
            }
        } elseif ($catid == 0) {
            $contents = $nv_Lang->getModule('nocatpage') . $array_op[0];
            if (isset($array_op[0]) and substr($array_op[0], 0, 5) == 'page-') {
                $page = intval(substr($array_op[0], 5));
            }
        }
    } elseif ($count_op == 2) {
        //kiểm tra xem có phải là một kỳ thi không
        $db->sqlreset()
        ->select('t2.id')
        ->from(NV_PREFIXLANG . '_' . $module_data . '_examinations AS t1')
        ->join(
            'INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_exam_subject AS t2 ON t1.id = t2.exam_id '  
        )
        ->where('t1.alias = "' . $array_op[0] . '" AND t2.alias = "' . $array_op[1] . '"');
        list($exam_subject_id) = $db->query($db->sql())->fetch(3);
        $op = !empty($exam_subject_id) ? 'detail' : $op;
    }

    if (empty($exam_subject_id) && ($count_op == 2) && ($op == 'main')) {
        $array_page = explode('-', $array_op[1]);
        $id = intval(end($array_page));
        $number = strlen($id) + 1;
        $alias_url = substr($array_op[1], 0, -$number);
        if ($id > 0 and $alias_url != '') {
            if ($catid > 0) {
                $op = 'detail';
            } else {
                // muc tieu neu xoa chuyen muc cu hoac doi ten alias chuyen muc thi van rewrite duoc bai viet
                $_row = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams WHERE id = ' . $id)->fetch();
                if (!empty($_row) and isset($array_test_cat[$_row['catid']])) {
                    $url_Permanently = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_test_cat[$_row['catid']]['alias'] . '/' . $_row['alias'] . '-' . $_row['id'] . $global_config['rewrite_exturl'], true);
                    header("HTTP/1.1 301 Moved Permanently");
                    header('Location:' . $url_Permanently);
                    exit();
                }
            }
        }
    }

    $parentid = $catid;
    while (($parentid > 0) && !empty($array_test_cat[$parentid])) {
        $array_cat_i = $array_test_cat[$parentid];
        $array_mod_title[] = array(
            'catid' => $parentid,
            'title' => $array_cat_i['title'],
            'link' => $array_cat_i['link']
        );
        $parentid = $array_cat_i['parentid'];
    }
    krsort($array_mod_title, SORT_NUMERIC);
}

function nv_exams_groups_list()
{
    global $db, $global_config, $lang_global;

    $groups_list = array();

    $resul = $db->query('SELECT group_id, title, description, group_type, exp_time, numbers FROM ' . NV_GROUPS_GLOBALTABLE . ' WHERE act=1 AND (idsite = ' . $global_config['idsite'] . ' OR (idsite =0 AND siteus = 1)) ORDER BY idsite, weight');
    while ($row = $resul->fetch()) {
        if (($row['exp_time'] == 0 or $row['exp_time'] > NV_CURRENTTIME)) {
            if ($row['group_id'] < 9) {
                $row['title'] = $lang_global['level' . $row['group_id']];
            }
            $groups_list[$row['group_id']] = $row;
        }
    }

    return $groups_list;
}



function nv_unset_session()
{
    global $nv_Request, $module_data;

    $nv_Request->unset_request($module_data . '_testing', 'session');
    $nv_Request->unset_request($module_data . '_examinations_subject', 'session');
}