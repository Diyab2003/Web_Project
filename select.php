<?php
include('db.php');

$result = mysqli_query($conn, "SELECT * FROM students");
echo "<h2>All Students</h2>";
echo "<table border='1' cellpadding='10'>
<tr><th>ID</th><th>Name</th><th>Age</th><th>Course</th><th>Branch</th></tr>";

while($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['age']}</td>
            <td>{$row['course']}</td>
            <td>{$row['branch']}</td>
          </tr>";
}
echo "</table>";
mysqli_close($conn);
?>
