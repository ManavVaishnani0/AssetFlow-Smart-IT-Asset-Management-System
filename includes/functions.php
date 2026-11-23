<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
function e($value) { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function redirect($url) { header("Location: $url"); exit; }
function csrf_token() {
    if (empty($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf_token'];
}
function verify_csrf() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token = $_POST['csrf_token'] ?? '';
        if (!hash_equals(csrf_token(), $token)) {
            http_response_code(403); exit('Invalid request token. Refresh and try again.');
        }
    }
}
function flash($message = null) {
    if ($message !== null) { $_SESSION['flash'] = $message; return; }
    $value = $_SESSION['flash'] ?? ''; unset($_SESSION['flash']); return $value;
}
function post($key, $default = '') { return trim($_POST[$key] ?? $default); }
