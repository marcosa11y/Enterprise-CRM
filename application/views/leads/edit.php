<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="content">
    <div class="card">
        <div class="card-header">Edit Lead</div>
        <div class="card-body">
            <?php echo form_open('leads/edit/'.$lead['id']); ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Name *</label>
                            <input type="text" name="name" class="form-control" value="<?php echo set_value('name', $lead['name']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo set_value('email', $lead['email']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo set_value('phone', $lead['phone']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Company</label>
                            <input type="text" name="company" class="form-control" value="<?php echo set_value('company', $lead['company']); ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Title/Position</label>
                            <input type="text" name="title" class="form-control" value="<?php echo set_value('title', $lead['title']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Source</label>
                            <select name="source" class="form-control">
                                <option value="website" <?php echo $lead['source'] == 'website' ? 'selected' : ''; ?>>Website</option>
                                <option value="referral" <?php echo $lead['source'] == 'referral' ? 'selected' : ''; ?>>Referral</option>
                                <option value="social_media" <?php echo $lead['source'] == 'social_media' ? 'selected' : ''; ?>>Social Media</option>
                                <option value="advertising" <?php echo $lead['source'] == 'advertising' ? 'selected' : ''; ?>>Advertising</option>
                                <option value="cold_call" <?php echo $lead['source'] == 'cold_call' ? 'selected' : ''; ?>>Cold Call</option>
                                <option value="other" <?php echo $lead['source'] == 'other' ? 'selected' : ''; ?>>Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="new" <?php echo $lead['status'] == 'new' ? 'selected' : ''; ?>>New</option>
                                <option value="contacted" <?php echo $lead['status'] == 'contacted' ? 'selected' : ''; ?>>Contacted</option>
                                <option value="qualified" <?php echo $lead['status'] == 'qualified' ? 'selected' : ''; ?>>Qualified</option>
                                <option value="unqualified" <?php echo $lead['status'] == 'unqualified' ? 'selected' : ''; ?>>Unqualified</option>
                                <option value="converted" <?php echo $lead['status'] == 'converted' ? 'selected' : ''; ?>>Converted</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Value ($)</label>
                            <input type="number" name="value" class="form-control" value="<?php echo set_value('value', $lead['value']); ?>" step="0.01">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4"><?php echo set_value('description', $lead['description']); ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Update Lead</button>
                    <a href="<?php echo site_url('leads'); ?>" class="btn btn-secondary">Cancel</a>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>