<?php
require_once 'config.php';

$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF token
    verifyCSRFToken($_POST['csrf_token']);

    // Sanitize and validate input
    $full_name = sanitize($_POST['full_name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $social_media = sanitize($_POST['social_media']);
    $experience = sanitize($_POST['experience']);
    $message = sanitize($_POST['message']);

    // Validate required fields
    if (empty($full_name) || empty($email) || empty($phone)) {
        $error_message = 'Lütfen zorunlu alanları doldurunuz.';
    } else {
        try {
            $stmt = $conn->prepare("INSERT INTO applications (full_name, email, phone, social_media, experience, message) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$full_name, $email, $phone, $social_media, $experience, $message]);
            $success_message = 'Başvurunuz başarıyla alınmıştır.';
            
            // Clear form after successful submission
            $_POST = array();
        } catch(PDOException $e) {
            $error_message = 'Başvuru gönderilirken bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Başvuru Formu - OnlyFans Ajansı</title>
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
                    <a href="basvuru.php" class="text-gray-900">Başvuru</a>
                    <a href="login.php" class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800">
                        Yönetim Paneli
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Application Form -->
    <div class="min-h-screen py-12 px-4">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold text-center mb-2">İçerik Üretici Başvurusu</h1>
            <p class="text-gray-600 text-center mb-8">Kariyerinizi bir üst seviyeye taşımak için formu doldurun.</p>

            <?php if ($success_message): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>

            <?php if ($error_message): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                
                <div>
                    <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Ad Soyad *</label>
                    <input type="text" id="full_name" name="full_name" required
                           value="<?php echo isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : ''; ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-posta *</label>
                    <input type="email" id="email" name="email" required
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black">
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Telefon *</label>
                    <input type="tel" id="phone" name="phone" required
                           value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black">
                </div>

                <div>
                    <label for="social_media" class="block text-sm font-medium text-gray-700 mb-1">Sosyal Medya Hesapları</label>
                    <input type="text" id="social_media" name="social_media"
                           value="<?php echo isset($_POST['social_media']) ? htmlspecialchars($_POST['social_media']) : ''; ?>"
                           placeholder="Instagram, Twitter, vb. hesap linkleri"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black">
                </div>

                <div>
                    <label for="experience" class="block text-sm font-medium text-gray-700 mb-1">Deneyim</label>
                    <input type="text" id="experience" name="experience"
                           value="<?php echo isset($_POST['experience']) ? htmlspecialchars($_POST['experience']) : ''; ?>"
                           placeholder="İçerik üretimi konusundaki deneyiminiz"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black">
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Eklemek İstedikleriniz</label>
                    <textarea id="message" name="message" rows="4"
                              placeholder="Kendiniz hakkında eklemek istediğiniz bilgiler..."
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black"><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                </div>

                <button type="submit"
                        class="w-full bg-black text-white py-2 px-4 rounded-lg hover:bg-gray-800 transition">
                    Başvuruyu Gönder
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
