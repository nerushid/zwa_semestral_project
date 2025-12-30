<?php
declare(strict_types=1);

function print_inputs() {
    $currentPwdError = $_SESSION["changepwd_errors"]["current_password_error"] ?? '';
    $newPwdError = $_SESSION["changepwd_errors"]["new_password_error"] ?? '';
    $confirmPwdError = $_SESSION["changepwd_errors"]["new_password_confirm_error"] ?? '';
    
    $currentPwdClass = $currentPwdError ? ' error-input' : '';
    $newPwdClass = $newPwdError ? ' error-input' : '';
    $confirmPwdClass = $confirmPwdError ? ' error-input' : '';

    echo '<div class="form-group">
            <label for="current-password">Current Password</label>
            <input type="password" id="current-password" name="current_password" placeholder="Enter your current password" class="' . $currentPwdClass . '">
            <div class="error" id="current_password_error">' . ($currentPwdError ? '* ' . $currentPwdError : '') . '</div>
        </div>';

    echo '<div class="form-group">
            <label for="new-password">New Password</label>
            <input type="password" id="new-password" name="new_password" placeholder="Enter your new password" class="' . $newPwdClass . '">
            <div class="error" id="new_password_error">' . ($newPwdError ? '* ' . $newPwdError : '') . '</div>
        </div>';

    echo '<div class="form-group">
            <label for="confirm-password">Confirm New Password</label>
            <input type="password" id="confirm-password" name="new_password_confirm" placeholder="Confirm your new password" class="' . $confirmPwdClass . '">
            <div class="error" id="confirm_password_error">' . ($confirmPwdError ? '* ' . $confirmPwdError : '') . '</div>
        </div>';

     echo '<div class="error" id="csrf-error">' . htmlspecialchars($_SESSION["changepwd_errors"]["csrf_error"] ?? '') . '</div>';

    unset($_SESSION["changepwd_errors"]);
    unset($_SESSION["changepwd_data"]);
}