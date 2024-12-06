<?php
// editUser.php
include 'db.php';

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Fetch the user data
    $stmt = $pdo->prepare("SELECT * FROM Users WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $user = $stmt->fetch();

    if (!$user) {
        die("User not found.");
    }
} else {
    die("Invalid request.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $role = $_POST['role'];

    // Update the user in the database
    $stmt = $pdo->prepare("UPDATE Users SET username = :username, email = :email, phone_number = :phone_number, role = :role WHERE user_id = :user_id");
    $stmt->execute([
        'username' => $username,
        'email' => $email,
        'phone_number' => $phone_number,
        'role' => $role,
        'user_id' => $user_id
    ]);

    header("Location: admin-dashboard.php?category=Users");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST">
    <input type="text" name="username" value="<?= $user['username'] ?>" required>
    <input type="email" name="email" value="<?= $user['email'] ?>" required>
    <input type="text" name="phone_number" value="<?= $user['phone_number'] ?>" required>
    <select name="role">
        <option value="customer" <?= $user['role'] == 'customer' ? 'selected' : '' ?>>Customer</option>
        <option value="therapist" <?= $user['role'] == 'therapist' ? 'selected' : '' ?>>Therapist</option>
        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
    </select>
    <button type="submit">Update</button>
</form>
</body>
</html>
