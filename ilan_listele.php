<?php
include 'auth.php';
include 'db.php';
include 'log_fonksiyonu.php';

// Oturum başlat
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Rol kontrolü
checkRole(['admin', 'editor']);

// Hata ayıklama modunu aktif et
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İlan Listele</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-10">
        <h2 class="text-2xl font-bold mb-4">Eklenen İlanlar</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <?php
            $sql = "SELECT * FROM properties";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='bg-white p-4 rounded-lg shadow-md'>";
                    if (!empty($row['image_path'])) {
                        echo "<img src='" . $row['image_path'] . "' class='w-full h-48 object-cover rounded-md' alt='İlan Resmi'>";
                    }
                    echo "<div class='p-4'>";
                    echo "<h5 class='text-lg font-semibold'>" . htmlspecialchars($row['title']) . "</h5>";
                    echo "<p class='text-gray-700'>" . htmlspecialchars($row['description']) . "</p>";
                    echo "<p class='text-gray-700'><strong>Fiyat:</strong> " . htmlspecialchars($row['price']) . " TL</p>";
                    echo "<p class='text-gray-700'><strong>Alan:</strong> " . htmlspecialchars($row['area']) . " m²</p>";
                    if ($row['type'] == 'konut') {
                        echo "<p class='text-gray-700'><strong>Oda Sayısı:</strong> " . htmlspecialchars($row['rooms']) . "</p>";
                        echo "<p class='text-gray-700'><strong>Kat Sayısı:</strong> " . htmlspecialchars($row['floors']) . "</p>";
                        echo "<p class='text-gray-700'><strong>Bina Yaşı:</strong> " . htmlspecialchars($row['building_age']) . "</p>";
                    } elseif ($row['type'] == 'arsa') {
                        echo "<p class='text-gray-700'><strong>İmar Durumu:</strong> " . htmlspecialchars($row['zoning_status']) . "</p>";
                        echo "<p class='text-gray-700'><strong>Arsa Tipi:</strong> " . htmlspecialchars($row['land_type']) . "</p>";
                    }
                    echo "<p class='text-gray-700'><strong>Adres:</strong> " . htmlspecialchars($row['address']) . ", " . htmlspecialchars($row['district']) . ", " . htmlspecialchars($row['city']) . "</p>";
                    echo "<a href='ilan_detay.php?id=" . $row['id'] . "' class='btn btn-primary mt-2'>Detayları Gör</a>";
                    echo "<a href='ilan_sil.php?id=" . $row['id'] . "' class='btn btn-danger mt-2'>Sil</a>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>Henüz eklenen ilan bulunmamaktadır.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>