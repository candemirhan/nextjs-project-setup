<?php
require_once 'config.php';

// Redirect if already logged in
if (isLoggedIn()) {
    redirect('dashboard.php');
}

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF token
    verifyCSRFToken($_POST['csrf_token']);

    $username = sanitize($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error_message = 'Lütfen tüm alanları doldurunuz.';
    } else {
        try {
            $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                redirect('dashboard.php');
            } else {
                $error_message = 'Geçersiz kullanıcı adı veya şifre.';
            }
        } catch(PDOException $e) {
            $error_message = 'Giriş yapılırken bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yönetim Paneli Girişi - OnlyFans Ajansı</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="index.php" class="text-xl font-bold text-gray-800">
                        OnlyFans Ajansı
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="basvuru.php" class="text-gray-600 hover:text-gray-900">Başvuru</a>
                    <a href="login.php" class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800">
                        Yönetim Paneli
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Login Form -->
    <div class="min-h-screen flex items-center justify-center py-12 px-4">
        <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold text-center mb-2">Yönetim Paneli</h2>
            <p class="text-gray-600 text-center mb-8">Giriş yapmak için bilgilerinizi giriniz</p>

            <?php if ($error_message): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">
                        Kullanıcı Adı
                    </label>
                    <input type="text" id="username" name="username" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"
                           value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        Şifre
                    </label>
                    <input type="password" id="password" name="password" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black">
                </div>

                <button type="submit"
                        class="w-full bg-black text-white py-2 px-4 rounded-lg hover:bg-gray-800 transition">
                    Giriş Yap
                </button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-600">
            <p>&copy; <?php echo date('Y'); ?> OnlyFans Ajansı. Tüm hakları saklıdır.</p>
        </div>
    </footer>
</body>
</html>
