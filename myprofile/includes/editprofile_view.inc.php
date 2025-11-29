<?php
declare(strict_types = 1);

function print_inputs() {
    /*
        <div class="form-group">
                <label for="firstname">First Name</label>
                <input type="text" id="firstname" name="firstname" placeholder="Enter your first name">
                <div class="error" id="firstname_error"></div>
            </div>

            <div class="form-group">
                <label for="surname">Surname</label>
                <input type="text" id="surname" name="surname" placeholder="Enter your surname">
                <div class="error" id="surname_error"></div>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="Enter your email">
                <div class="error" id="email_error"></div>
            </div>
    */

    if (isset($_SESSION["editprofile_data"]["firstname"]) && isset($_SESSION["editprofile_errors"]["firstname_error"])) {
        echo '<div class="form-group">
                <label for="firstname">First Name</label>
                <input type="text" id="firstname" name="firstname" placeholder="Enter your first name" 
                value="'.htmlspecialchars($_SESSION["editprofile_data"]["firstname"]).'"
                class="error-input">
                <div class="error" id="firstname_error">* '.$_SESSION["editprofile_errors"]["firstname_error"].'</div>
            </div>';
    } elseif (isset($_SESSION["editprofile_data"]["firstname"])) {
        echo '<div class="form-group">
                <label for="firstname">First Name</label>
                <input type="text" id="firstname" name="firstname" placeholder="Enter your first name" 
                value="'.htmlspecialchars($_SESSION["editprofile_data"]["firstname"]).'">
                <div class="error" id="firstname_error"></div>
            </div>';
    } else {
        echo '<div class="form-group">
                <label for="firstname">First Name</label>
                <input type="text" id="firstname" name="firstname" placeholder="Enter your first name" 
                value="'.htmlspecialchars($_SESSION["user_firstname"]).'">
                <div class="error" id="firstname_error"></div>
            </div>';
    }

    if (isset($_SESSION["editprofile_data"]["surname"]) && isset($_SESSION["editprofile_errors"]["surname_error"])) {
        echo '<div class="form-group">
                <label for="surname">Surname</label>
                <input type="text" id="surname" name="surname" placeholder="Enter your surname" 
                value="'.htmlspecialchars($_SESSION["editprofile_data"]["surname"]).'"
                class="error-input">
                <div class="error" id="surname_error">* '.$_SESSION["editprofile_errors"]["surname_error"].'</div>
            </div>';
    } elseif (isset($_SESSION["editprofile_data"]["surname"])) {
        echo '<div class="form-group">
                <label for="surname">Surname</label>
                <input type="text" id="surname" name="surname" placeholder="Enter your surname" 
                value="'.htmlspecialchars($_SESSION["editprofile_data"]["surname"]).'">
                <div class="error" id="surname_error"></div>
            </div>';
    } else {
        echo '<div class="form-group">
                <label for="surname">Surname</label>
                <input type="text" id="surname" name="surname" placeholder="Enter your surname" 
                value="'.htmlspecialchars($_SESSION["user_surname"]).'">
                <div class="error" id="surname_error"></div>
            </div>';
    }

    if (isset($_SESSION["editprofile_data"]["email"]) && isset($_SESSION["editprofile_errors"]["email_error"])) {
        echo '<div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="Enter your email" 
                value="'.htmlspecialchars($_SESSION["editprofile_data"]["email"]).'"
                class="error-input">
                <div class="error" id="email_error">* '.$_SESSION["editprofile_errors"]["email_error"].'</div>
            </div>';
    } elseif (isset($_SESSION["editprofile_data"]["email"])) {
        echo '<div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="Enter your email" 
                value="'.htmlspecialchars($_SESSION["editprofile_data"]["email"]).'">
                <div class="error" id="email_error"></div>
            </div>';
    } else {
        echo '<div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="Enter your email" 
                value="'.htmlspecialchars($_SESSION["user_email"]).'">
                <div class="error" id="email_error"></div>
            </div>';
    }
    unset($_SESSION["editprofile_errors"]);
    unset($_SESSION["editprofile_data"]);
}