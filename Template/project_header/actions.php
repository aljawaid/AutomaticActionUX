<?php
// Related tests: tests/ProjectHeaderPermissionTest.php, tests/ThemeContractTest.php and tests/TranslationIsolationTest.php.
$canViewAutomaticActions = $this->user->hasProjectAccess('ActionController', 'index', $project['id']);
?>
<?php if ($canViewAutomaticActions): ?>
    <?php
    // Query action metadata only after Kanboard has authorised access to the action list.
    $actions = $this->model->actionModel->getAllByProject($project['id']);
    $systemTriggerCount = 0;

    foreach ($actions as $action) {
        if ($this->text->contains($action['event_name'], 'task.cronjob.daily')) {
            $systemTriggerCount++;
        }
    }

    $userTriggerCount = count($actions) - $systemTriggerCount;
    ?>
    <li id="BoardActions" class="board-actions<?= $this->app->checkMenuSelection('ActionController') ? ' aa-is-hidden' : '' ?>">
        <a class="board-actions-summary"
           href="<?= $this->url->href('ActionController', 'index', array('project_id' => $project['id']), false, '', '') ?>"
           aria-label="<?= t('automatic_action_ux.view_actions') ?>">
            <span class="board-actions-title">
                <i class="fa fa-random aa-icon" aria-hidden="true"></i>
                <?= t('automatic_action_ux.automatic_actions') ?>
            </span>
            <span class="board-actions-counts">
                <span class="action-page-count" title="<?= t('automatic_action_ux.actions_for_project') ?>">
                    <?= count($actions) ?>
                </span>
                <span class="action-page-count" title="<?= t('automatic_action_ux.user_triggered_actions') ?>">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <?= $userTriggerCount ?>
                </span>
                <span class="action-page-count" title="<?= t('automatic_action_ux.system_triggered_actions') ?>">
                    <i class="fa fa-cog" aria-hidden="true"></i>
                    <?= $systemTriggerCount ?>
                </span>
            </span>
        </a>
    </li>
<?php endif ?>