<?php

/**
 * Verify that project action metadata is protected by Kanboard project permissions.
 *
 * Related file: Template/project_header/actions.php.
 */

$pluginRoot = dirname(__DIR__);
$template = file_get_contents($pluginRoot . '/Template/project_header/actions.php');
$failures = array();

$guardPosition = strpos($template, "hasProjectAccess('ActionController', 'index'");
$conditionalPosition = strpos($template, 'if ($canViewAutomaticActions):');
$queryPosition = strpos($template, 'getAllByProject');
$listItemPosition = strpos($template, '<li id="BoardActions"');

if ($guardPosition === false || $conditionalPosition === false || $queryPosition === false || $listItemPosition === false) {
    $failures[] = 'The project header permission contract is incomplete.';
} elseif (!($guardPosition < $conditionalPosition && $conditionalPosition < $queryPosition && $queryPosition < $listItemPosition)) {
    $failures[] = 'Permission must be checked before action metadata is queried or rendered.';
}

if (strpos($template, '<?php if ($canViewAutomaticActions): ?>') === false || strpos($template, '<?php endif ?>') === false) {
    $failures[] = 'The complete action summary must be enclosed by the permission guard.';
}

if (preg_match('/<\?php else: \?>\s*<\?= count\(\$actions\) \?>/', $template) === 1) {
    $failures[] = 'Restricted users must not receive an action-count fallback.';
}

if ($failures !== array()) {
    fwrite(STDERR, implode(PHP_EOL, $failures) . PHP_EOL);
    exit(1);
}

echo "Project header permission contract passed." . PHP_EOL;
