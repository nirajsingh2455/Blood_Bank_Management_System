<?php
include "db.php";
?>

<h2>Emergency Blood Request</h2>

<form method="POST">

Patient Name<br>
<input type="text" name="patient"><br><br>

Blood Group Needed<br>
<select name="blood_group">
<option>A+</option>
<option>A-</option>
<option>B+</option>
<option>B-</option>
<option>O+</option>
<option>O-</option>
<option>AB+</option>
<option>AB-</option>
</select><br><br>

City<br>
<input type="text" name="city"><br><br>

<button type="submit">Search Donors</button>

</form>

<?php

if(isset($_POST['blood_group'])){

$blood=$_POST['blood_group'];
$city=$_POST['city'];

$result=$conn->query("SELECT * FROM donors WHERE blood_group='$blood' AND city='$city'");

echo "<h3>Available Donors</h3>";

while($row=$result->fetch_assoc()){

echo $row['name']." - ".$row['phone']."<br>";

}

}
?>