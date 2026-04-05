<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php echo load_css('kanban', FALSE); ?>

<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Deal Pipeline</h1>
        <?php if ($this->permission->can('deals', 'create')): ?>
            <a href="<?php echo site_url('deals/create'); ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Deal
            </a>
        <?php endif; ?>
    </div>
</div>

<div class="content">
    <div class="kanban-board">
        <?php foreach ($stages as $stage): ?>
        <div class="kanban-column" data-stage-id="<?php echo $stage['id']; ?>">
            <div class="kanban-column-header" style="border-top-color: var(--<?php echo $stage['color']; ?>);">
                <h5><?php echo html_escape($stage['name']); ?></h5>
                <span class="badge"><?php echo count(array_filter($deals, function($d) use ($stage) { return $d['stage_id'] == $stage['id']; })); ?></span>
            </div>
            <div class="kanban-cards" data-stage-id="<?php echo $stage['id']; ?>">
                <?php 
                $stage_deals = array_filter($deals, function($d) use ($stage) { return $d['stage_id'] == $stage['id']; });
                foreach ($stage_deals as $deal): 
                ?>
                <div class="kanban-card" data-deal-id="<?php echo $deal['id']; ?>">
                    <div class="kanban-card-title"><?php echo html_escape($deal['title']); ?></div>
                    <div class="kanban-card-value">$<?php echo number_format($deal['value'], 2); ?></div>
                    <div class="kanban-card-probability"><?php echo $deal['probability']; ?>%</div>
                    <?php if ($this->permission->can('deals', 'edit')): ?>
                        <a href="<?php echo site_url('deals/edit/'.$deal['id']); ?>" class="btn btn-sm btn-link">Edit</a>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php echo load_js('kanban', FALSE); ?>