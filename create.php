<?php
include('db.php');

$sql = "CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    age INT NOT NULL,
    course VARCHAR(50) NOT NULL,
    branch VARCHAR(50) NOT NULL
)";

if (mysqli_query($conn, $sql)) {
    echo "Table 'students' created successfully.";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

mysqli_close($conn);
?>

