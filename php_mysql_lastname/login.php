<?php
session_start();
require 'connection.php';
$connect = Connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    try {
        if ($username === '' || $password === '') {
            throw new Exception("All fields are required.");
        }

        $stmt = $connect->prepare("SELECT * FROM tbl_users WHERE username = :username LIMIT 1");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_OBJ);

        if (!$user || !password_verify($password, $user->password)) {
            throw new Exception("Invalid username or password.");
        }

        $_SESSION['user_id'] = $user->id;
        $_SESSION['username'] = $user->username;

        $_SESSION['toast'] = [
            'title' => 'Welcome',
            'body'  => 'Login successful.',
            'type'  => 'success'
        ];

        header("Location: employee.php");
        exit;

    } catch (Exception $e) {
        $_SESSION['toast'] = [
            'title' => 'Error',
            'body'  => $e->getMessage(),
            'type'  => 'danger'
        ];
        header("Location: login.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Login</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" name="login" class="btn btn-primary">Login</button>
    </form>
</body>
</html>
