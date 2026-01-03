<?php
/**
 * Change Password Controller
 * 
 * Contains validation functions for password change operations.
 * 
 * @package NestlyHomes
 * @subpackage Controllers
 */

declare(strict_types=1);

/**
 * Verifies current password is correct
 * 
 * @param string $currentPwd Submitted current password
 * @param string $hashedPwd Stored password hash
 * @return bool True if password is wrong, false if correct
 */
function is_current_password_wrong(string $currentPwd, string $hashedPwd): bool {
    return !password_verify($currentPwd, $hashedPwd);
}

/**
 * Checks if passwords match
 * 
 * @param string $newPwd New password
 * @param string $newPwdConfirm Confirmation password
 * @return bool True if passwords don't match, false if they match
 */
function is_passwords_mismatch(string $newPwd, string $newPwdConfirm): bool {
    return $newPwd !== $newPwdConfirm;
}