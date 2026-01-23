<?php
// auth_check.php - File di controllo autenticazione
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se l'utente è loggato
if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    // Utente non autenticato, reindirizza al login
    header('Location: index.php');
    exit;
}



// Aggiorna il timestamp dell'ultima attività
$_SESSION['last_activity'] = time();
?>