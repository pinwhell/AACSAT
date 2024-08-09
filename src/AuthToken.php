<?php

namespace AACS;

use AACS\Crypto\ISigner;
use AACS\Crypto\IVerifier;

class AuthToken
{
    public static function Create(ISigner $signer, $userId, $orgId, $expDays = 30) : string
    {
        $dateTimeUtc = new \DateTime('now', new \DateTimeZone('UTC'));
        $expirationTimeUtc = (new \DateTime('now', new \DateTimeZone('UTC')))
            ->add(new \DateInterval('P' . $expDays . 'D'));

        $tokenRaw = array(
            'u' => $userId,
            'o' => $orgId,
            'c' => $dateTimeUtc->getTimestamp(),
            'e' => $expirationTimeUtc->getTimestamp(),
        );

        $tokenRaw['s'] = $signer->Sign(KVCanonicalMerger::Merge($tokenRaw, array('u', 'o', 'c', 'e')));

        return json_encode($tokenRaw);
    }

    public static function Verify(IVerifier $verifier, $token) : bool
    {
        $tokenRaw = json_decode($token, true);
        return $verifier->Verify(KVCanonicalMerger::Merge($tokenRaw, array('u', 'o', 'c', 'e')), $tokenRaw['s']);
    }
}