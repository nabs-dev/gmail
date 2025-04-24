<?php
include("db.php");
if ($_POST) {
    $name = $_POST['name']; $email = $_POST['email']; $pass = $_POST['password'];
    $conn->query("INSERT INTO users(name, email, password) VALUES('$name','$email','$pass')");
    echo "<script>location.href='login.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Signup</title>
<style>
body { font-family:sans-serif; display:flex; justify-content:center; align-items:center; height:100vh; background:#f1f1f1; }
form { background:white; padding:20px; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.1); width:300px; }
input { width:100%; padding:10px; margin:10px 0; border:1px solid #ccc; border-radius:5px; }
button { background:#4285f4; color:white; border:none; padding:10px; width:100%; border-radius:5px; font-weight:bold; }
</style>
</head>
<body>
<form method="post">
    <h2>Signup</h2>
    <input type="text" name="name" placeholder="Full Name" required />
    <input type="email" name="email" placeholder="Email" required />
    <input type="password" name="password" placeholder="Password" required />
    <button type="submit">Signup</button>
    <p>Already have an account? <a href="#" onclick="goLogin()">Login</a></p>
</form>
<script>
function goLogin(){ location.href='login.php'; }
</script>
</body>
</html>
