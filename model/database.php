<?php
// Set up the database connection
$dsn = '...';
$username = '...';
$password = '...';
$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

try {
    $db = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    $error_message = $e->getMessage();;
    exit();
}
?>