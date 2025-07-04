<?php
$conn = new mysqli("localhost", "root", "", "fake_follower");

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

$userid = $_POST['userid'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE userid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userid);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    if (password_verify($password, $row['password'])) {
        echo "<script>alert('Login Successful!'); window.location='dashboard.html';</script>";
    } else {
        echo "<script>alert('Incorrect Password!'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('User not found!'); window.history.back();</script>";
}
?>
