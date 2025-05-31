<?php

/**
 * @Project NUKEVIET 4.x
 * @Author hongoctrien (contact@mynukeviet.net)
 * @Copyright (C) 2016 hongoctrien. All rights reserved
 * @Createdate Wed, 27 Apr 2016 07:24:36 GMT
 */
if (!defined('NV_MAINFILE')) die('Stop!!!');

$module_version = array(
    'name' => 'Test',
    'modfuncs' => 'main,detail,topic,tag,groups,viewcat,history,print,rss,usersave,share,examinations,examinations-subject',
    'change_alias' => 'main,detail,topic,tag,groups,viewcat,history,print,usersave,share,examinations,examinations-subject',
    'submenu' => 'history,usersave',
    'is_sysmod' => 0,
    'virtual' => 1,
    'version' => '1.0.01',
    'date' => 'Wed, 27 Apr 2016 07:24:36 GMT',
    'author' => 'hongoctrien (contact@mynukeviet.net)',
    'uploads_dir' => array(
        $module_upload,
        $module_upload . '/topics'
    ),
    'files_dir' => array(
        $module_upload,
        $module_upload . '/topics'
    ),
    'note' => ''
);
