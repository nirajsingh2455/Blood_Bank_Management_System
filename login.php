<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
<title>Blood Bank Login</title>

<style>

body{
font-family:Arial;
background:linear-gradient(120deg,#c0392b,#e74c3c);
height:100vh;
display:flex;
align-items:center;
justify-content:center;
}

.login-box{
background:white;
padding:40px;
width:320px;
border-radius:8px;
box-shadow:0 4px 10px rgba(0,0,0,0.3);
text-align:center;
}

input{
width:100%;
padding:10px;
margin:10px 0;
border:1px solid #ccc;
border-radius:4px;
}

button{
background:#c0392b;
color:white;
border:none;
padding:10px;
width:100%;
border-radius:4px;
font-size:16px;
cursor:pointer;
}

h2{
margin-bottom:20px;
}

</style>

</head>

<body>

<div class="login-box">

<h2>Blood Bank Login</h2>

<form action="login_process.php" method="post">

<input type="text" name="username" placeholder="Username" required>

<input type="password" name="password" placeholder="Password" required>

<button type="submit">Login</button>

</form>

</div>

</body>
</html>