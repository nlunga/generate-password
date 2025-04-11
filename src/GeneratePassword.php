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

        // Step 1: Ensure minimum character types
        $uppercase = chr(rand(65, 90)); // A-Z
        $lowercase = chr(rand(97, 122)); // a-z
        $digit = chr(rand(48, 57)); // 0-9
        $special = chr(rand(33, 47)); // Special chars like ! " # $ % & ' ( ) * + , - . /

        // Step 2: Prepare password array with guaranteed characters
        $password = [$uppercase, $lowercase, $digit, $special];
        
        // Step 3: Fill the rest of the password with random characters
        for ($i = 4; $i < $password_length; $i++) { 
            $password[] = chr(rand(33, 126)); // Random visible ASCII chars
        }

        // Step 4: Shuffle to randomize positions
        shuffle($password);

        // Step 5: Return the final password
        return implode('', $password);
        
    }

    // check the random password generated is accurate 

    public static function getPattern($password_length) {
        return '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^A-Za-z0-9]).{' . $password_length . ',}$/';
    }
}