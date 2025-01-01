<?php

function getWhatsappSentFilePath()
{
    return storage_path('app/whatsapp_sent.json'); // Lokasi file JSON
}

function getWhatsappSentData()
{
    $filePath = getWhatsappSentFilePath();

    // Jika file tidak ada, buat file kosong
    if (!file_exists($filePath)) {
        file_put_contents($filePath, json_encode([]));
    }

    // Baca dan decode data dari file JSON
    return json_decode(file_get_contents($filePath), true);
}

function saveWhatsappSentData(array $data)
{
    $filePath = getWhatsappSentFilePath();

    // Simpan data ke file JSON
    file_put_contents($filePath, json_encode($data));
}
