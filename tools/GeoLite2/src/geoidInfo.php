<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 31/05/2010, 00:36
 */

/*
 * Đọc CODE quốc gia
 */
$geoinfoFile = NV_ROOTDIR . '/libs/GeoLite2-Country-Locations-en.csv';
if (!file_exists($geoinfoFile)) {
    echo "File not exists: libs/GeoLite2-Country-Locations-en.csv\n";
    exit(1);
}

$array_geo_info = [];
$f = fopen($geoinfoFile, 'r');
if ($f === false) {
    echo "Cannot open the file: libs/GeoLite2-Country-Locations-en.csv\n";
    exit(1);
}

$stt = 0;
while (($row = fgetcsv($f)) !== false) {
    if ($stt ++ == 0) {
        // Bỏ qua cột tiêu đề
        continue;
    }
    if (!empty($row[4]) and !empty($row[0])) {
        $array_geo_info[$row[0]] = $row[4];
    }
}
fclose($f);
unset($geoinfoFile, $f, $row);
