<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="content">
    <div class="card">
        <div class="card-header">Edit Company</div>
        <div class="card-body">
            <?php echo form_open('companies/edit/'.$company['id']); ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Company Name *</label>
                            <input type="text" name="name" class="form-control" value="<?php echo set_value('name', $company['name']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?php echo set_value('email', $company['email']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo set_value('phone', $company['phone']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Website</label>
                            <input type="text" name="website" class="form-control" value="<?php echo set_value('website', $company['website']); ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="3"><?php echo set_value('address', $company['address']); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control" value="<?php echo set_value('city', $company['city']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">State</label>
                            <input type="text" name="state" class="form-control" value="<?php echo set_value('state', $company['state']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Country</label>
                            <input type="text" name="country" class="form-control" value="<?php echo set_value('country', $company['country']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Postal Code</label>
                            <input type="text" name="postal_code" class="form-control" value="<?php echo set_value('postal_code', $company['postal_code']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="active" <?php echo $company['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                                <option value="inactive" <?php echo $company['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Update Company</button>
                    <a href="<?php echo site_url('companies'); ?>" class="btn btn-secondary">Cancel</a>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>