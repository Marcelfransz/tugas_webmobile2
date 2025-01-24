<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'kapal_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_kapal = $_POST['nama_kapal'];
    $callsign = $_POST['callsign'];
    $mmsi = $_POST['mmsi'];
    $type_gt = $_POST['type_gt'];
    $flag = $_POST['flag'];
    $ais_draft = $_POST['ais_draft'];
    $tanggal = $_POST['tanggal']; // Menambahkan waktu sekarang
    
    $stmt = $conn->prepare("INSERT INTO kapal (nama_kapal, callsign, mmsi, type_gt, flag, ais_draft, tanggal) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssissss", $nama_kapal, $callsign, $mmsi, $type_gt, $flag, $ais_draft, $tanggal);

    if ($stmt->execute()) {
        header("Location: informasi_kapal.php"); // Kembali ke halaman informasi kapal setelah berhasil
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Kapal</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-4">
        <a href="informasi_kapal.php" class="btn btn-secondary mb-4">← Back</a>
        <h2 class="text-2xl font-bold text-gray-700 mb-4">Tambah Kapal Baru</h2>

        <form method="POST" action="">
            <div class="form-group">
                <label>Nama Kapal</label>
                <input type="text" name="nama_kapal" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Callsign</label>
                <input type="text" name="callsign" class="form-control" required>
            </div>
            <div class="form-group">
                <label>MMSI</label>
                <input type="text" name="mmsi" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Type/GT</label>
                <input type="text" name="type_gt" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Flag</label>
                <input type="text" name="flag" class="form-control" required>
            </div>
            <div class="form-group">
                <label>AIS Draft</label>
                <input type="text" name="ais_draft" class="form-control" required>
            </div>
            <div class="form-group">
                <label>AIS Draft</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Kapal</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
