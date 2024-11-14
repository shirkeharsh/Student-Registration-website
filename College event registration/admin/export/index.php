<?php
include_once '../../config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the database connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = $conn->query("SELECT * FROM `user` ORDER BY uid ASC");

if ($query->num_rows > 0) {
    $delimiter = ",";
    $filename = "users-data_" . date('Y-m-d') . ".csv";

    $f = fopen('php://memory', 'w');
    $fields = array('UID', 'NAME', 'GENDER', 'PHONE', 'EMAIL', 'COURSE','ROLL NO','STATUS');
    fputcsv($f, $fields, $delimiter);

    while ($row = $query->fetch_assoc()) {
        $lineData = array($row['uid'], ($row['first_name'] . $row['last_name']), $row['gender'], $row['phone'], $row['email'], $row['course'], $row['rollno'], $row['status']);
        fputcsv($f, $lineData, $delimiter);
    }

    fseek($f, 0);
    
    // Set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    fpassthru($f);
}

// Close the database connection
$conn->close();
exit;
?>
