<?php 
include "../service/database.php";
session_start();

if (!isset($_SESSION["is_login"])) {
    header("location: ../akses/login.php");
    exit;
}

$add_log = "";
$user_id = $_SESSION["user_id"]; // Mengambil ID pengguna dari session

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $year = $_POST['year'];
    $genre = $_POST['genre'];
    $file_path = "";

    // Proses unggah file
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $file_name = time() . "_" . basename($_FILES["file"]["name"]); // Menambahkan timestamp ke nama file
        $target_dir = "uploads/"; // Folder uploads di dalam folder add
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            $file_path = "add/uploads/" . $file_name; // Menyimpan path relatif ke file
        } else {
            $add_log = "Gagal mengunggah file.";
        }
    }

    // Menyimpan data ke database
    $sql = "INSERT INTO books (title, author, year, genre, file_path, user_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("sssssi", $title, $author, $year, $genre, $file_path, $user_id);

    if ($stmt->execute()) {
        header("location: dashboard.php");
    } else {
        $add_log = "Gagal menambah buku.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
    <link rel="stylesheet" href="css/addbuku.css">
</head>

<body>

<div class="container">
    <h2>Tambahkan Buku</h2>
    <p><?= htmlspecialchars($add_log); ?></p>
    <form action="addbuku.php" method="POST" enctype="multipart/form-data">
        <label>Judul Buku</label>
        <input type="text" name="title" placeholder="Judul Buku" required><br>
        <label>Penulis</label>
        <input type="text" name="author" placeholder="Penulis" required><br>
        <label>Tahun Terbit</label>
        <input type="number" name="year" placeholder="Tahun Terbit" required><br>
        <label>Genre</label>
        <input type="text" name="genre" placeholder="Genre" required><br>
        <label>Unggah Gambar Buku</label>
        <input type="file" name="file" accept="image/*"><br>
        <button type="submit" name="submit">Tambah Buku</button>
    </form>
</div>

</body>
</html>
