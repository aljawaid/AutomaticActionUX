<?php
/**
 * Verify escaping and constrained attribute output in the automatic-action template.
 *
 * Related file: Template/action/index.php.
 */

$pluginRoot = dirname(__DIR__);
$template = file_get_contents($pluginRoot . '/Template/action/index.php');
$failures = array();

$requiredSnippets = array(
    '$this->text->e($project[\'name\'])',
    "preg_replace('/[^a-z0-9_-]+/'",
    '$this->text->e($colorClass)',
    "(int) \$action['id']",
    "t('Automatic Action not found: \"%s\"', \$action['action_name'])",
);

foreach ($requiredSnippets as $snippet) {
    if (strpos($template, $snippet) === false) {
        $failures[] = 'Missing output-safety contract: ' . $snippet;
    }
}

$forbiddenSnippets = array(
    "<?= \$project['name'] ?>",
    "action-color-<?= (strtolower(str_replace",
    "<?= \$action['id'] ?>",
);

foreach ($forbiddenSnippets as $snippet) {
    if (strpos($template, $snippet) !== false) {
        $failures[] = 'Unsafe output pattern remains: ' . $snippet;
    }
}

if ($failures !== array()) {
    fwrite(STDERR, implode(PHP_EOL, $failures) . PHP_EOL);
    exit(1);
}

echo "Template output security contract passed." . PHP_EOL;
