<?php
/**
 * Present Kanboard 1.2.54 automatic actions with accessible visual summaries.
 *
 * Related tests: tests/TemplateOutputSecurityTest.php and tests/TemplateCompatibilityTest.php.
 */

$systemTriggerCount = 0;
foreach ($actions as $action) {
    if ($this->text->contains($action['event_name'], 'task.cronjob.daily')) {
        $systemTriggerCount++;
    }
}
$userTriggerCount = count($actions) - $systemTriggerCount;

// Rules retain recognisable icons for known core and third-party actions while providing safe generic fallbacks.
$eventPresentationRules = array(
    array('event' => 'task.cronjob.daily', 'action' => 'NoActivityColumn', 'icon' => 'fa-pause', 'label' => 'No Activity Column'),
    array('event' => 'task.cronjob.daily', 'action' => 'TaskEmailNoActivity', 'icon' => 'fa-pause', 'label' => 'No Activity Task'),
    array('event' => 'task.cronjob.daily', 'action' => 'SubTaskEmailDue', 'icon' => 'fa-calendar', 'label' => 'Subtasks'),
    array('event' => 'task.move.column', 'icon' => 'fa-columns', 'label' => 'Move Column'),
    array('event' => 'task.create_update', 'icon' => 'fa-sticky-note-o', 'label' => 'Task Create/Edit'),
    array('event' => 'task.create', 'icon' => 'fa-sticky-note-o', 'label' => 'Task Create'),
    array('event' => 'task.update', 'icon' => 'fa-pencil-square-o', 'label' => 'Task Update'),
    array('event' => 'task.move.swimlane', 'icon' => 'fa-exchange', 'label' => 'Move Swimlane'),
    array('event' => 'task.close', 'icon' => 'fa-check-square-o', 'label' => 'Task Close'),
    array('event' => 'task.assignee_change', 'icon' => 'fa-user-o', 'label' => 'Assignee Change'),
    array('event' => 'gitlab.', 'icon' => 'fa-gitlab', 'label' => 'GitLab'),
    array('event' => 'github.', 'icon' => 'fa-github', 'label' => 'GitHub'),
);

$actionPresentationRules = array(
    array('action' => 'CommentCreationMoveTaskColumn', 'icon' => 'fa-commenting-o', 'label' => 'Comment Creation'),
    array('action' => 'CommentCreation', 'icon' => 'fa-commenting', 'label' => 'Comment Creation'),
    array('action' => 'TaskAssignColorPriority', 'icon' => 'fa-paint-brush', 'label' => 'Assign Color'),
    array('action' => 'TaskAssignColorSwimlane', 'icon' => 'fa-paint-brush', 'label' => 'Assign Color'),
    array('action' => 'TaskAssignColorUser', 'icon' => 'fa-paint-brush', 'label' => 'Assign Color'),
    array('action' => 'TaskAssignSpecificUser', 'icon' => 'fa-user-o', 'label' => 'Assign User'),
    array('action' => 'TaskClose', 'icon' => 'fa-check-square-o', 'label' => 'Close Task'),
    array('action' => 'TaskCreation', 'icon' => 'fa-sticky-note-o', 'label' => 'Create Task'),
    array('action' => 'TaskEmailNoActivity', 'icon' => 'fa-envelope-o', 'label' => 'Send Email'),
    array('action' => 'TaskEmail', 'icon' => 'fa-envelope-o', 'label' => 'Send Email'),
    array('action' => 'TaskMoveSwimlaneAssigned', 'icon' => 'fa-exchange', 'label' => 'Move Swimlane'),
    array('action' => 'TaskUpdateStartDateOnMoveToColumn', 'icon' => 'fa-play', 'label' => 'Start Date'),
    array('action' => 'TaskUpdateStartDate', 'icon' => 'fa-play', 'label' => 'Start Date'),
    array('action' => 'AutoCreateSubtask', 'icon' => 'fa-tasks', 'label' => 'Create Subtask'),
    array('action' => 'EmailGroup', 'icon' => 'fa-envelope-o', 'label' => 'Email Group'),
    array('action' => 'EmailTaskHistory', 'icon' => 'fa-envelope-o', 'label' => 'Email History'),
    array('action' => 'SendTaskAssignee', 'icon' => 'fa-envelope-o', 'label' => 'Email Assignee'),
    array('action' => 'SubTaskEmailDue', 'icon' => 'fa-envelope-o', 'label' => 'Subtasks Due'),
    array('action' => 'SubtaskTimerMoveTaskColumn', 'icon' => 'fa-clock-o', 'label' => 'Activate Timers'),
);

$resolvePresentation = static function ($eventName, $actionName, array $rules, array $fallback) {
    foreach ($rules as $rule) {
        if (isset($rule['event']) && strpos($eventName, $rule['event']) === false) {
            continue;
        }
        if (isset($rule['action']) && strpos($actionName, $rule['action']) === false) {
            continue;
        }
        return $rule;
    }
    return $fallback;
};
?>
<div id="ActionPageHeader" class="page-header action-page-header">
    <h2>
        <i class="fa fa-random aa-icon" aria-hidden="true"></i>
        <?= t('Automatic Actions') ?>
        <span class="aa-project-name">
            <i class="fa fa-folder" aria-hidden="true"></i>
            <strong><?= $this->text->e($project['name']) ?></strong>
        </span>
    </h2>
    <ul class="data-bar aa-summary-list">
        <li class="action-page-count" title="<?= t('Actions for this project') ?>">
            <span class="page-count-total"><?= t('Total') ?>:</span>
            <strong><?= count($actions) ?></strong>
        </li>
        <li class="action-page-count" title="<?= t('User Triggered Actions') ?>">
            <i class="fa fa-user" aria-hidden="true"></i>
            <?= $userTriggerCount ?>
        </li>
        <li class="action-page-count" title="<?= t('System Triggered Actions') ?>">
            <i class="fa fa-cog" aria-hidden="true"></i>
            <?= $systemTriggerCount ?>
        </li>
        <li class="aa-summary-action">
            <span class="add-action-btn">
                <?= $this->modal->medium('plus', t('Add a new action'), 'ActionCreationController', 'create', array('project_id' => $project['id'])) ?>
            </span>
        </li>
        <li class="aa-summary-action">
            <span class="import-action-btn">
                <?= $this->modal->medium('copy', t('Import from another project'), 'ProjectActionDuplicationController', 'show', array('project_id' => $project['id'])) ?>
            </span>
        </li>
    </ul>
</div>

<?php if (empty($actions)): ?>
    <p class="alert action-alert"><?= t('There is no action at the moment.') ?></p>
<?php else: ?>
    <table id="ActionTable" class="table-scrolling action-table">
        <thead>
            <tr class="action-table-row">
                <th class="aa-column-number" scope="col"><?= t('N°') ?></th>
                <th class="aa-column-trigger" scope="col"><?= t('Trigger') ?></th>
                <th class="aa-column-relation" scope="col"><?= t('Relation') ?></th>
                <th class="aa-column-event" scope="col"><?= t('Event Activity') ?></th>
                <th class="aa-column-action" scope="col"><?= t('Action Title') ?></th>
                <th class="aa-column-details" scope="col"><?= t('Action Details') ?></th>
                <th class="aa-column-id" scope="col">
                    <abbr title="<?= t('This ID is for the Action not the Action parameter') ?>"><?= t('Action ID') ?></abbr>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php $counter = 1; ?>
            <?php foreach ($actions as $action): ?>
                <?php
                $eventPresentation = $resolvePresentation(
                    $action['event_name'],
                    $action['action_name'],
                    $eventPresentationRules,
                    array('icon' => 'fa-bolt', 'label' => 'Event Name')
                );
                $actionPresentation = $resolvePresentation(
                    $action['event_name'],
                    $action['action_name'],
                    $actionPresentationRules,
                    array('icon' => 'fa-cogs', 'label' => 'Action')
                );

                $relationIcon = 'fa-sticky-note';
                $relationLabel = 'Task';
                if (
                    $this->text->contains($action['action_name'], 'AutoCreateSubtask')
                    || $this->text->contains($action['action_name'], 'SubtaskTimerMoveTaskColumn')
                    || $this->text->contains($action['action_name'], 'SubTaskEmailDue')
                ) {
                    $relationIcon = 'fa-tasks';
                    $relationLabel = 'Subtask';
                } elseif ($this->text->contains($action['action_name'], 'AssignColorUser')) {
                    $relationIcon = 'fa-user-o';
                    $relationLabel = 'User';
                } elseif ($this->text->contains($action['action_name'], 'TaskDuplicateAnotherProject')) {
                    $relationIcon = 'fa-folder';
                }
                ?>
                <tr class="action-table-row">
                    <td class="line-no" rowspan="2"><?= $counter ?></td>
                    <td class="action-trigger" rowspan="2">
                        <?php if ($this->text->contains($action['event_name'], 'task.cronjob.daily')): ?>
                            <i class="fa fa-fw fa-cog" aria-hidden="true"></i>
                            <span class="sr-only"><?= t('System') ?></span>
                        <?php else: ?>
                            <i class="fa fa-fw fa-user" aria-hidden="true"></i>
                            <span class="sr-only"><?= t('User') ?></span>
                        <?php endif ?>
                    </td>
                    <td class="action-relation" rowspan="2">
                        <i class="fa <?= $relationIcon ?>" aria-hidden="true"></i>
                        <span class="sr-only"><?= t($relationLabel) ?></span>
                    </td>
                    <td class="action-activity" rowspan="2">
                        <div class="action-activity-icon">
                            <i class="fa <?= $eventPresentation['icon'] ?>" aria-hidden="true"></i>
                        </div>
                        <div class="action-activity-text"><?= t($eventPresentation['label']) ?></div>
                    </td>
                    <td class="action-action" rowspan="2">
                        <div class="action-action-icon">
                            <i class="fa <?= $actionPresentation['icon'] ?>" aria-hidden="true"></i>
                        </div>
                        <div class="action-action-text"><?= t($actionPresentation['label']) ?></div>
                    </td>
                    <th class="action-name-cell" scope="row">
                        <i class="fa fa-random aa-icon" aria-hidden="true"></i>
                        <?php if (! isset($available_params[$action['action_name']])): ?>
                            <?= $this->text->e($action['action_name']) ?>
                        <?php else: ?>
                            <?= $this->text->in($action['action_name'], $available_actions) ?>
                        <?php endif ?>
                        <div class="dropdown aa-action-dropdown">
                            <a href="#"
                               class="dropdown-menu dropdown-menu-link-icon action-dropdown"
                               role="button"
                               aria-haspopup="true"
                               aria-label="<?= t('Automatic actions') ?>"
                               title="<?= t('Automatic actions') ?>">
                                <i class="fa fa-cog" aria-hidden="true"></i>
                                <i class="fa fa-caret-down" aria-hidden="true"></i>
                            </a>
                            <ul>
                                <li>
                                    <?= $this->modal->confirm('trash-o', t('Delete Automatic Action'), 'ActionController', 'confirm', array('project_id' => $project['id'], 'action_id' => $action['id'])) ?>
                                </li>
                            </ul>
                        </div>
                    </th>
                    <td class="action-id" rowspan="2">
                        <abbr title="<?= t('This ID is for the Action not the Action parameter') ?>"><?= (int) $action['id'] ?></abbr>
                    </td>
                </tr>
                <tr class="action-table-row">
                    <td class="action-details-cell">
                        <?php if (! isset($available_params[$action['action_name']])): ?>
                            <p class="alert alert-error"><?= t('Automatic Action not found: "%s"', $action['action_name']) ?></p>
                        <?php else: ?>
                            <ul class="action-details">
                                <li class="action-event-name">
                                    <span class="action-event-title">
                                        <i class="fa fa-power-off" aria-hidden="true"></i>
                                        <?= t('Action Trigger') ?>
                                    </span>
                                    <span class="action-event-value"><?= $this->text->in($action['event_name'], $available_events) ?></span>
                                    <span class="action-event-label"><?= t('Event Name') ?></span>
                                </li>
                                <li class="action-options-heading">
                                    <span class="action-options">
                                        <i class="fa fa-sliders" aria-hidden="true"></i>
                                        <?= t('Selected Options') ?>
                                    </span>
                                </li>
                                <?php foreach ($action['params'] as $paramName => $paramValue): ?>
                                    <?php
                                    $parameterDefinition = $available_params[$action['action_name']][$paramName] ?? null;
                                    $requiresProjectEmail = $paramName === 'send_to'
                                        && in_array($paramValue, array('assignee_project_email', 'creator_project_email', 'project_email', 'all'), true);
                                    ?>
                                    <li class="action-options-value">
                                        <span class="action-option-name">
                                            <?php if ($paramName === 'send_to'): ?>
                                                <?= t('Email Recipient(s)') ?>
                                            <?php elseif (is_array($parameterDefinition)): ?>
                                                <?= $this->text->e(ucfirst(str_replace('_', ' ', $paramName))) ?>
                                            <?php else: ?>
                                                <?= $this->text->in($paramName, $available_params[$action['action_name']]) ?>
                                            <?php endif ?>
                                            <span class="options-arrow" aria-hidden="true">&#10609;</span>
                                        </span>
                                        <span class="action-option-value">
                                            <?php if ($this->text->contains($paramName, 'column_id')): ?>
                                                <?= $this->text->in($paramValue, $columns_list) ?>
                                            <?php elseif ($this->text->contains($paramName, 'user_id')): ?>
                                                <?= $this->text->in($paramValue, $users_list) ?>
                                            <?php elseif ($this->text->contains($paramName, 'project_id')): ?>
                                                <?= $this->text->in($paramValue, $projects_list) ?>
                                            <?php elseif ($this->text->contains($paramName, 'color_id')): ?>
                                                <?php
                                                $colorClass = strtolower((string) $paramValue);
                                                $colorClass = trim((string) preg_replace('/[^a-z0-9_-]+/', '-', $colorClass), '-');
                                                if ($colorClass === '') {
                                                    $colorClass = 'default';
                                                }
                                                ?>
                                                <span class="action-color-value action-color-<?= $this->text->e($colorClass) ?>">
                                                    <?= $this->text->in($paramValue, $colors_list) ?>
                                                </span>
                                            <?php elseif ($this->text->contains($paramName, 'category_id')): ?>
                                                <?= $this->text->in($paramValue, $categories_list) ?>
                                            <?php elseif ($this->text->contains($paramName, 'link_id')): ?>
                                                <?= $this->text->in($paramValue, $links_list) ?>
                                            <?php elseif ($this->text->contains($paramName, 'swimlane_id')): ?>
                                                <?= $this->text->in($paramValue, $swimlane_list) ?>
                                            <?php elseif ($paramName === 'check_box_include_identifier'): ?>
                                                <?php if ((string) $paramValue === '1'): ?>
                                                    <span class="options-checked" aria-hidden="true">&#10004;</span> <?= t('Yes') ?>
                                                    <?php if (empty($project['identifier'])): ?>
                                                        <span class="form-warning">
                                                            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                                            <?= t('Project Identifier is not set') ?>
                                                        </span>
                                                    <?php endif ?>
                                                <?php else: ?>
                                                    <span class="options-unchecked" aria-hidden="true">&#10008;</span> <?= t('No') ?>
                                                <?php endif ?>
                                            <?php elseif ($this->text->contains($paramName, 'check_box_include_') || $this->text->contains($paramName, 'check_box_all_columns')): ?>
                                                <?php if ((string) $paramValue === '1'): ?>
                                                    <span class="options-checked" aria-hidden="true">&#10004;</span> <?= t('Yes') ?>
                                                <?php else: ?>
                                                    <span class="options-unchecked" aria-hidden="true">&#10008;</span> <?= t('No') ?>
                                                <?php endif ?>
                                            <?php elseif ($paramName === 'check_box_no_duplicates'): ?>
                                                <?php if ((string) $paramValue === '1'): ?>
                                                    <span class="options-checked" aria-hidden="true">&#10004;</span> <?= t('Checked') ?>
                                                <?php else: ?>
                                                    <span class="options-unchecked" aria-hidden="true">&#10008;</span> <?= t('Not Checked') ?>
                                                <?php endif ?>
                                            <?php elseif ($paramName === 'email_subject'): ?>
                                                <?php if ($paramValue === null || $paramValue === ''): ?>
                                                    <i class="not-set"><?= t('Not set') ?></i>
                                                    <span class="form-help form-help-not-set">
                                                        <abbr title="<?= t('Default Subject: Activity Report') ?>"><?= t('The default subject will be used') ?></abbr>
                                                    </span>
                                                <?php else: ?>
                                                    <?= $this->text->e($paramValue) ?>
                                                <?php endif ?>
                                            <?php elseif ($paramName === 'send_to' && is_array($parameterDefinition)): ?>
                                                <?php
                                                $recipientLabels = array(
                                                    'assignee' => 'Task Assignee',
                                                    'creator' => 'Task Creator',
                                                    'both' => 'Task Assignee & Task Creator',
                                                    'assignee_project_email' => 'Task Assignee & Project Email Address',
                                                    'creator_project_email' => 'Task Creator & Project Email Address',
                                                    'project_email' => 'Project Email Address',
                                                    'all' => 'Task Assignee, Task Creator & Project Email Address',
                                                );
                                                ?>
                                                <?php if (isset($recipientLabels[$paramValue])): ?>
                                                    <?= t($recipientLabels[$paramValue]) ?>
                                                <?php else: ?>
                                                    <?= $this->text->in($paramValue, $parameterDefinition) ?>
                                                <?php endif ?>
                                                <?php if ($requiresProjectEmail && empty($project['email'])): ?>
                                                    <span class="form-warning">
                                                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                                        <?= t('Project Email Address is not set') ?>
                                                    </span>
                                                <?php endif ?>
                                            <?php elseif (is_array($parameterDefinition)): ?>
                                                <?= $this->text->in($paramValue, $parameterDefinition) ?>
                                            <?php else: ?>
                                                <?= $this->text->e($paramValue) ?>
                                            <?php endif ?>
                                        </span>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        <?php endif ?>
                    </td>
                </tr>
                <?php $counter++; ?>
            <?php endforeach ?>
        </tbody>
    </table>
<?php endif ?>