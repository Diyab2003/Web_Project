<?php include('db.php'); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Insert Student</title>
</head>
<body>
  <h2>Add New Student</h2>
  <form action="" method="POST">
      Name: <input type="text" name="name" required><br><br>
      Age: <input type="number" name="age" required><br><br>
      Course: <input type="text" name="course" required><br><br>
      Branch: <input type="text" name="branch" required><br><br>
      <button type="submit" name="submit">Add Student</button>
  </form>

  <?php
  if (isset($_POST['submit'])) {
      $name = $_POST['name'];
      $age = $_POST['age'];
      $course = $_POST['course'];
      $branch = $_POST['branch'];

      $sql = "INSERT INTO students (name, age, course,branch) VALUES ('$name', '$age', '$course', '$branch')";
      if (mysqli_query($conn, $sql)) {
          echo "Student added successfully!";
      } else {
          echo "Error: " . mysqli_error($conn);
      }
  }
  ?>
</body>
</html>
