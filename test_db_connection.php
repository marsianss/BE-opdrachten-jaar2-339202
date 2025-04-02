<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=jamin_b;port=3308', 'root', '');
    echo "Database connection successful!";
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
}
