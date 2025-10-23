<?php
include('db.php');

$movie = null;
$message = "";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $error = "No movie ID provided for editing.";
} else {
    $movie_id = (int)$_GET['id'];
    
    $sql_fetch = "SELECT * FROM movies WHERE movie_id = $movie_id";
    $result_fetch = mysqli_query($conn, $sql_fetch);

    if (mysqli_num_rows($result_fetch) == 1) {
        $movie = mysqli_fetch_assoc($result_fetch);
    } else {
        $error = "Movie with ID $movie_id not found.";
    }
}

if (isset($_POST['update_movie'])) {
    $movie_id = (int)$_POST['movie_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $director = mysqli_real_escape_string($conn, $_POST['director']);
    $release_year = (int)$_POST['release_year'];
    $rating = (float)$_POST['rating'];

    $sql_update = "UPDATE movies 
                   SET title = '$title', 
                       director = '$director', 
                       release_year = $release_year, 
                       rating = $rating 
                   WHERE movie_id = $movie_id";
    
    if (mysqli_query($conn, $sql_update)) {
        header("Location: index.php?message=" . urlencode("✅ Movie ID $movie_id updated successfully!"));
        exit();
    } else {
        $message = "<p style='color: #dc3545; font-weight: bold;'>❌ Error updating movie: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Movie Record</title>
    <style>
        :root {
            --color-primary: #1a202c; /* Changed: Dark Slate Blue Page Background */
            --color-secondary: #00bcd4;
            --color-light: #ffffff;
            --color-dark-accent: #2d3748; /* Changed: Slightly Lighter Slate Card Background */
            --color-button-save: #28a745;
            --color-button-cancel: #555;
            --color-warning: #ffc107;
        }

        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            background-color: var(--color-primary); 
            color: var(--color-light);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container { 
            width: 90%;
            max-width: 600px; 
            background: var(--color-dark-accent); 
            padding: 30px; 
            border-radius: 10px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.7); 
        }
        h1 { 
            color: var(--color-secondary); 
            border-bottom: 3px solid var(--color-secondary); 
            padding-bottom: 10px; 
            margin-top: 0;
            font-weight: 300;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input[type="text"],
        .form-group input[type="number"] {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--color-secondary);
            background: var(--color-primary);
            color: var(--color-light);
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-actions {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }
        .form-actions button, .form-actions a {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: var(--color-light);
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.3s ease;
            text-align: center;
            flex-grow: 1;
            margin: 0 5px;
        }
        .form-actions button[type="submit"] {
            background-color: var(--color-button-save);
        }
        .form-actions button[type="submit"]:hover { background-color: #38c15a; }
        
        .form-actions a {
            background-color: var(--color-button-cancel);
        }
        .form-actions a:hover { background-color: #777; }
        
        .error-message {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid var(--color-warning);
            background-color: #4b3d16;
            color: var(--color-warning);
            border-radius: 4px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Movie Record</h1>
        <?php echo $message; ?>

        <?php if (isset($error)): ?>
            <p class="error-message">⚠️ <?php echo htmlspecialchars($error); ?></p>
            <p><a href="index.php" class="form-actions a">← Back to Catalog</a></p>
        <?php elseif ($movie): ?>
            <form action="edit.php" method="POST">
                <input type="hidden" name="movie_id" value="<?php echo $movie['movie_id']; ?>">
                
                <div class="form-group">
                    <label for="title">Title (ID: <?php echo $movie['movie_id']; ?>)</label>
                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($movie['title']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="director">Director</label>
                    <input type="text" id="director" name="director" value="<?php echo htmlspecialchars($movie['director']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="release_year">Release Year</label>
                    <input type="number" id="release_year" name="release_year" value="<?php echo $movie['release_year']; ?>" min="1888" max="<?php echo date('Y') + 1; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="rating">Rating (0.0 to 10.0)</label>
                    <input type="number" id="rating" name="rating" value="<?php echo $movie['rating']; ?>" step="0.1" min="0" max="10" required>
                </div>

                <div class="form-actions">
                    <button type="submit" name="update_movie">Save Changes</button>
                    <a href="index.php">Cancel & Back to Catalog</a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
<?php
mysqli_close($conn);
?>
