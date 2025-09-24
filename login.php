<?php
session_start();
include_once('config.php');

$message = "";

if (isset($_POST['Submit'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $sql = "SELECT * FROM user WHERE username = :username LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id']; 
        $_SESSION['username'] = $user['username'];

        header("Location: index.php");
        exit();
    } else {
        $message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Login</title>
</head>
<body>

<div class="container">
    <h2>Login</h2>

    <?php if ($message): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="username" placeholder="Username" required />
        <input type="password" name="password" placeholder="Password" required />
        <button type="submit" name="Submit">Sign In</button>
    </form>

    <p>Don't have an account? <a href="sign.php">Sign Up</a></p>
</div>

</body>
</html>