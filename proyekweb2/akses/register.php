<?php 
    include "../service/database.php"; 
    session_start();

    $register_log = "";

    if(isset($_SESSION["is_login"])){
        header("location: ../add/dashboard.php"); 
        exit;
    }

    if(isset($_POST["register"])){
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

        if($db->query($sql)){
            $register_log = "Registrasi berhasil";
        } else {
            $register_log = "Registrasi gagal";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../css/styles.css"> 
    <link rel="stylesheet" href="../css/register.css"> 
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
            <div class="register-container">
                <h3>Daftar Akun</h3>
                <p class="message"><?= htmlspecialchars($register_log) ?></p>
                <form action="register.php" method="POST">
                    <input type="text" placeholder="Username" name="username" required/>
                    <input type="password" placeholder="Password" name="password" required/>
                    <button type="submit" name="register">Daftar Sekarang</button>
                </form>
            </div>
        </main>

        <footer>
            <p>Cada final es solo un nuevo comienzo. Gracias por ser parte de nuestra historia.</p>
        </footer>
    </div>

</body>
</html>
