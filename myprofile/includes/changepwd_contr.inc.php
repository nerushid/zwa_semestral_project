<?php
declare(strict_types=1);

function is_current_password_wrong(string $currentPwd, string $hashedPwd) {
    if (!password_verify($currentPwd, $hashedPwd)) {
        return true;
    } else {
        return false;
    }
}

function is_passwords_mismatch(string $newPwd, string $newPwdConfirm) {
    if ($newPwd === $newPwdConfirm) {
        return false;
    } else {
        return true;
    }
}