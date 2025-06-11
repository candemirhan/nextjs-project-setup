<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OnlyFans Ajansı - Profesyonel İçerik Üretici Yönetimi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-white">
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

    <!-- Hero Section -->
    <div class="relative bg-black h-[600px] flex items-center">
        <div class="absolute inset-0 bg-gradient-to-b from-black/60 to-black/30"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                OnlyFans Ajansı ile Başarıya Ulaşın
            </h1>
            <p class="text-xl md:text-2xl text-gray-200 mb-8 max-w-2xl mx-auto">
                İçerik üreticileri için profesyonel yönetim ve gelir takip platformu
            </p>
            <div class="flex flex-col md:flex-row gap-4 justify-center">
                <a href="basvuru.php" 
                   class="bg-white text-black px-8 py-3 rounded-lg font-medium hover:bg-gray-100 transition">
                    Hemen Başvur
                </a>
                <a href="login.php" 
                   class="border border-white text-white px-8 py-3 rounded-lg font-medium hover:bg-white/10 transition">
                    Yönetim Paneli
                </a>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-20 px-4">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-12">
                Neden Bizi Seçmelisiniz?
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold mb-4">Profesyonel Yönetim</h3>
                    <p class="text-gray-600">
                        Deneyimli ekibimizle içerik üreticilerimize tam destek sağlıyoruz.
                    </p>
                </div>
                <!-- Feature 2 -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold mb-4">Gelir Optimizasyonu</h3>
                    <p class="text-gray-600">
                        Gelirlerinizi maksimize etmek için stratejik planlamalar yapıyoruz.
                    </p>
                </div>
                <!-- Feature 3 -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold mb-4">Şeffaf Raporlama</h3>
                    <p class="text-gray-600">
                        Detaylı gelir takibi ve raporlama sistemiyle kazançlarınızı anlık izleyin.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-black text-white py-20 px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">
                Kariyerinizi Bizimle Büyütün
            </h2>
            <p class="text-xl text-gray-300 mb-8">
                Profesyonel ekibimizle tanışın ve OnlyFans kariyerinizi bir üst seviyeye taşıyın.
            </p>
            <a href="basvuru.php" 
               class="bg-white text-black px-8 py-3 rounded-lg font-medium hover:bg-gray-100 inline-block transition">
                Başvuru Yap
            </a>
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
