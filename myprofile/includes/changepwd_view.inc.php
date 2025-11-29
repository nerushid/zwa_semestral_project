<?php
declare(strict_types=1);

function print_inputs() {
    // Current Password
    if (isset($_SESSION["changepwd_data"]["current_password"]) && isset($_SESSION["changepwd_errors"]["current_password_error"])) {
        echo '<div class="form-group">
                <label for="current-password">Current Password</label>
                <input type="password" id="current-password" name="current_password" placeholder="Enter your current password" 
                value="'.htmlspecialchars($_SESSION["changepwd_data"]["current_password"]).'"
                class="error-input">
                <div class="error" id="current_password_error">* '.$_SESSION["changepwd_errors"]["current_password_error"].'</div>
            </div>';
    } elseif (isset($_SESSION["changepwd_data"]["current_password"])) {
        echo '<div class="form-group">
                <label for="current-password">Current Password</label>
                <input type="password" id="current-password" name="current_password" placeholder="Enter your current password" 
                value="'.htmlspecialchars($_SESSION["changepwd_data"]["current_password"]).'">
                <div class="error" id="current_password_error"></div>
            </div>';
    } else {
        echo '<div class="form-group">
                <label for="current-password">Current Password</label>
                <input type="password" id="current-password" name="current_password" placeholder="Enter your current password">
                <div class="error" id="current_password_error"></div>
            </div>';
    }

    // New Password
    if (isset($_SESSION["changepwd_data"]["new_password"]) && isset($_SESSION["changepwd_errors"]["new_password_error"])) {
        echo '<div class="form-group">
                <label for="new-password">New Password</label>
                <input type="password" id="new-password" name="new_password" placeholder="Enter your new password" 
                value="'.htmlspecialchars($_SESSION["changepwd_data"]["new_password"]).'"
                class="error-input">
                <div class="error" id="new_password_error">* '.$_SESSION["changepwd_errors"]["new_password_error"].'</div>
            </div>';
    } elseif (isset($_SESSION["changepwd_data"]["new_password"])) {
        echo '<div class="form-group">
                <label for="new-password">New Password</label>
                <input type="password" id="new-password" name="new_password" placeholder="Enter your new password" 
                value="'.htmlspecialchars($_SESSION["changepwd_data"]["new_password"]).'">
                <div class="error" id="new_password_error"></div>
            </div>';
    } else {
        echo '<div class="form-group">
                <label for="new-password">New Password</label>
                <input type="password" id="new-password" name="new_password" placeholder="Enter your new password">
                <div class="error" id="new_password_error"></div>
            </div>';
    }

    // Confirm New Password
    if (isset($_SESSION["changepwd_data"]["new_password_confirm"]) && isset($_SESSION["changepwd_errors"]["new_password_confirm_error"])) {
        echo '<div class="form-group">
                <label for="confirm-password">Confirm New Password</label>
                <input type="password" id="confirm-password" name="new_password_confirm" placeholder="Confirm your new password" 
                value="'.htmlspecialchars($_SESSION["changepwd_data"]["new_password_confirm"]).'"
                class="error-input">
                <div class="error" id="confirm_password_error">* '.$_SESSION["changepwd_errors"]["new_password_confirm_error"].'</div>
            </div>';
    } elseif (isset($_SESSION["changepwd_data"]["new_password_confirm"])) {
        echo '<div class="form-group">
                <label for="confirm-password">Confirm New Password</label>
                <input type="password" id="confirm-password" name="new_password_confirm" placeholder="Confirm your new password" 
                value="'.htmlspecialchars($_SESSION["changepwd_data"]["new_password_confirm"]).'">
                <div class="error" id="confirm_password_error"></div>
            </div>';
    } else {
        echo '<div class="form-group">
                <label for="confirm-password">Confirm New Password</label>
                <input type="password" id="confirm-password" name="new_password_confirm" placeholder="Confirm your new password">
                <div class="error" id="confirm_password_error"></div>
            </div>';
    }

    unset($_SESSION["changepwd_errors"]);
    unset($_SESSION["changepwd_data"]);
}