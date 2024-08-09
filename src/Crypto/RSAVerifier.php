<?php

namespace AACS\Crypto;

use AACS\Crypto\IVerifier;

class RSAVerifier implements IVerifier
{
    public function __construct($rsaPubKeyPathOrContent)
    {
        
        $rsaPubKeyFileContent = file_exists($rsaPubKeyPathOrContent) ? file_get_contents($rsaPubKeyPathOrContent) : $rsaPubKeyPathOrContent;
        $this->rsaKeyInst = openssl_pkey_get_public($rsaPubKeyFileContent);
    }

    public function Verify($data, $signature)
    {
        if(is_string($signature))
            $signature = hex2bin($signature);

        return openssl_verify($data, $signature, $this->rsaKeyInst, OPENSSL_ALGO_SHA256);
    }

    private $rsaKeyInst;
}