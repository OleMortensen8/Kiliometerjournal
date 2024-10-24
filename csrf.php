<?php
// csrf.php

// Start output buffering
ob_start();

// Check if session is not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Generate a new CSRF token if none exists
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function getCsrfToken() {
    return $_SESSION['csrf_token'];
}

function verifyCsrfToken($token) {
    // Verify the CSRF token
    if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
        return false;
    }
    return true;
}

// Flush output buffer
ob_end_flush();
?>
