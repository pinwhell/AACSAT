<?php

namespace AACS;

use AACS\Crypto\RSASigner;
use AACS\Crypto\RSAVerifier;

class AuthTokenRSA
{
    public static function Create($rsaPrivKeyPath, $userId, $orgId, $expDays = 30) : string
    {
        $signer = new RSASigner($rsaPrivKeyPath);
        return AuthToken::Create($signer, $userId, $orgId, $expDays);
    }

    public static function Verify($rsaPubKeyPath, $token) : bool
    {
        $verifier = new RSAVerifier($rsaPubKeyPath);
        return AuthToken::Verify($verifier, $token);
    }
}