<?php
declare(strict_types=1);

function is_current_password_wrong(string $currentPwd, string $hashedPwd): bool {
    return !password_verify($currentPwd, $hashedPwd);
}

function is_passwords_mismatch(string $newPwd, string $newPwdConfirm): bool {
    return $newPwd !== $newPwdConfirm;
}