<?php
require_once 'Config.php';

try {
    $conn = Database::connect();
    echo "<h2 style='color:green'>✅ Connection successful!!</h2>";

    // test query
    $stmt = $conn->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo "<pre>";
    print_r($tables);
    echo "</pre>";

} catch (PDOException $e) {
    echo "<h2 style='color:red'>❌ Connection error:</h2>";
    echo $e->getMessage();
}
?>
