<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 03-05-2010
 */
if (!defined('NV_IS_MOD_SEARCH')) {
    die('Stop!!!');
}

$_sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $m_values['module_data'] . '_cat WHERE status=1 ORDER BY sort';
$array_test_cat = $nv_Cache->db($_sql, 'id', $m_values['module_name']);

$db_slave->sqlreset()
    ->select('COUNT(*)')
    ->from(NV_PREFIXLANG . '_' . $m_values['module_data'] . '_exams')
    ->where('(' . nv_like_logic('title', $dbkeyword, $logic) . ' OR ' . nv_like_logic('alias', $dbkeyword, $logic) . ' OR ' . nv_like_logic('code', $dbkeyword, $logic) . ' OR ' . nv_like_logic('hometext', $dbkeyword, $logic) . ' OR ' . nv_like_logic('description', $dbkeyword, $logic) . ')');
$num_items = $db_slave->query($db_slave->sql())
    ->fetchColumn();

if ($num_items) {
    $db_slave->select('id, title, alias, catid, hometext, description')
        ->limit($limit)
        ->offset(($page - 1) * $limit);
    $result = $db_slave->query($db_slave->sql());
    while (list ($id, $tilterow, $alias, $catid, $hometext, $description) = $result->fetch(3)) {
        $result_array[] = array(
            'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $m_values['module_name'] . '&amp;' . NV_OP_VARIABLE . '=' . $array_test_cat[$catid]['alias'] . '/' . $alias . '-' . $id . $global_config['rewrite_exturl'],
            'title' => BoldKeywordInStr($tilterow, $key, $logic),
            'content' => BoldKeywordInStr($hometext . ' ' . $description, $key, $logic)
        );
    }
}
