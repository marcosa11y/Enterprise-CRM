<?php
// test_db.php - Remove after testing
echo "<h1>Database Connection Test</h1>";

// Test database connection
$mysqli = new mysqli('localhost', 'root', '', 'crm_db');

if ($mysqli->connect_error) {
    echo "<p style='color:red'>❌ Connection failed: " . $mysqli->connect_error . "</p>";
} else {
    echo "<p style='color:green'>✅ Database connected successfully!</p>";
    
    // Check if tables exist
    $result = $mysqli->query("SHOW TABLES");
    echo "<h3>Existing tables:</h3>";
    if ($result->num_rows > 0) {
        echo "<ul>";
        while($row = $result->fetch_array()) {
            echo "<li>" . $row[0] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No tables found. Migration hasn't run.</p>";
    }
    $mysqli->close();
}

// Check CI configuration
echo "<h3>CodeIgniter Config Check:</h3>";
echo "APPPATH: " . __DIR__ . "/application/<br>";
$migration_file = __DIR__ . "/application/config/migration.php";
if (file_exists($migration_file)) {
    echo "✅ migration.php exists<br>";
    include($migration_file);
    echo "migration_enabled: " . ($config['migration_enabled'] ? 'TRUE' : 'FALSE') . "<br>";
    echo "migration_type: " . $config['migration_type'] . "<br>";
    echo "migration_path: " . $config['migration_path'] . "<br>";
} else {
    echo "❌ migration.php not found<br>";
}

// Check migrations folder
$migrations_folder = __DIR__ . "/application/migrations/";
if (is_dir($migrations_folder)) {
    echo "✅ Migrations folder exists<br>";
    $files = scandir($migrations_folder);
    echo "<strong>Migration files:</strong><br>";
    foreach($files as $file) {
        if($file != '.' && $file != '..') {
            echo "- $file<br>";
        }
    }
} else {
    echo "❌ Migrations folder NOT found at: $migrations_folder<br>";
}
?>