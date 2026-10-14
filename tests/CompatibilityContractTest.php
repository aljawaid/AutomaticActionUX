<?php

/**
 * Verify declared Kanboard and PHP compatibility details.
 *
 * Related files: Plugin.php, README.md and .github/workflows/php-compatibility.yaml.
 */

$pluginRoot = dirname(__DIR__);
$plugin = file_get_contents($pluginRoot . '/Plugin.php');
$readme = file_get_contents($pluginRoot . '/README.md');
$workflow = file_get_contents($pluginRoot . '/.github/workflows/php-compatibility.yaml');
$failures = array();

if (strpos($plugin, "return '>=1.2.54';") === false) {
    $failures[] = 'Plugin.php must require Kanboard 1.2.54 or newer.';
}
if (strpos($readme, '≥`1.2.54`') === false || strpos($readme, 'PHP `8.2`–`8.5`') === false) {
    $failures[] = 'README compatibility details are incomplete.';
}
if (strpos($plugin . $readme, '1.2.20') !== false) {
    $failures[] = 'The obsolete Kanboard 1.2.20 declaration remains.';
}
foreach (array("'8.2'", "'8.3'", "'8.4'", "'8.5'", 'KANBOARD_VERSION: v1.2.54') as $contract) {
    if (strpos($workflow, $contract) === false) {
        $failures[] = 'Missing workflow compatibility contract: ' . $contract;
    }
}

if ($failures !== array()) {
    fwrite(STDERR, implode(PHP_EOL, $failures) . PHP_EOL);
    exit(1);
}

echo "Compatibility declaration contract passed." . PHP_EOL;
