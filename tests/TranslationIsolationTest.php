<?php
/**
 * Verify AutomaticActionUX translation isolation and catalogue completeness.
 *
 * Related files: Plugin.php, Template/action/index.php, Template/project_header/actions.php and the Locale translation catalogues.
 */

$pluginRoot = dirname(__DIR__);
$localeCodes = array('en_US', 'en_GB', 'fr_FR', 'de_DE', 'de_DE_du');
$catalogues = array();
$failures = array();

foreach ($localeCodes as $localeCode) {
    $localeFile = $pluginRoot . '/Locale/' . $localeCode . '/translations.php';
    if (! is_file($localeFile)) {
        $failures[] = 'Missing locale catalogue: ' . $localeCode;
        continue;
    }

    $catalogue = require $localeFile;
    $catalogues[$localeCode] = $catalogue;
    foreach ($catalogue as $key => $value) {
        if (strpos($key, 'automatic_action_ux.') !== 0) {
            $failures[] = $localeCode . ' contains a non-namespaced key: ' . $key;
        }
        if ($value === '') {
            $failures[] = $localeCode . ' contains an empty translation: ' . $key;
        }
    }
}

if (isset($catalogues['en_US'])) {
    $referenceKeys = array_keys($catalogues['en_US']);
    sort($referenceKeys);
    foreach ($catalogues as $localeCode => $catalogue) {
        $keys = array_keys($catalogue);
        sort($keys);
        if ($keys !== $referenceKeys) {
            $failures[] = $localeCode . ' does not contain the complete isolated key set.';
        }
    }

    $starter = require $pluginRoot . '/Locale/translations-starter-template.php';
    $starterKeys = array_keys($starter);
    sort($starterKeys);
    if ($starterKeys !== $referenceKeys || array_filter($starter, static fn ($value) => $value !== '') !== array()) {
        $failures[] = 'The translation starter template does not match the complete key set.';
    }

    $source = file_get_contents($pluginRoot . '/Plugin.php')
        . file_get_contents($pluginRoot . '/Template/action/index.php')
        . file_get_contents($pluginRoot . '/Template/project_header/actions.php');
    preg_match_all("/['\"](automatic_action_ux\.[a-z0-9_]+)['\"]/", $source, $matches);
    $usedKeys = array_values(array_unique($matches[1]));
    sort($usedKeys);
    if ($usedKeys !== $referenceKeys) {
        $failures[] = 'The source and translation catalogues use different namespaced key sets.';
    }
}

$plugin = file_get_contents($pluginRoot . '/Plugin.php');
$englishPosition = strpos($plugin, "Translator::load('en_US'");
$currentPosition = strpos($plugin, 'Translator::load($currentLanguage');
if ($englishPosition === false || $currentPosition === false || $englishPosition > $currentPosition) {
    $failures[] = 'US English must load before the selected locale.';
}

if ($failures !== array()) {
    fwrite(STDERR, implode(PHP_EOL, array_unique($failures)) . PHP_EOL);
    exit(1);
}

echo "Translation isolation contract passed." . PHP_EOL;
