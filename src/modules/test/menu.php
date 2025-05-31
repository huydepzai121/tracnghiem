<?php

/**
 * @Project NUKEVIET 4.x
 * @Author mynukeviet (contact@mynukeviet.net)
 * @Copyright (C) 2017 mynukeviet. All rights reserved
 * @Createdate Sat, 01 Apr 2017 00:52:38 GMT
 */
if (!defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}
$result = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $mod_data . '_cat WHERE status=1 ORDER BY sort');
while ($row = $result->fetch()) {
    $array_item[$row['id']] = array(
        'parentid' => $row['parentid'],
        'groups_view' => $row['groups_view'],
        'key' => $row['id'],
        'title' => $row['title'],
        'alias' => $row['alias']
    );
}
