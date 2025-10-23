<?php
include('db.php');

$error = null;

$sql_truncate = "TRUNCATE TABLE movies";

if (!mysqli_query($conn, $sql_truncate)) {
    $error = "Failed to truncate table: " . mysqli_error($conn);
}

$sql_reset_auto_increment = "ALTER TABLE movies AUTO_INCREMENT = 1";

if (!mysqli_query($conn, $sql_reset_auto_increment)) {
    if (!$error) {
        $error = "Failed to reset AUTO_INCREMENT: " . mysqli_error($conn);
    }
}

mysqli_close($conn);

if ($error) {
    header("Location: index.php?error=" . urlencode("❌ Catalog reset failed. " . $error));
} else {
    header("Location: index.php?message=" . urlencode("✅ Movie catalog successfully reset! ID counter is now back to 1."));
}
exit();
?>
