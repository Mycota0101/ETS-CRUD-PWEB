<?php
include "../service/database.php";

$file_name = "books_" . date("Y-m-d_H-i-s") . ".sql";

header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary");
header("Content-disposition: attachment; filename=\"{$file_name}\"");

ob_start();

$query = "SHOW CREATE TABLE books";
$result = $db->query($query);
if ($row = $result->fetch_assoc()) {
    echo $row['Create Table'] . ";\n\n";
}

$query = "SELECT * FROM books";
$result = $db->query($query);

while ($row = $result->fetch_assoc()) {
    $values = array_map([$db, 'real_escape_string'], array_values($row));
    $values = "'" . implode("', '", $values) . "'";
    echo "INSERT INTO books VALUES ($values);\n";
}

ob_end_flush();
exit;
?>
