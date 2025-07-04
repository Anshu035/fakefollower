<?php
$conn = new mysqli("localhost", "root", "", "fake_follower");

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

$userid = $_POST['userid'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

$check = $conn->prepare("SELECT id FROM users WHERE userid = ?");
$check->bind_param("s", $userid);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo "<script>alert('User ID already exists'); window.history.back();</script>";
} else {
    $stmt = $conn->prepare("INSERT INTO users (userid, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $userid, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful!'); window.location='index.html';</script>";
    } else {
        echo "<script>alert('Registration failed!'); window.history.back();</script>";
    }
}
?>
