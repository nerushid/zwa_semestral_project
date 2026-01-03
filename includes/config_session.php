<?php
/**
 * Session Configuration File
 * 
 * Configures PHP session settings for security and handles session ID regeneration
 * to prevent session fixation attacks. Sets secure cookie parameters and manages
 * automatic session regeneration for both logged-in and anonymous users.
 * 
 * @package NestlyHomes
 * @subpackage Session
 */

ini_set("session.use_only_cookies", 1);
ini_set("session.use_strict_mode", 1);

session_set_cookie_params([
    'lifetime' => 1800,
    'path' => '/',
    'secure' => true,
    'httponly' => true
]);

session_start();

if (isset($_SESSION["user_id"])) {
    if (!isset($_SESSION["last_regeneration"])) {
        regenerate_session_id_loggedin();
    } else {
        $interval = 60 * 30;
        if (time() - $_SESSION["last_regeneration"] >= $interval) {
            regenerate_session_id_loggedin();
        }
    } 
} else {
    if (!isset($_SESSION["last_regeneration"])) {
        regenerate_session_id();
    } else {
        $interval = 60 * 30;
        if (time() - $_SESSION["last_regeneration"] >= $interval) {
            regenerate_session_id();
        }
    } 
}

/**
 * Regenerates session ID for logged-in users
 * 
 * Creates a new session ID incorporating the user ID for additional security.
 * Updates the last regeneration timestamp to track session age.
 * 
 * @return void
 */
function regenerate_session_id_loggedin(): void {
    session_regenerate_id(true);

    $userId = $_SESSION["user_id"];
    $newSessionId = session_create_id();
    $sessionId = $newSessionId . "_" . $userId;
    session_id($sessionId);

    $_SESSION["last_regeneration"] = time();
}

/**
 * Regenerates session ID for anonymous users
 * 
 * Creates a new session ID and updates the last regeneration timestamp.
 * Helps prevent session fixation attacks for non-authenticated visitors.
 * 
 * @return void
 */
function regenerate_session_id(): void {
    session_regenerate_id(true);
    $_SESSION["last_regeneration"] = time();
}