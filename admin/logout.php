<?php
// logout.php
session_start();

// Distruggi tutte le variabili di sessione
$_SESSION = array();

// Distruggi il cookie di sessione se esiste
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

// Distruggi la sessione
session_destroy();

// Reindirizza al login
header('Location: index.php');
exit;
?>