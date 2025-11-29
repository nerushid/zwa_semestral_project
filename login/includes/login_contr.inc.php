<?php
declare(strict_types=1);

function is_inputs_empty(string $email, string $pwd) {
    if (empty($email) || empty($pwd)) {
        return true;
    } else {
        return false;
    }
}

function is_user_wrong(array|bool $result) {
    if (!$result) {
        return true;
    } else {
        return false;
    }
}

function is_password_wrong(string $pwd, string $hashedPwd) {
    if (!password_verify($pwd, $hashedPwd)) {
        return true;
    } else {
        return false;
    }
}