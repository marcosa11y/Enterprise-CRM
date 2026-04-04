<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Phase 2 Test Report - Permissions System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 30px; background: #f8f9fa; }
        .test-card { background: white; border-radius: 8px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .pass { color: #198754; font-weight: 600; }
        .fail { color: #dc3545; font-weight: 600; }
        .warn { color: #fd7e14; font-weight: 600; }
        .section-title { border-bottom: 2px solid #667eea; padding-bottom: 10px; margin-bottom: 15px; color: #333; }
        code { background: #e9ecef; padding: 2px 6px; border-radius: 3px; font-size: 0.9em; }
    </style>
</head>
<body>
    <div class="container" style="max-width: 800px;">
        <h1 class="mb-4">🧪 Phase 2 Test Report</h1>
        <p class="text-muted">Permissions System Verification</p>
        
        <?php foreach ($results as $section => $tests): ?>
        <div class="test-card">
            <h4 class="section-title"><?php echo ucfirst(str_replace('_', ' ', $section)); ?></h4>
            <table class="table table-sm">
                <tbody>
                <?php foreach ($tests as $test => $result): ?>
                    <tr>
                        <td style="width: 60%;"><code><?php echo $test; ?></code></td>
                        <td class="<?php 
                            echo strpos($result, '✅') !== FALSE ? 'pass' : 
                                 (strpos($result, '❌') !== FALSE ? 'fail' : 'warn');
                        ?>">
                            <?php echo $result; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endforeach; ?>
        
        <div class="alert alert-info">
            <strong>Next Steps:</strong>
            <ol class="mb-0 mt-2">
                <li>If all tests show ✅, Phase 2 is complete</li>
                <li>Delete <code>application/controllers/Test_permissions.php</code></li>
                <li>Delete <code>application/views/test/</code> folder</li>
                <li>Proceed to Phase 3: Company & Contact Management</li>
            </ol>
        </div>
        
        <hr>
        <p class="text-center text-muted small">
            ⚠️ This test controller is for development only. Delete before production.
        </p>
    </div>
</body>
</html>