<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'kapal_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil ID kapal dari URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Ambil data kapal berdasarkan ID
    $stmt = $conn->prepare("SELECT * FROM kapal WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $kapal = $result->fetch_assoc();
    $stmt->close();
    
    // Jika data kapal tidak ditemukan
    if (!$kapal) {
        echo "Data kapal tidak ditemukan.";
        exit;
    }
} else {
    echo "ID kapal tidak disertakan.";
    exit;
}

// Proses update data kapal
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_kapal = $_POST['nama_kapal'];
    $callsign = $_POST['callsign'];
    $mmsi = $_POST['mmsi'];
    $type_gt = $_POST['type_gt'];
    $flag = $_POST['flag'];
    $ais_draft = $_POST['ais_draft'];
    $tanggal = $_POST['tanggal']; // Tanggal yang dikirimkan dari form
    
    // Update data kapal
    $stmt = $conn->prepare("UPDATE kapal SET nama_kapal = ?, callsign = ?, mmsi = ?, type_gt = ?, flag = ?, ais_draft = ?, tanggal = ? WHERE id = ?");
    $stmt->bind_param("ssissssi", $nama_kapal, $callsign, $mmsi, $type_gt, $flag, $ais_draft, $tanggal, $id);

    if ($stmt->execute()) {
        header("Location: informasi_kapal.php"); // Kembali ke halaman informasi_kapal
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
    <title>Edit Kapal</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-4">
        <a href="informasi_kapal.php" class="btn btn-secondary mb-4">← Back</a>
        <h2 class="text-2xl font-bold text-gray-700 mb-4">Edit Informasi Kapal</h2>

        <form method="POST" action="">
            <div class="form-group">
                <label>Nama Kapal</label>
                <input type="text" name="nama_kapal" class="form-control" value="<?php echo htmlspecialchars($kapal['nama_kapal']); ?>" required>
            </div>
            <div class="form-group">
                <label>Callsign</label>
                <input type="text" name="callsign" class="form-control" value="<?php echo htmlspecialchars($kapal['callsign']); ?>" required>
            </div>
            <div class="form-group">
                <label>MMSI</label>
                <input type="text" name="mmsi" class="form-control" value="<?php echo htmlspecialchars($kapal['mmsi']); ?>" required>
            </div>
            <div class="form-group">
                <label>Type/GT</label>
                <input type="text" name="type_gt" class="form-control" value="<?php echo htmlspecialchars($kapal['type_gt']); ?>" required>
            </div>
            <div class="form-group">
                <label>Flag</label>
                <input type="text" name="flag" class="form-control" value="<?php echo htmlspecialchars($kapal['flag']); ?>" required>
            </div>
            <div class="form-group">
                <label>AIS Draft</label>
                <input type="text" name="ais_draft" class="form-control" value="<?php echo htmlspecialchars($kapal['ais_draft']); ?>" required>
            </div>
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="<?php echo htmlspecialchars($kapal['tanggal']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
