<?php 
include_once('config.php');

$message = "";

if(isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $password = $_POST['password']; // corrected variable name
    $passwordConfirmation = $_POST['passwordConfirmation'];

    if ($password !== $passwordConfirmation) { // corrected comparison
        $message = "Passwords do not match.";
    } else {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT); // use the corrected $password

        $sql = "INSERT INTO user (username, firstName, lastName, pass) VALUES (:username, :firstName, :lastName, :pass)";
        $stmt = $conn->prepare($sql);

        try {
            $stmt->execute([
                ':username' => $username,
                ':firstName' => $firstName,
                ':lastName' => $lastName,
                ':pass' => $passwordHash,
            ]);
            $message = "Account created successfully! You can now <a href='login.php'>login</a>.";
        } catch (PDOException $e) {
            $message = "Error creating account: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Sign Up</title>
</head>
<body>

<div class="container">
    <h2>Create an Account</h2>
    <?php if($message): ?>
        <div class="message <?php echo strpos($message, 'successfully') !== false ? 'success' : '' ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Username" required />
        <input type="text" name="firstName" placeholder="First Name" required />
        <input type="text" name="lastName" placeholder="Last Name" required />
        <input type="password" name="password" placeholder="Password" required />
        <input type="password" name="passwordConfirmation" placeholder="Confirm Password" required />
        <button type="submit" name="submit">Create Account</button>
    </form>

    <p>Already have an account? <a href="login.php">Login</a></p>
</div>

</body>
</html>
