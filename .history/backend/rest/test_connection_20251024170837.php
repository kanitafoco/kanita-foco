<?php
require_once 'config.php';

try {
    $conn = Database::connect();
    echo "<h2 style='color:green'>✅ Konekcija uspješna!</h2>";

    // test upit
    $stmt = $conn->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo "<pre>";
    print_r($tables);
    echo "</pre>";

} catch (PDOException $e) {
    echo "<h2 style='color:red'>❌ Greška pri konekciji:</h2>";
    echo $e->getMessage();
}
?>