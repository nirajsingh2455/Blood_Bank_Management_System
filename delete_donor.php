<?php
include "db.php";

$id = $_GET['id'];

$sql = "DELETE FROM donors WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: view_donors.php");
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>