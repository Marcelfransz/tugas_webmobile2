<?php
$conn = new mysqli('localhost', 'root', '', 'kapal_db');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search = isset($_GET['query']) ? $_GET['query'] : '';
$query = "%" . $search . "%";

$stmt = $conn->prepare("SELECT * FROM kapal WHERE nama_kapal LIKE ?");
$stmt->bind_param("s", $query);
$stmt->execute();
$result = $stmt->get_result();

$kapal = [];

while ($row = $result->fetch_assoc()) {
    $kapal[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($kapal);
?>
