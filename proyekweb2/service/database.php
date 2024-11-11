<?php 

$hostname = "localhost";
$username = "root";
$password = "";
$database_name = "buku";

$db = mysqli_connect($hostname, $username, $password);


if (mysqli_connect_errno()) {
    echo "Koneksi ke server MySQL gagal: " . mysqli_connect_error();
    exit(); 
}

$sql_create_database = "CREATE DATABASE IF NOT EXISTS $database_name";
if (!$db->query($sql_create_database)) {
    echo "Error membuat database: " . $db->error;
}

$db->select_db($database_name);

$sql_create_table_books = "
    CREATE TABLE IF NOT EXISTS books (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        author VARCHAR(255) NOT NULL,
        year YEAR NOT NULL,
        genre VARCHAR(100) NOT NULL,
        file_path VARCHAR(255),
        user_id INT
    )
";

if (!$db->query($sql_create_table_books)) {
    echo "Error membuat tabel books: " . $db->error;
}

$sql_create_table_users = "
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(100) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
";

if (!$db->query($sql_create_table_users)) {
    echo "Error membuat tabel users: " . $db->error;
}

?>
