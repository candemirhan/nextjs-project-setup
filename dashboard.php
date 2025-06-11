<?php
require_once 'config.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('login.php');
}

// Fetch applications
try {
    $stmt = $conn->query("SELECT * FROM applications ORDER BY created_at DESC LIMIT 10");
    $applications = $stmt->fetchAll();
} catch(PDOException $e) {
    $applications = [];
}

// Fetch revenue data
try {
    $stmt = $conn->query("SELECT DATE_FORMAT(month, '%Y-%m') as month, SUM(amount) as total_amount 
                         FROM revenue 
                         GROUP BY DATE_FORMAT(month, '%Y-%m') 
                         ORDER BY month DESC 
                         LIMIT 6");
    $revenue_data = $stmt->fetchAll();
    // Reverse array to show oldest to newest
    $revenue_data = array_reverse($revenue_data);
} catch(PDOException $e) {
    $revenue_data = [];
}

// Calculate total revenue
try {
    $stmt = $conn->query("SELECT SUM(amount) as total FROM revenue");
    $total_revenue = $stmt->fetch()['total'] ?? 0;
} catch(PDOException $e) {
    $total_revenue = 0;
}

// Get pending applications count
try {
    $stmt = $conn->query("SELECT COUNT(*) as count FROM applications WHERE status = 'pending'");
    $pending_count = $stmt->fetch()['count'] ?? 0;
} catch(PDOException $e) {
    $pending_count = 0;
}

// Get active creators count
try {
    $stmt = $conn->query("SELECT COUNT(DISTINCT creator_name) as count FROM revenue");
    $active_creators = $stmt->fetch()['count'] ?? 0;
} catch(PDOException $e) {
    $active_creators = 0;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yönetim Paneli - OnlyFans Ajansı</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    <span class="text-xl font-bold text-gray-800">Yönetim Paneli</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="logout.php" class="text-gray-600 hover:text-gray-900">Çıkış Yap</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-sm font-medium text-gray-500">Toplam Gelir</h3>
                <p class="text-2xl font-bold mt-2">₺<?php echo number_format($total_revenue, 2); ?></p>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-sm font-medium text-gray-500">Aktif İçerik Üreticileri</h3>
                <p class="text-2xl font-bold mt-2"><?php echo $active_creators; ?></p>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-sm font-medium text-gray-500">Bekleyen Başvurular</h3>
                <p class="text-2xl font-bold mt-2"><?php echo $pending_count; ?></p>
            </div>
        </div>

        <!-- Revenue Chart -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
            <h2 class="text-lg font-semibold mb-4">Gelir Grafiği</h2>
            <canvas id="revenueChart" height="100"></canvas>
        </div>

        <!-- Recent Applications -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-lg font-semibold mb-4">Son Başvurular</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                İsim
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Telefon
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Durum
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tarih
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($applications as $app): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php echo htmlspecialchars($app['full_name']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php echo htmlspecialchars($app['email']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php echo htmlspecialchars($app['phone']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        <?php echo $app['status'] === 'approved' ? 'bg-green-100 text-green-800' : 
                                            ($app['status'] === 'rejected' ? 'bg-red-100 text-red-800' : 
                                            'bg-yellow-100 text-yellow-800'); ?>">
                                        <?php echo ucfirst($app['status']); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo date('Y-m-d H:i', strtotime($app['created_at'])); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Revenue Chart
        const ctx = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_column($revenue_data, 'month')); ?>,
                datasets: [{
                    label: 'Aylık Gelir (₺)',
                    data: <?php echo json_encode(array_column($revenue_data, 'total_amount')); ?>,
                    borderColor: 'rgb(0, 0, 0)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₺' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
