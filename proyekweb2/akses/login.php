<?php 
include "../service/database.php"; 
session_start();

$login_log = "";

if (isset($_SESSION["is_login"])) {
    header("location: ../add/dashboard.php"); 
    exit;
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $_SESSION["user_id"] = $data["id"]; 
        $_SESSION["username"] = $data["username"];
        $_SESSION["is_login"] = true;
        header("location: ../add/dashboard.php"); 
        exit;
    } else {
        $login_log = "Username atau password salah";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/styles.css"> 
    <link rel="stylesheet" href="../css/login.css">  
</head>
<body>

    <div class="container">
        <header>
            <h3>Bo0ks</h3>
            <a href="../index.php">Home</a> 
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        </header>

        <main>
            <div class="login-container">
                <h3>Masuk Akun</h3>
                <p class="error"><?= htmlspecialchars($login_log) ?></p>
                <form action="login.php" method="POST">
                    <input type="text" placeholder="Username" name="username" required/>
                    <input type="password" placeholder="Password" name="password" required/>
                    <button type="submit" name="login">Masuk Sekarang</button>
                </form>
            </div>
        </main>

        <footer>
            <p>La vida es un viaje, y estamos felices de que seas parte de nuestro camino.</p>
        </footer>
    </div>

</body>
</html>
