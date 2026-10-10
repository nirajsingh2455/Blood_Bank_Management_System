<?php
include "db.php";

$id = $_POST['id'];
$name = $_POST['name'];
$blood_group = $_POST['blood_group'];
$age = $_POST['age'];

$sql = "UPDATE donors 
        SET name='$name', blood_group='$blood_group', age='$age'
        WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: view_donors.php");
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>