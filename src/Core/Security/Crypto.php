<?php

namespace App\Core\Security;

class Crypto
{
    const ENCRYPTION_SQL = '%ENCRYPTION_SQL%';
    const CIPHERING = "AES-128-ECB";

    public function encryptData(string $text)
    {
        return openssl_encrypt($text, self::CIPHERING, self::ENCRYPTION_SQL, 0);
    }

    public function decryptData(string $text)
    {
        return openssl_decrypt($text, self::CIPHERING, self::ENCRYPTION_SQL, 0);
    }
}
