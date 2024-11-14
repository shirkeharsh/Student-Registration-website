<?php
include('../config.php');

if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];
    mysqli_query($conn, "UPDATE `participants` SET `attended` = '1' WHERE `id` = '$id'") or die('Query failed');
}

?>
