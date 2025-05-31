<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_MAINFILE')) {
    exit('Stop!!!');
}

// FIXME xóa plugin sau khi dev xong giao diện admin_future
nv_add_hook($module_name, 'get_global_admin_theme', $priority, function ($vars) {
    $admin_theme = $vars[0];
    $module_name = $vars[1];
    $module_info = $vars[2];
    $op = $vars[3];

    $new_theme = 'admin_future';

    if (($module_info['module_file'] ?? '') == 'news' and in_array($op, ['drafts', 'report', 'content', 'tags', 'main'])) {
        return $new_theme;
    }
    if (($module_info['module_file'] ?? '') == 'users' and in_array($op, ['config'])) {
        return $new_theme;
    }
    if (in_array($module_name, ['upload', 'themes', 'emailtemplates', 'settings', 'seotools', 'modules', 'extensions', 'webtools', 'language', 'siteinfo', 'authors', 'database', 'comment'])) {
        return $new_theme;
    }
    if (($module_info['module_file'] ?? '') == 'voting' and in_array($op, ['main', 'setting'])) {
        return $new_theme;
    }
    if (($module_info['module_file'] ?? '') == 'contact' and in_array($op, ['main'])) {
        return $new_theme;
    }
    if (($module_info['module_file'] ?? '') == 'page' and in_array($op, ['config'])) {
        return $new_theme;
    }

    if (($module_info['module_file'] ?? '') == 'test' and in_array($op, ['addtotopics', 'admins', 'ajax', 'bank', 'bank_list', 'block', 'cat', 'chang_block_cat', 'change_block', 'change_cat', 'change_topic', 'config', 'del_topic', 'detail', 'econtent', 'exam-subject', 'examinations', 'examinations-content', 'exams', 'exams-config', 'exams-config-content', 'exams-config-content-bank', 'exams-content', 'exams_bank', 'exams_bank_cats', 'exams_bank_chap', 'exams_bank_class', 'exams_bank_content', 'exams_bank_mon_hoc', 'groups', 'history', 'history-view', 'list_block', 'list_block_cat', 'list_topic', 'main', 'merge-exams', 'publtime', 'question', 'question-content', 'question-list', 'questionexcel', 'questionword', 'random_exam', 'random_exam_content', 'random_question', 'random_question_content', 'rating', 'result_exam', 'search_questions', 'sendapprov', 'sources', 'statistics_testing', 'tags', 'tagsajax', 'theme', 'topicajax', 'topicdelnews', 'topics', 'topicsnews', 'update-bank-cat', 'view'])) {
        return $new_theme;
    }

    return $admin_theme;
});
