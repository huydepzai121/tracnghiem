<?php

/**
 * NukeViet Content Management System
 * @version 5.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2025 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

declare(strict_types=1);

use Rector\Config\RectorConfig;

$config = RectorConfig::configure();

$config->withPaths([
    __DIR__ . '/src',
    __DIR__ . '/tests',
    __DIR__ . '/tools',
]);

$config->withSkip([
    __DIR__ . '/src/vendor/*',
    '!' . __DIR__ . '/src/vendor/vinades/*',
]);

// $config->withPhpSets(php56: true);

$config->withTypeCoverageLevel(0);
$config->withDeadCodeLevel(0);
$config->withCodeQualityLevel(0);

/* $config->withPreparedSets(
    rectorPreset: true
); */

return $config;
