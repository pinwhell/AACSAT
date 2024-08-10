<?php

use PHPUnit\Framework\TestCase;
use AACS\AuthTokenRSA;

class AuthTokenRSATest extends TestCase 
{
    public static string $testPrivKey = <<<EOD
-----BEGIN PRIVATE KEY-----
MIIEvwIBADANBgkqhkiG9w0BAQEFAASCBKkwggSlAgEAAoIBAQC73YDkX9frG/Kd
iCKUL7vm2VkwzNmcePtFRv9uFnooCGT+HrGM6MLVOc9FXsCcR/Y4shSzLs8fWJux
lRiyYeQdnuCfS76rNCK/Cm0mnggnT4DQyiZsBCHLZ8n4TMb9V7bIHUAbWmoP5UvR
VO3E4qhYfJIMHTKlld2DjLY8U1rsTwpF09eVDoGGOR4lxyvd/7Pl8+5cecGNr15e
GZ+ZuJiy04xoiqh7bqv0Cm8rDt9h3X2mCI8+n1bTcirwZ3c7hILD9zc+uwngwREA
G4aWy2V/EDQmv/cfRL3DhZTkuJof7ScHz8Ao2x3NWahRWT14APkPYWgJsgOVaRLp
3IfRJa05AgMBAAECggEBAKgGnVmlP4FRJdYwBH11lCINE/DJx3hj3JlBvwO/ptJX
b7y5xyO4q0n6wp/Q94TP+DENVeZNX4MxxU83gzdIxraXe1/+ZzLJFqq3sJhxj+lY
+mXD6EmECJXc5o/mW7QL17d0MfpFC8fb1cwMof0OnHNIN3gORVZEjDM0j2m1RAVF
wdpvCcb63wWSp3716d60MI0U+SZTghKAGAICuzPyJ7PsvtdCdS2WWt+szYb6M8yv
jJdZUs6zymfO084aiutGaMs4vgM3ZytDQurDL7JIrUo3vfkad2POJf6RmPZehRAs
T/PvbgWglCImtTyhrGW8l7vAg3tPRT6wuz/+XbWClGECgYEA9GEYmBgC4hxKNcB8
iZEjNGvwL96vp1ZqEpgQ8oHQPokWcpWa/HlfqvEER2fXeNgkLVk5upDXGKBegNF7
jKaeQz4kNKoS1PcGcGANHwoHBVGnLE9BGvupRk7bwqbzXPHJlJnu5UK0uviZJr3E
MyhbtWxelCKhApqAYkgLlz/9LRcCgYEAxMxx225ZwXFVQfkPnjEyqVQL5Iab11Df
KFYBs1F/w1avox4noA8BcgyHaGsrrwq0fIm3V5idePOfKUc2t4KM7PRCtJ0omRtv
3YhyE1KFjod2M6/WamJnZjXGQ4yqZADi9/8foeQYOlwGP2MOai/hpnp6/LrbMedr
8sTaaxUEii8CgYBXy95jHhVDGLjMkOftIHiOZ8z11cIzk0cugPVtupePL/8hkYAJ
/q0RI9/Oq47s+nIc3LZxwYGVdmAdVaVWhbHMJLIrPYLgghMNImT0ZszY61ntAFg6
knlhKgmn6AT8ul0ahycdtJZrqc6T7Y9kdbZk+pcMD1jbL5i6Nnn7j+CsZwKBgQDD
OmXA3ynfQwTnG6KotfmiDSR3Iio7YZjftOKe9zydlcNLOEDrAbfXYiJ6Lcb6MM53
tU7ScS3WrSe5lVHsnnAbKP17m2SI7rT8ub0g+f5QNIXIJKm6g8A7nyD+Je9qoY6H
ounIejSmwF/aRfQo1zMtKdgUG3ITgZaPEUX0cLc+NQKBgQDYMd6UQIYUnCMcNzmP
XvRVnBtiqQcRkcBDQB7PKvPeU6UeHHeOrI8sU5n/LlHQhzYSujJt3BC/n3CId3Vr
aLiibPQoWWtHhf0ezeX2Z76L3JvPecpkSYkrzpFYG4qyVmvxoesVZ5yrI0ef40Ic
JH9KvxQkWl8qQiL7Fs/GvHbO0A==
-----END PRIVATE KEY-----
EOD;

    public static string $testpubKey = <<<EOD
-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAu92A5F/X6xvynYgilC+7
5tlZMMzZnHj7RUb/bhZ6KAhk/h6xjOjC1TnPRV7AnEf2OLIUsy7PH1ibsZUYsmHk
HZ7gn0u+qzQivwptJp4IJ0+A0MombAQhy2fJ+EzG/Ve2yB1AG1pqD+VL0VTtxOKo
WHySDB0ypZXdg4y2PFNa7E8KRdPXlQ6BhjkeJccr3f+z5fPuXHnBja9eXhmfmbiY
stOMaIqoe26r9ApvKw7fYd19pgiPPp9W03Iq8Gd3O4SCw/c3PrsJ4MERABuGlstl
fxA0Jr/3H0S9w4WU5LiaH+0nB8/AKNsdzVmoUVk9eAD5D2FoCbIDlWkS6dyH0SWt
OQIDAQAB
-----END PUBLIC KEY-----
EOD;

    public function testTokenCreationAndVerification()
    {
        // Create token
        $token = AuthTokenRSA::Create(self::$testPrivKey, 1, 'FooOrg');

        // Assert token is a non-empty string
        $this->assertIsString($token);
        $this->assertNotEmpty($token);

        // Verify the token
        $this->assertTrue(AuthTokenRSA::Verify(self::$testpubKey, $token));

        // Tamper with the token
        $decodedToken = json_decode(base64_decode($token), true);
        $decodedToken['o'] .= '=)';
        $tamperedToken = base64_encode(json_encode($decodedToken));

        // Assert that the tampered token is not valid
        $this->assertFalse(AuthTokenRSA::Verify(self::$testpubKey, $tamperedToken));
    }
}