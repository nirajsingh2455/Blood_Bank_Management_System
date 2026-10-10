<?php
include "db.php";

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM donors WHERE id=$id");
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Donor</title>
</head>
<body>

<h2>Edit Donor</h2>

<form action="update_donor.php" method="post">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

    Name: <input type="text" name="name" value="<?php echo $row['name']; ?>" required><br><br>
    Blood Group: <input type="text" name="blood_group" value="<?php echo $row['blood_group']; ?>" required><br><br>
    Age: <input type="number" name="age" value="<?php echo $row['age']; ?>" required><br><br>

    <button type="submit">Update Donor</button>
</form>

</body>
</html>