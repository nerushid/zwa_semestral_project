<?php
declare(strict_types = 1);

function is_email_registered(object $pdo, string $email) {
    if (get_email($pdo, $email)) {
        return true;
    } else {
        return false;
    }
}

// If name are have only letters and spaces
function is_name_invalid(string $firstname) {
    if (!preg_match("/^[\p{L}\s'-]+$/u", $firstname)) {
        return true;
    }
    return false;
}

// If surname are have only letters and spaces
function is_surname_invalid(string $surname) {
    if (!preg_match("/^[\p{L}\s'-]+$/u", $surname)) {
        return true;
    }
    return false;
}



