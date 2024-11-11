<?php 
include "../service/database.php";
session_start();

if (!isset($_SESSION["is_login"])) {
    header("location: ../akses/login.php");
    exit;
}

$id = $_GET['id'];
$sql = "DELETE FROM books WHERE id=$id";

if ($db->query($sql)) {
    header("location: dashboard.php");
} else {
    echo "Gagal menghapus buku.";
}
?>
