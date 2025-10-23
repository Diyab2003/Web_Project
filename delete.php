<?php
include('db.php');

if(isset($_POST['delete'])){
    $id = $_POST['id'];
    $sql = "DELETE FROM students WHERE id=$id";
    mysqli_query($conn, $sql);
    echo "Record deleted successfully!";
}

$result = mysqli_query($conn, "SELECT * FROM students");
?>
<h2>Delete Student</h2>
<form method="POST">
<select name="id">
<?php
while($row = mysqli_fetch_assoc($result)){
    echo "<option value='{$row['id']}'>{$row['name']}</option>";
}
?>
</select><br><br>
<button type="submit" name="delete">Delete</button>
</form>
