<?php
session_start();
if (!isset($_SESSION['user'])) {
    echo "<script>location.href='login.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Compose Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }
        .container {
            max-width: 500px;
            margin: 40px auto;
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
        h2 {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }
        input[type="text"], input[type="email"], textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 7px;
            font-size: 14px;
        }
        textarea {
            resize: vertical;
            height: 120px;
        }
        .starred {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }
        .starred input {
            margin-right: 10px;
        }
        .btns {
            margin-top: 20px;
        }
        .btns button {
            padding: 10px 20px;
            background: #4285F4;
            color: white;
            border: none;
            margin-right: 10px;
            border-radius: 7px;
            cursor: pointer;
            font-size: 14px;
        }
        .btns button:hover {
            background: #3367D6;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Compose Email</h2>
    <form method="POST" action="send_email.php">
        <label for="receiver_email">To:</label>
        <input type="email" name="receiver_email" placeholder="Enter recipient's email" required>

        <label>Subject:</label>
        <input type="text" name="subject" placeholder="Enter subject" required>

        <label>Body:</label>
        <textarea name="body" placeholder="Write your message here..." required></textarea>

        <div class="starred">
            <input type="checkbox" name="starred" id="starred">
            <label for="starred">Mark as Starred</label>
        </div>

        <div class="btns">
            <button type="submit">Send</button>
            <button type="button" onclick="location.href='dashboard.php'">Cancel</button>
        </div>
    </form>
</div>
</body>
</html>
