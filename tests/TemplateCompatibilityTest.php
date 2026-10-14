<?php
/**
 * Verify the AutomaticActionUX template contract for Kanboard 1.2.54.
 *
 * Related files: Template/action/index.php and Template/project_header/actions.php.
 */

$pluginRoot = dirname(__DIR__);
$actionTemplate = file_get_contents($pluginRoot . '/Template/action/index.php');
$projectTemplate = file_get_contents($pluginRoot . '/Template/project_header/actions.php');
$failures = array();

foreach (array($actionTemplate, $projectTemplate) as $template) {
    if (stripos($template, '<style') !== false) {
        $failures[] = 'Template markup must not contain embedded style elements.';
    }
}

if (preg_match('/\swidth="[^"]+"/', $actionTemplate) === 1) {
    $failures[] = 'Template column sizing must remain in the scoped stylesheet.';
}

$requiredVariables = array(
    '$actions', '$available_actions', '$available_events', '$available_params',
    '$columns_list', '$users_list', '$projects_list', '$colors_list',
    '$categories_list', '$links_list', '$swimlane_list', '$project',
);
foreach ($requiredVariables as $variable) {
    if (strpos($actionTemplate, $variable) === false) {
        $failures[] = 'Missing Kanboard action-template variable: ' . $variable;
    }
}

$requiredContracts = array(
    "'ActionCreationController', 'create'",
    "'ProjectActionDuplicationController', 'show'",
    "'ActionController', 'confirm'",
    'scope="col"',
    'aria-haspopup="true"',
    "'icon' => 'fa-bolt'",
    "'icon' => 'fa-cogs'",
);
foreach ($requiredContracts as $contract) {
    if (strpos($actionTemplate, $contract) === false) {
        $failures[] = 'Missing template compatibility contract: ' . $contract;
    }
}

if (strpos($actionTemplate, "\$paramName === 'check_box_include_identifier'") === false
    || strpos($actionTemplate, '<span class="options-unchecked"') === false) {
    $failures[] = 'The identifier checkbox must render both enabled and disabled states.';
}

$kanboardRoot = getenv('KANBOARD_ROOT');
if ($kanboardRoot !== false && $kanboardRoot !== '') {
    $controllerPath = rtrim($kanboardRoot, '/\\') . '/app/Controller/ActionController.php';
    if (! is_file($controllerPath)) {
        $failures[] = 'KANBOARD_ROOT does not contain ActionController.php.';
    } else {
        $controller = file_get_contents($controllerPath);
        foreach (array('available_actions', 'available_events', 'available_params', 'columns_list', 'users_list', 'projects_list', 'colors_list', 'categories_list', 'links_list', 'swimlane_list') as $variable) {
            if (strpos($controller, "'" . $variable . "'") === false) {
                $failures[] = 'Kanboard no longer supplies template data: ' . $variable;
            }
        }
    }
}

if ($failures !== array()) {
    fwrite(STDERR, implode(PHP_EOL, array_unique($failures)) . PHP_EOL);
    exit(1);
}

echo "Kanboard 1.2.54 template compatibility contract passed." . PHP_EOL;
