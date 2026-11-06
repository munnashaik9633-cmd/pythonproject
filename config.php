<?php
declare(strict_types=1);

define('APP_NAME', 'Campus Feedback Lens');
define('BASE_URL', '/campus-feedback-lens'); // Change to '' when deployed at the domain root.
define('DB_HOST', 'localhost');
define('DB_NAME', 'campus_feedback_lens');
define('DB_USER', 'root');
define('DB_PASS', '');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set('Asia/Kolkata');
