<?php
include('db.php');

$sql = "
CREATE TABLE IF NOT EXISTS movies (
    movie_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    director VARCHAR(100) NOT NULL, 
    release_year INT,
    rating DECIMAL(2, 1) 
);
";

if (mysqli_query($conn, $sql)) {
    echo "Table 'movies' created successfully!";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

mysqli_close($conn);
?>

