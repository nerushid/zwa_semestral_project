<?php
declare(strict_types=1);

function print_csrf_error(): void {
    $error = $_SESSION['deletelisting_errors']['csrf_error'] ?? '';
    echo '<div class="error" id="csrf-error">' . ($error ? htmlspecialchars($error) : '') . '</div>';
    unset($_SESSION['deletelisting_errors']);
}
