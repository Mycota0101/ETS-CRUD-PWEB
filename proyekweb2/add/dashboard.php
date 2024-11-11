<?php 
    session_start();
    include "../service/database.php";

    if (isset($_POST['logout'])) {
        session_unset();
        session_destroy();
        header('location: ../index.php');
        exit;
    }

    if (!isset($_SESSION["is_login"])) {
        header("location: ../akses/login.php");
        exit;
    }

    $sql = "SELECT books.*, users.username FROM books JOIN users ON books.user_id = users.id";
    $result = $db->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

<nav>
    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="addbuku.php">Tambah Buku</a></li>
        <li><a href="../index.php">Home</a></li>
        <li><a href="download_sql.php">Download Database</a></li>
    </ul>
</nav>

<h1>Welcome <?= htmlspecialchars($_SESSION["username"]); ?></h1>

<form action="dashboard.php" method="POST">
    <button type="submit" name="logout">Logout</button>
</form>

<h2>Daftar Buku</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Judul</th>
        <th>Penulis</th>
        <th>Tahun</th>
        <th>Genre</th>
        <th>Cover</th>
        <th>Ditambahkan Oleh</th>
        <th>Update</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id']; ?></td>
        <td><?= htmlspecialchars($row['title']); ?></td>
        <td><?= htmlspecialchars($row['author']); ?></td>
        <td><?= htmlspecialchars($row['year']); ?></td>
        <td><?= htmlspecialchars($row['genre']); ?></td>
        <td>
            <?php if ($row['file_path'] && preg_match('/\.(jpg|jpeg|png|gif)$/i', $row['file_path'])): ?>
                <img src="../<?= htmlspecialchars($row['file_path']); ?>" alt="Gambar Buku" width="100" height="100">
            <?php else: ?>
                Tidak ada gambar
            <?php endif; ?>
        </td>
        <td><?= htmlspecialchars($row['username']); ?></td>
        <td>
            <a href="editbuku.php?id=<?= $row['id']; ?>">Edit</a> |
            <a href="deletebuku.php?id=<?= $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus buku ini?')">Hapus</a>
            <?php if ($row['file_path']): ?>
                | <a href="../<?= htmlspecialchars($row['file_path']); ?>" download>Download</a>
            <?php endif; ?>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
