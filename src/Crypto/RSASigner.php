<?php

namespace AACS\Crypto;

class RSASigner implements ISigner
{
    public function __construct($privateKeyFilePathOrContent)
    {
        $privKeyFileContent = file_exists($privateKeyFilePathOrContent) ? file_get_contents($privateKeyFilePathOrContent) : $privateKeyFilePathOrContent;
        $this->key = openssl_pkey_get_private($privKeyFileContent);
    }

    public function Sign($data = '')
    {
        $signature = '';
        openssl_sign($data, $signature, $this->key, OPENSSL_ALGO_SHA256);
        return bin2hex($signature);
    }

    public $key;
}