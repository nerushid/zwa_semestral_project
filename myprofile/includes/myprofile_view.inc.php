<?php
/**
 * My Profile View Helper
 * 
 * Contains functions for rendering user profile information.
 * 
 * @package NestlyHomes\Views
 */

declare(strict_types=1);

/**
 * Prints user profile information
 * 
 * Displays user's first name, surname, and email
 * from session data. Values are escaped for XSS prevention
 * when stored in session.
 * 
 * @return void
 */
function print_user(): void {
    echo '<p>First Name: ' . $_SESSION["user_firstname"] . '</p>
          <p>Surname: ' . $_SESSION["user_surname"] . '</p>
          <p>Email: ' . $_SESSION["user_email"] . '</p>';
}