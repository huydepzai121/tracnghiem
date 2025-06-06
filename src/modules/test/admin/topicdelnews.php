<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-9-2010 14:43
 */
if (!defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

$id = $nv_Request->get_string('list', 'post,get');
$id = array_map('trim', array_unique(array_filter(explode(',', $id))));

foreach ($id as $value) {
    $sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_exams SET topicid=0 WHERE id = " . intval($value);
    $db->query($sql);
}

echo $nv_Lang->getModule('topic_delete_success');