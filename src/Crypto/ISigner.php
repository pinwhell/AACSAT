<?php
    
namespace AACS\Crypto;

interface ISigner {
    public function Sign($data = '');
}

