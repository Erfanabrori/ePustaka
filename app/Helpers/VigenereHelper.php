<?php

namespace App\Helpers;

class VigenereHelper
{
    // Kunci rahasia untuk enkripsi dan dekripsi
    private static $key = 'EPUSTAKA2026';

    // ENKRIPSI
    public static function encrypt($text)
    {
        $result = '';
        $key = self::$key;
        $keyLength = strlen($key);

        for ($i = 0; $i < strlen($text); $i++) {
            $plainChar = ord($text[$i]);
            $keyChar = ord($key[$i % $keyLength]);

            // Tambah nilai ASCII lalu mod 256
            $encrypted = ($plainChar + $keyChar) % 256;

            // Ubah ke karakter
            $result .= chr($encrypted);
        }csza

        // base64 agar aman disimpan di database
        return base64_encode($result);
    }

    // DEKRIPSI
    public static function decrypt($encryptedText)
    {
        $result = '';
        $key = self::$key;
        $keyLength = strlen($key);

        // Kembalikan hasil base64 menjadi karakter asli
        $encryptedText = base64_decode($encryptedText);

        for ($i = 0; $i < strlen($encryptedText); $i++) {
            $encryptedChar = ord($encryptedText[$i]);
            $keyChar = ord($key[$i % $keyLength]);

            // Kurangi nilai ASCII
            $decrypted = ($encryptedChar - $keyChar + 256) % 256;

            // Ubah kembali ke karakter asli
            $result .= chr($decrypted);
        }

        return $result;
    }
}
