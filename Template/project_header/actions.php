<?php $actions = $this->model->actionModel->getAllByProject($project['id']); ?>

<li id="BoardActions" class="board-actions <?php if ($this->app->checkMenuSelection('ActionController')): ?> display-none <?php endif ?>">
    <?php if ($this->user->hasProjectAccess('ActionController', 'index', $project['id'])): ?>
    <a href="<?= $this->url->href('ActionController', 'index', array('project_id' => $project['id']), false, '', '') ?>">
    <?php endif ?>
        <div class="board-actions-title">
            <i class="fa fa-magic" aria-hidden="true">&nbsp;</i> <?= t('Automatic Actions') ?>
        </div>
    	<div class="board-actions-counts">
            <div class="action-page-count" title="<?= t('Actions for this project')?>">
                <?php if ($this->user->hasProjectAccess('ActionController', 'index', $project['id'])): ?>
                    <i class="fa fa-magic" aria-hidden="true">&nbsp;</i><?= $this->url->link(count($actions), 'ActionController', 'index', array('project_id' => $project['id']), '', 'board-action-link', t('View all actions for this project')) ?>
                <?php else: ?>
                    <i class="fa fa-magic" aria-hidden="true">&nbsp;</i> <?= count($actions) ?>
                <?php endif ?>
            </div>

            <?php
            //set counter variable for actions trigger count
            $userTriggerCounter = 0;
            $systemTriggerCounter = 0;
            ?>

            <?php foreach ($actions as $action):
                $systemTrigger = $this->text->contains($action['event_name'], 'task.cronjob.daily');
                if ($systemTrigger) {
                    $systemTriggerCounter += 1;
                }
            endforeach;
            $userTriggerCounterResult = (count($actions)) - $systemTriggerCounter;
            ?>

            <div class="action-page-count" title="<?= t('User Triggered Actions')?>">
                <i class="fa fa-user" aria-hidden="true">&nbsp;</i> <?= $userTriggerCounterResult ?>
            </div>

            <?php $systemTriggerCounterZero = '0'; ?>

            <div class="action-page-count" title="<?= t('System Triggered Actions')?>">
                <i class="fa fa-cog" aria-hidden="true">&nbsp;</i>
                <?php if ($systemTriggerCounter > 0): ?>
                    <?= $systemTriggerCounter ?>
                <?php else: ?>
                    <?= $systemTriggerCounterZero ?>
                <?php endif ?>
            </div>
        </div>
    <?php if ($this->user->hasProjectAccess('ActionController', 'index', $project['id'])): ?>
    </a>
    <?php endif ?>
</li>
