<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phase 2 Test Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 30px; background: #f8f9fa; font-family: sans-serif; }
        .card { margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .pass { color: #198754; font-weight: 600; }
        .fail { color: #dc3545; font-weight: 600; }
        .table td { padding: 8px; }
    </style>
</head>
<body>
    <div class="container" style="max-width: 800px;">
        <h1 class="mb-4">🧪 Phase 2 Test Report</h1>
        
        <?php foreach ($results as $section => $tests): ?>
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0"><?php echo ucfirst(str_replace('_', ' ', $section)); ?></h5>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <?php foreach ($tests as $test => $result): ?>
                    <tr>
                        <td style="width: 60%;"><?php echo str_replace('_', ' ', $test); ?></td>
                        <td class="<?php echo strpos($result, '✅') !== FALSE ? 'pass' : 'fail'; ?>">
                            <?php echo $result; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
        <?php endforeach; ?>
        
        <div class="alert alert-info mt-4 mb-0">
            <strong>Next Steps:</strong>
            <ol class="mb-0 mt-2">
                <li>If all tests show ✅, Phase 2 is complete</li>
                <li>Delete test files (controller + view folder)</li>
                <li>Commit with provided message</li>
                <li>Proceed to Phase 3</li>
            </ol>
        </div>
    </div>
</body>
</html>