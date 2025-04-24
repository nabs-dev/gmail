<?php
session_start();
if (!isset($_SESSION['user'])) echo "<script>location.href='login.php';</script>";
include("db.php");
include("email_functions.php");

$uid = $_SESSION['user']['id'];
$folder = $_GET['folder'] ?? 'inbox';
$search = $_GET['search'] ?? '';

$emails = [];
if ($folder == 'inbox') {
    $query = "SELECT * FROM emails WHERE receiver_id=$uid";
} elseif ($folder == 'sent') {
    $query = "SELECT * FROM emails WHERE sender_id=$uid";
} elseif ($folder == 'starred') {
    $query = "SELECT * FROM emails WHERE receiver_id=$uid AND starred=1";
}

if ($search != '') {
    $query .= " AND (subject LIKE '%$search%' OR body LIKE '%$search%')";
}

$result = $conn->query($query . " ORDER BY created_at DESC");
while ($row = $result->fetch_assoc()) {
    $emails[] = $row;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<style>
body { margin:0; font-family:sans-serif; }
header { background:#4285f4; color:white; padding:15px; display:flex; justify-content:space-between; align-items:center; }
nav { background:#f1f1f1; width:200px; float:left; height:100vh; padding:20px; box-sizing:border-box; }
main { margin-left:200px; padding:20px; }
a { text-decoration:none; display:block; margin:10px 0; color:#333; }
.email { border-bottom:1px solid #ccc; padding:10px; }
.email strong { display:block; color:#111; }
.email small { color:gray; }
input[type=search] { padding:5px; width:200px; border-radius:5px; border:1px solid #ccc; }
button { background:#34a853; border:none; color:white; padding:5px 10px; border-radius:5px; }
</style>
</head>
<body>
<header>
  <h2>Welcome, <?= $_SESSION['user']['name'] ?></h2>
  <div>
    <input type="search" id="search" placeholder="Search emails..." value="<?= htmlspecialchars($search) ?>">
    <button onclick="searchMail()">Search</button>
    <button onclick="location.href='compose.php'">Compose</button>
    <button onclick="location.href='logout.php'">Logout</button>
  </div>
</header>

<nav>
  <a href="#" onclick="goTo('inbox')">Inbox</a>
  <a href="#" onclick="goTo('sent')">Sent</a>
  <a href="#" onclick="goTo('starred')">Starred</a>
</nav>

<main>
  <h3><?= ucfirst($folder) ?> Emails</h3>
  <?php if (empty($emails)) echo "<p>No emails found.</p>"; ?>
  <?php foreach ($emails as $email): ?>
    <div class="email">
      <strong><?= $folder == 'sent' ? "To: " . getUserName($email['receiver_id']) : "From: " . getUserName($email['sender_id']) ?></strong>
      <span>Subject: <?= htmlspecialchars($email['subject']) ?></span><br>
      <small><?= $email['created_at'] ?> <?= $email['starred'] ? '⭐' : '' ?></small>
    </div>
  <?php endforeach; ?>
</main>

<script>
function goTo(folder) {
  location.href = 'dashboard.php?folder=' + folder;
}
function searchMail() {
  let s = document.getElementById("search").value;
  location.href = 'dashboard.php?folder=<?= $folder ?>&search=' + encodeURIComponent(s);
}
</script>
</body>
</html>
