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

// lay ID can chia se
$id = $nv_Request->get_int('id', 'get', 0);

// bat dau lay du lieu tu CSDL
$sql = 'SELECT id, exam_id, userid, begin_time, end_time, count_true, count_false, count_skeep, score FROM ' . NV_PREFIXLANG . '_' . $module_data . '_answer WHERE id=' . $id;
// thuc thi cau lenh
$result = $db->query($sql);
$info = $result->fetch();

// nếu không tồn tại bản ghi (có thể đã bị xóa khỏi lịch sử thi) thì chuyển về trang chính
if (!$info) {
    nv_redirect_location(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
}

// lay thong tin de thi
$exam_info = $db->query('SELECT id, title, alias, catid, hometext, rating, num_question, timer FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams WHERE id=' . $info['exam_id'])->fetch();
$info['percent'] = ($info['count_true'] * 100) / $exam_info['num_question'];
if ($exam_info['rating']) {
    
    $info['rating'] = nv_get_rating($info['percent']);
}

$exam_info['url_share'] = NV_MY_DOMAIN . nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=share&id=' . $id, true);

$exam_info['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_test_cat[$exam_info['catid']]['alias'] . '/' . $exam_info['alias'] . '-' . $exam_info['id'] . $global_config['rewrite_exturl'];

$info['photo'] = NV_BASE_SITEURL . 'themes/' . $module_info['template'] . '/images/' . $module_file . '/no_avatar.png';

// kiem tra thong tin tai khoan
if ($info['userid'] > 0) {
    
    // lay thong tin tin thanh vien
    $user_info = $db->query('SELECT userid, username, first_name, last_name, photo FROM ' . NV_USERS_GLOBALTABLE . ' WHERE userid=' . $info['userid'])->fetch();
    $info['fullname'] = nv_show_name_user($user_info['first_name'], $user_info['last_name'], $user_info['username']);
    
    if (!empty($user_info['photo']) and file_exists(NV_ROOTDIR . '/' . $user_info['photo'])) {
        $info['photo'] = NV_BASE_SITEURL . $user_info['photo'];
    }
    
    // Thiết lập ảnh đại diện sẽ hiển thị cùng link khi chia sẽ lên
    $meta_property['og:image'] = NV_MY_DOMAIN . $info['photo'];
} else {
    $info['fullname'] = $nv_Lang->getGlobal('guests');
}

// $page_title thiết lập giá trị tiêu đề trang, lấy bằng tiêu đề đề thi
$page_title = sprintf($nv_Lang->getModule('share_result'), $info['fullname'], $exam_info['title']);
$description = $exam_info['hometext'];

$xtpl = new XTemplate('share.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
$xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
$xtpl->assign('INFO', $info);
$xtpl->assign('EXAM_INFO', $exam_info);

if ($exam_info['rating']) {
    $xtpl->parse('main.rating');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents, false);
include NV_ROOTDIR . '/includes/footer.php';