<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner"><h3>150</h3><p>New Leads</p></div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner"><h3>53</h3><p>Deals Won</p></div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header"><h3 class="card-title">Welcome, <?php echo $user['username']; ?></h3></div>
    <div class="card-body">
        <p>You are logged in as <strong><?php echo ($user['role_id'] == ROLE_ADMIN) ? 'Administrator' : 'User'; ?></strong>.</p>
    </div>
</div>