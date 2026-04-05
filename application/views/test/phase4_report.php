<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head><title>Phase 4 Test</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h1>🧪 Phase 4 Test Report</h1>
    <table class="table">
        <?php foreach ($tests as $name => $result): ?>
        <tr><td><?php echo $name; ?></td><td class="<?php echo strpos($result, '✅') !== FALSE ? 'text-success' : 'text-danger'; ?>"><?php echo $result; ?></td></tr>
        <?php endforeach; ?>
    </table>
</body>
</html>