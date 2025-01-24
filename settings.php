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

// Fungsi untuk mengedit informasi admin
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_admin'])) {
    $id = $_POST['admin_id'];
    $username = $_POST['edit_username'];

    // Ambil data admin berdasarkan ID
    $query = "SELECT * FROM admin WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();  // Ambil data admin

    // Periksa apakah password baru diisi
    if (!empty($_POST['edit_password'])) {
        // Jika password baru diisi, hash password baru
        $password = md5($_POST['edit_password']);
    } else {
        // Jika password tidak diubah, gunakan password lama
        $password = $admin['password'];
    }

    // Update data admin
    $stmt = $conn->prepare("UPDATE admin SET username = ?, password = ? WHERE id = ?");
    $stmt->bind_param("ssi", $username, $password, $id);
    $stmt->execute();
    $stmt->close();
}

// Fungsi untuk menghapus admin
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_admin'])) {
    $id = $_POST['admin_id'];

    $stmt = $conn->prepare("DELETE FROM admin WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    echo "<p class='text-red-500'>Admin berhasil dihapus!</p>";
}

// Ambil data admin untuk ditampilkan
$result = $conn->query("SELECT * FROM admin");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Settings</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-gray-100">
    <!-- Tombol Back -->
    <div class="container mx-auto mt-4">
        <a href="dashboard.php" class="inline-block bg-gray-200 text-gray-600 py-2 px-4 rounded-lg hover:bg-gray-300 transition duration-200">
            ← Back
        </a>
    </div>

    <div class="container mx-auto mt-4 p-8 bg-white rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-gray-700 mb-6">Pengaturan Admin</h2>

        <!-- Form Tambah Admin Baru -->
        <h3 class="text-xl font-semibold text-blue-600 mb-4">Tambah Admin Baru</h3>
        <form method="POST" action="">
            <input type="hidden" name="add_admin">
            <div class="form-group">
                <label for="new_username" class="block text-gray-600 mb-2">Username Baru</label>
                <input type="text" name="new_username" id="new_username" class="form-control rounded-lg w-full p-3 border border-gray-300" required>
            </div>
            <div class="form-group mt-4">
                <label for="new_password" class="block text-gray-600 mb-2">Password Baru</label>
                <input type="password" name="new_password" id="new_password" class="form-control rounded-lg w-full p-3 border border-gray-300" required>
            </div>
            <button type="submit" class="w-full mt-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">Tambah Admin</button>
        </form>

        <!-- Daftar Admin yang Dapat Diedit -->
        <h3 class="text-xl font-semibold text-blue-600 mt-8 mb-4">Edit Informasi Admin</h3>
        
        <!-- Tabel Daftar Admin -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['username']; ?></td>
                    <td>
                        <!-- Edit Button -->
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal<?php echo $row['id']; ?>">Edit</button>
                        <!-- Hapus Button -->
                        <form method="POST" action="" style="display:inline;">
                            <input type="hidden" name="delete_admin" value="1">
                            <input type="hidden" name="admin_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>

                <!-- Modal Edit Admin -->
                <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Admin</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="">
                                    <input type="hidden" name="edit_admin">
                                    <input type="hidden" name="admin_id" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="current_password" value="<?php echo $row['password']; ?>"> <!-- Current Password Field -->
                                    <div class="form-group">
                                        <label for="edit_username<?php echo $row['id']; ?>" class="block text-gray-600">Username</label>
                                        <input type="text" name="edit_username" value="<?php echo $row['username']; ?>" class="form-control rounded-lg w-full p-3 border border-gray-300" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="edit_password" class="block text-gray-600">Password Baru</label>
                                        <input type="password" name="edit_password" class="form-control rounded-lg w-full p-3 border border-gray-300" placeholder="Biarkan kosong jika tidak ingin mengubah password">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
