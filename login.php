<?php
include("db.php");
session_start();
if ($_POST) {
    $email = $_POST['email']; $pass = $_POST['password'];
    $q = $conn->query("SELECT * FROM users WHERE email='$email' AND password='$pass'");
    if ($q->num_rows > 0) {
        $_SESSION['user'] = $q->fetch_assoc();
        echo "<script>location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Invalid login');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<style>
body { font-family:sans-serif; display:flex; justify-content:center; align-items:center; height:100vh; background:#eaeaea; }
form { background:white; padding:20px; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.1); width:300px; }
input { width:100%; padding:10px; margin:10px 0; border:1px solid #ccc; border-radius:5px; }
button { background:#34a853; color:white; border:none; padding:10px; width:100%; border-radius:5px; font-weight:bold; }
</style>
</head>
<body>
<form method="post">
    <h2>Login</h2>
    <input type="email" name="email" placeholder="Email" required />
    <input type="password" name="password" placeholder="Password" required />
    <button type="submit">Login</button>
    <p>New user? <a href="#" onclick="goSignup()">Signup</a></p>
</form>
<script>
function goSignup(){ location.href='signup.php'; }
</script>
</body>
</html>
