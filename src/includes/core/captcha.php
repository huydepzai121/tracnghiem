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

mt_srand(microtime(true) * 1000000);
$maxran = 1000000;
$random_num = random_int(1, $maxran);

$nv_Request->set_Session('random_num', $random_num);

$datekey = date('F j');
$rcode = strtoupper(md5(NV_USER_AGENT . $global_config['sitekey'] . $random_num . $datekey));
$code = substr($rcode, 2, NV_GFX_NUM);

$image = imagecreate(NV_GFX_WIDTH, NV_GFX_HEIGHT);
$bgc = imagecolorallocate($image, 240, 240, 240);
imagefilledrectangle($image, 0, 0, NV_GFX_WIDTH, NV_GFX_HEIGHT, $bgc);

$text_color = imagecolorallocate($image, 50, 50, 50);
/* output each character */
for ($l = 0; $l < 5; ++$l) {
    $r = random_int(120, 255);
    $g = random_int(120, 255);
    $b = random_int(120, 255);
    $color_elipse = imagecolorallocate($image, round($r * 0.90), round($g * 0.90), round($b * 0.90));
    $cx = random_int(0, NV_GFX_WIDTH - NV_GFX_HEIGHT);
    $cy = random_int(0, NV_GFX_WIDTH - NV_GFX_HEIGHT);
    $rx = random_int(10, NV_GFX_WIDTH - NV_GFX_HEIGHT);
    $ry = random_int(10, NV_GFX_WIDTH - NV_GFX_HEIGHT);
    imagefilledellipse($image, $cx, $cy, $rx, $ry, $color_elipse);
}

$r = random_int(0, 100);
$g = random_int(0, 100);
$b = random_int(0, 100);
$text_color = imagecolorallocate($image, $r, $g, $b);

$ff = random_int(1, 15);
$font = NV_ROOTDIR . '/includes/fonts/captcha/font' . $ff . '.ttf';

if (file_exists($font) and nv_function_exists('imagettftext')) {
    imagettftext($image, 15, 0, 5, NV_GFX_HEIGHT - 3, $text_color, $font, $code);
} else {
    imagestring($image, 5, 20, 6, $code, $text_color);
}

header('Content-type: image/jpeg');
header('Cache-Control:');
header('Pragma:');
header('Set-Cookie:');
imagejpeg($image, null, 80);
version_compare(PHP_VERSION, '8.0.0', '<') && imagedestroy($image);
exit();
