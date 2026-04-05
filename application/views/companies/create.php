<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="content">
    <div class="card">
        <div class="card-header">Add New Company</div>
        <div class="card-body">
            <?php echo form_open('companies/create'); ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Company Name *</label>
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
                            <label class="form-label">Website</label>
                            <input type="text" name="website" class="form-control" value="<?php echo set_value('website'); ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="3"><?php echo set_value('address'); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control" value="<?php echo set_value('city'); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">State</label>
                            <input type="text" name="state" class="form-control" value="<?php echo set_value('state'); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Country</label>
                            <input type="text" name="country" class="form-control" value="<?php echo set_value('country', 'USA'); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Postal Code</label>
                            <input type="text" name="postal_code" class="form-control" value="<?php echo set_value('postal_code'); ?>">
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Save Company</button>
                    <a href="<?php echo site_url('companies'); ?>" class="btn btn-secondary">Cancel</a>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>