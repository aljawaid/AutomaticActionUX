<?php
$actions = $this->model->actionModel->getAllByProject($project['id']);
// phpcs:disable Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace,Squiz.WhiteSpace.ScopeClosingBrace.ContentBefore -- code must be kept intact
?>
<li id="BoardActions" class="board-actions <?php if ($this->app->checkMenuSelection('ActionController')): ?> display-none <?php endif ?>">
    <?php // phpcs:enable ?>
    <?php if ($this->user->hasProjectAccess('ActionController', 'index', $project['id'])): ?>
        <a href="<?= $this->url->href('ActionController', 'index', array('project_id' => $project['id']), false, '', '') ?>">
    <?php endif ?>
    <div class="board-actions-title">
        <svg version="1.1" class="aa-icon" width="18px" height="18px" fill="currentColor" viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <g stroke-width="0"></g>
            <g stroke-linecap="round" stroke-linejoin="round"></g>
            <g>
                <style type="text/css"> .blueprint_een {fill: #000000;} .st0 {fill: #000000;} </style>
                <path class="blueprint_een" d="M31.981,15.403C31.676,10.691,27.61,7,22.726,7H16V6.414c0-1.104-0.9-2.002-2.007-2.002h0 c-0.528,0-1.028,0.209-1.407,0.588l-2,2H9C6.522,7,4.128,8.037,2.433,9.846c-1.719,1.834-2.576,4.232-2.413,6.751 C0.324,21.309,4.39,25,9.274,25H16v0.586c0,1.104,0.9,2.002,2.007,2.002c0.528,0,1.028-0.209,1.407-0.588l2-2H23 c2.478,0,4.872-1.037,6.568-2.846C31.287,20.32,32.144,17.922,31.981,15.403z M18,25.586V23H9.274c-3.833,0-7.022-2.869-7.259-6.532 C1.751,12.393,4.965,9,9,9h1l-1.293,1.293c-0.391,0.391-0.391,1.024,0,1.414L10,13H9c-1.838,0-3.261,1.643-2.96,3.496 C6.272,17.924,7.591,19,9.107,19H18v-2.586L22.586,21L18,25.586z M11,14l2.293,2.293c0.204,0.204,0.454,0.295,0.7,0.295 c0.514,0,1.007-0.399,1.007-1.002V14h7.893c0.996,0,1.92,0.681,2.08,1.664C25.176,16.917,24.215,18,23,18h-2l-2.293-2.293 c-0.204-0.204-0.454-0.295-0.7-0.295c-0.514,0-1.007,0.399-1.007,1.002V18H9.107c-0.996,0-1.92-0.681-2.08-1.664 C6.824,15.083,7.785,14,9,14H11z"></path>
                <path d="M23,23h-1l1.293-1.293c0.391-0.391,0.391-1.024,0-1.414L22,19h1c1.838,0,3.261-1.643,2.96-3.496 C25.728,14.076,24.409,13,22.893,13H14l0,2.586L9.414,11L14,6.415V9h8.726c3.833,0,7.022,2.869,7.259,6.532 C30.249,19.607,27.035,23,23,23z"></path>
            </g>
        </svg> &nbsp;<?= t('Automatic Actions') ?>
    </div>
    <div class="board-actions-counts">
        <div class="action-page-count" title="<?= t('Actions for this project')?>">
            <?php if ($this->user->hasProjectAccess('ActionController', 'index', $project['id'])): ?>
                <?= $this->url->link(count($actions), 'ActionController', 'index', array('project_id' => $project['id']), '', 'board-action-link', t('View all actions for this project')) ?>
            <?php else: ?>
                <?= count($actions) ?>
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
