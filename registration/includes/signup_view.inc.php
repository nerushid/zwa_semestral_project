<?php
declare(strict_types=1);

function signup_inputs() {
    // <div id="name-username">
    //     <div>
    //         <label for="nameid">First name: <span class="required">*</span></label>
    //         <input type="text" name="name" class="first-name" id="nameid" placeholder="First name">
    //         <div class="error" id="first-name-error"></div>
    //     </div>
    //     <div>
    //         <label for="surnameid">Surname: <span class="required">*</span></label>
    //         <input type="text" name="surname" class="surname" id="surnameid" placeholder="Surname">
    //         <div class="error" id="surname-error"></div>
    //     </div>
    // </div>

    // <label for="emailid">Email: <span class="required">*</span></label>
    // <input type="text" name="email" class="email" id="emailid" placeholder="Your email">
    // <div class="error" id="email-error"></div>
    
    echo '<div id="name-username">
        <div>';
        if (isset($_SESSION["signup_data"]["firstName"])) {
            echo '<label for="nameid">First name: <span class="required">*</span></label>
            <input type="text" name="name" class="first-name" id="nameid" placeholder="First name" 
            value="'.htmlspecialchars($_SESSION["signup_data"]["firstName"]).'">
            <div class="error" id="first-name-error"></div>';
        } else {
            echo '<label for="nameid">First name: <span class="required">*</span></label>
            <input type="text" name="name" class="first-name" id="nameid" placeholder="First name">
            <div class="error" id="first-name-error"></div>';
        }
    echo '</div>
        <div>';
        if (isset($_SESSION["signup_data"]["surname"])) {
            echo '<label for="surnameid">Surname: <span class="required">*</span></label>
            <input type="text" name="surname" class="surname" id="surnameid" placeholder="Surname" 
            value="'.htmlspecialchars($_SESSION["signup_data"]["surname"]).'">
            <div class="error" id="surname-error"></div>';
        } else {
            echo '<label for="surnameid">Surname: <span class="required">*</span></label>
            <input type="text" name="surname" class="surname" id="surnameid" placeholder="Surname">
            <div class="error" id="surname-error"></div>';
        }
    echo '</div>
        </div>';

    if (isset($_SESSION["signup_data"]["email"]) && isset($_SESSION["signup_errors"]["email_registred"])) {
        echo '<label for="emailid">Email: <span class="required">*</span></label>
        <input type="text" name="email" class="email" id="emailid" placeholder="Your email" 
        value="'.htmlspecialchars($_SESSION["signup_data"]["email"]).'">
        <div class="error" id="email-error">* '.$_SESSION["signup_errors"]["email_registred"].'</div>';
    } elseif (isset($_SESSION["signup_data"]["email"])) {
        echo '<label for="emailid">Email: <span class="required">*</span></label>
        <input type="text" name="email" class="email" id="emailid" placeholder="Your email" 
        value="'.htmlspecialchars($_SESSION["signup_data"]["email"]).'">
        <div class="error" id="email-error"></div>';
    } else {
        echo '<label for="emailid">Email: <span class="required">*</span></label>
        <input type="text" name="email" class="email" id="emailid" placeholder="Your email">
        <div class="error" id="email-error"></div>';
    }
}

function password_input() {
    // <input type="password" name="password-confirm" id="password-confirmid" placeholder="Confirm password">
    // <div class="error" id="password-confirm-error"></div>

    if (isset($_SESSION["signup_errors"]['password_mismatch'])) {
        echo '<input type="password" name="password-confirm" id="password-confirmid" placeholder="Confirm password">
            <div class="error" id="password-confirm-error">* '.$_SESSION["signup_errors"]['password_mismatch'].'</div>';
    } else {
        echo '<input type="password" name="password-confirm" id="password-confirmid" placeholder="Confirm password">
            <div class="error" id="password-confirm-error"></div>';
    }
}
