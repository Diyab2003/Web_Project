<?php
include('db.php');

$search_query = "";
$message = "";


if (isset($_GET['message'])) {
    $message = "<p style='color: #28a745; font-weight: bold;'>" . htmlspecialchars($_GET['message']) . "</p>";
}
if (isset($_GET['error'])) {
    $message = "<p style='color: #dc3545; font-weight: bold;'>❌ " . htmlspecialchars($_GET['error']) . "</p>";
}


if (isset($_POST['add_movie'])) {
    
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $director = mysqli_real_escape_string($conn, $_POST['director']);
    $release_year = (int)$_POST['release_year'];
    $rating = (float)$_POST['rating'];

    
    $sql_insert = "INSERT INTO movies (title, director, release_year, rating) 
                    VALUES ('$title', '$director', $release_year, $rating)";
    
    if (mysqli_query($conn, $sql_insert)) {
        
        header("Location: index.php?message=" . urlencode("✅ Movie added successfully!"));
        exit();
    } else {
        $message = "<p style='color: #dc3545; font-weight: bold;'>❌ Error adding movie: " . mysqli_error($conn) . "</p>";
    }
}

if (isset($_GET['search_term']) && $_GET['search_term'] != '') {
    $search_term = mysqli_real_escape_string($conn, $_GET['search_term']);
    $search_query = $search_term;
    
    
    $sql_select = "SELECT * FROM movies 
                    WHERE title LIKE '%$search_term%' 
                    OR director LIKE '%$search_term%' 
                    ORDER BY movie_id ASC";

} else {
    
    $sql_select = "SELECT * FROM movies ORDER BY movie_id ASC";
}

$result = mysqli_query($conn, $sql_select);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Movie Catalog Manager</title>
    <style>
        
        :root {
            --color-primary: #1e2833; 
            --color-secondary: #00bcd4; 
            --color-light: #ffffff;
            --color-dark-accent: #323f4b;
            --color-button-search: #ff4141; 
            --color-button-add: #00bcd4;
            --color-button-reset: #dc3545;
        }

        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            background-color: var(--color-primary); 
            color: var(--color-light); 
        }
        .container { 
            max-width: 900px; 
            margin: 30px auto; 
            background: var(--color-dark-accent); 
            padding: 20px; 
            border-radius: 10px; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.5); 
        }
        h1 { 
            color: var(--color-secondary); 
            border-bottom: 3px solid var(--color-secondary); 
            padding-bottom: 10px; 
            font-weight: 300;
        }
        
        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .reset-button {
            padding: 8px 15px;
            background-color: var(--color-button-reset);
            color: var(--color-light);
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
            white-space: nowrap;
        }

        .reset-button:hover { background-color: #f14e5f; }

        .search-box, .add-box { 
            background: var(--color-dark-accent); 
            padding: 15px 0; 
            margin-bottom: 20px; 
            border-radius: 6px; 
            border: none; 
        }
        .add-box input[type="text"], 
        .add-box input[type="number"], 
        .search-box input[type="text"] {
            padding: 10px; 
            margin-right: 10px; 
            border: 1px solid var(--color-secondary); 
            background: var(--color-primary);
            color: var(--color-light);
            border-radius: 4px; 
            width: 18%; 
            display: inline-block;
        }
        .add-box input[type="number"] { width: 12%; }
        .search-box button, .add-box button { 
            padding: 10px 20px; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer; 
            color: var(--color-light); 
            font-weight: bold; 
            transition: background-color 0.3s ease;
        }
        
        .search-box button[type="submit"] { 
            background-color: var(--color-button-search); 
        }
        .search-box button[type="submit"]:hover { background-color: #ff6666; }
        
        .search-box button[type="button"] { 
            background-color: #555; 
        }
        .search-box button[type="button"]:hover { background-color: #777; }

        
        .add-box button { 
            background-color: var(--color-button-add); 
            margin-top: 10px; 
        }
        .add-box button:hover { background-color: #00dfff; }

        
        .catalog-list table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
        }
        .catalog-list th, .catalog-list td { 
            padding: 15px; 
            border: 1px solid var(--color-dark-accent); 
        }
        .catalog-list th { 
            background-color: var(--color-secondary); 
            color: var(--color-primary); 
            text-align: left; 
            font-weight: bold;
        }
        .catalog-list td { 
            background-color: var(--color-primary); 
            color: var(--color-light);
        }
        .actions a { 
            text-decoration: none; 
            margin-right: 10px; 
            font-weight: bold; 
            transition: color 0.3s ease;
        }
        .edit-link { 
            color: #ffc107; 
        }
        .edit-link:hover { color: #fff; }
        .delete-link { 
            color: var(--color-button-search); 
        }
        .delete-link:hover { color: #ff6666; }
        .no-records { 
            text-align: center; 
            padding: 20px; 
            color: #bbb; 
            background-color: var(--color-dark-accent);
        }
        .search-box label { color: var(--color-light); }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-actions">
            <h1>Movie Catalog Manager</h1>
            <!-- New Reset Button -->
            <a href="reset.php" class="reset-button" onclick="return confirm('WARNING: This will delete ALL movies and reset the ID counter to 1. Are you absolutely sure?');">Reset Catalog</a>
        </div>
        
        <?php echo $message; ?>


        <div class="search-box">
            <form action="index.php" method="GET" style="display: inline;">
                <label for="search">Search by Title or Director:</label>
                <input type="text" name="search_term" value="<?php echo htmlspecialchars($search_query); ?>" placeholder="Search...">
                <button type="submit">Search</button>
                <button type="button" onclick="window.location.href='index.php'">Reset</button>
            </form>
        </div>

        
        <div class="add-box">
            <h3>+ Add New Movie</h3>
            <form action="index.php" method="POST">
                <input type="text" name="title" placeholder="Title" required>
                <input type="text" name="director" placeholder="Director" required>
                <input type="number" name="release_year" placeholder="Year" min="1888" max="<?php echo date('Y') + 1; ?>" required>
                <input type="number" name="rating" step="0.1" min="0" max="10" placeholder="Rating (e.g., 8.5)" required>
                <button type="submit" name="add_movie">Add Movie</button>
            </form>
        </div>

        
        <div class="catalog-list">
            <h2>Catalog List</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Director</th>
                        <th>Year</th>
                        <th>Rating</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row["movie_id"] . "</td>";
                            echo "<td>" . htmlspecialchars($row["title"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["director"]) . "</td>";
                            echo "<td>" . $row["release_year"] . "</td>";
                            echo "<td>" . $row["rating"] . "</td>";
                            echo "<td class='actions'>";
                            
                            echo "<a href='edit.php?id=" . $row["movie_id"] . "' class='edit-link'>Edit</a> | ";
                            
                            echo "<a href='delete.php?id=" . $row["movie_id"] . "' class='delete-link' onclick=\"return confirm('Are you sure you want to delete ' + '" . htmlspecialchars($row["title"]) . "' + '?');\">Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='no-records'>No movies found. Try adding one above!</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<?php
mysqli_close($conn);
?>
