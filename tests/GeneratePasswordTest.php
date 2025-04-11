<?php

use Nnil\GeneratePassword\GeneratePassword;
use PHPUnit\Framework\TestCase;

class GeneratePasswordTest extends TestCase
{

    public function testRandomPassword() {
        $random_password = GeneratePassword::random(12);
        $pattern = GeneratePassword::getPattern(12);
        echo $random_password;
        $this->assertTrue(preg_match($pattern, $random_password) === 1);
    }
}