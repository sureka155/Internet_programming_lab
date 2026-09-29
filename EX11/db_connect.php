<?php
// db_connect.php
$servername = "localhost";
$username   = "root";
$password   = "mysql";
$dbname     = "shopping_db1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
