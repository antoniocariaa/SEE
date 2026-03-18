<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Generate CSRF token if one does not exist
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    require __DIR__ . '/config.php';

    try {
        // Enforce mysqli exceptions
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    } catch (\mysqli_sql_exception $e) {
        // Log error internally in a real-world scenario
        error_log($e->getMessage());
        // Generic error message for the user (Information Disclosure fix)
        die("A system error occurred. Please try again later.");
    }
?>