<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login | <?php echo html_escape($site_name); ?></title>
    
    <?php echo load_css($this->config->item('css/bootstrap', 'assets'), TRUE); ?>
    <?php echo load_css($this->config->item('css/fontawesome', 'assets'), TRUE); ?>
    <?php echo load_css('auth', FALSE); ?>
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-header">
                <h2><i class="fas fa-lock"></i> CRM Login</h2>
                <p>Enterprise Customer Relationship Management</p>
            </div>
            
            <?php if ($error = $this->session->flashdata('error')): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-circle"></i> <?php echo html_escape($error); ?>
                </div>
            <?php endif; ?>
            
            <?php echo form_open('auth/login', ['class' => 'auth-form']); ?>
                <div class="mb-3">
                    <?php echo form_label('<i class="fas fa-envelope"></i> Email Address', 'email'); ?>
                    <?php echo form_input([
                        'name' => 'email',
                        'id' => 'email',
                        'type' => 'email',
                        'class' => 'form-control form-control-lg',
                        'value' => set_value('email'),
                        'placeholder' => 'admin@crm.com',
                        'required' => 'required',
                        'autofocus' => 'autofocus'
                    ]); ?>
                    <?php echo form_error('email', '<div class="text-danger small mt-1">', '</div>'); ?>
                </div>
                
                <div class="mb-4">
                    <?php echo form_label('<i class="fas fa-key"></i> Password', 'password'); ?>
                    <?php echo form_input([
                        'name' => 'password',
                        'id' => 'password',
                        'type' => 'password',
                        'class' => 'form-control form-control-lg',
                        'placeholder' => '••••••••',
                        'required' => 'required'
                    ]); ?>
                    <?php echo form_error('password', '<div class="text-danger small mt-1">', '</div>'); ?>
                </div>
                
                <?php echo form_button([
                    'type' => 'submit',
                    'class' => 'btn btn-auth',
                    'content' => '<i class="fas fa-sign-in-alt"></i> Sign In'
                ]); ?>
            <?php echo form_close(); ?>
            
            <div class="auth-footer">
                <small>
                    <strong>Default Credentials:</strong><br>
                    <code>admin@crm.com</code> / <code>Admin@123</code>
                </small>
            </div>
        </div>
    </div>
    
    <?php echo load_js($this->config->item('js/bootstrap', 'assets'), TRUE); ?>
</body>
</html>