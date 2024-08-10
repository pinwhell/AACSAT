<?php
use AACS\AuthTokenRSA;

include_once (__DIR__.'/../vendor/autoload.php');
include_once (__DIR__.'/AuthTokenRSATest.php');

echo AuthTokenRSA::Create(AuthTokenRSATest::$testPrivKey, 1, 'fooorg');