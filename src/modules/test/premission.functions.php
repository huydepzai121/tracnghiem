<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 12/31/2009 0:51
 */
if (!defined('NV_MAINFILE')) {
    die('Stop!!!');
}

// Default setting
$array_premission = array(
    'max_user_admin' => 9999999999, // Số người thi trong 1 phòng thi
    'max_user_number' => 9999999999, // Số người thi trong 1 phòng thi
    'max_user_test_room' => 9999999999, // Số người thi trong 1 phòng thi
    'max_user_test_site' => 9999999999, // Số người thi toàn hệ thống
    'question_bank_owns' => true, // Ngân hàng câu hỏi tự tạo
    'import_question_bank' => true, // Import từ Ngân hàng câu hỏi độc quyền của Aztest (*)
    'question_bank_shared' => true, // Ngân hàng câu hỏi dùng chung (*)
    'create_unlimited_an_exam' => true, // Tạo đề thi không giới hạn
    'rating_results' => true, // Xếp loại kết quả thi
    'import_word' => true, // Tạo danh sách câu hỏi từ MS Word
    'import_excel' => true, // Tạo danh sách câu hỏi từ MS Excel
    'create_related_exam_groups' => true, // Tạo nhóm đề thi liên quan
    'create_topics_by_keyword_search' => true, // Tạo đề theo từ khóa tìm kiếm
    'solution_hint' => true, // Thêm hướng dẫn, gợi ý giải câu hỏi
    'random_question_answer' => true, // Trộn ngẫu nhiên câu hỏi, đáp án
    'permissions_anagement' => true, // Phân quyền quản lý
    'comments_in_the_exam' => true, // Bình luận trong đề thi
    'save_result' => true, // Cấu hình lưu lịch sử bài thi
    'require_once_wallet' => true, // Cấu hình lưu lịch sử bài thi
    'bank' => 1,
    'merge_exams' => true, 
    'aztest_questions_bank' => true
);

if (!empty($global_config['idsite'])) {
    // Detail site
    $sql = "SELECT * FROM " . $db_config['dbsystem'] . "." . $db_config['prefix'] . "_site WHERE idsite=" . $global_config['idsite'];
    $result = $db->query($sql);
    $row_site = $result->fetch();

    // chổ này fix cứng, cần sửa lại sau
    if (defined('NV_CONFIG_DIR') && $global_config['idsite'] && isset($row_site['cid']) && !empty($row_site['cid'])) {
        if ($row_site['cid'] == 3) {
            $array_premission['useguide'] = 0;
            $array_premission['admins'] = 0;
        } elseif ($row_site['cid'] == 4) {
            $array_premission['admins'] = 0;
        }
    }
    $global_config['aztest_questions_bank'] = true;
    $array_package = array(
        '3' => array(
            'question_bank_owns' => true, // Ngân hàng câu hỏi tự tạo
            'import_question_bank' => true, // Import từ Ngân hàng câu hỏi độc quyền của Aztest (*)
            'question_bank_shared' => true, // Ngân hàng câu hỏi dùng chung (*)
            'create_unlimited_an_exam' => true, // Tạo đề thi không giới hạn
            'rating_results' => true, // Xếp loại kết quả thi
            'import_word' => true, // Tạo danh sách câu hỏi từ MS Word
            'import_excel' => true, // Tạo danh sách câu hỏi từ MS Excel
            'create_related_exam_groups' => true, // Tạo nhóm đề thi liên quan
            'create_topics_by_keyword_search' => true, // Tạo đề theo từ khóa tìm kiếm
            'solution_hint' => true, // Thêm hướng dẫn, gợi ý giải câu hỏi
            'random_question_answer' => true, // Trộn ngẫu nhiên câu hỏi, đáp án
            'permissions_anagement' => false, // Phân quyền quản lý
            'comments_in_the_exam' => true, // Bình luận trong đề thi
            'notice_update' => 'Bạn đang sử dụng gói Free! Toàn bộ đề thi & câu hỏi của bạn thêm vào đây sẽ được hiển thị sang ngân hàng đề thi/ ngân hàng câu hỏi dùng chung (tất cả mọi người có thể sử dụng). Để bảo mật kho đề, bạn hãy sử dụng <a href="https://aztest.vn/bang-gia.html">gói trả phí.</a>', // Cảnh báo nâng cấp gói sử dụng
            'save_result' => false, // Cấu hình lưu lịch sử bài thi
            'require_once_wallet' => false, // Cấu hình lưu lịch sử bài thi
            'allow_config_history_user_common' => false, // Cấu hình cho phép tài khoản chung lưu lịch sử thi
            'merge_exams' => false, // Chức năng trộn đề
            'unallow_exams_bank' => true, // Không cho phép sử dụng chức năng "Ngân hàng đề thi aztest"
            'unallow_history' => true, // Không cho phép sử dụng chức năng "Ngân hàng đề thi aztest"
            'aztest_questions_bank' => false
        ),
        '9' => array(
            'question_bank_owns' => true, // Ngân hàng câu hỏi tự tạo
            'import_question_bank' => true, // Import từ Ngân hàng câu hỏi độc quyền của Aztest (*)
            'question_bank_shared' => true, // Ngân hàng câu hỏi dùng chung (*)
            'create_unlimited_an_exam' => true, // Tạo đề thi không giới hạn
            'rating_results' => true, // Xếp loại kết quả thi
            'import_word' => true, // Tạo danh sách câu hỏi từ MS Word
            'import_excel' => true, // Tạo danh sách câu hỏi từ MS Excel
            'create_related_exam_groups' => true, // Tạo nhóm đề thi liên quan
            'create_topics_by_keyword_search' => true, // Tạo đề theo từ khóa tìm kiếm
            'solution_hint' => true, // Thêm hướng dẫn, gợi ý giải câu hỏi
            'random_question_answer' => true, // Trộn ngẫu nhiên câu hỏi, đáp án
            'permissions_anagement' => false, // Phân quyền quản lý
            'comments_in_the_exam' => true, // Bình luận trong đề thi
            'notice_update' => !empty($nv_Lang->getGlobal('mes_trial')) ? $nv_Lang->getGlobal('mes_trial') : '', // Cảnh báo nâng cấp gói sử dụng
            'save_result' => false, // Cấu hình lưu lịch sử bài thi
            'require_once_wallet' => false, // Cấu hình lưu lịch sử bài thi
            'allow_config_history_user_common' => false, // Cấu hình cho phép tài khoản chung lưu lịch sử thi
            'merge_exams' => false, // Chức năng trộn đề
            'guider' => true, // Thông báo hướng dẫn
            'input_question_disable_exam' => array(
                1, // không cho phép nhập câu hỏi từ MS Word
                3, // không cho phép nhập câu hỏi từ MS Excel
                4   // không cho phép nhập câu hỏi từ ngân hàng đề thi AZtest
            ),
            'unallow_exams_bank' => true, // Không cho phép sử dụng chức năng "Ngân hàng đề thi aztest"
            'unallow_exams_config_content_bank' => true, // Không cho phép sử dụng chức năng "Thêm từ ngân hàng chung" ở "Cấu hình đề thi"
            'aztest_questions_bank' => false
        ),
        '4' => array(
            'question_bank_owns' => true, // Ngân hàng câu hỏi tự tạo
            'import_question_bank' => false, // Import từ Ngân hàng câu hỏi độc quyền của Aztest (*)
            'question_bank_shared' => true, // Ngân hàng câu hỏi dùng chung (*)
            'create_unlimited_an_exam' => true, // Tạo đề thi không giới hạn
            'rating_results' => true, // Xếp loại kết quả thi
            'import_word' => true, // Tạo danh sách câu hỏi từ MS Word
            'import_excel' => true, // Tạo danh sách câu hỏi từ MS Excel
            'create_related_exam_groups' => true, // Tạo nhóm đề thi liên quan
            'create_topics_by_keyword_search' => true, // Tạo đề theo từ khóa tìm kiếm
            'solution_hint' => true, // Thêm hướng dẫn, gợi ý giải câu hỏi
            'random_question_answer' => true, // Trộn ngẫu nhiên câu hỏi, đáp án
            'permissions_anagement' => false, // Phân quyền quản lý
            'comments_in_the_exam' => true, // Bình luận trong đề thi
            'save_result' => true, // Cấu hình lưu lịch sử bài thi
            'require_once_wallet' => true, // Cấu hình lưu lịch sử bài thi
            'allow_config_history_user_common' => true, // Cấu hình cho phép tài khoản chung lưu lịch sử thi
            'merge_exams' => true, // Chức năng trộn đề 
            'aztest_questions_bank' => true
        ),
        '5' => array(
            'question_bank_owns' => true, // Ngân hàng câu hỏi tự tạo
            'import_question_bank' => true, // Import từ Ngân hàng câu hỏi độc quyền của Aztest (*)
            'question_bank_shared' => true, // Ngân hàng câu hỏi dùng chung (*)
            'create_unlimited_an_exam' => true, // Tạo đề thi không giới hạn
            'rating_results' => true, // Xếp loại kết quả thi
            'import_word' => true, // Tạo danh sách câu hỏi từ MS Word
            'import_excel' => true, // Tạo danh sách câu hỏi từ MS Excel
            'create_related_exam_groups' => true, // Tạo nhóm đề thi liên quan
            'create_topics_by_keyword_search' => true, // Tạo đề theo từ khóa tìm kiếm
            'solution_hint' => true, // Thêm hướng dẫn, gợi ý giải câu hỏi
            'random_question_answer' => true, // Trộn ngẫu nhiên câu hỏi, đáp án
            'permissions_anagement' => true, // Phân quyền quản lý
            'comments_in_the_exam' => true, // Bình luận trong đề thi
            'save_result' => true, // Cấu hình lưu lịch sử bài thi
            'require_once_wallet' => true, // Cấu hình lưu lịch sử bài thi
            'allow_config_history_user_common' => true, // Cấu hình cho phép tài khoản chung lưu lịch sử thi
            'merge_exams' => true, // Chức năng trộn đề 
            'aztest_questions_bank' => true
        ),
        '8' => array(
            'question_bank_owns' => true, // Ngân hàng câu hỏi tự tạo
            'import_question_bank' => true, // Import từ Ngân hàng câu hỏi độc quyền của Aztest (*)
            'question_bank_shared' => true, // Ngân hàng câu hỏi dùng chung (*)
            'create_unlimited_an_exam' => true, // Tạo đề thi không giới hạn
            'rating_results' => true, // Xếp loại kết quả thi
            'import_word' => true, // Tạo danh sách câu hỏi từ MS Word
            'import_excel' => true, // Tạo danh sách câu hỏi từ MS Excel
            'create_related_exam_groups' => true, // Tạo nhóm đề thi liên quan
            'create_topics_by_keyword_search' => true, // Tạo đề theo từ khóa tìm kiếm
            'solution_hint' => true, // Thêm hướng dẫn, gợi ý giải câu hỏi
            'random_question_answer' => true, // Trộn ngẫu nhiên câu hỏi, đáp án
            'permissions_anagement' => true, // Phân quyền quản lý
            'comments_in_the_exam' => true, // Bình luận trong đề thi
            'save_result' => true, // Cấu hình lưu lịch sử bài thi
            'require_once_wallet' => true, // Cấu hình lưu lịch sử bài thi
            'allow_config_history_user_common' => true, // Cấu hình cho phép tài khoản chung lưu lịch sử thi
            'merge_exams' => true, // Chức năng trộn đề
            'aztest_questions_bank' => true
        ),
        '7' => array(
            'question_bank_owns' => true, // Ngân hàng câu hỏi tự tạo
            'import_question_bank' => true, // Import từ Ngân hàng câu hỏi độc quyền của Aztest (*)
            'question_bank_shared' => true, // Ngân hàng câu hỏi dùng chung (*)
            'create_unlimited_an_exam' => true, // Tạo đề thi không giới hạn
            'rating_results' => true, // Xếp loại kết quả thi
            'import_word' => true, // Tạo danh sách câu hỏi từ MS Word
            'import_excel' => true, // Tạo danh sách câu hỏi từ MS Excel
            'create_related_exam_groups' => true, // Tạo nhóm đề thi liên quan
            'create_topics_by_keyword_search' => true, // Tạo đề theo từ khóa tìm kiếm
            'solution_hint' => true, // Thêm hướng dẫn, gợi ý giải câu hỏi
            'random_question_answer' => true, // Trộn ngẫu nhiên câu hỏi, đáp án
            'permissions_anagement' => true, // Phân quyền quản lý
            'comments_in_the_exam' => true, // Bình luận trong đề thi
            'save_result' => true, // Cấu hình lưu lịch sử bài thi
            'require_once_wallet' => true, // Cấu hình lưu lịch sử bài thi
            'allow_config_history_user_common' => true, // Cấu hình cho phép tài khoản chung lưu lịch sử thi
            'merge_exams' => true, // Chức năng trộn đề
            'aztest_questions_bank' => true,
            'merge_exams' => true // Chức năng trộn đề 
        )
    );

    // dữ liệu chính thức
    $global_config = array_merge($global_config, $array_package[$row_site['cid']], array('cid' => $row_site['cid'], 'addtime_site' => $row_site['addtime']));
} else {
    $global_config = array_merge($global_config, $array_premission);
}
