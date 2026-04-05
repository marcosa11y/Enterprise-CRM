<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Companies</h1>
        <?php if ($this->permission->can('companies', 'create')): ?>
            <a href="<?php echo site_url('companies/create'); ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Company
            </a>
        <?php endif; ?>
    </div>
</div>

<div class="content">
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Company Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>City</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($companies)): ?>
                        <tr><td colspan="6" class="text-center">No companies found.</td></tr>
                    <?php else: ?>
                        <?php foreach ($companies as $company): ?>
                        <tr>
                            <td><?php echo html_escape($company['name']); ?></td>
                            <td><?php echo html_escape($company['email']); ?></td>
                            <td><?php echo html_escape($company['phone']); ?></td>
                            <td><?php echo html_escape($company['city']); ?></td>
                            <td>
                                <span class="badge bg-<?php echo $company['status'] == 'active' ? 'success' : 'secondary'; ?>">
                                    <?php echo ucfirst($company['status']); ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($this->permission->can('companies', 'edit')): ?>
                                    <a href="<?php echo site_url('companies/edit/'.$company['id']); ?>" class="btn btn-sm btn-info">Edit</a>
                                <?php endif; ?>
                                <?php if ($this->permission->can('companies', 'delete')): ?>
                                    <a href="<?php echo site_url('companies/delete/'.$company['id']); ?>" 
                                       class="btn btn-sm btn-danger" 
                                       onclick="return confirm('Are you sure?')">Delete</a>
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