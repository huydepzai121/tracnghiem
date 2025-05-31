<?php

/**
 * @Project NUKEVIET 4.x
 * @Author hongoctrien (contact@mynukeviet.net)
 * @Copyright (C) 2016 hongoctrien. All rights reserved
 * @Createdate Wed, 27 Apr 2016 07:24:36 GMT
 */


if (!defined('NV_ADMIN') or !defined('NV_MAINFILE') or !defined('NV_IS_MODADMIN')) {
    die('Stop!!!');
}

define('NV_IS_FILE_ADMIN', true);
define('NV_IS_MOD_TEST', true);
define('MAX_FILE_SIZE', 60000000);
require_once NV_ROOTDIR . '/modules/' . $module_file . '/global.functions.php';

$spadmin_allow_func = array();
$allow_func = array(
    'main',
    'question',
    'question-list',
    'question-content',
    'examinations',
    'examinations-content',
    'exam-subject',
    'random_exam',
    'random_question',
    'random_exam_content',
    'random_question_content',
    'exams',
    'exams-content',
    'history',
    'history-view',
    'sendapprov',
    'publtime',
    'detail',
    'view',
    'statistics_testing',
    'search_questions',
    'ajax',
    'merge-exams',
);

$allow_func[] = 'questionword';
$allow_func[] = 'questionexcel';
$allow_func[] = 'result_exam';
$allow_func[] = 'exams_bank';

if ($global_config['aztest_questions_bank'] !== FALSE) {
    $allow_func[] = 'exams_bank_cats';
    $allow_func[] = 'exams_bank_content';
}

if ($array_premission['bank']) {
    if ($global_config['question_bank_owns']) {
        $allow_func[] = 'bank';
    }
    if ($global_config['question_bank_owns'] && !empty($global_config['idsite'])) {
        $allow_func[] = 'bank_list';
    }
    $allow_func[] = 'exams-config';
    $allow_func[] = 'exams-config-content';
    $allow_func[] = 'exams-config-bank';
    $allow_func[] = 'exams-config-content-bank';
}

if ($NV_IS_ADMIN_MODULE) {
    define('NV_IS_ADMIN_MODULE', true);
}

if ($NV_IS_ADMIN_FULL_MODULE) {
    define('NV_IS_ADMIN_FULL_MODULE', true);
}

if (defined('NV_IS_SPADMIN') || $NV_IS_ADMIN_FULL_MODULE) {
    $spadmin_allow_func = array(
        'cat',
        'change_cat',
        'config',
        'topicsnews',
        'topics',
        'topicdelnews',
        'addtotopics',
        'change_topic',
        'list_topic',
        'del_topic',
        'tags',
        'block',
        'chang_block_cat',
        'change_block',
        'list_block_cat',
        'list_block',
        'groups',
        'econtent',
        'rating',
        'sources',
        'update-bank-cat',
    );
    if ($global_config['permissions_anagement']) {
        $spadmin_allow_func[] = 'admins';
    }
}
$allow_func = array_merge($allow_func, $spadmin_allow_func);

// $ck_editor_word Được sử dụng để hỗ trợ xuất file word từ ckeditor
require_once NV_ROOTDIR . '/modules/test/ck_editor_word.php';
$ck_editor_word = new NukeNukeViet\Module\test\ck_editor_word();
$ck_editor_word->addHeader(
    'Phần mềm tạo đề thi trắc nghiệm trực tuyến AZtest.vn',
    array(
        'size' => 10,
        'name' => 'Times New Roman',
    ),
    array(
        'alignment' => 'center'
    )
);
require_once NV_ROOTDIR . '/modules/test/import_word_to_exam.php';
$import_word_to_exam = new NukeNukeViet\Module\test\import_word_to_exam();
/**
 * Kiểm tra với chức năng hiện tại thì đang ở chế độ tắt hay mở thông báo.
 */
$turn_off_msg = $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_noview_msg WHERE userid = ' . $admin_info['userid'] . ' AND func ="' . $op . '"')->fetchColumn();
/**
 * Bật/Tắt thông báo ở phần chức năng
 */
if ($nv_Request->isset_request('turn_on_off_msg', 'get')) {
    $status = $nv_Request->get_title('status', 'post', 'on');
    $func = $nv_Request->get_title('func', 'post', 0);
    if ($status == 'on') {
        $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_noview_msg WHERE userid = ' . $admin_info['userid'] . ' AND func ="' . $func . '"');
        exit('on');
    } else {
        $db->query('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_noview_msg(userid, func) VALUES(' . $admin_info['userid'] . ',"' . $func . '" )');
        exit('off');
    }
}

// Ngân hàng đề thi
/**
 * Kiểm tra $new_parentid có trùng với một id của chủ đề con nào không.
 * Đề phòng trường hợp khi thay đổi chủ đề mẹ thì chọn luôn chủ đề con của nó.
 * @param $id là của chủ đề được cập nhật chủ đề mẹ
 * @param $new_parentid là chủ đề mẹ mà chủ đề hiện tại đang thay đổi.
 * @duplicate_child hãy để mặt định là false không thay đổi
 */

function func_check_duplicate_child($id, $new_parentid, $duplicate_child = false)
{
    global $db;
    if (!$duplicate_child) {
        $result = $db->query('SELECT id FROM ' . tableSystem . '_exams_bank_cats WHERE parentid = "' . $id . '"');
        while ((list($id) = $result->fetch(3)) && !$duplicate_child) {
            $duplicate_child = $duplicate_child || ($id == $new_parentid);
            $duplicate_child = $duplicate_child || func_check_duplicate_child($id, $new_parentid, $duplicate_child);
        }
    }
    return $duplicate_child;
}
/**
 * Lấy tất cả chủ đề con cháu của một chủ đề trong danh sách các chủ đề
 */
function get_childrent_cat($array_exams_bank_cats, $id)
{
    $array_childrent = array();
    foreach ($array_exams_bank_cats as $cat) {
        if ($cat['parentid'] == $id) {
            $array_childrent[] = $cat['id'];
            $array_child =  get_childrent_cat($array_exams_bank_cats, $cat['id']);
            $array_childrent = array_merge($array_childrent, $array_child);
        }
    }
    return $array_childrent;
}
/**
 * Lấy điều hướng cho một chủ đề (các chủ đề ông cha của nó)
 */
function get_nav_child_cat($parentid)
{
    global $array_exams_bank_cats_origin;
    $nav_cats = array();
    $parent_cat = $parentid;
    while (!empty($parent_cat)) {
        $nav_cats[] = $array_exams_bank_cats_origin[$parent_cat]['id'];
        $parent_cat = $array_exams_bank_cats_origin[$parent_cat]['parentid'];
    }
    $nav_cats[] = 0;
    return array_reverse($nav_cats);
}
/**
 * Loại bỏ chủ đề được chọn và con cháu của nó.
 * Chỉ áp dụng đối với mãng đã được xắp xếp theo hàm convert_tree_to_flat
 */
function remove_child_cat($array_bank_cats_clone, $id)
{
    reset($array_bank_cats_clone);
    $current_cat = current($array_bank_cats_clone);
    while (!empty($current_cat['id']) && ($current_cat['id'] != $id)) {
        $current_cat = next($array_bank_cats_clone);
    }
    $level_index = $current_cat['level'];
    unset($array_bank_cats_clone[$current_cat['id']]);

    $current_cat = current($array_bank_cats_clone);
    while ($current_cat && ($current_cat['level'] > $level_index)) {
        unset($array_bank_cats_clone[$current_cat['id']]);
        $current_cat = current($array_bank_cats_clone);
    };
    return $array_bank_cats_clone;
}
/**
 * Chuyển đổi một cây các chủ đề dạng chủ đề mẹ và chủ đề con ở propty children.
 * thành các chủ đề ngang hàng
 */
function convert_tree_to_flat($array_exams_bank_cats_tree)
{
    $array_exams_bank_cats_flat = array();
    foreach ($array_exams_bank_cats_tree as $item) {
        $array_exams_bank_cats_flat[$item['id']] = array(
            'id' => $item['id'],
            'title' => $item['title'],
            'title_level' => $item['title_level'],
            'num_child' => $item['num_child'],
            'level' => $item['level'],
            'parentid' => $item['parentid'],
            'status' => $item['status'],
            'weight' => $item['weight'],
        );
        if (!empty($item['children'])) {
            $child_flat = convert_tree_to_flat($item['children']);
            foreach ($child_flat as $child) {
                $array_exams_bank_cats_flat[$child['id']] = $child;
            }
        }
    }
    return $array_exams_bank_cats_flat;
}
/**
 * Đưa các chủ đề vào cây chủ đề đúng thứ tự
 */
function get_cats_tree($array_keys_cats, $parent_id = 0, $level = 0)
{
    global $array_exams_bank_cats_origin;
    $array_exams_bank_cats_tree = array();
    foreach ($array_keys_cats as $key) {
        $item = $array_exams_bank_cats_origin[$key];
        if (($item['parentid'] == $parent_id)) {
            $item['level'] = $level;
            $item['title_level'] = $item['title'];
            if ($level > 0) {
                $item['title_level'] = '--> ' . $item['title'];
                for ($i = 0; $i < $item['level']; $i++) {
                    $item['title_level'] = '--' . $item['title_level'];
                }
                $item['title_level'] = '|' . $item['title_level'];
            }
            $array_keys_cats = array_diff($array_keys_cats, array($item['id']));
            $item['children'] = get_cats_tree($array_keys_cats, $item['id'], $level + 1);
            $item['num_child'] = count($item['children']);
            $array_exams_bank_cats_tree[$item['id']] = $item;
            $array_keys_cats = array_diff($array_keys_cats, array_keys($item['children']));
        };
    }
    return $array_exams_bank_cats_tree;
}
$_sql = 'SELECT * FROM ' . tableSystem . '_exams_bank_cats ORDER BY parentid, weight';
$array_exams_bank_cats_origin = $nv_Cache_main->db($_sql, 'id', $module_name);
/**
 * $array_keys_cats là một array đánh dấu để loại bỏ nhưng cat đã đưa vào $array_exams_bank_cats_tree
 * khắc phục trường hợp cat cha lại có parentid lại chỉ vào con, cháu của nó.
 */
$array_keys_cats = array_keys($array_exams_bank_cats_origin);
$array_exams_bank_cats_tree = get_cats_tree($array_keys_cats);
$array_exams_bank_cats = convert_tree_to_flat($array_exams_bank_cats_tree);
$array_question_type = array(
    1 => $nv_Lang->getModule('question_type_1'),
    2 => $nv_Lang->getModule('question_type_2'),
    3 => $nv_Lang->getModule('question_type_3'),
    4 => $nv_Lang->getModule('question_type_4'),
    5 => $nv_Lang->getModule('question_type_5'),
    6 => $nv_Lang->getModule('question_type_6'),
    7 => $nv_Lang->getModule('question_type_7'),
);

//Document
$array_url_instruction['exams'] = 'https://aztest.vn/huong-dan-su-dung/huong-dan-tao-de-thi-tren-he-thong-trac-nghiem-aztest-28.html';
$array_url_instruction['cat'] = 'https://aztest.vn/huong-dan-su-dung/huong-dan-cach-thiet-lap-va-quan-ly-chu-de-30.html';
$array_url_instruction['history'] = 'https://aztest.vn/huong-dan-su-dung/huong-dan-xem-lai-lich-su-thi-34.html';
$array_url_instruction['exams-content'] = 'https://aztest.vn/huong-dan-su-dung/huong-dan-tao-de-thi-tren-he-thong-trac-nghiem-aztest-28.html';
$array_url_instruction['config'] = 'https://docs.aztest.vn/cau-hinh/';
$array_url_instruction['rating'] = 'https://docs.aztest.vn/xep-loai/';
$array_url_instruction['admins'] = 'https://docs.aztest.vn/phan-quyen-quan-ly/';
$array_url_instruction['questionword'] = 'https://docs.aztest.vn/huong-dan-mo-rong/nhap-cau-hoi-tu-microsoftword/';
$array_url_instruction['question'] = 'https://docs.aztest.vn/de-thi/#quan-ly-e-thi';

if ($global_config['idsite'] > 0) {
    $time_set = $nv_Request->get_int($module_data . '_' . $global_config['idsite'] . '_lasttime', 'session');
    if (empty($time_set)) {
        $nv_Request->set_Session($module_data . '_' . $global_config['idsite'] . '_lasttime', NV_CURRENTTIME);
        $db->query('UPDATE ' . $db_config['dbsystem'] . '.' . $db_config['prefix'] . '_site SET lasttime=' . NV_CURRENTTIME . ' WHERE idsite=' . $global_config['idsite']);
    }
}
function list_template_bank_type($data = null)
{
    global $global_config, $nv_Lang, $array_bank_type, $module_file, $module_data, $db_config, $db;
    $contents = '';
    $total = 0;
    $xtpl = new XTemplate('list_template_bank_type.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
     $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('id', mt_rand(100000, 999999));
    if (empty($data)) {
        $data['class_id'] = 0;
        $data['cat_id'] = 0;
        $data['sum'] = array();
        foreach ($array_bank_type as $id => $bank_type) {
            $data['sum'][$bank_type['id']] = 0;
        }
    }
    $xtpl->assign('class_id', $data['class_id']);
    $xtpl->assign('cat_id', $data['cat_id']);

    if (!empty($data['class_id'])) {
        $db->sqlreset()
            ->select('id, title')
            ->from($db_config['dbsystem'] . "." . NV_PREFIXLANG . '_' . $module_data . '_bank')
            ->where('id = ' . $data['class_id']);
        list($class_id, $class_text) = $db->query($db->sql())->fetch(3);
        $xtpl->assign('class_id', $class_id);
        $xtpl->assign('class_text', $class_text);
        $xtpl->parse('main.class_id');
    }
    if (!empty($data['cat_id'])) {
        $db->sqlreset()
            ->select('id, title')
            ->from($db_config['dbsystem'] . "." . NV_PREFIXLANG . '_' . $module_data . '_bank')
            ->where('id = ' . $data['cat_id']);
        list($cat_id, $cat_text) = $db->query($db->sql())->fetch(3);
        $xtpl->assign('cat_id', $cat_id);
        $xtpl->assign('cat_text', $cat_text);
        $xtpl->parse('main.cat_id');
    }
    foreach ($array_bank_type as $id => $bank_type) {
        $total +=  $data['sum'][$bank_type['id']];
        $xtpl->assign('COUNT_MAX', 0);
        $xtpl->assign('value', $data['sum'][$bank_type['id']]);
        $xtpl->assign('BANK_TYPE', $bank_type);
        $xtpl->assign('not_none', $data['sum'][$bank_type['id']] > 0 ? '' : "style=\"display:none\"");
        $xtpl->assign('had_none', $data['sum'][$bank_type['id']] == 0 ? '' : "style=\"display:none\"");
        $xtpl->parse('main.bank_type');
    }
    $xtpl->assign('TOTAL', $total);
    $xtpl->parse('main');
    $contents = $xtpl->text('main');
    return $contents;
}

/**
 * nv_fix_order()
 *
 * @param integer $parentid
 * @param integer $order
 * @param integer $lev
 * @return
 *
 */
function nv_fix_order($table_name, $parentid = 0, $sort = 0, $lev = 0)
{
    global $db, $db_config, $module_data;

    $sql = 'SELECT id, parentid FROM ' . $table_name . ' WHERE parentid=' . $parentid . ' ORDER BY weight ASC';
    $result = $db->query($sql);
    $array_order = array();
    while ($row = $result->fetch()) {
        $array_order[] = $row['id'];
    }
    $result->closeCursor();
    $weight = 0;
    if ($parentid > 0) {
        ++$lev;
    } else {
        $lev = 0;
    }
    foreach ($array_order as $order_i) {
        ++$sort;
        ++$weight;

        $sql = 'UPDATE ' . $table_name . ' SET weight=' . $weight . ', sort=' . $sort . ', lev=' . $lev . ' WHERE id=' . $order_i;
        $db->query($sql);

        $sort = nv_fix_order($table_name, $order_i, $sort, $lev);
    }

    $numsub = $weight;

    if ($parentid > 0) {
        $sql = "UPDATE " . $table_name . " SET numsub=" . $numsub;
        if ($numsub == 0) {
            $sql .= ",subid=''";
        } else {
            $sql .= ",subid='" . implode(",", $array_order) . "'";
        }
        $sql .= " WHERE id=" . intval($parentid);
        $db->query($sql);
    }
    return $sort;
}

function nv_eraser_question($table, $id)
{
    global $db, $module_data;

    $question_info = $db->query('SELECT * FROM ' . $table . ' WHERE id = ' . $id)->fetch();

    if ($question_info) {
        // làm rỗng nội dung tiêu đề, đáp án, lời giải
        $count = $db->exec('UPDATE ' . $table . ' SET title="", type=1, answer="", useguide = "" WHERE id = ' . $id);
        if ($count) {
            nv_exam_question_status($question_info['examid']);
        }
        return 1;
    }
    return 0;
}

function nv_delete_question($table_exams, $table_question, $id, $exam_id = 0)
{
    global $db, $module_data,  $db_config, $module_name, $nv_Lang, $admin_info;
    if (empty($id) && !empty($exam_id)) {
        $db->query('UPDATE ' . $table_exams . ' SET num_question=num_question-1 WHERE id=' . $exam_id);
        nv_exam_question_status($exam_id);
        return true;
    } else {
        $rows = $db->query('SELECT * FROM ' . $table_question . ' WHERE id=' . $id)->fetch();
        /*
        * chỉ cho phép xóa câu khi câu đó tồn tại và không thuộc bất cứ kỳ thi nào
        */
        if ($rows && empty($rows['examinationsid'])) {
            $count = $db->exec('DELETE FROM ' . $table_question . ' WHERE id = ' . $id);
            if ($count) {
                nv_insert_logs(NV_LANG_DATA, $module_name, $nv_Lang->getModule('del_question'), $nv_Lang->getModule('question') . " (id:#" . $id . ")", $admin_info['userid']);
                // xóa khỏi bảng đề thi
                $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams_question WHERE questionid = ' . $id);

                if ($rows['examid'] > 0) {
                    // Cập nhật lại số câu hỏi đề thi
                    $db->query('UPDATE ' . $table_exams . ' SET num_question=num_question-1 WHERE id=' . $rows['examid']);

                    // Cập nhật sắp xếp câu hỏi trong đề
                    $sql = 'SELECT id, examid, weight FROM ' . $table_question . ' WHERE examid=' . $rows['examid'] . ' ORDER BY weight';
                    $result = $db->query($sql);
                    $array_order = array();
                    while ($row = $result->fetch()) {
                        $array_order[] = $row['id'];
                    }
                    $result->closeCursor();
                    $weight = 0;

                    foreach ($array_order as $order_i) {
                        ++$weight;
                        $sql = 'UPDATE ' . $table_question . ' SET weight=' . $weight . ' WHERE id=' . $order_i;
                        $db->query($sql);
                    }
                }
                nv_exam_question_status($rows['examid']);
                // nếu câu hỏi được đưa từ site con lên mà chưa được xác thực thì giảm tổng số câu hỏi chờ duyệt
                if (!empty($rows['idsite'])) {
                    /*xử lý ở server website con */
                    list($dbsite) = $db->query('SELECT dbsite FROM ' . $db_config['dbsystem'] . '.' . $db_config['prefix'] . '_site WHERE idsite = ' . $rows['idsite'])->fetch(3);
                    $db->query('UPDATE '  . $dbsite . "." . $table_question . ' SET  status= 0 WHERE id=' . $rows['idsq']);
                }
                if (!empty($rows['idsite']) && $rows['status'] != 10) {
                    $typeid_main = $rows['typeid'];
                    while (!empty($typeid_main)) {
                        $db->query('UPDATE ' . $db_config['dbsystem'] . "." . NV_PREFIXLANG . '_' . $module_data . '_bank SET num_req = num_req - 1 WHERE id=' . $typeid_main);
                        list($typeid_main) = $db->query('SELECT parentid FROM ' .  $db_config['dbsystem'] . "." . NV_PREFIXLANG . '_' . $module_data . '_bank WHERE id = ' . $typeid_main)->fetch(3);
                    }
                }

                return true;
            }
        } elseif ($rows && !empty($rows['examinationsid'])) {
            return $rows['examinationsid'];
        }
    }
    return false;
}

function nv_delete_exams_config($id)
{
    global $db, $module_data, $module_name, $nv_Lang, $admin_info;

    $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams_config WHERE id=' . $id);
    nv_insert_logs(NV_LANG_DATA, $module_name, $nv_Lang->getModule('exams_config_del'), $nv_Lang->getModule('exams_config') . ": #" . $id, $admin_info['userid']);
}

function nv_delete_exams_answer($id)
{
    global $db, $module_data;

    // xoa cau tra loi
    $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_answer WHERE id=' . $id);
}

function nv_sort_by_value($a, $b)
{
    $p1 = $a['count_answer_true'];
    $p2 = $b['count_answer_true'];
    return (int) $p1 < (float) $p2;
}

function nv_getClosestValue($search, $arr)
{
    $closest = array();
    foreach ($arr as $index => $item) {
        if (empty($closest) || abs($search - $closest['value']) > abs($item - $search)) {
            $closest['index'] = $index;
            $closest['value'] = $item;
        }
    }
    return $closest;
}

function nv_exams_delete($table_exams, $table_question, $exam_id)
{
    global $db, $db_config, $module_data, $module_name, $nv_Lang,  $admin_info;
    list($title) = $db->query('SELECT title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams WHERE id = ' . $exam_id)->fetch(3);
    $count = $db->exec('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams WHERE id = ' . $exam_id);
    if ($count) {
        nv_insert_logs(NV_LANG_DATA, $module_name, $nv_Lang->getModule('delete_exams'), $nv_Lang->getModule('exams') . ": " . $title, $admin_info['userid']);
        // xóa khỏi nhóm đề thi
        $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block WHERE id = ' . $exam_id);

        // xóa lịch sử thi
        $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_answer WHERE exam_id = ' . $exam_id);

        // xóa câu hỏi
        $result = $db->query('SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_question WHERE examid=' . $exam_id);
        while (list($questionid) = $result->fetch(3)) {
            nv_delete_question($table_exams, $table_question, $questionid, $exam_id);
        }

        // xóa khỏi đề thi đã lưu
        $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_usersave WHERE examid = ' . $exam_id);


        // giảm câu hỏi trong thống kê lượt sử dụng câu hỏi
        $result = $db->query('SELECT questionid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams_question WHERE examsid = ' . $exam_id);
        while (list($questionid) = $result->fetch(3)) {
            $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_question SET total_use= total_use-1 WHERE id = ' . $questionid);
        }
        // xóa câu hỏi được chỉ định vào đề thi ở ngân hàng đề thi
        $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams_question WHERE examsid = ' . $exam_id);
    }
}

/**
 * nv_fix_topic()
 *
 * @return
 *
 */
function nv_fix_topic()
{
    global $db, $module_data;
    $sql = 'SELECT topicid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_topics ORDER BY weight ASC';
    $result = $db->query($sql);
    $weight = 0;
    while ($row = $result->fetch()) {
        ++$weight;
        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_topics SET weight=' . $weight . ' WHERE topicid=' . intval($row['topicid']);
        $db->query($sql);
    }
    $result->closeCursor();
}

/**
 * nv_show_topics_list()
 *
 * @return
 *
 */
function nv_show_topics_list($page = 1)
{
    global $db, $nv_Lang, $lang_global, $module_name, $module_data, $module_config, $global_config, $module_file, $module_info;

    $per_page = 20;
    $db->sqlreset()
        ->select('COUNT(*)')
        ->from(NV_PREFIXLANG . '_' . $module_data . '_topics');

    $num_items = $db->query($db->sql())
        ->fetchColumn();

    $db->select('*')
        ->order('weight ASC')
        ->limit($per_page)
        ->offset(($page - 1) * $per_page);
    $_array_topic = $db->query($db->sql())
        ->fetchAll();
    $num = sizeof($_array_topic);

    if ($num > 0) {
        $xtpl = new XTemplate('topics_list.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
         $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
        $xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
        foreach ($_array_topic as $row) {
            $numnews = $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams where topicid=' . $row['topicid'])->fetchColumn();
            $xtpl->assign('ROW', array(
                'topicid' => $row['topicid'],
                'description' => $row['description'],
                'title' => $row['title'],
                'link' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=topicsnews&amp;topicid=' . $row['topicid'],
                'linksite' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['topic'] . '/' . $row['alias'],
                'numnews' => $numnews,
                'url_edit' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=topics&amp;topicid=' . $row['topicid'] . '#edit'
            ));

            for ($i = ($page - 1) * $per_page; $i <= $page * $per_page; ++$i) {
                $xtpl->assign('WEIGHT', array(
                    'key' => $i,
                    'title' => $i,
                    'selected' => $i == $row['weight'] ? ' selected="selected"' : ''
                ));
                $xtpl->parse('main.loop.weight');
            }

            $xtpl->parse('main.loop');
        }

        $xtpl->parse('main');
        $contents = $xtpl->text('main');
        $contents .= nv_generate_page(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=topics', $num_items, $per_page, $page);
    } else {
        $contents = '&nbsp;';
    }
    return $contents;
}

/**
 * get_mod_alias()
 *
 * @param mixed $title
 * @param string $mod
 * @param integer $id
 * @return
 *
 */
function get_mod_alias($title, $mod = '', $id = 0)
{
    global $module_data, $module_config, $module_name, $db, $db;

    if (empty($title)) {
        return '';
    }

    $alias = change_alias($title);
    $alias = strtolower($alias);
    $id = intval($id);

    if ($mod == 'topics') {
        $tab = NV_PREFIXLANG . '_' . $module_data . '_topics';
        $stmt = $db->prepare('SELECT COUNT(*) FROM ' . $tab . ' WHERE topicid!=' . $id . ' AND alias= :alias');
        $stmt->bindParam(':alias', $alias, PDO::PARAM_STR);
        $stmt->execute();
        $nb = $stmt->fetchColumn();
        if (!empty($nb)) {
            $nb = $db->query('SELECT MAX(topicid) FROM ' . $tab)->fetchColumn();

            $alias .= '-' . (intval($nb) + 1);
        }
    } elseif ($mod == 'blockcat') {
        $tab = NV_PREFIXLANG . '_' . $module_data . '_block_cat';
        $stmt = $db->prepare('SELECT COUNT(*) FROM ' . $tab . ' WHERE bid!=' . $id . ' AND alias= :alias');
        $stmt->bindParam(':alias', $alias, PDO::PARAM_STR);
        $stmt->execute();
        $nb = $stmt->fetchColumn();
        if (!empty($nb)) {
            $nb = $db->query('SELECT MAX(bid) FROM ' . $tab)->fetchColumn();

            $alias .= '-' . (intval($nb) + 1);
        }
    }

    return $alias;
}

/**
 * nv_show_groups_list()
 *
 * @return
 *
 */
function nv_show_groups_list()
{
    global $db, $db_config, $nv_Lang, $lang_global, $module_name, $module_data, $op, $module_file, $global_config, $module_info;

    $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block_cat ORDER BY weight ASC';
    $_array_block_cat = $db->query($sql)->fetchAll();
    $num = sizeof($_array_block_cat);

    if ($num > 0) {
        $array_useradd = $array_adddefault = array(
            $nv_Lang->getGlobal('no'),
            $nv_Lang->getGlobal('yes')
        );

        $xtpl = new XTemplate('blockcat_lists.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
        $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
        $xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);

        foreach ($_array_block_cat as $row) {
            $numnews = $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block where bid=' . $row['bid'])->fetchColumn();
            $xtpl->assign('ROW', array(
                'bid' => $row['bid'],
                'title' => $row['title'],
                'numnews' => $numnews,
                'link' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=block&amp;bid=' . $row['bid'],
                'linksite' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['groups'] . '/' . $row['alias'],
                'url_edit' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;bid=' . $row['bid'] . '#edit'
            ));

            for ($i = 1; $i <= $num; ++$i) {
                $xtpl->assign('WEIGHT', array(
                    'key' => $i,
                    'title' => $i,
                    'selected' => $i == $row['weight'] ? ' selected="selected"' : ''
                ));
                $xtpl->parse('main.loop.weight');
            }

            foreach ($array_adddefault as $key => $val) {
                $xtpl->assign('ADDDEFAULT', array(
                    'key' => $key,
                    'title' => $val,
                    'selected' => $key == $row['adddefault'] ? ' selected="selected"' : ''
                ));
                $xtpl->parse('main.loop.adddefault');
            }

            for ($i = 1; $i <= 30; ++$i) {
                $xtpl->assign('NUMBER', array(
                    'key' => $i,
                    'title' => $i,
                    'selected' => $i == $row['numbers'] ? ' selected="selected"' : ''
                ));
                $xtpl->parse('main.loop.number');
            }

            $xtpl->parse('main.loop');
        }

        $xtpl->parse('main');
        $contents = $xtpl->text('main');
    } else {
        $contents = '&nbsp;';
    }

    return $contents;
}

/**
 * nv_fix_block_cat()
 *
 * @return
 *
 */
function nv_fix_block_cat()
{
    global $db, $db_config, $module_data;

    $sql = 'SELECT bid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block_cat ORDER BY weight ASC';
    $weight = 0;
    $result = $db->query($sql);
    while ($row = $result->fetch()) {
        ++$weight;
        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_block_cat SET weight=' . $weight . ' WHERE bid=' . intval($row['bid']);
        $db->query($sql);
    }
    $result->closeCursor();
}

/**
 * nv_show_block_list()
 *
 * @param mixed $bid
 * @return
 *
 */
function nv_show_block_list($bid)
{
    global $db, $db_config, $nv_Lang, $lang_global, $module_name, $module_data, $op, $module_file, $global_config, $array_test_cat;

    $xtpl = new XTemplate('block_list.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('GLANG', \NukeViet\Core\Language::$lang_global);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('OP', $op);
    $xtpl->assign('BID', $bid);

    $array_jobs[0] = array(
        'alias' => 'Other'
    );

    $sql = 'SELECT t1.id, t1.catid, title, alias, t2.weight FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams t1 INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_block t2 ON t1.id = t2.id WHERE t2.bid= ' . $bid . ' AND t1.status=1 ORDER BY t2.weight ASC';
    $array_block = $db->query($sql)->fetchAll();

    $num = sizeof($array_block);
    if ($num > 0) {
        foreach ($array_block as $row) {
            $xtpl->assign('ROW', array(
                'id' => $row['id'],
                'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_test_cat[$row['catid']]['alias'] . '/' . $row['alias'] . '-' . $row['id'] . $global_config['rewrite_exturl'],
                'title' => $row['title']
            ));

            for ($i = 1; $i <= $num; ++$i) {
                $xtpl->assign('WEIGHT', array(
                    'key' => $i,
                    'title' => $i,
                    'selected' => $i == $row['weight'] ? ' selected="selected"' : ''
                ));
                $xtpl->parse('main.loop.weight');
            }

            $xtpl->parse('main.loop');
        }

        $xtpl->parse('main');
        $contents = $xtpl->text('main');
    } else {
        $contents = '&nbsp;';
    }

    return $contents;
}

/**
 * nv_fix_block()
 *
 * @param mixed $bid
 * @param bool $repairtable
 * @return
 *
 */
function nv_fix_block($bid, $repairtable = true)
{
    global $db, $db_config, $module_data;
    $bid = intval($bid);
    if ($bid > 0) {
        $sql = 'SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block where bid=' . $bid . ' ORDER BY weight ASC';
        $result = $db->query($sql);
        $weight = 0;
        while ($row = $result->fetch()) {
            ++$weight;
            if ($weight <= 100) {
                $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_block SET weight=' . $weight . ' WHERE bid=' . $bid . ' AND id=' . $row['id'];
            } else {
                $sql = 'DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block WHERE bid=' . $bid . ' AND id=' . $row['id'];
            }

            $db->query($sql);
        }
        $result->closeCursor();
        if ($repairtable) {
            $db->query('OPTIMIZE TABLE ' . NV_PREFIXLANG . '_' . $module_data . '_block');
        }
    }
}

function nvConvertToLatex($string)
{
    // xu ly text chuyen sang code latex image url
    $imageMatch = array();
    $filter = '#\[(.*)\\\]#imsU';
    preg_match_all($filter, $string, $_result);
    foreach ($_result[0] as $key => $_tagimg) {
        $new_imageSrc = 'http://latex.codecogs.com/svg.latex?' . rawurlencode(nv_unhtmlspecialchars($_result[1][$key]));
        $string = str_replace('\\' . $_tagimg, '<img src="' . $new_imageSrc . '" />', $string);
    }

    $filter = '#\$(.*)\$#imsU';
    preg_match_all($filter, $string, $_result);
    foreach ($_result[0] as $key => $_tagimg) {
        $new_imageSrc = 'http://latex.codecogs.com/svg.latex?' . rawurlencode(nv_unhtmlspecialchars($_result[1][$key]));
        $string = str_replace($_tagimg, '&nbsp;<img src="' . $new_imageSrc . '" />', $string);
    }
    return $string;
}

function nv_test_read_msword_new($fileword, $examid)
{
    global $import_word_to_exam, $module_data, $nv_Request, $nv_Lang, $array_bank_type;
    $import_word_to_exam->setFile($fileword);
    $import_word_to_exam->start();
    $array_question = $import_word_to_exam->parseQuestionForExam();
    $nv_Request->set_Session($module_data . '_array_question', serialize($array_question));

    return $array_question;
}
/**
 * Function này cũ để lại coi sau có cần dùng gì không
 */
function nv_test_read_msword_old($fileword, $examid)
{
    global $module_data, $nv_Request, $nv_Lang, $array_bank_type;

    $temp_file = NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $module_data . '_import_' . md5($fileword) . '.html';
    require_once(NV_ROOTDIR . '/modules/test/simple_html_dom.php');

    $phpWord = \PhpOffice\PhpWord\IOFactory::load($fileword);
    $htmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
    $htmlWriter->save($temp_file);

    $html = file_get_html($temp_file);
    $all_p_tags = $html->find('p');

    $array_question = array(
        'data' => array(),
        'error' => 0
    );
    $images = array();
    $count_image = 1;
    $index_image = $count_elemt = 0;
    $str = '';

    foreach ($phpWord->getSections() as $section) {
        $arrays = $section->getElements();
        foreach ($arrays as $e) {
            if (get_class($e) === 'PhpOffice\PhpWord\Element\TextRun') {
                $i = 0;
                foreach ($e->getElements() as $text) {
                    if (get_class($text) === 'PhpOffice\PhpWord\Element\Text') {
                        $str .= $text->getText();
                    } elseif (get_class($text) === 'PhpOffice\PhpWord\Element\Image') {
                        $data = base64_decode($text->getImageStringData(true));
                        $file_name = md5($text->getName() . $i . time());
                        file_put_contents(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' . $file_name . '.png', $data);
                        array_push($images, NV_BASE_SITEURL . NV_TEMP_DIR . '/' . $file_name . '.png');
                        $count_image++;
                    }
                    $i++;
                }
                $str .= "\n";
            }

            if (get_class($e) === 'PhpOffice\PhpWord\Element\TextBreak') {
                $array = preg_split("/\r\n|\n|\r/", $str);
                if (is_array($array) && count($array) > 0) {
                    $count_point = $index_image = 0;
                    $question = array(
                        'id' => 0,
                        'question' => '',
                        'answer' => array(),
                        'useguide' => '',
                        'count_true' => 0,
                        'bank_type' => 0,
                        'type' => 1,
                        'error' => array(),
                        'generaltext' => ''
                    );

                    $j = 0;
                    // phát hiện câu hỏi chung
                    if (substr($array[$j], 0, 1) === '@') {
                        $question['type'] = 3;
                        if (count($all_p_tags[$count_elemt]->find('span')) > 0) {
                            $type = 'span';
                            $generaltext = nv_unhtmlspecialchars($all_p_tags[$count_elemt]->find('span')[0]->innertext);
                        } else {
                            $type = 'p';
                            $generaltext = nv_unhtmlspecialchars($all_p_tags[$count_elemt]->innertext);
                        }

                        if ($type == 'span') {
                            $generaltext = $all_p_tags[$count_elemt]->find('span')[0]->innertext = substr($generaltext, 1);
                        } else {
                            $generaltext = $all_p_tags[$count_elemt]->innertext = substr($generaltext, 1);
                        }
                        $question['generaltext'] = nv_test_content_format($all_p_tags[$count_elemt]);
                        $count_elemt++;
                        $j++;
                    }

                    if (isset($all_p_tags[$count_elemt]) && $all_p_tags[$count_elemt]->find('img')) {
                        $all_p_tags[$count_elemt]->find('img')[0]->src = $images[$index_image++];
                    }

                    preg_match('/^\[#(\d+)\]/', $array[$j], $matches);
                    $question['id'] = !empty($matches[1]) ? $matches[1] : 0;
                    $array[$j] = trim(preg_replace('/^\[#(\d+)\]/', '', $array[$j]));

                    $array_width_code = $array_code = array();
                    foreach ($array_bank_type as $typeid => $bank_type) {
                        $array_width_code[$bank_type['code']] = $typeid;
                        $array_code[] = '[' . $bank_type['code'] . ']';
                    }

                    $code = substr($array[$j], 0, 4);
                    if (in_array($code, $array_code)) {
                        $question['bank_type'] = $array_width_code[preg_replace("/[^a-zA-Z0-9]+/", "", $code)];
                    }

                    $question['question'] = nv_test_content_format($all_p_tags[$count_elemt++]);

                    for ($i = 1 + $j; $i < count($array); $i++) {
                        $is_userguide = 0;
                        if (substr(nv_unhtmlspecialchars($array[$i]), 0, 1) === '>') {
                            // phát hiện lời giải
                            $is_userguide = 1;
                        } elseif (substr($array[$i], 0, 1) === '*') {
                            // phát hiện đáp án đúng
                            $is_true = 1;
                            $question['count_true']++;
                        } else {
                            $is_true = 0;
                        }

                        if (isset($all_p_tags[$count_elemt]) && $all_p_tags[$count_elemt]->find('img')) {
                            // $all_p_tags[$count_elemt]->find('img')[0]->src = $images[$index_image++];
                        }

                        // loại bỏ các ký tự đánh dấu
                        if (isset($all_p_tags[$count_elemt])) {
                            if (count($all_p_tags[$count_elemt]->find('span')) > 0) {
                                $type = 'span';
                                $answerText = nv_unhtmlspecialchars($all_p_tags[$count_elemt]->find('span')[0]->innertext);
                            } else {
                                $type = 'p';
                                $answerText = nv_unhtmlspecialchars($all_p_tags[$count_elemt]->innertext);
                            }

                            if (substr($answerText, 0, 1) === '*' || substr($answerText, 0, 1) === '>') {
                                if ($type == 'span') {
                                    $answerText = $all_p_tags[$count_elemt]->find('span')[0]->innertext = substr($answerText, 1);
                                } else {
                                    $answerText = $all_p_tags[$count_elemt]->innertext = substr($answerText, 1);
                                }
                            }
                        }

                        // kiểm tra xem có quy định điểm cho đáp án không
                        // nếu có thì loại câu hỏi là Đánh giá năng lực
                        $is_point = $point = 0;
                        if (preg_match('/^\[(([0-9]+\.?[0-9]*)|([0-9]*\.[0-9]+))\]/', $answerText, $m)) {
                            $point = $m[1];
                            $is_point = 1;
                            $count_point++;
                            if ($type == 'span') {
                                $all_p_tags[$count_elemt]->find('span')[0]->innertext = substr($answerText, strlen($m[0]));
                            } else {
                                $all_p_tags[$count_elemt]->innertext = substr($answerText, strlen($m[0]));
                            }
                        }

                        if ($is_userguide) {
                            $question['useguide'] = nv_test_content_format($all_p_tags[$count_elemt++]);
                        } elseif ($i < count($array) - 1) {
                            $question['answer'][$i] = array(
                                'id' => $i,
                                'content' => nv_test_content_format($all_p_tags[$count_elemt++]),
                                'is_true' => $is_true
                            );
                            if ($is_point) {
                                $question['answer'][$i]['point'] = $point;
                            }
                        } else {
                            $count_elemt++;
                        }
                    }

                    if ($count_point == count($question['answer'])) {
                        $question['type'] = 5;
                    }

                    // kiểm tra lỗi
                    if (count($question['answer']) < 2) {
                        $question['error'][] = $nv_Lang->getModule('error_required_answer');
                    } elseif (empty($question['count_true'])) {
                        $question['error'][] = $nv_Lang->getModule('error_required_answer_is_true');
                    } elseif (empty($examid) && empty($question['bank_type'])) {
                        $question['error'][] = $nv_Lang->getModule('error_required_bank_type');
                    }

                    if (!empty($question['error'])) {
                        $array_question['error'] = 1;
                    }

                    $array_question['data'][] = $question;
                }
                $str = '';
                $images = array();
            }
        }
    }

    // insert last question
    $array = preg_split("/\r\n|\n|\r/", $str);
    if ($str != '' && is_array($array) && count($array) > 0) {
        $count_point = $index_image = 0;
        $question = array(
            'id' => 0,
            'question' => '',
            'useguide' => '',
            'answer' => array(),
            'count_true' => 0,
            'bank_type' => 0,
            'type' => 1, // mặc định câu hỏi lựa chọn
            'error' => array(),
            'generaltext' => ''
        );

        $j = 0;
        // phát hiện câu hỏi chung
        if (substr($array[$j], 0, 1) === '@') {
            $question['type'] = 3;
            if (count($all_p_tags[$count_elemt]->find('span')) > 0) {
                $type = 'span';
                $generaltext = nv_unhtmlspecialchars($all_p_tags[$count_elemt]->find('span')[0]->innertext);
            } else {
                $type = 'p';
                $generaltext = nv_unhtmlspecialchars($all_p_tags[$count_elemt]->innertext);
            }

            if ($type == 'span') {
                $generaltext = $all_p_tags[$count_elemt]->find('span')[0]->innertext = substr($generaltext, 1);
            } else {
                $generaltext = $all_p_tags[$count_elemt]->innertext = substr($generaltext, 1);
            }
            $question['generaltext'] = nv_test_content_format($all_p_tags[$count_elemt]);
            $count_elemt++;
            $j++;
        }

        if (isset($all_p_tags[$count_elemt]) && $all_p_tags[$count_elemt]->find('img')) {
            $all_p_tags[$count_elemt]->find('img')[0]->src = $images[$index_image++];
        }
        preg_match('/^\[#(\d+)\]/', $array[$j], $matches);
        $question['id'] = !empty($matches[1]) ? $matches[1] : 0;
        $array[$j] = trim(preg_replace('/^\[#(\d+)\]/', '', $array[$j]));

        $array_width_code = $array_code = array();
        foreach ($array_bank_type as $typeid => $bank_type) {
            $array_width_code[$bank_type['code']] = $typeid;
            $array_code[] = '[' . $bank_type['code'] . ']';
        }
        $code = substr($array[$j], 0, 4);
        if (in_array($code, $array_code)) {
            $question['bank_type'] = $array_width_code[preg_replace("/[^a-zA-Z0-9]+/", "", $code)];
        }
        $question['question'] = nv_test_content_format($all_p_tags[$count_elemt++]);
        $question['question'] = preg_replace('/^\[#\d+\]/', '', nv_trim($question['question']));
        $question['question'] = preg_replace('/^\[\w+\]/', '', nv_trim($question['question']));
        for ($i = 1 + $j; $i < count($array); $i++) {
            // phát hiện lời giải
            $is_userguide = 0;
            if (substr(nv_unhtmlspecialchars($array[$i]), 0, 1) === '>') {
                $is_userguide = 1;
                $question['useguide'] = nv_test_content_format($all_p_tags[$count_elemt]);
            } elseif (substr($array[$i], 0, 1) === '*') {
                $is_true = 1;
                $question['count_true']++;
            } else {
                $is_true = 0;
            }

            if (isset($all_p_tags[$count_elemt]) && $all_p_tags[$count_elemt]->find('img')) {
                // Hiển thị sai vị trí câu
                // Fix css inline của ảnh
                $all_p_tags[$count_elemt]->find('img')[0]->src = $images[$index_image++];
            }

            // loại bỏ các ký tự đánh dấu
            if (isset($all_p_tags[$count_elemt])) {
                if (count($all_p_tags[$count_elemt]->find('span')) > 0) {
                    $type = 'span';
                    $answerText = nv_unhtmlspecialchars($all_p_tags[$count_elemt]->find('span')[0]->innertext);
                } else {
                    $type = 'p';
                    $answerText = nv_unhtmlspecialchars($all_p_tags[$count_elemt]->innertext);
                }

                if (substr($answerText, 0, 1) === '*' || substr($answerText, 0, 1) === '>' || substr($answerText, 0, 1) === '@') {
                    if ($type == 'span') {
                        $answerText = $all_p_tags[$count_elemt]->find('span')[0]->innertext = substr($answerText, 1);
                    } else {
                        $answerText = $all_p_tags[$count_elemt]->innertext = substr($answerText, 1);
                    }
                }

                // kiểm tra xem có quy định điểm cho đáp án không
                // nếu có thì loại câu hỏi là Đánh giá năng lực
                $is_point = $point = 0;
                if (preg_match('/^\[(([0-9]+\.?[0-9]*)|([0-9]*\.[0-9]+))\]/', $answerText, $m)) {
                    $point = $m[1];
                    $is_point = 1;
                    $count_point++;
                    if ($type == 'span') {
                        $all_p_tags[$count_elemt]->find('span')[0]->innertext = substr($answerText, strlen($m[0]));
                    } else {
                        $all_p_tags[$count_elemt]->innertext = substr($answerText, strlen($m[0]));
                    }
                }
            }

            if ($is_userguide) {
                $question['useguide'] = nv_test_content_format($all_p_tags[$count_elemt++]);
            } elseif ($i < count($array) - 1) {
                $question['answer'][$i] = array(
                    'id' => $i,
                    'content' => nv_test_content_format($all_p_tags[$count_elemt++]),
                    'is_true' => $is_true
                );
                if ($is_point) {
                    $question['answer'][$i]['point'] = $point;
                }
            } else {
                $count_elemt++;
            }
        }

        if ($count_point == count($question['answer'])) {
            $question['type'] = 5;
        }

        // kiểm tra lỗi
        if (count($question['answer']) < 2) {
            $question['error'][] = $nv_Lang->getModule('error_required_answer');
        } elseif (empty($question['count_true'])) {
            $question['error'][] = $nv_Lang->getModule('error_required_answer_is_true');
        } elseif (empty($examid) && empty($question['bank_type'])) {
            $question['error'][] = $nv_Lang->getModule('error_required_bank_type');
        }

        if (!empty($question['error'])) {
            $array_question['error'] = 1;
        }

        $array_question['data'][] = $question;
    }

    $nv_Request->set_Session($module_data . '_array_question', serialize($array_question));
    nv_deletefile($temp_file);

    return $array_question;
}

function nv_preview_import_word($array_question, $examid = 0, $typeid = 0, $update_question = 0)
{
    global $nv_Lang, $global_config, $module_file, $array_bank_type;

    $xtpl = new XTemplate('preview.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
     $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('examid', $examid);
    $xtpl->assign('typeid', $typeid);
    $xtpl->assign('update_question', $update_question);
    if (!empty($array_question['data'])) {
        $i = 1;
        $array_letters = range('A', 'Z');
        foreach ($array_question['data'] as $question) {
            $question['number'] = $i++;
            $xtpl->assign('QUESTION', $question);
            if (!empty($array_bank_type[$question['bank_type']])) {
                $xtpl->assign('bank_type_title', $array_bank_type[$question['bank_type']]['title']);
                $xtpl->parse('main.data.question.bank_type');
            }
            $k = 0;
            foreach ($question['answer'] as $answer) {
                $answer['letter'] = $array_letters[$k];
                $k++;
                $xtpl->assign('ANSWER', $answer);
                if ($question['type'] == 1) {
                    if ($answer['is_true'] == 1) {
                        $xtpl->parse('main.data.question.answer.question_type_1.is_true_highlight');
                    }
                    $xtpl->parse('main.data.question.answer.question_type_1');
                } else if ($question['type'] == 2) {
                    $xtpl->parse('main.data.question.answer.question_type_2');
                }
                $xtpl->parse('main.data.question.answer');
            }

            if (!empty($question['useguide'])) {
                $xtpl->parse('main.data.question.useguide');
            }

            if (!empty($question['error'])) {
                $xtpl->assign('ERROR', implode(', ', $question['error']));
                $xtpl->parse('main.data.question.error');
            }

            if ($question['type'] == 3) {
                $xtpl->parse('main.data.question.generaltext');
            }

            $xtpl->parse('main.data.question');
        }

        if ($array_question['error']) {
            $xtpl->parse('main.data.disabled');
        }

        $xtpl->parse('main.data');
    } else {
        $xtpl->parse('main.nodata');
    }

    $xtpl->parse('main');
    $contents = $xtpl->text('main');

    return $contents;
}

/**
 * nv_history_download()
 *
 * @param mixed $array_data
 * @param mixed $type
 * @return
 *
 */
function nv_history_download($array_data, $type = 'xlsx')
{
    global $module_name, $module_file, $admin_info, $nv_Lang;

    if (empty($array_data['data'])) {
        die('Nothing download!');
    }

    $array = array(
        'objType' => '',
        'objExt' => ''
    );
    switch ($type) {
        case 'xlsx':
            $array['objType'] = 'Excel2007';
            $array['objExt'] = 'xlsx';
            break;
        case 'ods':
            $array['objType'] = 'OpenDocument';
            $array['objExt'] = 'ods';
            break;
        default:
            $array['objType'] = 'CSV';
            $array['objExt'] = 'csv';
    }

    $array_fields = array(
        'number',
        'score',
        'timer',
        'rating',
        'count_true',
        'count_false',
        'count_skeep'
    );

    $objPHPExcel = \PhpOffice\PhpSpreadsheet\IOFactory::load(NV_ROOTDIR . '/modules/' . $module_file . '/template/history_download.xls');
    $objPHPExcel->setActiveSheetIndex(0);

    // Set properties
    $objPHPExcel->getProperties()
        ->setCreator($admin_info['username'])
        ->setLastModifiedBy($admin_info['username'])
        ->setTitle($array_data['title'])
        ->setSubject($array_data['title'])
        ->setDescription($array_data['title'])
        ->setCategory($module_name);

    $columnIndex = 1; // Cot bat dau ghi du lieu
    $rowIndex = 4; // Dong bat dau ghi du lieu

    $i = $rowIndex + 1;
    foreach ($array_data['data'] as $data) {
        $j = $columnIndex;
        foreach ($array_fields as $field) {
            $col = \PhpOffice\PhpSpreadsheet\Cell::stringFromColumnIndex($j);
            $CellValue = $data[$field];
            $objPHPExcel->getActiveSheet()->setCellValue($col . $i, $CellValue);
            $j++;
        }
        $i++;
    }

    $highestRow = $i - 1;
    $highestColumn = \PhpOffice\PhpSpreadsheet\Cell::stringFromColumnIndex($j - 1);

    $objPHPExcel->getActiveSheet()->setCellValue('A2', mb_strtoupper($array_data['title']));

    // Set color
    $styleArray = array(
        'borders' => array(
            'outline' => array(
                'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => array(
                    'argb' => 'FF000000'
                )
            )
        )
    );
    $objPHPExcel->getActiveSheet()
        ->getStyle('A' . $rowIndex . ':' . $highestColumn . $highestRow)
        ->applyFromArray($styleArray);

    $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, $array['objType']);
    $file_src = NV_ROOTDIR . NV_BASE_SITEURL . NV_TEMP_DIR . '/' . change_alias($array_data['title']) . '.' . $array['objExt'];
    $objWriter->save($file_src);

    $download = new NukeViet\Files\Download($file_src, NV_ROOTDIR . NV_BASE_SITEURL . NV_TEMP_DIR);
    $download->download_file();
    die();
}

/**
 * nv_exams_report_download()
 *
 * @param mixed $exam_info
 * @param mixed $array_data
 * @param mixed $type
 * @return
 *
 */
function nv_exams_report_download($lang_file, $exam_info, $array_data, $type = 'xlsx')
{
    global $module_name, $array_field_config, $admin_info, $nv_Lang, $array_header;

    $array = array(
        'objType' => '',
        'objExt' => ''
    );
    switch ($type) {
        case 'xlsx':
            $array['objType'] = 'Xlsx';
            $array['objExt'] = 'xlsx';
            break;
        case 'ods':
            $array['objType'] = 'OpenDocument';
            $array['objExt'] = 'ods';
            break;
        default:
            $array['objType'] = 'CSV';
            $array['objExt'] = 'csv';
    }

    // Tạo một mảng clone từ $array_field_config và loại bỏ các cột sig, question, answer
    $array_field_config_object = new ArrayObject($array_field_config);
    $array_field_config_collapse = $array_field_config_object->getArrayCopy();
    unset($array_field_config_collapse['sig']);
    unset($array_field_config_collapse['question']);
    unset($array_field_config_collapse['answer']);

    $objPHPExcel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $objPHPExcel->setActiveSheetIndex(0);

    // Set properties
    $objPHPExcel->getProperties()
        ->setCreator($admin_info['username'])
        ->setLastModifiedBy($admin_info['username'])
        ->setTitle($lang_file . ' ' . $exam_info['title'])
        ->setSubject($lang_file . ' ' . $exam_info['title'])
        ->setDescription($lang_file . ' ' . $exam_info['title'])
        ->setCategory($module_name);

    $columnIndex = 3; // Cot bat dau ghi du lieu
    $rowIndex = 3; // Dong bat dau ghi du lieu

    // Tieu de cot
    $objPHPExcel->getActiveSheet()->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(1) . $rowIndex, $nv_Lang->getModule('number'));
    $objPHPExcel->getActiveSheet()->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(2) . $rowIndex, $nv_Lang->getModule('admin_username'));

    // Hien thi tieu de tuy bien du lieu
    $_columnIndex = $columnIndex;
    if (!empty($array_field_config_collapse)) {
        foreach ($array_field_config_collapse as $field) {
            if (in_array($field, $array_header)) {
                $TextColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($_columnIndex);
                $objPHPExcel->getActiveSheet()->setCellValue($TextColumnIndex . $rowIndex, $field['title']);
            }
        }
    }

    foreach ($array_field_config_collapse as $vl_field) {
        $objPHPExcel->getActiveSheet()->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($_columnIndex++) . $rowIndex, $vl_field['title']);
    }

    // Hien thi tieu de cho loai dot thi trac nghiem
    if (empty($exam_info['id'])) {
        $objPHPExcel->getActiveSheet()
            ->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($_columnIndex++) . $rowIndex, $nv_Lang->getModule('exams'));
    }

    $objPHPExcel->getActiveSheet()
        ->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($_columnIndex++) . $rowIndex, $nv_Lang->getModule('score'))
        ->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($_columnIndex++) . $rowIndex, $nv_Lang->getModule('begin_time'))
        ->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($_columnIndex++) . $rowIndex, $nv_Lang->getModule('test_time'))
        ->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($_columnIndex++) . $rowIndex, $nv_Lang->getModule('rating'))
        ->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($_columnIndex++) . $rowIndex, $nv_Lang->getModule('tester_info_true'))
        ->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($_columnIndex++) . $rowIndex, $nv_Lang->getModule('tester_info_false'))
        ->setCellValue(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($_columnIndex++) . $rowIndex, $nv_Lang->getModule('tester_info_skeep'));

    // Hien thi danh sach cau tra loi
    $i = $rowIndex + 1;
    $number = 1;
    foreach ($array_data as $data) {
        $j = $columnIndex;
        $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(1);
        $CellValue = $number;
        $objPHPExcel->getActiveSheet()->setCellValue($col . $i, $CellValue);

        $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(2);
        $CellValue = $data['username'];
        $objPHPExcel->getActiveSheet()->setCellValue($col . $i, $CellValue);

        // Hien thi tuy bien du lieu
        $number++;
        if (!empty($array_field_config_collapse) and !empty($data['custom_field'])) {
            foreach ($array_field_config_collapse as $field_value) {
                $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($j);
                $CellValue = $data['custom_field'][$field_value['field']]['value'];
                $objPHPExcel->getActiveSheet()->setCellValue($col . $i, $CellValue);
                $j++;
            }
        }

        // Hien thi cau tra loi cho tgian tham gia
        if (empty($exam_info['id'])) {
            $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($j++);
            $CellValue = $data['exams']['title'];
            $objPHPExcel->getActiveSheet()->setCellValue($col . $i, $CellValue);
        }

        $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($j++);
        $CellValue = $data['score'];
        $objPHPExcel->getActiveSheet()->setCellValue($col . $i, $CellValue);

        $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($j++);
        $CellValue = $data['begin_time'];
        $objPHPExcel->getActiveSheet()->setCellValue($col . $i, $CellValue);

        $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($j++);
        $CellValue = $data['test_time'];
        $objPHPExcel->getActiveSheet()->setCellValue($col . $i, $CellValue);

        $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($j++);
        $CellValue = $data['rating'];
        $objPHPExcel->getActiveSheet()->setCellValue($col . $i, $CellValue);

        // Hien thi cau tra loi cho loai dot thi trac nghiem
        $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($j++);
        $CellValue = $data['count_true'];
        $objPHPExcel->getActiveSheet()->setCellValue($col . $i, $CellValue);

        $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($j++);
        $CellValue = $data['count_false'];
        $objPHPExcel->getActiveSheet()->setCellValue($col . $i, $CellValue);

        $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($j++);
        $CellValue = $data['count_skeep'];
        $objPHPExcel->getActiveSheet()->setCellValue($col . $i, $CellValue);

        $i++;
    }

    $highestRow = $i - 1;
    $highestColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($j - 1);

    // Rename sheet
    $objPHPExcel->getActiveSheet()->setTitle('Sheet 1');

    // Set page orientation and size
    $objPHPExcel->getActiveSheet()
        ->getPageSetup()
        ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);
    $objPHPExcel->getActiveSheet()
        ->getPageSetup()
        ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

    // Excel title
    $style_title = array(
        'borders' => array(
            'outline' => array(
                'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => array(
                    'argb' => 'FF000000'
                )
            )
        ),
        'font' => array(
            'bold' => true
        )
    );
    $style_text_bold = array(
        'font' => array(
            'bold' => true
        )
    );
    $objPHPExcel->getActiveSheet()->mergeCells('A1:' . $highestColumn . '2');
    $objPHPExcel->getActiveSheet()->setCellValue('A1', mb_strtoupper($exam_info['title'], 'UTF-8'));
    $objPHPExcel->getActiveSheet()
        ->getStyle('A2')
        ->getAlignment()
        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()
        ->getStyle('A2')
        ->getAlignment()
        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()
        ->getStyle('A2:' . $highestColumn . '2')
        ->applyFromArray($style_title);

    $objPHPExcel->getActiveSheet()
        ->getStyle('A3:' . $highestColumn . '3')
        ->applyFromArray($style_text_bold);

    // Set color
    $styleArray = array(
        'borders' => array(
            'outline' => array(
                'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => array(
                    'argb' => 'FF000000'
                )
            )
        )
    );

    $objPHPExcel->getActiveSheet()
        ->getStyle('A3' . ':' . $highestColumn . $highestRow)
        ->applyFromArray($styleArray);

    // Set font size
    $objPHPExcel->getActiveSheet()
        ->getStyle("A1:" . $highestColumn . $highestRow)
        ->getFont()
        ->setSize(13);
    // Kẻ bảng
    $styleArray = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => [
                    'rgb' => '000000'
                ]
            ]
        ]
    ];
    $objPHPExcel->getActiveSheet()->getStyle('A3' . ':' . $highestColumn . $highestRow)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle('A1')
        ->getAlignment()
        ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true)->setSize(16);
    /* $objPHPExcel->getActiveSheet()->getStyle('A3:' . $highestColumn . '3')->applyFromArray(
        array(
            'fill' => array(
                'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => array('rgb' => 'BABABA')
            )
        )
    ); */
    $objPHPExcel->getActiveSheet()->getStyle('A3:' . $highestColumn . '3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('C9C9C9');
    // Set auto column width
    foreach (range('A', $highestColumn) as $columnID) {
        $objPHPExcel->getActiveSheet()
            ->getColumnDimension($columnID)
            ->setAutoSize(true);
    }

    $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, $array['objType']);
    $file_src = NV_ROOTDIR . NV_BASE_SITEURL . NV_TEMP_DIR . '/' . $lang_file . '.' . $array['objExt'];
    $objWriter->save($file_src);

    return $file_src;
}

function nv_view_content($contentid)
{
    global $db, $global_config, $module_name, $module_data, $module_file, $nv_Lang;

    $exam_info = $db->query('SELECT t1.*, t2.time, t2.number_question, t2.ladder, t2.perpage, t2.rand_answer, t2.display_answer FROM ' . NV_PREFIXLANG . '_' . $module_data . ' t1 INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_exam t2 ON t1.examid=t2.id WHERE t1.active=1 AND t2.active=1 AND t1.id=' . $contentid)->fetch();

    if (!empty($codeid)) {
        list($exam_info['config']) = $db->query('SELECT config FROM ' . NV_PREFIXLANG . '_' . $module_data . '_code WHERE content_id=' . $contentid . ' AND id=' . $codeid)->fetch(3);
    }

    $array_question = nv_get_data_question($exam_info['config']);
    $question_content = nv_theme_nvtest_test_content($exam_info, $array_question, array(), 0, 1, 1, 1);
    $question_content = nv_replace_template_exam($exam_info, $question_content);

    return $question_content;
}

function nv_delete_sample_data()
{
    global $db, $global_config, $module_data, $db_config, $module_name, $nv_Cache;

    define('NV_IS_FILE_MODULES', true);
    $lang = NV_LANG_DATA;

    $sample_delete = 1;
    require_once NV_ROOTDIR . '/modules/test/action_mysql.php';

    $sql_create_module[] = "UPDATE " . NV_CONFIG_GLOBALTABLE . " SET config_value = 1 WHERE config_name = 'sample_deleted' AND module='" . $module_name . "' ";
    foreach ($sql_create_module as $sql) {
        $db->query($sql);
    }
    $nv_Cache->delMod($module_name);
    $nv_Cache->delMod('settings');
    return true;
}

function nv_view_statistics($id)
{
    global $db, $module_data, $module_name, $module_info, $global_config, $module_file, $nv_Lang, $nv_Cache;

    $db->sqlreset()
        ->select('COUNT(*)')
        ->from(NV_PREFIXLANG . '_' . $module_data . '_answer t1');
    if (!empty($id)) {
        $db->where('exam_id=' . $id);
    }

    $sth = $db->prepare($db->sql());
    $sth->execute();

    $num_items = $sth->fetchColumn();

    $db->select('t1.*');

    $sth = $db->prepare($db->sql());
    $sth->execute();

    $_sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rating WHERE status=1 ORDER BY weight';
    $array_rating = $nv_Cache->db($_sql, 'id', $module_name);

    $array_data = $array_title = $array_color = array();
    foreach ($array_rating as $val) {
        $array_title[] = $val['title'];
        $array_color[] = $val['color'];
        $array_data[$val['id']] = 0;
    }

    while ($view = $sth->fetch()) {
        $percent = ($view['count_true'] * 100) / ($view['count_true'] + $view['count_false'] + $view['count_skeep']);
        $ratingid = nv_get_rating($percent, 2);
        $array_data[$ratingid]++;
    }

    $xtpl = new XTemplate('statistics.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
     $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);
    $xtpl->assign('DATA_LABEL', '"' . implode('", "', $array_title) . '"');
    $xtpl->assign('DATA_COLOR', '"' . implode('", "', $array_color) . '"');
    $xtpl->assign('DATA_VALUE', implode(',', array_values($array_data)));

    $xtpl->parse('main');
    $contents = $xtpl->text('main');
    return $contents;
}

function nv_test_content_format($content)
{
    /**
     * Kiểm tra câu hỏi có
     * [#ddd] id của câu hỏi
     * [NB]: nhận biết, [TH]: thông hiểu, [VD]: vận dụng, [VC]: vận dụng cao
     * và loại bỏ dữ liệu đó khi cập nhật nội dung câu hỏi.
     * Yêu cầu chỉ được bỏ khi gặp đúng dạng trên với điều kiện dạng trên ở phần đầu của câu hỏi nếu có dạng [#ddd] hoặc [NB] | [TH].... nhưng ở giữa câu hỏi thì không được xóa.
     * Xử lý được cả trường hợp phần đầu của câu hỏi là các "space" rồi đến dạng [#ddd] cũng được xóa
     */
    $content = preg_replace('/>\s*(\[\s*#\s*\d+\s*\])/', '$2>', $content);
    $content = preg_replace('/>\s*(\[\s*(NB|TH|VD|VC)\s*\])/', '$2>', $content);
    // loại bỏ <p> không có nội dung
    $content = preg_replace('#<p(.*?)>(.*?)</p>#is', '$2', trim($content));

    // xóa định dạng font chữ trong nội dung
    $content = preg_replace('/font-family.+?;/', "", $content);

    // xóa định dạng cỡ chữ trong nội dung
    $content = preg_replace('/font-size.+?;/', "", $content);

    // chuyển Tex sang công thức toán
    $content = nvConvertToLatex($content);

    $content = htmlspecialchars_decode(htmlspecialchars($content));

    return $content;
}

/**
 * nv_fix_source()
 *
 * @return
 */
function nv_fix_source()
{
    global $db, $module_data;
    $sql = 'SELECT sourceid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_sources ORDER BY weight ASC';
    $result = $db->query($sql);
    $weight = 0;
    while ($row = $result->fetch()) {
        ++$weight;
        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_sources SET weight=' . $weight . ' WHERE sourceid=' . intval($row['sourceid']);
        $db->query($sql);
    }
    $result->closeCursor();
}

function nv_package_notice($idsite = 0, $alert = false)
{

    global $db, $module_data, $module_name, $module_info, $global_config, $module_file, $nv_Lang, $array_package;

    $xtpl = new XTemplate('notice.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
     $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);

    if (isset($global_config['cid']) && isset($array_package[$global_config['cid']]['notice_update'])) {
        if ($alert) {
            $xtpl->assign('ALERT_NOTIICE', $array_package[$global_config['cid']]['notice_update']);
            $xtpl->parse('main.alert_notice');
        } else {
            if ($global_config['cid'] == 3) {
                $exptime_str = get_exptime_site($idsite);
                $exptime = nv_date('d/m/Y', $exptime_str);
                $xtpl->assign('PACKAGE_NOTIICE', sprintf($array_package[$global_config['cid']]['notice_update'], $exptime));
                $xtpl->parse('main.notice');
            } else {
                $xtpl->assign('PACKAGE_NOTIICE', $array_package[$global_config['cid']]['notice_update']);
                $xtpl->parse('main.notice');
            }
        }
    } elseif (isset($global_config['notice_update'])) {
        if ($alert) {
            $xtpl->assign('ALERT_NOTIICE', $global_config['notice_update']);
            $xtpl->parse('main.alert_notice');
        } else {
            $xtpl->assign('PACKAGE_NOTIICE', $global_config['notice_update']);
            $xtpl->parse('main.notice');
        }
    }
    $xtpl->parse('main');
    $contents = $xtpl->text('main');
    return $contents;
}

function nv_view_option($id = null)
{
    global $module_file, $nv_Lang, $global_config, $array_exams_bank_cats_tree;

    $xtpl = new XTemplate('exams.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
     $xtpl->assign('LANG', \NukeViet\Core\Language::$lang_module);

    foreach ($array_exams_bank_cats_tree as $cats) {
        if ($cats['id'] == $id) {
            continue;
        }
        $xtpl->assign('label_group', $cats['title']);
        foreach ($cats['children'] as $cat) {
            if ($cat['id'] == $id) {
                continue;
            }
            $xtpl->assign('CAT', $cat);
            $xtpl->parse('view_add_bank.group_cat.cats');
        }
        $xtpl->parse('view_add_bank.group_cat');
    }

    $xtpl->parse('view_add_bank');
    return $xtpl->text('view_add_bank');
}

function clone_exam($id)
{
    global $db, $module_data, $module_name, $nv_Lang, $admin_info;
    $db->sqlreset()
        ->select('*')
        ->from(NV_PREFIXLANG . '_' . $module_data . '_exams')
        ->where('id = ' . $id);
    $row = $db->query($db->sql())->fetch(2);
    $_weight = $db->query('SELECT max(weight) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_exams')->fetchColumn();
    $_weight = intval($_weight) + 1;
    $_sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_exams (isbank, catid, topicid, sourceid, title, alias, code, image, image_position, hometext, description, groups, groups_comment, groups_result, begintime, endtime, num_question, count_question, timer, ladder, per_page, type, input_question, exams_config, exams_reset_bank, question_list, addtime, userid, isfull, random_answer, rating, history_save, save_max_score, print, useguide, type_useguide, multiple_test, template, weight, test_limit, price, check_result, view_mark_after_test, view_question_after_test, preview_question_test, mix_question) VALUES (:isbank, :catid, :topicid, :sourceid, :title, :alias, :code, :image, :image_position, :hometext, :description, :groups, :groups_comment, :groups_result, :begintime, :endtime, :num_question, :count_question, :timer, :ladder, :per_page, :type, :input_question, :exams_config, :exams_reset_bank, :question_list, ' . NV_CURRENTTIME . ', ' . $admin_info['userid'] . ', :isfull, :random_answer, :rating, :history_save, :save_max_score, :print, :useguide, :type_useguide, :multiple_test, :template, :weight, :test_limit, :price, :check_result, :view_mark_after_test, :view_question_after_test, :preview_question_test, :mix_question)';
    $data_insert = array();
    $data_insert['isbank'] = $row['isbank'];
    $data_insert['catid'] = $row['catid'];
    $data_insert['topicid'] = $row['topicid'];
    $data_insert['sourceid'] = $row['sourceid'];
    $data_insert['title'] = $row['title'] . ' Copy';
    $data_insert['alias'] = $row['alias'] . '-copy';
    $data_insert['code'] = $row['code'];
    $data_insert['image'] = $row['image'];
    $data_insert['image_position'] = $row['image_position'];
    $data_insert['hometext'] = $row['hometext'];
    $data_insert['description'] = $row['description'];
    $data_insert['groups'] = $row['groups'];
    $data_insert['groups_comment'] = $row['groups_comment'];
    $data_insert['groups_result'] = $row['groups_result'];
    $data_insert['begintime'] = $row['begintime'];
    $data_insert['endtime'] = $row['endtime'];
    $data_insert['num_question'] = $row['num_question'];
    $data_insert['count_question'] = $row['count_question'];
    $data_insert['timer'] = $row['timer'];
    $data_insert['ladder'] = $row['ladder'];
    $data_insert['per_page'] = $row['per_page'];
    $data_insert['type'] = $row['type'];
    $data_insert['input_question'] = $row['input_question'];
    $data_insert['exams_config'] = $row['exams_config'];
    $data_insert['exams_reset_bank'] = $row['exams_reset_bank'];
    $data_insert['question_list'] = '';
    $data_insert['isfull'] = $row['isfull'];
    $data_insert['random_answer'] = $row['random_answer'];
    $data_insert['check_result'] = $row['check_result'];
    $data_insert['view_mark_after_test'] = $row['view_mark_after_test'];
    $data_insert['view_question_after_test'] = $row['view_question_after_test'];
    $data_insert['preview_question_test'] = $row['preview_question_test'];
    $data_insert['rating'] = $row['rating'];
    $data_insert['multiple_test'] = $row['multiple_test'];
    $data_insert['history_save'] = $row['history_save'];
    $data_insert['save_max_score'] = $row['save_max_score'];
    $data_insert['print'] = $row['print'];
    $data_insert['useguide'] = $row['useguide'];
    $data_insert['type_useguide'] = $row['type_useguide'];
    $data_insert['template'] = $row['template'];
    $data_insert['weight'] = $_weight;
    $data_insert['test_limit'] = $row['test_limit'];
    $data_insert['price'] = $row['price'];
    $data_insert['mix_question'] = $row['mix_question'];
    $new_id = $db->insert_id($_sql, 'id', $data_insert);
    if (!empty($new_id)) {
        $list_question_id = array();
        $db->sqlreset()
            ->select('*')
            ->from(NV_PREFIXLANG . '_' . $module_data . '_question')
            ->where('examid =' . $id);
        $result = $db->query($db->sql());
        while ($row = $result->fetch(2)) {
            $_sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_question (examid, typeid, bank_type, title, useguide, type, answer, weight, answer_style, answer_fixed, point, count_true, edittime, max_answerid, generaltext, answer_editor, answer_editor_type, addtime, userid, note, limit_time_audio, mark_max_constructed_response) VALUES (:examid, :typeid, :bank_type, :title, :useguide, :type, :answer, :weight, :answer_style, :answer_fixed, :point, :count_true, :edittime, :max_answerid, :generaltext, :answer_editor, :answer_editor_type, ' . NV_CURRENTTIME . ', :userid,"", :limit_time_audio, :mark_max_constructed_response )';
            $data_insert = array();
            $data_insert['examid'] = $new_id;
            $data_insert['typeid'] = $row['typeid'];
            $data_insert['bank_type'] = $row['bank_type'];
            $data_insert['title'] = $row['title'];
            $data_insert['type'] = $row['type'];
            $data_insert['useguide'] = $row['useguide'];
            $data_insert['answer'] = $row['answer'];
            $data_insert['weight'] = $row['weight'];
            $data_insert['answer_style'] = $row['answer_style'];
            $data_insert['answer_fixed'] = $row['answer_fixed'];
            $data_insert['point'] = $row['point'];
            $data_insert['count_true'] = $row['count_true'];
            $data_insert['max_answerid'] = $row['max_answerid'];
            $data_insert['generaltext'] = $row['generaltext'];
            $data_insert['answer_editor'] = $row['answer_editor'];
            $data_insert['answer_editor_type'] = $row['answer_editor_type'];
            $data_insert['userid'] = $row['userid'];
            $data_insert['edittime'] = NV_CURRENTTIME;
            $data_insert['limit_time_audio'] = $row['limit_time_audio'];
            $data_insert['mark_max_constructed_response'] = $row['mark_max_constructed_response'];
            $question_id = $db->insert_id($_sql, 'id', $data_insert);
            $list_question_id[] = $question_id;
        }
        if (!empty($list_question_id)) {
            $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_exams SET question_list = "' . implode(',', $list_question_id) . '" WHERE id = ' . $new_id);
        }
    }
    nv_insert_logs(NV_LANG_DATA, $module_name, $nv_Lang->getModule('clone_exam'), $row['title'] . "(#" . $new_id . ")", $admin_info['userid']);
    return $new_id;
}
/*
* Lấy tất cả câu hỏi được sử dụng trong môt môn thi
*/
function get_exam_subject_question($id)
{
    global $db, $module_data;
    $questionids = array();
    $examsid = array();
    $db->sqlreset()
        ->select('*')
        ->from(NV_PREFIXLANG . '_' . $module_data . '_subject_questions')
        ->where('id=' . $id);
    $result = $db->query($db->sql());

    while ($row = $result->fetch(2)) {
        if (!empty($row['questionid'])) {
            $questionids[$row['questionid']] = true;
        }
        if (!empty($row['examsid'])) {
            $examsid[] = $row['examsid'];
        }
    }
    if (!empty($examsid)) {
        $db->sqlreset()
            ->select('questionid')
            ->from(NV_PREFIXLANG . '_' . $module_data . '_exams_question')
            ->where('examsid IN (' . implode(',', $examsid) . ')');
        $result = $db->query($db->sql());
        while ($row = $result->fetch(2)) {
            if (!empty($row['questionid'])) {
                $questionids[$row['questionid']] = true;
            }
        }
        $db->sqlreset()
            ->select('id')
            ->from(NV_PREFIXLANG . '_' . $module_data . '_question')
            ->where('examid IN (' . implode(',', $examsid) . ')');
        $result = $db->query($db->sql());
        while ($row = $result->fetch(2)) {
            if (!empty($row['id'])) {
                $questionids[$row['id']] = true;
            }
        }
    }

    return array_keys($questionids);
}
/**
 * Chuyển các hình ảnh trong nội dung đến thư mục đích đồng thời sửa nội dung tương ứng
 * Ví dụ $content = '<div><img src="orgin/test/abc.png"/></div>';
 * Được chuyển tới thư mục đích destination
 * Thì hình ảnh sẽ được chuyển đến destination và
 * $content = '<div><img src="destination/abc.png"/></div>'
 */

function move_file_and_change_content($content)
{
    global $main_upload_dir;
    $des_dir =  SYSTEM_UPLOADS_DIR . '/' . $main_upload_dir . '/test/';
    $new_dir = date('Y_m', NV_CURRENTTIME);
    $check = true;
    if (!is_dir(NV_ROOTDIR . '/' . $des_dir . $new_dir)) {
        $check = nv_mkdir(NV_ROOTDIR . '/' . $des_dir, $new_dir);
    }
    if (!$check) {
        return '';
    }
    // Lấy các url
    $rand = rand(100000, 999999);
    preg_match_all('/(<\s*img[^>]*src\s*=\s*[\"\']+)([^>\"\']*)([\"\'][^>]*>)/i', $content, $matches);
    $array_url = $matches[2];
    foreach ($array_url as $url) {
        preg_match('/[^\/]*$/', $url, $imgs);
        if (count($imgs) > 0) {
            $content = str_replace($url, '/' . $des_dir . $new_dir . '/' . $rand . '_' . $imgs[0], $content);
            nv_copyfile(NV_ROOTDIR . $url, NV_ROOTDIR  . '/' . $des_dir . $new_dir .  '/' . $rand . '_' . $imgs[0]);
        }
    }
    return $content;
}
/**
 * Xóa tất cả ảnh có trong content html
 */
function remove_img_in_content($content)
{
    preg_match_all('/(<\s*img[^>]*src\s*=\s*[\"\']+)([^>\"\']*)([\"\'][^>]*>)/i', $content, $matches);
    $array_url = $matches[2];
    foreach ($array_url as $url) {
        nv_deletefile(NV_ROOTDIR . $url);
    }
}

/**
 * Chuyển đổi từ số thứ tự sang alphabet
 * Ví dụ 1->A, 2->B
 */
function number_to_alphabet($number)
{
    $number = intval($number);
    if ($number <= 0) {
        return '';
    }
    $alphabet = '';
    while ($number != 0) {
        $p = ($number - 1) % 26;
        $number = intval(($number - $p) / 26);
        $alphabet = chr(65 + $p) . $alphabet;
    }
    return $alphabet;
}
/**
 * word: Xuất tiêu đề và đáp án
 */
function export_word_from_exam($exam_id)
{
    global $db, $module_data, $ck_editor_word, $nv_Lang, $array_config;
    $db->sqlreset()
        ->select('title, question_list')
        ->from(NV_PREFIXLANG . '_' . $module_data . '_exams')
        ->where('id = ' . $exam_id);
    list($title, $question_list) = $db->query($db->sql())->fetch(3);
    $title = preg_replace('/^\s*<\s*\/*\s*br\s*\/*\s*>\s*/', '', $title);
    $title = preg_replace('/\s*<\s*\/*\s*br\s*\/*\s*>\s*$/', '', $title);
    $ck_editor_word->reset();
    $ck_editor_word->addEditor($array_config['top_content_exam']);
    $ck_editor_word->addTextBreak();
    $ck_editor_word->addEditor('<p style="font-weight: bold; font-size: 16; text-align: center">ĐỀ THI</p>');
    $ck_editor_word->addEditor('<p style="font-weight: bold; font-size: 16; text-align: center">' . mb_strtoupper($title, 'UTF-8') . '</p>');
    $question_list = explode(',', $question_list);
    $ck_editor_word->addTextBreak();
    $correct_answer = export_word_from_question($question_list);
    $ck_editor_word->addPageBreak();
    $ck_editor_word->addEditor('<p style="font-weight: bold; font-size: 16; text-align: center">ĐÁP ÁN</p>');
    $ck_editor_word->addTextBreak();
    export_word_correct_answer($correct_answer);
    $ck_editor_word->export_word(change_alias($title));
}

function parse_table_correct_answer($arr_correct_answer)
{
    $result_data = array();

    $max_exams_in_table = 5;
    $sum_exams = count($arr_correct_answer);
    if ($sum_exams == 0) {
        return false;
    }
    $num_table = (floor(($sum_exams - 1) / $max_exams_in_table) + 1);
    $num_exams_in_table = ceil($sum_exams / $num_table);
    $arr_data_table = array_chunk($arr_correct_answer, $num_exams_in_table, true);

    foreach ($arr_data_table as $data_table) {
        $data = array();
        $title = array();
        foreach ($data_table as $key => $data_column) {
            $title[] = str_replace('_', '-', $key);
            foreach ($data_column as $cell) {
                if (!isset($data[$cell['question']])) {
                    $data[$cell['question']] = array();
                }
                $data[$cell['question']][$key] = $cell['answer'];
            }
        }
        $result_data[] = array('title' => $title, 'data' => $data);
    }
    return $result_data;
}
function add_table_answer_to_word($data_table, $title_table)
{
    global $ck_editor_word, $nv_Lang;
    $html_body = "";
    foreach ($data_table as $qs => $row) {
        $html_row = "";
        $html_row .= '<td><span style="text-align: center">' . $qs . '</span></td>';
        foreach ($row as $cell) {
            $html_row .= '<td><span style="text-align: center">' . implode(', ', $cell) . '</span></td>';
        };
        $html_row = '<tr>' . $html_row . '</tr>';
        $html_body .= $html_row;
    }
    $html_body = '<tbody>' . $html_body . '</tbody>';

    $html_head = "";
    $html_head .= '<td><span style="text-align: center">' . $nv_Lang->getModule('question') . '</span></td>';
    foreach ($title_table as $title) {
        $html_head .= '<td><span style="text-align: center">' . $title . '</span></td>';
    }
    $html_head = '<thead><tr>' . $html_head . '</tr></thead>';

    $table_answer = '<table style="border-color: #000000; vertical-align: top" tblHeader="true">' . $html_head . $html_body . '</table>';
    $ck_editor_word->addEditor($table_answer);
}
/**
 * word: Xuất mãng đáp án của nhiều đề khác nhau
 */
function export_word_multi_correct_answer($arr_correct_answer, $arr_title = null)
{
    global $ck_editor_word;

    $arr_table_answer = parse_table_correct_answer($arr_correct_answer);
    foreach ($arr_table_answer as $table_answer) {
        add_table_answer_to_word($table_answer['data'], $table_answer['title']);
        $ck_editor_word->addTextBreak();
    }
}

/**
 * WORD: xuất đáp án dạng chỉ có một đáp án
 */
function export_word_correct_answer($correct_answer)
{
    global $ck_editor_word, $nv_Lang;
    $table_answer = "";
    foreach ($correct_answer as $row) {
        $table_answer .=  ('
        <tr>
            <td><span style="text-align: center">' . $row['question'] . '</span></td>
            <td><span style="text-align: center">' . implode(', ', $row['answer']) . '</span></td>
        </tr>');
    }
    $table_answer = '<tbody>' . $table_answer . '</tbody>';
    $table_answer = '
    <thead>
        <tr>
            <td><span style="text-align: center">' . $nv_Lang->getModule('question') . '</span></td>
            <td><span style="text-align: center">' . $nv_Lang->getModule('answer') . '</span></td>
        </tr>
    </thead>' . $table_answer;

    $table_answer = '<table style="border-color: #000000; vertical-align: top" tblHeader="true">' . $table_answer . '</table>';
    $ck_editor_word->addEditor($table_answer);
}
/**
 * word: Xuất câu hỏi và trả về đáp án
 * @param array $ids: Danh sách id câu hỏi của đề thi
 * @param int $tt: Title của đề thi
 * @param bool $shuffle_answer: Cho phép đảo trộn thứ tự đáp án của câu hỏi. Mặc định là không cho phép.
 * @return mixed
 */
function export_word_from_question($ids, $tt = 1, $shuffle_answer = false, $arr_question_value = array())
{
    global $db, $module_data, $ck_editor_word, $nv_Lang;
    $correct_answer = array();
    if (!empty($ids) && empty($arr_question_value)) {
        $db->sqlreset()
            ->select('title, answer, type')
            ->from(NV_PREFIXLANG . '_' . $module_data . '_question')
            ->where('id IN (' . implode(',', $ids) . ')')
            ->order('FIELD(id, ' . implode(',', $ids) . ')');
        $result = $db->query($db->sql());
        while (list($title, $answer, $type) = $result->fetch(3)) {
            $arr_question_value[] = array(
                'title' => $title,
                'answer' => unserialize($answer),
                'type' => $type
            );
        }
    }
    foreach ($arr_question_value as $question_value) {
        $title = $question_value['title'];
        $answer = $question_value['answer'];
        $type = $question_value['type'];

        $content = '<span style="font-weight: bold; color: #000000">' .  $nv_Lang->getModule('question') . ' ' . $tt . '. </span>';
        $title = $ck_editor_word->insert_content_into_html($content, $title);
        $ck_editor_word->addEditor($title);
        if ($shuffle_answer == true) {
            $answer = array_values(shuffle_assoc($answer));
        }

        $html_answer = "";
        $html_item = "";
        $i = 0;
        $correct_answer[$tt] = array(
            'type' => $type,
            'question' => '<span style="font-weight: bold; color: #000000">' .  $tt . '</span>',
            'answer' => $type == 6 ? array($nv_Lang->getModule('question_type_6')) : array()
        );
        if ($type == 4) {
            $answer = array(
                array(
                    'content' => $nv_Lang->getModule('question_type_4_1'),
                    'is_true' => $answer == 1 ? 1 : 0,
                    'origin' => $nv_Lang->getModule('question_type_4_1')
                ),
                array(
                    'content' => $nv_Lang->getModule('question_type_4_2'),
                    'is_true' => $answer == 0 ? 1 : 0,
                    'origin' => $nv_Lang->getModule('question_type_4_2')
                )
            );
        }

        foreach ($answer as $item) {
            ++$i;
            $content = '<span style="font-weight: bold; color: #000000">' . number_to_alphabet($i)  . '. </span>';
            $item['content'] = $ck_editor_word->insert_content_into_html($content, $item['content']);
            $html_item .= ("<td>" . $item['content']  . ($type == 2 ? '.............................' : '')  . "</td>");
            if (($i % 2 == 0) || ($i == count($answer))) {
                $html_item .= ("<tr>" . $html_item . "</tr>");
                $html_answer .= $html_item;
                $html_item = "";
            }
            if (($type == 1) || ($type == 3)) {
                if ($item['is_true'] == 1) {
                    $correct_answer[$tt]['answer'][] = number_to_alphabet($i);
                }
            } elseif ($type == 2) {
                $correct_answer[$tt]['answer'][] = $content .  $item['is_true'] . '<br />';
            } elseif ($type == 4) {
                if ($item['is_true'] == 1) {
                    $correct_answer[$tt]['answer'][] = $item['origin'];
                }
            } elseif ($type == 5) {
                $correct_answer[$tt]['answer'][] = $content . $item['point'] . ' đ<br />';
            }
        }
        $html_answer = "<table style='border-color: #ffffff; vertical-align: top'>" . $html_answer . "</table>";
        $ck_editor_word->addEditor($html_answer);
        $ck_editor_word->addTextBreak();
        $tt++;
    }
    return $correct_answer;
}

function get_exptime_site($id)
{
    global $db;
    $sql = 'SELECT exptime FROM aztest_system.nv4_site WHERE idsite=' . $id;
    $result = $db->query($sql)->fetch();
    return $result['exptime'];
}
/**
 * Xuất đề thi ra file word theo lịch sử trộn đề
 */
function export_word_from_merge_history($hm_id)
{
    global $db, $module_name, $ck_editor_word, $array_config;
    $db->sqlreset()
        ->select('title, content')
        ->from(NV_PREFIXLANG . '_' . $module_name . '_history_merge')
        ->where('id = ' . $hm_id);
    list($exam_title, $content) = $db->query($db->sql())->fetch(3);
    $content = unserialize($content);
    $question_list = $content['question_list'];
    $result = $content['result'];

    $correct_answer = array();
    $ck_editor_word->reset();
    foreach ($result as $key => $question) {
        $arr_question_value = array();
        foreach ($question as $k => $v) {
            $answer = array();
            $i = 0;
            foreach ($v as $ans) {
                $i++;
                $answer[$i] = $question_list[$k]['answer'][$ans];
            }
            $arr_question_value[] = array(
                'title' => $question_list[$k]['title'],
                'type' => $question_list[$k]['type'],
                'answer' => $answer
            );
        }
        $ck_editor_word->addEditor($array_config['top_content_exam']);
        $ck_editor_word->addTextBreak();
        $ck_editor_word->addEditor('<p style="font-weight: bold; font-size: 18; text-align: center;text-transform: uppercase;">' . mb_strtoupper($exam_title, 'UTF-8') . '</p>');
        $ck_editor_word->addEditor('<p style="font-weight: bold; font-size: 14; text-align: center">(Mã đề thi: ' . str_replace('_', '-', $key) . ')</p>');
        $ck_editor_word->addTextBreak();
        $correct_answer[$key] = export_word_from_question(null, 1, false, $arr_question_value);
        $ck_editor_word->addPageBreak();
    }
    $ck_editor_word->addEditor('<p style="font-weight: bold; font-size: 18; text-align: center;text-transform: uppercase;">ĐÁP ÁN</p>');
    $ck_editor_word->addEditor('<p style="font-weight: bold; font-size: 18; text-align: center;text-transform: uppercase;">' . mb_strtoupper($exam_title, 'UTF-8') . '</p>');
    export_word_multi_correct_answer($correct_answer);
    $ck_editor_word->export_word(change_alias($exam_title));
}
function change_question_order($exam_id, $question_id, $order_new) {
    global $db, $module_data;
    $table_question = NV_PREFIXLANG . '_' . $module_data . '_question';
    $db->sqlreset()
    ->select('weight')
    ->from($table_question)
    ->where('id=' . $question_id);
    list($order_old) = $db->query($db->sql())->fetch(3);
    if (!empty($exam_id) && !empty($question_id) && !empty($order_old) && !empty($order_new)) {
        // Lấy tổng số câu hỏi
        $db->sqlreset()
        ->select('COUNT(*)')
        ->from($table_question)
        ->where('examid=' . $exam_id);
        $nums = $db->query($db->sql())->fetchColumn();
        if (($order_new > $nums) || ($order_new<=0)) {
            die('error_range');
        }
        $order_old = $nums < $order_old ? $nums : $order_old;
        $order_new = $nums < $order_new ? $nums : $order_new;
        $f = $order_new < $order_old ? $order_new : $order_old;
        $l = $order_new > $order_old ? $order_new : $order_old;

        $db->query('UPDATE ' . $table_question . ' SET weight = ' . $order_new . ' WHERE id = ' . $question_id);
        $db->sqlreset()
        ->select('id')
        ->from($table_question)
        ->where('examid=' . $exam_id . ' AND weight >= ' . $f . ' AND weight <= ' . $l . ' AND id != ' . $question_id)
        ->order('weight ASC');
        $result = $db->query($db->sql());
        $i = $order_old < $order_new ? $f : ($f + 1);
        while (list($id) = $result->fetch(3)) {
            $db->query('UPDATE ' . $table_question . ' SET weight = ' . $i . ' WHERE id = ' . $id);
            $i++;
        }
        return true;
    }
    return false;
}