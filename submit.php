<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $guestName = htmlspecialchars($_POST['guestName']);
    $birthDate = htmlspecialchars($_POST['birthDate']);

    // Validasi format tanggal lahir (contoh: '2023-05-15')
    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $birthDate)) {
        echo "Invalid birth date format. Please use YYYY-MM-DD format.";
        exit;
    }

    // Ambil bulan dan hari dari tanggal lahir
    $birthdayParts = explode('-', $birthDate);
    $birthMonth = (int) $birthdayParts[1];
    $birthDay = (int) $birthdayParts[2];

    // Tentukan tanda bintang berdasarkan bulan dan hari
    $stars = [
        1 => ($birthDay <= 19) ? 'Capricorn' : 'Aquarius',
        2 => ($birthDay <= 18) ? 'Aquarius' : 'Pisces',
        3 => ($birthDay <= 20) ? 'Pisces' : 'Aries',
        4 => ($birthDay <= 19) ? 'Aries' : 'Taurus',
        5 => ($birthDay <= 20) ? 'Taurus' : 'Gemini',
        6 => ($birthDay <= 20) ? 'Gemini' : 'Cancer',
        7 => ($birthDay <= 22) ? 'Cancer' : 'Leo',
        8 => ($birthDay <= 22) ? 'Leo' : 'Virgo',
        9 => ($birthDay <= 22) ? 'Virgo' : 'Libra',
        10 => ($birthDay <= 22) ? 'Libra' : 'Scorpio',
        11 => ($birthDay <= 21) ? 'Scorpio' : 'Sagittarius',
        12 => ($birthDay <= 21) ? 'Sagittarius' : 'Capricorn'
    ];

    $starSign = $stars[$birthMonth];

    // Load star data from JSON file
    $data = file_get_contents('data/stars.json');
    $starsData = json_decode($data, true);

    // Cari data bintang berdasarkan tanda bintang
    $starData = [];
    foreach ($starsData as $star) {
        if (strcasecmp($star['nama'], $starSign) == 0) {
            $starData = $star;
            break;
        }
    }

    // Jika tidak ditemukan data tanda bintang, berikan pesan default
    if (empty($starData)) {
        $starData = [
            'nama' => $starSign,
            'sifat' => 'Informasi sifat tidak tersedia.',
            'jodoh' => 'Informasi jodoh tidak tersedia.',
            'khodam' => 'Informasi khodam tidak tersedia.'
        ];
    }

    // Preparing the message
    $message = "Nama: $guestName\nBintang: {$starData['nama']}\nSifat: {$starData['sifat']}\nJodoh: {$starData['jodoh']}\nKhodam: {$starData['khodam']}";

    // Sending the message to Telegram (replace with your actual implementation)
     $telegram_api_url = "https://api.telegram.org/bot7279726543:AAEGZsAyOEI2VkjU1xxJR0mxvHH9GaPrQDQ/sendMessage?chat_id=5953645511&text=" . urlencode($message);
    file_get_contents($telegram_api_url);

    // Menampilkan hasil
    include 'templates/header.php';
    echo '<div class="container">';
    echo '<h1>Hasil Tebak Bintang</h1>';
    echo '<div class="result-container">';
    echo '<div class="result">' . nl2br($message) . '</div>';
    echo '<button onclick="goBack()">Kembali ke Form</button>';
    echo '</div>';
    echo '</div>';
    include 'templates/footer.php';

} else {
    // Jika metode request bukan POST, redirect ke halaman utama
    header('Location: index.php');
}
?>

<!-- Script JavaScript untuk fungsi goBack() -->
<script>
function goBack() {
    window.location.href = 'index.php'; // Sesuaikan dengan nama file form Anda
}
</script>