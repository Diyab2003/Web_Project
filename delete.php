<?php
include('db.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
   
    $movie_id = mysqli_real_escape_string($conn, $_GET['id']);

  
    $sql = "DELETE FROM movies WHERE movie_id = $movie_id";

    if (mysqli_query($conn, $sql)) {
       
        $message = "Record ID $movie_id successfully deleted!";
        header("Location: index.php?message=" . urlencode($message));
        exit();
    } else {
       
        $error_message = "Error deleting record: " . mysqli_error($conn);
        header("Location: index.php?error=" . urlencode($error_message));
        exit();
    }
} else {

    header("Location: index.php?error=" . urlencode("No movie ID specified for deletion."));
    exit();
}

mysqli_close($conn);
?>
