<?php

/**
 * Verify that AutomaticActionUX styling remains scoped, responsive and theme-aware.
 *
 * Related files: Assets/css/automatic-action-ux.css and Template/project_header/actions.php.
 */

$pluginRoot = dirname(__DIR__);
$css = file_get_contents($pluginRoot . '/Assets/css/automatic-action-ux.css');
$projectTemplate = file_get_contents($pluginRoot . '/Template/project_header/actions.php');
$failures = array();

if (preg_match('/#[0-9a-f]{3,8}\b/i', $css) === 1) {
    $failures[] = 'The stylesheet contains a fixed hexadecimal colour.';
}
if (strpos($css, ':root') !== false || strpos($css, '--pp-') !== false) {
    $failures[] = 'The plugin must not define global colour variables.';
}
if (strpos($css, '!important') !== false) {
    $failures[] = 'The scoped stylesheet must not rely on !important.';
}

foreach (array('.float-right', '.text-center', '.display-none', '.bl-0', '.not-set', '.form-warning', 'h2 > svg', 'ul#BoardViews') as $selector) {
    if (preg_match('/(?m)^' . preg_quote($selector, '/') . '\s*[{,]/', $css) === 1) {
        $failures[] = 'Unscoped selector remains: ' . $selector;
    }
}

foreach (array('--color-primary', '--color-light', '--link-color-primary', '--table-border-color', '--table-header-background-color', '--button-primary-background-color', '--form-error-color') as $variable) {
    if (strpos($css, 'var(' . $variable . ')') === false) {
        $failures[] = 'Missing Kanboard theme variable: ' . $variable;
    }
}

if (strpos($css, '@media (max-width: 768px)') === false || strpos($css, '#ActionTable.table-scrolling') === false) {
    $failures[] = 'Responsive action-table styling is missing.';
}

if (strpos($css, '#BoardActions.aa-is-hidden') === false || strpos($projectTemplate, ' aa-is-hidden') === false) {
    $failures[] = 'The project-menu visibility class is not consistently scoped.';
}

if ($failures !== array()) {
    fwrite(STDERR, implode(PHP_EOL, $failures) . PHP_EOL);
    exit(1);
}

echo "Theme contract passed." . PHP_EOL;
