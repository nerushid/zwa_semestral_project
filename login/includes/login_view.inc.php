<?php
declare(strict_types=1);

function print_inputs() {
    // <label for="emailid">Email: <span class="required">*</span></label>
    // <input type="email" name="email" class="email" id="emailid" placeholder="Your email address">

    // <label for="passwordid">Password: <span class="required">*</span></label>
    // <input type="password" name="password" id="passwordid" placeholder="Password">

    // <div class="error" id="password-error"></div>

    echo '<label for="emailid">Email: <span class="required">*</span></label>';

    if (isset($_SESSION["login_data"]["email"])) {
        echo '<input type="text" name="email" class="email" id="emailid" placeholder="Your email address" 
        value="'.htmlspecialchars($_SESSION["login_data"]["email"]).'"
        class="error-input">';
    } else {
        echo '<input type="text" name="email" class="email" id="emailid" placeholder="Your email address">';
    }

    echo '<div class="error" id="email-error"></div>';

    echo '<label for="passwordid">Password: <span class="required">*</span></label>';

    if (isset($_SESSION['login_errors']['password_wrong']) || isset($_SESSION['login_errors']['user_wrong'])) {
        echo '<input type="password" name="password" id="passwordid" placeholder="Password"
        class="error-input">';
    } else {
        echo '<input type="password" name="password" id="passwordid" placeholder="Password">';
    }

    echo '<div class="error" id="password-error"></div>';

    if (isset($_SESSION['login_errors']['password_wrong']) || isset($_SESSION['login_errors']['user_wrong'])) {
        if (!empty($_SESSION['login_errors']['password_wrong'])) {
            echo '<div class="phperror">* '.htmlspecialchars($_SESSION['login_errors']['password_wrong']).'</div>';
        } elseif (!empty($_SESSION['login_errors']['user_wrong'])) {
            echo '<div class="phperror">* '.htmlspecialchars($_SESSION['login_errors']['user_wrong']).'</div>';
        }
    }
    unset($_SESSION['login_errors']);
    unset($_SESSION['login_data']);
}