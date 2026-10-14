<?php
// Related tests: tests/ProjectHeaderPermissionTest.php and tests/ThemeContractTest.php.
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
           aria-label="<?= t('View all actions for this project') ?>">
            <span class="board-actions-title">
                <i class="fa fa-random aa-icon" aria-hidden="true"></i>
                <?= t('Automatic Actions') ?>
            </span>
            <span class="board-actions-counts">
                <span class="action-page-count" title="<?= t('Actions for this project') ?>">
                    <?= count($actions) ?>
                </span>
                <span class="action-page-count" title="<?= t('User Triggered Actions') ?>">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <?= $userTriggerCount ?>
                </span>
                <span class="action-page-count" title="<?= t('System Triggered Actions') ?>">
                    <i class="fa fa-cog" aria-hidden="true"></i>
                    <?= $systemTriggerCount ?>
                </span>
            </span>
        </a>
    </li>
<?php endif ?>