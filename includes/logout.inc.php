<?php
/**
 * Logout Handler
 * 
 * Destroys the current session and redirects user to the main page.
 * Clears all session data to ensure complete logout.
 * 
 * @package NestlyHomes
 * @subpackage Authentication
 */

session_start();
session_unset();    
session_destroy();  

header("Location: ../mainpage/index.php"); 
die();