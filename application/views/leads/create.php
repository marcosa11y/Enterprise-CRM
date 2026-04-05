<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="content">
    <div class="card">
        <div class="card-header">Add New Lead</div>
        <div class="card-body">
            <?php echo form_open('leads/create'); ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Name *</label>
                            <input type="text" name="name" class="form-control" value="<?php echo set_value('name'); ?>" required>
                            <?php echo form_error('name', '<div class="text-danger">', '</div>'); ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo set_value('email'); ?>">
                            <?php echo form_error('email', '<div class="text-danger">', '</div>'); ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo set_value('phone'); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Company</label>
                            <input type="text" name="company" class="form-control" value="<?php echo set_value('company'); ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Title/Position</label>
                            <input type="text" name="title" class="form-control" value="<?php echo set_value('title'); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Source</label>
                            <select name="source" class="form-control">
                                <option value="website">Website</option>
                                <option value="referral">Referral</option>
                                <option value="social_media">Social Media</option>
                                <option value="advertising">Advertising</option>
                                <option value="cold_call">Cold Call</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Value ($)</label>
                            <input type="number" name="value" class="form-control" value="<?php echo set_value('value', '0'); ?>" step="0.01">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4"><?php echo set_value('description'); ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Save Lead</button>
                    <a href="<?php echo site_url('leads'); ?>" class="btn btn-secondary">Cancel</a>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>