<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Leads</h1>
        <?php if ($this->permission->can('leads', 'create')): ?>
            <a href="<?php echo site_url('leads/create'); ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Lead
            </a>
        <?php endif; ?>
    </div>
</div>

<div class="content">
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
    <?php endif; ?>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <?php 
        $status_colors = array(
            'new' => 'info',
            'contacted' => 'warning',
            'qualified' => 'success',
            'unqualified' => 'secondary',
            'converted' => 'primary'
        );
        foreach ($stats as $stat): 
        ?>
        <div class="col-md-2">
            <div class="card bg-<?php echo $status_colors[$stat['status']] ?? 'secondary'; ?> text-white">
                <div class="card-body text-center">
                    <h3><?php echo $stat['count']; ?></h3>
                    <small><?php echo ucfirst($stat['status']); ?></small>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Filter -->
    <div class="mb-3">
        <a href="<?php echo site_url('leads'); ?>" class="btn btn-sm btn-<?php echo empty($current_status) ? 'primary' : 'outline-primary'; ?>">All</a>
        <?php foreach (array('new', 'contacted', 'qualified', 'converted') as $status): ?>
            <a href="<?php echo site_url('leads?status='.$status); ?>" class="btn btn-sm btn-<?php echo $current_status == $status ? 'primary' : 'outline-primary'; ?>">
                <?php echo ucfirst($status); ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Leads Table -->
    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Company</th>
                        <th>Source</th>
                        <th>Status</th>
                        <th>Value</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($leads)): ?>
                        <tr><td colspan="7" class="text-center">No leads found.</td></tr>
                    <?php else: ?>
                        <?php foreach ($leads as $lead): ?>
                        <tr>
                            <td><?php echo html_escape($lead['name']); ?></td>
                            <td><?php echo html_escape($lead['email']); ?></td>
                            <td><?php echo html_escape($lead['company']); ?></td>
                            <td><span class="badge bg-info"><?php echo ucfirst(str_replace('_', ' ', $lead['source'])); ?></span></td>
                            <td><span class="badge bg-<?php echo $status_colors[$lead['status']] ?? 'secondary'; ?>"><?php echo ucfirst($lead['status']); ?></span></td>
                            <td>$<?php echo number_format($lead['value'], 2); ?></td>
                            <td>
                                <?php if ($this->permission->can('leads', 'edit')): ?>
                                    <a href="<?php echo site_url('leads/edit/'.$lead['id']); ?>" class="btn btn-sm btn-info">Edit</a>
                                    <?php if ($lead['status'] != 'converted'): ?>
                                        <a href="<?php echo site_url('leads/convert/'.$lead['id']); ?>" class="btn btn-sm btn-success" onclick="return confirm('Convert to contact?')">Convert</a>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if ($this->permission->can('leads', 'delete')): ?>
                                    <a href="<?php echo site_url('leads/delete/'.$lead['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>