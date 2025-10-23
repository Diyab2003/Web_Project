<?php
include('db.php');

if(isset($_POST['update'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $course = $_POST['course'];
    $branch = $_POST['branch'];
    $sql = "UPDATE students SET name='$name', age='$age', course='$course', branch='$branch' WHERE id=$id";
    mysqli_query($conn, $sql);
    echo "Record updated successfully!";
}

$result = mysqli_query($conn, "SELECT * FROM students");
?>
<h2>Update Student</h2>
<form method="POST">
<select name="id">
<?php
while($row = mysqli_fetch_assoc($result)){
    echo "<option value='{$row['id']}'>{$row['name']}</option>";
}
?>
</select><br><br>
New Name: <input type="text" name="name" required><br><br>
New Age: <input type="number" name="age" required><br><br>
New Course: <input type="text" name="course" required><br><br>
New Branch: <input type="text" name="branch" required><br><br>
<button type="submit" name="update">Update</button>
</form>
