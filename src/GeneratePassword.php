<?php

namespace Nnil\GeneratePassword;

class GeneratePassword{

    protected $password = [];
    // Define generator rules
    // ASCII 33 - 126 [echo chr(52)]
    // Add functionality to remove A-Z | a-z | 0-9 | <special characters>

    protected $password_strength = [
        1 => "low",
        2 => "medium",
        3 => "high"
    ];

    public static function random(int $password_length, string $strength = "high") : string
    {
     
        for ($i=0; $i < $password_length; $i++) { 
            # code...
            $password[$i] = chr(rand(33, 126));
        }

        return  implode('', $password);
        
    }

    // check the random password generated is accurate 

    public static function getPattern($password_length) {
        return '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^A-Za-z0-9]).{' . $password_length . ',}$/';
    }
}