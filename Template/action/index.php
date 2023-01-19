<div id="ActionPageHeader" class="page-header action-page-header">
    <h2 class="">
        <i class="fa fa-magic" aria-hidden="true">&nbsp;</i> <?= t('Automatic Actions for Project') ?>
        <span class="float-right pp-grey">
            <i class="fa fa-folder" aria-hidden="true"></i> <strong><?= $project['name'] ?></strong>
        </span>
    </h2>
    <ul class="">
        <li class="action-page-count" title="<?= t('Actions for this project')?>">
            <i class="fa fa-magic" aria-hidden="true">&nbsp;</i> <?= count($actions) ?>
        </li>
        
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
        
        <li class="action-page-count" title="<?= t('User Triggered Actions')?>">
            <i class="fa fa-user" aria-hidden="true">&nbsp;</i> <?= $userTriggerCounterResult ?>
        </li>

        <?php
        $systemTriggerCounterZero = '0';
        ?>

        <li class="action-page-count" title="<?= t('System Triggered Actions')?>">
            <i class="fa fa-cog" aria-hidden="true">&nbsp;</i> 

            <?php if ($systemTriggerCounter > 0): ?>
                <?= $systemTriggerCounter ?>
            <?php else: ?>
                <?= $systemTriggerCounterZero ?>
            <?php endif ?>

        </li>
        <li class="">
            <?= $this->modal->medium('plus', t('Add a new action'), 'ActionCreationController', 'create', array('project_id' => $project['id'])) ?>
        </li>
        <li class="">
            <?= $this->modal->medium('copy', t('Import from another project'), 'ProjectActionDuplicationController', 'show', array('project_id' => $project['id'])) ?>
        </li>
    </ul>
</div>

<?php if (empty($actions)): ?>
    <p class="alert action-alert"><?= t('There is no action at the moment.') ?></p>
<?php else: ?>
    <table id="ActionTable" class="table-scrolling action-table">
        <thead>
            <tr class="action-table-row">
                <th class="action-table-column-title text-center cell-bg-title" width="30px"><?= t('N°') ?></th>
                <th class="action-table-column-title text-center cell-bg-title"><?= t('Trigger') ?></th>
                <th class="action-table-column-title text-center cell-bg-title"><?= t('Relation') ?></th>
                <th class="action-table-column-title text-center cell-bg-title" width="100px"><?= t('Event Activity') ?></th>
                <th class="action-table-column-title text-center cell-bg-title" width="100px"><?= t('Action Title') ?></th>
                <th class="action-table-column-title cell-bg-title pl-15"><?= t('Action Details') ?></th>
                <th class="action-table-column-title text-center cell-bg-title"><abbr title="<?= t('This ID is for the Action not the Action parameter') ?>"><?= t('Action ID') ?></abbr></th>
            </tr>
        </thead>
        <tbody>
            <?php 
            //set counter variable for line number
            $counter = 1;
            ?>
            <?php foreach ($actions as $action): ?>
            <tr class="action-table-row">

                <!-- LINE NUMBER -->
                <td class="line-no" rowspan="2"><?= $counter ?></td>
                
                <!-- TRIGGER - SYSTEM OR USER -->
                <td class="action-trigger" rowspan="2">
                    <?php if ($this->text->contains($action['event_name'], 'task.cronjob.daily')): ?>
                        <i class="fa fa-fw fa-cog fa-spin" aria-hidden="true" title="<?= t('System') ?>"></i>
                    <?php else: ?>
                        <i class="fa fa-fw fa-user" aria-hidden="true" title="<?= t('User') ?>"></i>
                    <?php endif ?>
                </td>
                
                <!-- MAIN RELATION - EVENT OR ACTION -->
                <td class="action-relation" rowspan="2">

                    <?php if ($this->text->contains($action['action_name'], 'TaskDuplicateAnotherProject')): ?>
                        <i class="fa fa-folder" aria-hidden="true" title="<?= t('Task') ?>"></i>

                    <?php elseif ($this->text->contains($action['action_name'], 'AutoCreateSubtask')): ?>
                        <i class="fa fa-tasks" aria-hidden="true" title="<?= t('Subtask') ?>"></i>
                    
                    <?php elseif (($this->text->contains($action['event_name'], 'task.move.column')) && ($this->text->contains($action['action_name'], 'SubtaskTimerMoveTaskColumn'))): ?>
                            <i class="fa fa-tasks" aria-hidden="true" title="<?= t('Subtask') ?>"></i>

                    <?php elseif (($this->text->contains($action['event_name'], 'task.create')) && ($this->text->contains($action['action_name'], 'AssignColorUser'))): ?>
                            <i class="fa fa-user-o" aria-hidden="true" title="<?= t('User') ?>"></i>

                    <?php elseif (($this->text->contains($action['event_name'], 'task.cronjob.daily')) && ($this->text->contains($action['action_name'], 'SubTaskEmailDue'))): ?>
                            <i class="fa fa-tasks" aria-hidden="true" title="<?= t('Subtask') ?>"></i>
                    <?php else: ?>
                        <i class="fa fa-sticky-note" aria-hidden="true" title="<?= t('Task') ?>"></i>
                    
                    <?php endif ?>
                </td>

                <!-- EVENT - ACTIVITY BASED ON EVENT NAME -->
                <td class="action-activity" rowspan="2">

                    <?php if ($this->text->contains($action['event_name'], 'task.move.column')): ?>
                        <div class="action-activity-icon">
                            <i class="fa fa-columns" aria-hidden="true" title="<?= t('Move Column') ?>"></i>
                        </div>
                        <div class="action-activity-text"><?= t('Move Column') ?></div>

                    <?php elseif ($this->text->contains($action['event_name'], 'task.create_update')): ?>
                        <div class="action-activity-icon">
                            <i class="fa fa-sticky-note-o" aria-hidden="true" title="<?= t('Task Create') ?>"></i>
                        </div>
                        <div class="action-activity-text"><?= t('Task Create/Edit') ?></div>

                    <?php elseif ($this->text->contains($action['event_name'], 'task.create')): ?>
                        <div class="action-activity-icon">
                            <i class="fa fa-sticky-note-o" aria-hidden="true" title="<?= t('Task Create') ?>"></i>
                        </div>
                        <div class="action-activity-text"><?= t('Task Create') ?></div>

                    <?php elseif ($this->text->contains($action['event_name'], 'task.update')): ?>
                        <div class="action-activity-icon">
                            <i class="fa fa-sticky-note-o" aria-hidden="true" title="<?= t('Task Update') ?>"></i>
                        </div>
                        <div class="action-activity-text"><?= t('Task Update') ?></div>

                    <?php elseif ($this->text->contains($action['event_name'], 'task.move.swimlane')): ?>
                        <div class="action-activity-icon">
                            <i class="fa fa-exchange" aria-hidden="true" title="<?= t('Task Create') ?>"></i>
                        </div>
                        <div class="action-activity-text"><?= t('Move Swimlane') ?></div>

                    <?php elseif ($this->text->contains($action['event_name'], 'task.close')): ?>
                        <div class="action-activity-icon">
                            <i class="fa fa-columns" aria-hidden="true" title="<?= t('Task Close') ?>"></i>
                        </div>
                        <div class="action-activity-text"><?= t('Task Close') ?></div>

                    <?php elseif ($this->text->contains($action['event_name'], 'task.assignee_change')): ?>
                        <div class="action-activity-icon">
                            <i class="fa fa-user-o" aria-hidden="true" title="<?= t('Task Assignee Change') ?>"></i>
                        </div>
                        <div class="action-activity-text"><?= t('Assignee Change') ?></div>

                    <?php elseif ($this->text->contains($action['event_name'], 'gitlab.')): ?>
                        <div class="action-activity-icon">
                            <i class="fa fa-gitlab" aria-hidden="true" title="<?= t('GitLab') ?>"></i>
                        </div>
                        <div class="action-activity-text"><?= t('GitLab') ?></div>

                    <?php elseif ($this->text->contains($action['event_name'], 'github.')): ?>
                        <div class="action-activity-icon">
                            <i class="fa fa-github" aria-hidden="true" title="<?= t('GitHub') ?>"></i>
                        </div>
                        <div class="action-activity-text"><?= t('GitHub') ?></div>

                    <?php elseif (($this->text->contains($action['event_name'], 'task.cronjob.daily')) && ($this->text->contains($action['action_name'], 'NoActivityColumn'))): ?>
                        <div class="action-activity-icon">
                            <i class="fa fa-pause" aria-hidden="true" title="<?= t('No Activity') ?>"></i>
                        </div>
                        <div class="action-activity-text"><?= t('No Activity Column') ?></div>

                    <?php elseif (($this->text->contains($action['event_name'], 'task.cronjob.daily')) && ($this->text->contains($action['action_name'], 'TaskEmailNoActivity'))): ?>
                        <div class="action-activity-icon">
                            <i class="fa fa-pause" aria-hidden="true" title="<?= t('No Activity') ?>"></i>
                        </div>
                        <div class="action-activity-text"><?= t('No Activity Task') ?></div>

                    <?php elseif (($this->text->contains($action['event_name'], 'task.cronjob.daily')) && ($this->text->contains($action['action_name'], 'SubTaskEmailDue'))): ?>
                        <div class="action-activity-icon">
                            <i class="fa fa-calendar" aria-hidden="true" title="<?= t('Subtasks') ?>"></i>
                        </div>
                        <div class="action-activity-text"><?= t('Subtasks') ?></div>

                    <?php endif ?>
                </td>

                <!-- ACTION - BASED ON ACTION NAME -->
                <td class="action-action" rowspan="2">

                    <?php if ($this->text->contains($action['action_name'], 'CommentCreationMoveTaskColumn')): ?>
                        <div class="action-action-icon">
                            <i class="fa fa-commenting-o" aria-hidden="true" title="<?= t('Comment Creation') ?>"></i>
                        </div>
                        <div class="action-action-text"><?= t('Comment Creation') ?></div>

                    <?php elseif ($this->text->contains($action['action_name'], 'CommentCreation')): ?>
                        <div class="action-activity-icon">
                            <i class="fa fa-commenting" aria-hidden="true" title="<?= t('Comment Creation') ?>"></i>
                        </div>
                        <div class="action-activity-text"><?= t('Comment Creation') ?></div>
                    
                    <?php elseif ($this->text->contains($action['action_name'], 'TaskAssignColorPriority')): ?>
                        <div class="action-activity-icon">
                            <i class="fa fa-paint-brush" aria-hidden="true" title="<?= t('Assign Color') ?>"></i>
                        </div>
                        <div class="action-activity-text"><?= t('Assign Color') ?></div>

                    <?php elseif ($this->text->contains($action['action_name'], 'TaskAssignColorSwimlane')): ?>
                        <div class="action-activity-icon">
                            <i class="fa fa-paint-brush" aria-hidden="true" title="<?= t('Assign Color') ?>"></i>
                        </div>
                        <div class="action-activity-text"><?= t('Assign Color') ?></div>

                    <?php elseif ($this->text->contains($action['action_name'], 'TaskAssignColorUser')): ?>
                        <div class="action-activity-icon">
                            <i class="fa fa-paint-brush" aria-hidden="true" title="<?= t('Assign Color') ?>"></i>
                        </div>
                        <div class="action-activity-text"><?= t('Assign Color') ?></div>

                    <?php elseif ($this->text->contains($action['action_name'], 'TaskAssignSpecificUser')): ?>
                        <div class="action-activity-icon">
                            <i class="fa fa-user-o" aria-hidden="true" title="<?= t('Assign User') ?>"></i>
                        </div>
                        <div class="action-activity-text"><?= t('Assign User') ?></div>

                    <?php elseif ($this->text->contains($action['action_name'], 'TaskClose')): ?>
                        <div class="action-activity-icon">
                            <i class="fa fa-sticky-note-o" aria-hidden="true" title="<?= t('Close Task') ?>"></i>
                        </div>
                        <div class="action-activity-text"><?= t('Close Task') ?></div>

                    <?php elseif ($this->text->contains($action['action_name'], 'TaskCreation')): ?>
                        <div class="action-activity-icon">
                            <i class="fa fa-sticky-note-o" aria-hidden="true" title="<?= t('Create Task') ?>"></i>
                        </div>
                        <div class="action-activity-text"><?= t('Create Task') ?></div>

                    <?php elseif ($this->text->contains($action['action_name'], 'TaskEmailNoActivity')): ?>
                        <div class="action-activity-icon">
                            <i class="fa fa-envelope-o" aria-hidden="true" title="<?= t('Send Email') ?>"></i>
                        </div>
                        <div class="action-activity-text"><?= t('Send Email') ?></div>

                    <?php elseif ($this->text->contains($action['action_name'], 'TaskEmail')): ?>
                        <div class="action-activity-icon">
                            <i class="fa fa-envelope-o" aria-hidden="true" title="<?= t('Send Email') ?>"></i>
                        </div>
                        <div class="action-activity-text"><?= t('Send Email') ?></div>

                    <?php elseif ($this->text->contains($action['action_name'], 'TaskMoveSwimlaneAssigned')): ?>
                        <div class="action-activity-icon">
                            <i class="fa fa-exchange" aria-hidden="true" title="<?= t('Move to Swimlane') ?>"></i>
                        </div>
                        <div class="action-activity-text"><?= t('Move Swimlane') ?></div>

                    <?php elseif ($this->text->contains($action['action_name'], 'TaskUpdateStartDateOnMoveToColumn')): ?>
                        <div class="action-activity-icon">
                            <i class="fa fa-play" aria-hidden="true" title="<?= t('Update Start Date') ?>"></i>
                        </div>
                        <div class="action-activity-text"><?= t('Start Date') ?></div>

                    <?php elseif ($this->text->contains($action['action_name'], 'TaskUpdateStartDate')): ?>
                        <div class="action-activity-icon">
                            <i class="fa fa-play" aria-hidden="true" title="<?= t('Update Start Date') ?>"></i>
                        </div>
                        <div class="action-activity-text"><?= t('Start Date') ?></div>

                    <?php elseif ($this->text->contains($action['action_name'], 'AutoCreateSubtask')): ?>
                        <div class="action-activity-icon">
                            <i class="fa fa-tasks" aria-hidden="true" title="<?= t('Create Subtask') ?>"></i>
                        </div>
                        <div class="action-activity-text"><?= t('Create Subtask') ?></div>

                    <?php elseif ($this->text->contains($action['action_name'], 'EmailGroup')): ?>
                        <div class="action-activity-icon">
                            <i class="fa fa-envelope-o" aria-hidden="true" title="<?= t('Email Group') ?>"></i>
                        </div>
                        <div class="action-activity-text"><?= t('Email Group') ?></div>

                    <?php elseif ($this->text->contains($action['action_name'], 'EmailTaskHistory')): ?>
                        <div class="action-activity-icon">
                            <i class="fa fa-envelope-o" aria-hidden="true" title="<?= t('Email Task History') ?>"></i>
                        </div>
                        <div class="action-activity-text"><?= t('Email History') ?></div>

                    <?php elseif ($this->text->contains($action['action_name'], 'SendTaskAssignee')): ?>
                        <div class="action-activity-icon">
                            <i class="fa fa-envelope-o" aria-hidden="true" title="<?= t('Email Assignee') ?>"></i>
                        </div>
                        <div class="action-activity-text"><?= t('Email Assignee') ?></div>

                    <?php elseif ($this->text->contains($action['action_name'], 'SubTaskEmailDue')): ?>
                        <div class="action-activity-icon">
                            <i class="fa fa-envelope-o" aria-hidden="true" title="<?= t('Subtasks Due') ?>"></i>
                        </div>
                        <div class="action-activity-text"><?= t('Subtasks Due') ?></div>

                    <?php elseif ($this->text->contains($action['action_name'], 'SubtaskTimerMoveTaskColumn')): ?>
                        <div class="action-activity-icon">
                            <i class="fa fa-clock-o" aria-hidden="true" title="<?= t('Create Subtasks and Activate Timers') ?>"></i>
                        </div>
                        <div class="action-activity-text"><?= t('Activate Timers') ?></div>
                        
                    <?php endif ?>
                </td>

            <?php $counter++; ?>
                
                <th class="cell-bg">
                    <?php if (! isset($available_params[$action['action_name']])): ?>
                        <i class="fa fa-magic" aria-hidden="true">&nbsp;</i> <?= $this->text->e($action['action_name']) ?>
                    <?php else: ?>
                        <i class="fa fa-magic" aria-hidden="true">&nbsp;</i> <?= $this->text->in($action['action_name'], $available_actions) ?>
                    <?php endif ?>
                    <div class="dropdown float-right">
                        <a href="#" class="dropdown-menu dropdown-menu-link-icon action-dropdown"><i class="fa fa-cog"></i><i class="fa fa-caret-down"></i></a>
                        <ul class="">
                            <li class="">
                                <?= $this->modal->confirm('trash-o', t('Delete Automatic Action'), 'ActionController', 'confirm', array('project_id' => $project['id'], 'action_id' => $action['id'])) ?>
                            </li>
                        </ul>
                    </div>
                </th>

                <!-- ACTION ID - NOT ACTION PARAMETER ID -->
                <td class="action-id" rowspan="2">
                    <abbr title="<?= t('This ID is for the Action not the Action parameter') ?>"><?= $action['id'] ?></abbr>
                </td>

            </tr>
            <tr class="action-table-row">
                <td class="bl-0">
                    <?php if (! isset($available_params[$action['action_name']])): ?>
                        <p class="alert alert-error"><?= t('Automatic Action not found: "%s"', $action['action_name']) ?></p>
                    <?php else: ?>
                    <ul class="action-details">
                        <span class="action-event-title">
                            <svg width="18px" height="18px" fill="currentColor" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="" stroke-width="0"></g><g id="" stroke-linecap="round" stroke-linejoin="round"></g><g id=""><path d="M15.5 31.062c-6.904 0-12.5-5.597-12.5-12.5 0-5.315 3.323-9.844 8-11.651v4.449c-2.399 1.503-4 4.162-4 7.202 0 4.694 3.806 8.5 8.5 8.5s8.5-3.806 8.5-8.5c0-2.596-1.166-4.915-3-6.475v-4.736c4.143 2.036 7 6.284 7 11.212 0 6.903-5.597 12.499-12.5 12.499zM16 17.062c-1.104 0-2-0.896-2-2v-11.124c0-1.104 0.896-2 2-2s2 0.896 2 2v11.125c0 1.104-0.896 1.999-2 1.999z"></path> </g></svg> <?= t('Action Trigger') ?>
                        </span>
                        <li class="action-event-name">
                            <?= t('Event Name') ?> = <span class=""><?= $this->text->in($action['event_name'], $available_events) ?></span>
                        </li>
                        <span class="action-options">
                            <svg width="18px" height="18px" fill="currentColor" viewBox="0 0 32 32" version="1.1" id="" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve"><g id="" stroke-width="0"></g><g id="" stroke-linecap="round" stroke-linejoin="round"></g><g id=""> <style type="text/css"> .st0{fill:none;stroke:#000000;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;} </style> <line class="st0" x1="17" y1="5" x2="29" y2="5"></line> <line class="st0" x1="17" y1="9" x2="24" y2="9"></line> <line class="st0" x1="17" y1="21" x2="29" y2="21"></line> <line class="st0" x1="17" y1="25" x2="24" y2="25"></line> <circle class="st0" cx="8" cy="8" r="5"></circle> <circle class="st0" cx="8" cy="24" r="5"></circle> <circle class="st0" cx="8" cy="8" r="1"></circle> </g></svg> <?= t('Selected Options') ?>
                        </span>
                        <?php foreach ($action['params'] as $param_name => $param_value): ?>
                            <li class="action-options-value">
                                <?php if (isset($available_params[$action['action_name']][$param_name]) && is_array($available_params[$action['action_name']][$param_name])): ?>
                                    <?php if ($param_name == 'send_to'): ?>
                                        <?= t('Email Recipient(s)') ?> =
                                    <?php else: ?>
                                        <?= $this->text->e(ucfirst($param_name)) ?> =
                                    <?php endif ?>
                                <?php else: ?>
                                    <?= $this->text->in($param_name, $available_params[$action['action_name']]) ?> =
                                <?php endif ?>

                                <?php if ($this->text->contains($param_name, 'column_id')): ?>
                                    <?= $this->text->in($param_value, $columns_list) ?>
                                <?php elseif ($this->text->contains($param_name, 'user_id')): ?>
                                    <?= $this->text->in($param_value, $users_list) ?>
                                <?php elseif ($this->text->contains($param_name, 'project_id')): ?>
                                    <?= $this->text->in($param_value, $projects_list) ?>
                                <?php elseif ($this->text->contains($param_name, 'color_id')): ?>
                                    <?= $this->text->in($param_value, $colors_list) ?>
                                <?php elseif ($this->text->contains($param_name, 'category_id')): ?>
                                    <?= $this->text->in($param_value, $categories_list) ?>
                                <?php elseif ($this->text->contains($param_name, 'link_id')): ?>
                                    <?= $this->text->in($param_value, $links_list) ?>
                                <?php elseif ($this->text->contains($param_name, 'swimlane_id')): ?>
                                    <?= $this->text->in($param_value, $swimlane_list) ?>
                                <?php elseif ($this->text->contains($param_name, 'check_box_include_')): ?>
                                    <?php if ($param_value == '1'): ?>
                                        <?= t('Yes') ?>
                                    <?php else: ?>
                                        <?= t('No') ?>
                                    <?php endif ?>
                                <?php elseif ($this->text->contains($param_name, 'email_subject')): ?>
                                    <?php if ($param_value == null): ?>
                                        <i class="not-set"><?= t('Not set') ?></i>
                                        <div class="form-help form-help-not-set">
                                            <abbr title="<?= t('Default Subject: Activity Report') ?>"><?= t('(The default subject will be used)') ?></abbr>
                                        </div>
                                    <?php else: ?>
                                        <?= $this->text->e($param_value) ?>
                                    <?php endif ?>
                                <?php elseif (is_array($available_params[$action['action_name']][$param_name]) && ($param_name == 'send_to')): ?>
                                    <?php if ($param_value == 'assignee'): ?>
                                        <?= t('Task Assignee') ?>
                                    <?php elseif ($param_value == 'creator'): ?>
                                        <?= t('Task Creator') ?>
                                    <?php elseif ($param_value == 'both'): ?>
                                        <?= t('Task Assignee & Task Creator') ?>
                                    <?php elseif ($param_value == 'assignee_project_email'): ?>
                                        <?= t('Task Assignee & Project Email Address') ?>
                                    <?php elseif ($param_value == 'creator_project_email'): ?>
                                        <?= t('Task Creator & Project Email Address') ?>
                                    <?php elseif ($param_value == 'project_email'): ?>
                                        <?= t('Project Email Address') ?>
                                    <?php elseif ($param_value == 'all'): ?>
                                        <?= t('Task Assignee, Task Creator & Project Email Address') ?>
                                    <?php endif ?>
                                <?php else: ?>
                                    <?= $this->text->e($param_value) ?>
                                <?php endif ?>

                            </li>
                        <?php endforeach ?>
                    </ul>
                    <?php endif ?>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
<?php endif ?>
