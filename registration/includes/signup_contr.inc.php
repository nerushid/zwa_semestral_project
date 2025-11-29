<?php
declare(strict_types=1);

function is_inputs_empty(string $firstName, string $surname, string $email, string $pwd, string $pwd_confirm) {
    if (empty($firstName) || empty($surname) || empty($email) || empty($pwd) || empty($pwd_confirm)) {
        return true;
    } else {
        return false;
    }
}

function is_email_invalid(string $email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

function is_email_registred(object $pdo, string $email) {
    if (get_email($pdo, $email)) {
        return true;
    } else {
        return false;
    }
}

function is_passwords_mismatch(string $pwd, string $pwd_confirm) {
    if ($pwd === $pwd_confirm) {
        return false;
    } else {
        return true;
    }
}

function create_user (object $pdo, string $firstName, string $surname, string $email, string $pwd) {
    set_user($pdo, $firstName, $surname, $email, $pwd);
}