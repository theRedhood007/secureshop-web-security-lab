<?php
$servername = "localhost";
$username = "shopuser";
$password = "vulnerable123";
$dbname = "secureshop";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

