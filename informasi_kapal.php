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

// Menghapus data kapal
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM kapal WHERE id = $id");
    header("Location: informasi_kapal.php");
}

// Ambil semua kapal
$result = $conn->query("SELECT * FROM kapal");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Informasi Kapal</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#searchInput').on('input', function() {
                const query = $(this).val();
                $.ajax({
                    url: 'search_kapal.php',
                    method: 'GET',
                    data: { query: query },
                    success: function(data) {
                        const kapal = JSON.parse(data);
                        let rows = '';

                        kapal.forEach(function(row) {
                            rows += `<tr class="border-b border-gray-200">
                                <td class="px-4 py-2">${row.nama_kapal}</td>
                                <td class="px-4 py-2">${row.callsign}</td>
                                <td class="px-4 py-2">${row.mmsi}</td>
                                <td class="px-4 py-2">${row.type_gt}</td>
                                <td class="px-4 py-2">${row.flag}</td>
                                <td class="px-4 py-2">${row.ais_draft}</td>
                                <td class="px-4 py-2">${row.tanggal}</td>
                                <td class="px-4 py-2">
                                    <a href="edit_kapal.php?id=${row.id}" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="informasi_kapal.php?delete=${row.id}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                </td>
                            </tr>`;
                        });

                        $('#kapalTableBody').html(rows);
                    }
                });
            });
        });
    </script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-4">
        <a href="dashboard.php" class="inline-block bg-gray-200 text-gray-600 py-2 px-4 rounded-lg hover:bg-gray-300 transition duration-200">
            ← Back
        </a>
        <h2 class="text-2xl font-bold text-gray-700 mt-6">Informasi Kapal</h2>
        <a href="tambah_kapal.php" class="btn btn-primary my-4">Tambah Kapal Baru</a>

        <!-- Form Pencarian -->
        <form id="searchForm" method="POST" class="form-inline mb-4">
            <input type="text" id="searchInput" class="form-control mr-2" placeholder="Cari berdasarkan nama kapal">
        </form>

        <div class="overflow-x-auto">
            <table class="table-auto w-full bg-white shadow-lg rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="px-4 py-2">Nama Kapal</th>
                        <th class="px-4 py-2">Callsign</th>
                        <th class="px-4 py-2">MMSI</th>
                        <th class="px-4 py-2">Type/GT</th>
                        <th class="px-4 py-2">Flag</th>
                        <th class="px-4 py-2">AIS/Draft</th>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody id="kapalTableBody">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-2"><?php echo htmlspecialchars($row['nama_kapal']); ?></td>
                            <td class="px-4 py-2"><?php echo htmlspecialchars($row['callsign']); ?></td>
                            <td class="px-4 py-2"><?php echo htmlspecialchars($row['mmsi']); ?></td>
                            <td class="px-4 py-2"><?php echo htmlspecialchars($row['type_gt']); ?></td>
                            <td class="px-4 py-2"><?php echo htmlspecialchars($row['flag']); ?></td>
                            <td class="px-4 py-2"><?php echo htmlspecialchars($row['ais_draft']); ?></td>
                            <td class="px-4 py-2"><?php echo htmlspecialchars($row['tanggal']); ?></td>
                            <td class="px-4 py-2">
                                <a href="edit_kapal.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="informasi_kapal.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
