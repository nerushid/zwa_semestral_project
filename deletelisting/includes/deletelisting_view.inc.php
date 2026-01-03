<?php
/**
 * Delete Listing View Helper
 * 
 * Contains functions for rendering delete confirmation dialog elements.
 * 
 * @package NestlyHomes\Views
 */

declare(strict_types=1);

/**
 * Prints CSRF error message
 * 
 * Displays CSRF validation error if present and clears it from session.
 * 
 * @return void
 */
function print_csrf_error(): void {
    $error = $_SESSION['deletelisting_errors']['csrf_error'] ?? '';
    echo '<div class="error" id="csrf-error">' . ($error ? htmlspecialchars($error) : '') . '</div>';
    unset($_SESSION['deletelisting_errors']);
}
