<?php
include "db.php";

/* Search */

$search="";
if(isset($_GET['search'])){
$search=$_GET['search'];

$query="SELECT * FROM donors 
WHERE name LIKE '%$search%' 
OR city LIKE '%$search%' 
OR blood_group LIKE '%$search%'";
}else{
$query="SELECT * FROM donors";
}

$result=$conn->query($query);

/* Eligibility Function */

function checkEligibility($last_date){

if(!$last_date){
return "Unknown";
}

$last=strtotime($last_date);
$today=time();

$days=($today-$last)/(60*60*24);

if($days>=90){
return "Eligible";
}else{
return "Not Eligible";
}

}
?>

<!DOCTYPE html>
<html>

<head>

<title>View Donors</title>

<style>

body{
font-family:Arial;
background:#f4f6f9;
margin:0;
}

.header{
background:#c0392b;
color:white;
padding:15px;
text-align:center;
font-size:22px;
}

/* Navigation */

.nav{
text-align:center;
margin-top:20px;
margin-bottom:30px;
}

.nav a{
padding:10px 18px;
background:#c0392b;
color:white;
text-decoration:none;
margin:5px;
border-radius:6px;
font-weight:bold;
}

/* Search Bar */

.search-container{
display:flex;
justify-content:center;
margin-bottom:30px;
}

.search-form{
background:white;
padding:15px 20px;
border-radius:10px;
box-shadow:0 3px 8px rgba(0,0,0,0.2);
display:flex;
gap:10px;
}

.search-form input{
padding:10px;
width:280px;
border:1px solid #ccc;
border-radius:6px;
outline:none;
}

.search-form input:focus{
border-color:#c0392b;
}

.search-form button{
padding:10px 18px;
background:#c0392b;
color:white;
border:none;
border-radius:6px;
cursor:pointer;
font-weight:bold;
}

.search-form button:hover{
background:#a93226;
}

/* Table */

.container{
width:90%;
margin:auto;
}

table{
width:100%;
border-collapse:collapse;
background:white;
box-shadow:0 2px 8px rgba(0,0,0,0.2);
}

th,td{
padding:10px;
border:1px solid #ddd;
text-align:center;
}

th{
background:#c0392b;
color:white;
}

/* Buttons */

.edit{
color:green;
font-weight:bold;
text-decoration:none;
}

.delete{
color:red;
font-weight:bold;
text-decoration:none;
}

/* Eligibility */

.eligible{
color:green;
font-weight:bold;
}

.noteligible{
color:red;
font-weight:bold;
}

</style>

</head>

<body>

<div class="header">
Blood Donor List
</div>

<div class="nav">

<a href="dashboard.php">Dashboard</a>
<a href="add_donor.html">Add Donor</a>

</div>

<div class="search-container">

<form method="GET" class="search-form">

<input type="text" name="search" placeholder="🔍 Search by Name, City, Blood Group">

<button type="submit">Search</button>

</form>

</div>

<div class="container">

<table>

<tr>

<th>ID</th>
<th>Name</th>
<th>Age</th>
<th>Gender</th>
<th>Blood Group</th>
<th>Phone</th>
<th>City</th>
<th>Last Donation</th>
<th>Eligibility</th>
<th>Edit</th>
<th>Delete</th>

</tr>

<?php

while($row=$result->fetch_assoc()){

$status=checkEligibility($row['last_donation']);

if($status=="Eligible"){
$class="eligible";
}else{
$class="noteligible";
}

echo "<tr>";

echo "<td>".$row['id']."</td>";
echo "<td>".$row['name']."</td>";
echo "<td>".$row['age']."</td>";
echo "<td>".$row['gender']."</td>";
echo "<td>".$row['blood_group']."</td>";
echo "<td>".$row['phone']."</td>";
echo "<td>".$row['city']."</td>";
echo "<td>".$row['last_donation']."</td>";

echo "<td class='$class'>".$status."</td>";

echo "<td><a class='edit' href='edit_donor.php?id=".$row['id']."'>Edit</a></td>";

echo "<td><a class='delete' href='delete_donor.php?id=".$row['id']."' onclick=\"return confirm('Delete this donor?');\">Delete</a></td>";

echo "</tr>";

}

?>

</table>

</div>

</body>
</html>

