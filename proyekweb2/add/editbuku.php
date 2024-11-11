<?php 
include "../service/database.php";
session_start();

if (!isset($_SESSION["is_login"])) {
    header("location: ../akses/login.php");
    exit;
}

$id = $_GET['id'];
$update_log = "";

$sql = "SELECT * FROM books WHERE id=$id";
$result = $db->query($sql);
$book = $result->fetch_assoc();

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $year = $_POST['year'];
    $genre = $_POST['genre'];
    $file_path = $book['file_path'];

    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $file_name = time() . "_" . basename($_FILES["file"]["name"]); 
        $target_dir = __DIR__ . "/uploads/"; 
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            $file_path = "add/uploads/" . $file_name;
        } else {
            $update_log = "Gagal mengunggah file.";
        }
    }

    // Update data di database
    $sql = "UPDATE books SET title='$title', author='$author', year='$year', genre='$genre', file_path='$file_path' WHERE id=$id";

    if ($db->query($sql)) {
        header("location: dashboard.php");
    } else {
        $update_log = "Gagal memperbarui buku.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title>
    <link rel="stylesheet" href="css/addbuku.css">
</head>
<body>

<div class="container">
    <a href="dashboard.php" class="back-button">Back</a>
    <h2>Edit Buku</h2>
    <p><?= htmlspecialchars($update_log); ?></p>
    <form action="editbuku.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
        <label>Judul Buku</label>
        <input type="text" name="title" value="<?= htmlspecialchars($book['title']); ?>" required><br>
        
        <label>Penulis</label>
        <input type="text" name="author" value="<?= htmlspecialchars($book['author']); ?>" required><br>
        
        <label>Tahun Terbit</label>
        <input type="number" name="year" value="<?= htmlspecialchars($book['year']); ?>" required><br>
        
        <label>Genre</label>
        <input type="text" name="genre" value="<?= htmlspecialchars($book['genre']); ?>" required><br>
        
        <label>Unggah Gambar Baru (Opsional)</label>
        <input type="file" name="file" accept="image/*"><br>
        
        <button type="submit" name="submit">Perbarui Buku</button>
    </form>
</div>

</body>
</html>
