<?php
/**
 * CSRF Protection Module
 * 
 * Provides functions for generating, printing, verifying, and regenerating
 * CSRF (Cross-Site Request Forgery) tokens. Uses cryptographically secure
 * random bytes for token generation.
 * 
 * @package NestlyHomes\Security
 */

declare(strict_types=1);

/**
 * Generates a CSRF token
 * 
 * Creates a new CSRF token if one doesn't exist in the session.
 * Returns the existing token if already generated.
 * 
 * @return string The CSRF token (64 character hexadecimal string)
 */
function generate_csrf_token(): string {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Prints a hidden CSRF token input field
 * 
 * Outputs an HTML hidden input element containing the CSRF token.
 * The token value is properly escaped to prevent XSS attacks.
 * 
 * @return void
 */
function print_csrf_input(): void {
    $token = generate_csrf_token();
    echo '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
}

/**
 * Verifies a submitted CSRF token
 * 
 * Compares the submitted token against the session token using
 * timing-safe comparison to prevent timing attacks.
 * 
 * @param string $token The token submitted with the form
 * @return bool True if token is valid, false otherwise
 */
function verify_csrf_token(string $token): bool {
    if (!isset($_SESSION['csrf_token'])) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Regenerates the CSRF token
 * 
 * Creates a new CSRF token, replacing the existing one.
 * Should be called after successful authentication or sensitive operations.
 * 
 * @return void
 */
function regenerate_csrf_token(): void {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
