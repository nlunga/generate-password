<?php

class GeneratePasswordOptimized {
    // Character pools
    private const CHARS_UPPER = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    private const CHARS_LOWER = 'abcdefghijklmnopqrstuvwxyz';
    private const CHARS_DIGITS = '0123456789';
    private const CHARS_SPECIAL = '!@#$%^&*()-_=+[]{}|;:,.<>?/';
    
    // Password strength configurations
    private const STRENGTH_CONFIG = [
        'low' => ['upper' => false, 'lower' => true, 'digits' => true, 'special' => false],
        'medium' => ['upper' => true, 'lower' => true, 'digits' => true, 'special' => false],
        'high' => ['upper' => true, 'lower' => true, 'digits' => true, 'special' => true]
    ];
    
    /**
     * Generate a random password based on specified length and strength
     *
     * @param int $password_length The desired password length (minimum 4 for high strength)
     * @param string $strength Password strength: 'low', 'medium', or 'high'
     * @return string The generated password
     * @throws InvalidArgumentException If parameters are invalid
     */
    public static function random(int $password_length, string $strength = 'high'): string
    {
        // Validate inputs
        $strength = strtolower($strength);
        if (!isset(self::STRENGTH_CONFIG[$strength])) {
            throw new InvalidArgumentException("Invalid strength. Use 'low', 'medium', or 'high'");
        }
        
        $config = self::STRENGTH_CONFIG[$strength];
        $required_chars_count = array_sum($config);
        
        if ($password_length < $required_chars_count) {
            throw new InvalidArgumentException("Password length must be at least $required_chars_count for '$strength' strength");
        }
        
        // Build character pool based on strength
        $all_chars = '';
        $required_chars = [];
        
        if ($config['upper']) {
            $all_chars .= self::CHARS_UPPER;
            $required_chars[] = self::CHARS_UPPER[random_int(0, strlen(self::CHARS_UPPER) - 1)];
        }
        
        if ($config['lower']) {
            $all_chars .= self::CHARS_LOWER;
            $required_chars[] = self::CHARS_LOWER[random_int(0, strlen(self::CHARS_LOWER) - 1)];
        }
        
        if ($config['digits']) {
            $all_chars .= self::CHARS_DIGITS;
            $required_chars[] = self::CHARS_DIGITS[random_int(0, strlen(self::CHARS_DIGITS) - 1)];
        }
        
        if ($config['special']) {
            $all_chars .= self::CHARS_SPECIAL;
            $required_chars[] = self::CHARS_SPECIAL[random_int(0, strlen(self::CHARS_SPECIAL) - 1)];
        }
        
        // Generate remaining characters
        $remaining_length = $password_length - count($required_chars);
        $password = $required_chars;
        
        for ($i = 0; $i < $remaining_length; $i++) {
            $password[] = $all_chars[random_int(0, strlen($all_chars) - 1)];
        }
        
        // Shuffle to randomize positions
        shuffle($password);
        
        return implode('', $password);
    }
    
    /**
     * Verify if a password meets the strength requirements
     *
     * @param string $password The password to check
     * @param string $strength The strength to check against
     * @return bool True if password meets requirements
     */
    public static function verify(string $password, string $strength = 'high'): bool
    {
        $strength = strtolower($strength);
        if (!isset(self::STRENGTH_CONFIG[$strength])) {
            return false;
        }
        
        $config = self::STRENGTH_CONFIG[$strength];
        
        if ($config['upper'] && !preg_match('/[A-Z]/', $password)) {
            return false;
        }
        
        if ($config['lower'] && !preg_match('/[a-z]/', $password)) {
            return false;
        }
        
        if ($config['digits'] && !preg_match('/[0-9]/', $password)) {
            return false;
        }
        
        if ($config['special'] && !preg_match('/[^A-Za-z0-9]/', $password)) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Generate a regex pattern for password validation
     *
     * @param int $password_length The minimum password length
     * @param string $strength The password strength to validate
     * @return string Regex pattern
     */
    public static function getPattern(int $password_length, string $strength = 'high'): string
    {
        $strength = strtolower($strength);
        $config = self::STRENGTH_CONFIG[$strength] ?? self::STRENGTH_CONFIG['high'];
        
        $pattern = '/^';
        
        if ($config['upper']) {
            $pattern .= '(?=.*[A-Z])';
        }
        
        if ($config['lower']) {
            $pattern .= '(?=.*[a-z])';
        }
        
        if ($config['digits']) {
            $pattern .= '(?=.*\d)';
        }
        
        if ($config['special']) {
            $pattern .= '(?=.*[^A-Za-z0-9])';
        }
        
        $pattern .= '.{' . $password_length . ',}$/';
        
        return $pattern;
    }
}