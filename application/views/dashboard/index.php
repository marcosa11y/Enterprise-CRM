<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card" style="position: relative;">
            <h3>150</h3>
            <p>Total Leads</p>
            <i class="fas fa-users"></i>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="stat-card" style="position: relative; background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
            <h3>53</h3>
            <p>Active Deals</p>
            <i class="fas fa-handshake"></i>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="stat-card" style="position: relative; background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%);">
            <h3>28</h3>
            <p>Won This Month</p>
            <i class="fas fa-trophy"></i>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6">
        <div class="stat-card" style="position: relative; background: linear-gradient(135deg, #4568dc 0%, #b06ab3 100%);">
            <h3>12</h3>
            <p>Pending Tasks</p>
            <i class="fas fa-tasks"></i>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0"><i class="fas fa-user"></i> Welcome to Your CRM Dashboard</h5>
            </div>
            <div class="card-body">
                <p class="lead">Hello, <strong><?php echo isset($user['username']) ? htmlspecialchars($user['username']) : 'Admin'; ?></strong>!</p>
                <p>You are logged in as: 
                    <span class="badge bg-primary">
                        <?php 
                        if (isset($user['role_id'])) {
                            echo ($user['role_id'] == 1) ? 'Administrator' : 'User';
                        }
                        ?>
                    </span>
                </p>
                <hr>
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-check-circle text-success fa-2x me-3"></i>
                            <div>
                                <strong>System Status</strong><br>
                                <small class="text-muted">All systems operational</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-database text-primary fa-2x me-3"></i>
                            <div>
                                <strong>Database</strong><br>
                                <small class="text-muted">Connected successfully</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-shield-alt text-warning fa-2x me-3"></i>
                            <div>
                                <strong>Security</strong><br>
                                <small class="text-muted">CSRF protection enabled</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>