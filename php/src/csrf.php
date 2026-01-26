<?php
/**
 * CSRF Protection Functions
 */

/**
 * Generate CSRF Token
 * 
 * @return string CSRF token (random string)
 */
function generateCSRFToken(): string {
    // Step 1: Check if session is already started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Step 2: Check if token already exists in session
    if (!isset($_SESSION['csrf_token'])) {
        // If not, generate a new one
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    
    // Step 3: Return the token
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF Token
 * 
 * @param string $token Token to verify
 * @return bool True if valid, false if invalid
 */
function verifyCSRFToken(string $token): bool {
    // Step 1: Check if session is already started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Step 2: Check if token exists in session
    if (!isset($_SESSION['csrf_token'])) {
        return false;
    }
    
    // Step 3: Compare the two tokens
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Generate CSRF hidden input field
 * 
 * @return string HTML code (hidden input)
 */
function csrfField(): string {
    $token = htmlspecialchars(generateCSRFToken(), ENT_QUOTES, 'UTF-8');
    return '<input type="hidden" name="csrf_token" value="' . $token . '">';
}