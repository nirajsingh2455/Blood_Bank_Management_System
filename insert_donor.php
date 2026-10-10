<?php
include "db.php";

$name = $_POST['name'];
$blood = $_POST['blood_group'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$phone = $_POST['phone'];
$city = $_POST['city'];
$last = $_POST['last_donation'];
$address = $_POST['address'];

$sql = "INSERT INTO donors(name,blood_group,age,gender,phone,city,last_donation,address)
VALUES('$name','$blood','$age','$gender','$phone','$city','$last','$address')";

if($conn->query($sql)){
header("Location:view_donors.php");
}else{
echo "Error: ".$conn->error;
}
?>