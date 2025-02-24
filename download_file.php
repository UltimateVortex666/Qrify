<?php
$conn = new mysqli('localhost', 'root', '', 'event management');
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT file, fileName FROM events WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($fileData, $fileName);
    $stmt->fetch();

    if ($fileData) {
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=" . $fileName);
        echo $fileData;
    } else {
        echo "No file found!";
    }
}
$conn->close();
?>
