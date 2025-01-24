<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <!-- Tambahkan Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tambahkan Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-blue-600 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-white text-2xl font-bold">Admin Dashboard</h1>
            <div>
                <a href="informasi_kapal.php" class="text-white mr-4 hover:underline">Informasi Kapal</a>
                <a href="settings.php" class="text-white mr-4 hover:underline">Setting</a>
                <a href="logout.php" class="text-white hover:underline">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <div class="container mx-auto mt-10 p-8 bg-white rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-gray-700 mb-6">Selamat datang, <?php echo $_SESSION['admin']; ?>!</h2>
        <p class="text-gray-600">Gunakan menu di atas untuk mengakses informasi kapal, pengaturan, atau logout.</p>
        
        <!-- Menu Informasi Kapal -->
        <div class="mt-8">
            <h3 class="text-xl font-semibold text-blue-600 mb-4">Menu Informasi Kapal</h3>
            <p class="text-gray-700">Di sini Anda dapat mengelola informasi kapal, menambahkan, mengedit, atau menghapus data kapal yang tersedia.</p>
            <!-- Link ke halaman informasi kapal -->
            <a href="informasi_kapal.php" class="inline-block mt-4 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition">Lihat Informasi Kapal</a>
        </div>

        <!-- Menu Setting -->
        <div class="mt-8">
            <h3 class="text-xl font-semibold text-blue-600 mb-4">Menu Setting</h3>
            <p class="text-gray-700">Pengaturan akun dan preferensi Anda dapat diubah melalui menu setting ini.</p>
            <!-- Link ke halaman pengaturan -->
            <a href="settings.php" class="inline-block mt-4 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition">Buka Pengaturan</a>
        </div>

        <!-- Logout -->
        <div class="mt-8">
            <h3 class="text-xl font-semibold text-blue-600 mb-4">Logout</h3>
            <p class="text-gray-700">Jika selesai, Anda dapat logout dari sistem melalui menu ini.</p>
            <!-- Link untuk logout -->
            <a href="logout.php" class="inline-block mt-4 bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600 transition">Logout</a>
        </div>
    </div>

    <!-- Tambahkan Bootstrap JS dan jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
