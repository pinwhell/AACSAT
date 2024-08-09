<?php

namespace AACS\Crypto;

interface IVerifier {
    public function Verify($data, $signature);
}