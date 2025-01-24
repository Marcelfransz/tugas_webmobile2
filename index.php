<!-- login.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <!-- Tambahkan Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tambahkan Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-700">Login Admin</h2>
        <form action="authenticate.php" method="POST">
            <div class="form-group">
                <label for="username" class="block text-gray-600 mb-2">Username</label>
                <input type="text" name="username" id="username" class="form-control rounded-lg focus:ring-2 focus:ring-blue-500 w-full p-3 border border-gray-300" required>
            </div>
            <div class="form-group mt-4">
                <label for="password" class="block text-gray-600 mb-2">Password</label>
                <input type="password" name="password" id="password" class="form-control rounded-lg focus:ring-2 focus:ring-blue-500 w-full p-3 border border-gray-300" required>
            </div>
            <button type="submit" class="w-full mt-6 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 transition duration-200">
                Login
            </button>
        </form>
        <p class="text-center text-gray-500 mt-4">© 2024 Navigasi Sorong</p>
    </div>
    <!-- Tambahkan Bootstrap JS dan jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
