<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./images/favicon.ico">
    <title>Contatti - Camunin</title>

<?php
// ═══════════════════════════════════════════════════════════
// CONFIGURAZIONE EMAIL - MODIFICA SOLO QUESTA PARTE
// ═══════════════════════════════════════════════════════════
$email_destinatario = "camunin.casavacanze@gmail.com"; // TUA EMAIL QUI

// ═══════════════════════════════════════════════════════════
// GESTIONE INVIO EMAIL (NON MODIFICARE)
// ═══════════════════════════════════════════════════════════

$messaggio_successo = "";
$messaggio_errore = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupero dati
    $nome = isset($_POST['nome']) ? htmlspecialchars(trim($_POST['nome'])) : '';
    $cognome = isset($_POST['cognome']) ? htmlspecialchars(trim($_POST['cognome'])) : '';
    $email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
    $note = isset($_POST['note']) ? htmlspecialchars(trim($_POST['note'])) : 'Nessuna nota aggiunta';
    $privacy = isset($_POST['privacy']) ? true : false;
    
    // Validazione
    $errori = [];
    
    if (empty($nome)) $errori[] = "Il nome è obbligatorio";
    if (empty($cognome)) $errori[] = "Il cognome è obbligatorio";
    if (empty($email)) {
        $errori[] = "L'email è obbligatoria";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errori[] = "L'email non è valida";
    }
    if (!$privacy) $errori[] = "Devi accettare la Privacy Policy";
    
    // Se non ci sono errori, invia le email
    if (empty($errori)) {
        $oggetto = "Nuova Richiesta Informazioni - Camunin";
        
        // EMAIL HTML AL PROPRIETARIO
        $corpo_email = '
        <!DOCTYPE html>
        <html lang="it">
        <head>
            <meta charset="UTF-8">
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                body { font-family: Georgia, serif; background-color: #f9f9f9; padding: 20px; }
                .email-container { max-width: 600px; margin: 0 auto; background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1); }
                .header { background: linear-gradient(135deg, #db7343 0%, #c5633a 100%); padding: 40px 20px; text-align: center; }
                .header h1 { color: white; font-size: 28px; font-weight: 300; letter-spacing: 2px; }
                .content { padding: 40px 30px; }
                .section-title { color: #db7343; font-size: 22px; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 3px solid #db7343; font-weight: 500; }
                .info-box { background: #fff3e0; border-left: 4px solid #db7343; padding: 20px; margin-bottom: 20px; border-radius: 5px; }
                .info-row { margin-bottom: 15px; }
                .info-label { color: #db7343; font-weight: 600; font-size: 16px; display: inline-block; min-width: 120px; }
                .info-value { color: #333; font-size: 16px; }
                .note-box { background: #f9f9f9; border-radius: 8px; padding: 20px; margin-top: 20px; }
                .note-box h3 { color: #db7343; font-size: 18px; margin-bottom: 10px; }
                .footer { background: #2c2c2c; color: #ccc; padding: 30px; text-align: center; font-size: 14px; }
                .footer strong { color: #db7343; }
            </style>
        </head>
        <body>
            <div class="email-container">
                <div class="header">
                    <h1>🏔️ NUOVA RICHIESTA</h1>
                </div>
                <div class="content">
                    <h2 class="section-title">📋 Dettagli del Contatto</h2>
                    <div class="info-box">
                        <div class="info-row">
                            <span class="info-label">👤 Nome:</span>
                            <span class="info-value">' . $nome . ' ' . $cognome . '</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">📧 Email:</span>
                            <span class="info-value">' . $email . '</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">📅 Data:</span>
                            <span class="info-value">' . date('d/m/Y H:i') . '</span>
                        </div>
                    </div>
                    <div class="note-box">
                        <h3>💬 Messaggio del Cliente:</h3>
                        <p>' . nl2br($note) . '</p>
                    </div>
                </div>
                <div class="footer">
                    <p><strong>C\'Amunin - Casa Vacanze</strong></p>
                    <p>Via Adda, 18 - 23030 Chiuro (SO)</p>
                </div>
            </div>
        </body>
        </html>
        ';
        
        // Headers
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: Camunin Form <noreply@camunin.it>\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        
        // Invio email al proprietario
        $inviato = @mail($email_destinatario, $oggetto, $corpo_email, $headers);
        
        if ($inviato) {
            // EMAIL DI CONFERMA AL CLIENTE
            $oggetto_cliente = "Conferma Ricezione Richiesta - C'Amunin";
            $corpo_cliente = '
            <!DOCTYPE html>
            <html lang="it">
            <head>
                <meta charset="UTF-8">
                <style>
                    * { margin: 0; padding: 0; box-sizing: border-box; }
                    body { font-family: Georgia, serif; background-color: #f9f9f9; padding: 20px; }
                    .email-container { max-width: 600px; margin: 0 auto; background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1); }
                    .header { background: linear-gradient(135deg, #db7343 0%, #c5633a 100%); padding: 40px 20px; text-align: center; }
                    .header h1 { color: white; font-size: 26px; font-weight: 300; letter-spacing: 2px; }
                    .content { padding: 40px 30px; }
                    .greeting { font-size: 20px; color: #db7343; margin-bottom: 20px; font-weight: 500; }
                    .message { color: #555; line-height: 1.8; font-size: 16px; margin-bottom: 20px; }
                    .highlight-box { background: #fff3e0; border-left: 4px solid #db7343; padding: 20px; margin: 30px 0; border-radius: 5px; }
                    .footer { background: #2c2c2c; color: #ccc; padding: 30px; text-align: center; font-size: 14px; }
                    .footer strong { color: #db7343; }
                </style>
            </head>
            <body>
                <div class="email-container">
                    <div class="header">
                        <h1>✅ CONFERMA RICHIESTA</h1>
                    </div>
                    <div class="content">
                        <p class="greeting">Ciao ' . $nome . ',</p>
                        <p class="message">
                            Grazie per averci contattato! Abbiamo ricevuto la tua richiesta </strong>.
                        </p>
                        <div class="highlight-box">
                            <p><strong style="color: #db7343;">📝 Riepilogo:</strong></p>
                            <p><strong>Email:</strong> ' . $email . '</p>
                            <p><strong>Data:</strong> ' . date('d/m/Y H:i') . '</p>
                        </div>
                        <p class="message">
                            📞 <strong>Telefono:</strong> +39 366.8283156<br>
                            ✉️ <strong>Email:</strong> camunin.casavacanze@gmail.com<br>
                            📱 <strong>Instagram:</strong> @camunin.casavacanze
                        </p>
                        <p class="message" style="margin-top: 30px; font-style: italic; color: #888;">
                            Ti aspettiamo a C\'Amunin! 🏔️
                        </p>
                    </div>
                    <div class="footer">
                        <p><strong>C\'Amunin - Casa Vacanze</strong></p>
                        <p>Via Adda, 18 - 23030 Chiuro (SO) - Valtellina</p>
                    </div>
                </div>
            </body>
            </html>
            ';
            
            $headers_cliente = "MIME-Version: 1.0\r\n";
            $headers_cliente .= "Content-type: text/html; charset=UTF-8\r\n";
            $headers_cliente .= "From: C'Amunin <camunin.casavacanze@gmail.com>\r\n";
            $headers_cliente .= "Reply-To: camunin.casavacanze@gmail.com\r\n";
            
            @mail($email, $oggetto_cliente, $corpo_cliente, $headers_cliente);
            
            $messaggio_successo = "✅ Messaggio inviato con successo!";
            
            // Reset campi
            $nome = $cognome = $email = $note = "";
        } else {
            $messaggio_errore = "❌ Errore nell'invio. Riprova o contattaci direttamente.";
        }
    } else {
        $messaggio_errore = "❌ " . implode(", ", $errori);
    }
}
?>

   <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Georgia', serif;
            color: #333;
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Loading Screen */
        .loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: linear-gradient(135deg, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 1) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }

        .loading-screen.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .loading-logo {
            width: 200px;
            height: auto;
            animation: pulse 1.5s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
        }

        /* Header e Navigation */
        header {
            position: absolute;
            top: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            z-index: 1000;
            padding: 0.8rem 0;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        header.scrolled {
            position: fixed;
            background: rgba(255, 255, 255, 0.7);
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        nav {
            max-width: 100%;
            margin: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
        }

        .nav-left {
            display: flex;
            align-items: center;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .logo {
            height: 50px;
            width: auto;
        }

        /* Hamburger Menu */
        .hamburger {
            width: 30px;
            height: 25px;
            position: relative;
            cursor: pointer;
            z-index: 1001;
        }

        .hamburger span {
            display: block;
            position: absolute;
            height: 3px;
            width: 100%;
            background: #db7343;
            border-radius: 3px;
            opacity: 1;
            left: 0;
            transform: rotate(0deg);
            transition: .25s ease-in-out;
        }

        .hamburger span:nth-child(1) {
            top: 0px;
        }

        .hamburger span:nth-child(2) {
            top: 10px;
        }

        .hamburger span:nth-child(3) {
            top: 20px;
        }

        .hamburger.active span:nth-child(1) {
            top: 10px;
            transform: rotate(135deg);
        }

        .hamburger.active span:nth-child(2) {
            opacity: 0;
            left: -60px;
        }

        .hamburger.active span:nth-child(3) {
            top: 10px;
            transform: rotate(-135deg);
        }

        /* Menu Overlay */
        .menu-overlay {
            position: fixed;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100vh;
            background: linear-gradient(135deg, #db7343 0%, #c5633a 100%);
            z-index: 999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: left 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .menu-overlay.active {
            left: 0;
        }

        .nav-links {
            list-style: none;
            text-align: center;
        }

        .nav-links li {
            margin: 2rem 0;
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.5s ease;
        }

        .menu-overlay.active .nav-links li {
            opacity: 1;
            transform: translateY(0);
        }

        .menu-overlay.active .nav-links li:nth-child(1) { transition-delay: 0.1s; }
        .menu-overlay.active .nav-links li:nth-child(2) { transition-delay: 0.2s; }
        .menu-overlay.active .nav-links li:nth-child(3) { transition-delay: 0.3s; }
        .menu-overlay.active .nav-links li:nth-child(4) { transition-delay: 0.4s; }

        .nav-links a {
            text-decoration: none;
            color: white;
            font-size: 2.5rem;
            transition: all 0.3s;
            display: block;
        }

        .nav-links a:hover {
            color: #ffd7c4;
            transform: scale(1.1);
        }

        /* Bottone Prenota */
        .book-button {
            padding: 0.6rem 1.8rem;
            background: #db7343;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s;
            font-size: 0.95rem;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(219, 115, 67, 0.3);
        }

        .book-button:hover {
            background: #c5633a;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(219, 115, 67, 0.4);
        }

        /* Main Content Area */
        main {
            padding-top: 0;
            min-height: calc(100vh - 400px);
        }

        /* CONTACT HERO SECTION */
        .contact-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), 
                        url('./images/contattaci.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            padding: 8rem 2rem 5rem 2rem;
            text-align: center;
            color: white;
            position: relative;
            min-height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .contact-hero::before {
            display: none;
        }

        .contact-hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            margin: 0 auto;
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s ease;
        }

        .contact-hero.animate .contact-hero-content {
            opacity: 1;
            transform: translateY(0);
        }

        .contact-hero h1 {
            font-size: 3.5rem;
            font-weight: 300;
            letter-spacing: 2px;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);
        }

        .contact-hero p {
            font-size: 1.3rem;
            line-height: 1.8;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.5);
        }

        /* Alert Messages */
        .alert {
            max-width: 800px;
            margin: 2rem auto;
            padding: 1.5rem 2rem;
            border-radius: 10px;
            font-size: 1rem;
            text-align: center;
            animation: slideDown 0.5s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: #d4edda;
            border: 2px solid #28a745;
            color: #155724;
        }

        .alert-error {
            background: #f8d7da;
            border: 2px solid #dc3545;
            color: #721c24;
        }

        .alert strong {
            font-weight: 600;
            display: block;
            margin-bottom: 0.5rem;
            font-size: 1.2rem;
        }

        /* FORM SECTION */
        .form-section {
            background: #f9f9f9;
            padding: 5rem 2rem;
        }

        .form-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 3rem;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            opacity: 1;
            transform: translateY(0);
            transition: all 0.8s ease;
        }

        .form-section.animate .form-container {
            opacity: 1;
            transform: translateY(0);
        }

        .form-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .form-header h2 {
            font-size: 2.5rem;
            color: #db7343;
            margin-bottom: 1rem;
            font-weight: 400;
        }

        .form-header p {
            font-size: 1.1rem;
            color: #666;
            line-height: 1.8;
        }

        .form-group {
            margin-bottom: 2rem;
        }

        .form-group label {
            display: block;
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .form-group label span {
            color: #db7343;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 1rem;
            font-size: 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-family: 'Georgia', serif;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #db7343;
            box-shadow: 0 0 0 3px rgba(219, 115, 67, 0.1);
        }

        .form-group textarea {
            min-height: 150px;
            resize: vertical;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        /* Checkbox Privacy */
        .privacy-group {
            margin-bottom: 2rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .privacy-group input[type="checkbox"] {
            width: 20px;
            height: 20px;
            margin-top: 3px;
            cursor: pointer;
            accent-color: #db7343;
        }

        .privacy-group label {
            font-size: 0.95rem;
            color: #555;
            line-height: 1.6;
            cursor: pointer;
        }

        .privacy-group label a {
            color: #db7343;
            text-decoration: none;
            font-weight: 600;
        }

        .privacy-group label a:hover {
            text-decoration: underline;
        }

        /* Submit Button */
        .submit-button {
            width: 100%;
            padding: 1.2rem;
            background: #db7343;
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(219, 115, 67, 0.3);
        }

        .submit-button:hover {
            background: #c5633a;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(219, 115, 67, 0.4);
        }

        .submit-button:active {
            transform: translateY(0);
        }

        /* Info Note */
        .info-note {
            text-align: center;
            margin-top: 2rem;
            padding: 1.5rem;
            background: #fff3e0;
            border-radius: 10px;
            border-left: 4px solid #db7343;
        }

        .info-note p {
            font-size: 1rem;
            color: #666;
            margin-bottom: 0.5rem;
        }

        .info-note p:last-child {
            font-weight: 600;
            color: #db7343;
            margin-bottom: 0;
        }

        /* Contact Info Section */
        .contact-info-section {
            background: white;
            padding: 5rem 2rem;
        }

        .contact-info-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 3rem;
        }

        .contact-info-card {
            text-align: center;
            padding: 3rem 2rem;
            background: #f9f9f9;
            border-radius: 15px;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            opacity: 0;
            transform: translateY(30px);
        }

        .contact-info-section.animate .contact-info-card {
            opacity: 1;
            transform: translateY(0);
        }

        .contact-info-section.animate .contact-info-card:nth-child(1) {
            transition-delay: 0.2s;
        }

        .contact-info-section.animate .contact-info-card:nth-child(2) {
            transition-delay: 0.4s;
        }

        .contact-info-section.animate .contact-info-card:nth-child(3) {
            transition-delay: 0.6s;
        }

        .contact-info-card:hover {
            transform: translateY(-10px);
            border-color: #db7343;
            background: white;
            box-shadow: 0 10px 30px rgba(219, 115, 67, 0.1);
        }

        .contact-info-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            border: 2px solid #db7343;
            border-radius: 50%;
            color: #db7343;
            transition: all 0.3s ease;
        }

        .contact-info-card:hover .contact-info-icon {
            background: rgba(219, 115, 67, 0.05);
            transform: scale(1.1);
        }

        .contact-info-icon svg {
            width: 48px;
            height: 48px;
        }

        .contact-info-card h3 {
            font-size: 1.5rem;
            color: #db7343;
            margin-bottom: 1rem;
            font-weight: 500;
        }

        .contact-info-card p {
            font-size: 1rem;
            color: #666;
            line-height: 1.6;
        }

        .contact-info-card a {
            color: #333;
            text-decoration: none;
            transition: color 0.3s;
            font-weight: 500;
        }

        .contact-info-card a:hover {
            color: #db7343;
        }

        /* Footer */
        footer {
            background: #2c2c2c;
            color: white;
            padding: 3rem 2rem;
            text-align: center;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h3 {
            color: #db7343;
            margin-bottom: 1rem;
        }

        .footer-section p, .footer-section a {
            color: #ccc;
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
        }

        .footer-section a:hover {
            color: white;
        }

        .footer-bottom {
            border-top: 1px solid #444;
            padding-top: 2rem;
            color: #888;
        }

        .footer-bottom a {
            color: #db7343;
            text-decoration: none;
        }

        .footer-bottom a:hover {
            text-decoration: underline;
        }

        /* Social Icons Styles - Footer */
        .social-links {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1.5rem;
            margin-top: 1rem;
        }

        .social-links a {
            color: #ccc;
            font-size: 1.8rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
        }

        .social-links a:hover {
            color: #db7343;
            background: rgba(219, 115, 67, 0.1);
            transform: translateY(-3px);
        }

        .social-links a i {
            transition: transform 0.3s ease;
        }

        .social-links a:hover i {
            transform: scale(1.1);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-links a {
                font-size: 2rem;
            }

            .contact-hero {
                background-attachment: scroll;
                min-height: 50vh;
                padding: 6rem 2rem 4rem 2rem;
            }

            .contact-hero h1 {
                font-size: 2.5rem;
            }

            .contact-hero p {
                font-size: 1.1rem;
            }

            .form-container {
                padding: 2rem 1.5rem;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .form-header h2 {
                font-size: 2rem;
            }

            .contact-info-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .contact-info-card {
                padding: 2rem 1.5rem;
            }
        }
</style>
</head>
<body>
    <!-- Loading Screen -->
    <div class="loading-screen" id="loadingScreen">
        <img src="./images/logoA.webp" alt="Loading Logo" class="loading-logo">
    </div>

    <!-- Header -->
    <header>
        <nav>
            <div class="nav-left">
               <a href="./index.php"><img src="./images/logoA.webp" style="height:80px" alt="Camunin Logo" class="logo"></a>
            </div>
            <div class="nav-right">
                <a href="./listinoprezzi.php" class="book-button">PRENOTA</a>
                <div class="hamburger" onclick="toggleMenu()">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </nav>
    </header>
<?php


// Configurazione database
    $host = 'localhost';
    $dbname = 'my_camunin';
    $username = 'root';
    $password = '';

    // Connessione al database
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Errore di connessione al database");
    }
    // Verifica stato online del listino
    $stmtOnline = $pdo->query("SELECT online FROM onlinelistino ORDER BY id DESC LIMIT 1");
    $rowOnline = $stmtOnline->fetch(PDO::FETCH_ASSOC);
    $listinoOnline = ($rowOnline && $rowOnline['online'] === 'si');
?>
<div class="menu-overlay" id="menuOverlay">
    <ul class="nav-links">
        <li><a href="./index.php" onclick="toggleMenu()">Home</a></li>
        <?php if ($listinoOnline): ?>
            <li><a href="./listinoprezzi.php" onclick="toggleMenu()">Listino Prezzi</a></li>
        <?php endif; ?>
        <li><a href="./galleria.php" onclick="toggleMenu()">Galleria</a></li>
        <li><a href="./contatti.php" onclick="toggleMenu()">Contatti</a></li>
    </ul>
</div>

    <!-- Main Content -->
    <main>
        <!-- Hero Section -->
     <section class="contact-hero">
    <div class="contact-hero-content">
        <h1>Benvenuti</h1>
        <p>Contattaci per prenotare o per ricevere il tuo preventivo</p>
    </div>
</section>

        <!-- Form Section -->
        <section class="form-section">
            <?php if (!empty($messaggio_successo)): ?>
                <div class="alert alert-success">
                    <strong><?php echo $messaggio_successo; ?></strong>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($messaggio_errore)): ?>
                <div class="alert alert-error">
                    <strong><?php echo $messaggio_errore; ?></strong>
                </div>
            <?php endif; ?>
            
            <div class="form-container">
                <div class="form-header">
                    <h2>Richiedi Informazioni</h2>
                    <p>Compilate il modulo e vi ricontatteremo</p>
                </div>

                <form action="" method="POST" id="contactForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nome">Nome <span>*</span></label>
                            <input type="text" id="nome" name="nome" required placeholder="Il tuo nome" value="<?php echo isset($nome) ? htmlspecialchars($nome) : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label for="cognome">Cognome <span>*</span></label>
                            <input type="text" id="cognome" name="cognome" required placeholder="Il tuo cognome" value="<?php echo isset($cognome) ? htmlspecialchars($cognome) : ''; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email <span>*</span></label>
                        <input type="email" id="email" name="email" required placeholder="la.tua.email@esempio.com" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="note">Note / Richiesta</label>
                        <textarea id="note" name="note" placeholder="Scrivi qui le tue domande o richieste speciali..."><?php echo isset($note) && $note !== 'Nessuna nota aggiunta' ? htmlspecialchars($note) : ''; ?></textarea>
                    </div>

                    <div class="privacy-group">
                        <input type="checkbox" id="privacy" name="privacy" required>
                        <label for="privacy">
                            Ho letto e accetto la <a href="./privacy-policy.php" target="_blank">Privacy Policy</a>. 
                            Acconsento al trattamento dei miei dati personali per ricevere risposta alla mia richiesta. <span style="color: #db7343;">*</span>
                        </label>
                    </div>

                    <button type="submit" class="submit-button">Invia Richiesta</button>

                    <div class="info-note">
                        <p> La tua richiesta è importante!</p>
                        <p>📧 Ti ricontatteremo per fornirti tutte le informazioni necessarie.</p>
                    </div>
                </form>
            </div>
        </section>

        <!-- Contact Info Cards -->
        <!-- Contact Info Cards -->
<section class="contact-info-section">
    <div class="contact-info-grid">
        <div class="contact-info-card">
            <div class="contact-info-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                </svg>
            </div>
            <h3>Telefono</h3>
            <p><a href="tel:+393668283156">+39 366.8283156</a></p>
            <p style="font-size: 0.9rem; margin-top: 0.5rem;">Chiamaci</p>
        </div>

        <div class="contact-info-card">
            <div class="contact-info-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                    <polyline points="22,6 12,13 2,6"></polyline>
                </svg>
            </div>
            <h3>Email</h3>
            <p><a href="mailto:camunin.casavacanze@gmail.com">camunin.casavacanze@gmail.com</a></p>
            <p style="font-size: 0.9rem; margin-top: 0.5rem;">Scrivici</p>
        </div>

        <div class="contact-info-card">
            <div class="contact-info-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                </svg>
            </div>
            <h3>Instagram</h3>
            <p><a href="https://www.instagram.com/camunin.casavacanze/" target="_blank">@camunin.casavacanze</a></p>
            <p style="font-size: 0.9rem; margin-top: 0.5rem;">Seguici!</p>
        </div>
    </div>
</section>

<style>
/* Contact Info Section - AGGIORNA QUESTI STILI */
.contact-info-section {
    background: white;
    padding: 5rem 2rem;
}

.contact-info-grid {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 3rem;
}

.contact-info-card {
    text-align: center;
    padding: 3rem 2rem;
    background: #f9f9f9;
    border-radius: 15px;
    border: 2px solid transparent;
    transition: all 0.3s ease;
    opacity: 0;
    transform: translateY(30px);
}

.contact-info-section.animate .contact-info-card {
    opacity: 1;
    transform: translateY(0);
}

.contact-info-section.animate .contact-info-card:nth-child(1) {
    transition-delay: 0.2s;
}

.contact-info-section.animate .contact-info-card:nth-child(2) {
    transition-delay: 0.4s;
}

.contact-info-section.animate .contact-info-card:nth-child(3) {
    transition-delay: 0.6s;
}

.contact-info-card:hover {
    transform: translateY(-10px);
    border-color: #db7343;
    background: white;
    box-shadow: 0 10px 30px rgba(219, 115, 67, 0.1);
}

.contact-info-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    border: 2px solid #db7343;
    border-radius: 50%;
    color: #db7343;
    transition: all 0.3s ease;
}

.contact-info-card:hover .contact-info-icon {
    background: rgba(219, 115, 67, 0.05);
    transform: scale(1.1);
}

.contact-info-icon svg {
    width: 48px;
    height: 48px;
}

.contact-info-card h3 {
    font-size: 1.5rem;
    color: #db7343;
    margin-bottom: 1rem;
    font-weight: 500;
}

.contact-info-card p {
    font-size: 1rem;
    color: #666;
    line-height: 1.6;
}

.contact-info-card a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s;
    font-weight: 500;
}

.contact-info-card a:hover {
    color: #db7343;
}

@media (max-width: 768px) {
    .contact-info-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .contact-info-card {
        padding: 2rem 1.5rem;
    }
}
</style>
    </main>

   
 <!-- Aggiungi questo nel <head> del tuo HTML -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- CSS da aggiungere nel tuo <style> -->
 <!-- CSS da aggiungere nel tuo <style> -->
<style>
/* Social Icons Styles */
.social-links {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 1.5rem;
    margin-top: 1rem;
}

.social-links a {
    color: #ccc;
    font-size: 1.8rem;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.05);
}

.social-links a:hover {
    color: #db7343;
    background: rgba(219, 115, 67, 0.1);
    transform: translateY(-3px);
}

.social-links a i {
    transition: transform 0.3s ease;
}

.social-links a:hover i {
    transform: scale(1.1);
}
</style>

<!-- FOOTER HTML -->
<footer id="contatti">
    <div class="footer-content">
        <div class="footer-section">
            <h3>C'Amunin</h3>
            <p>Via Adda, 18</p>
            <p>23030 Chiuro (SO)</p>
            <p>Valtellina - Italia</p>
        </div>
        <div class="footer-section">
            <h3>Contatti</h3>
            <p>Tel: +39 366.8283156</p>
            <p>Email: camunin.casavacanze@gmail.com</p>
        </div>
        <div class="footer-section">
            <h3>Seguici</h3>
            <div class="social-links">
                <a href="https://www.instagram.com/camunin.casavacanze/" target="_blank" title="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>

                <a href="https://www.tiktok.com/login?redirect_url=https%3A%2F%2Fwww.tiktok.com%2F%40camunin.casavacanze%3F_r%3D1%26_t%3DZN-91tbUUz1Upy&lang=en&enter_method=mandatory" target="_blank" title="TikTok">
                    <i class="fab fa-tiktok"></i>
                </a>
                <a href="https://www.facebook.com/people/CAmunin-Casa-Vacanze/61583657716861/?rdid=AIKZ696fgzkfR3Ju&share_url=https%3A%2F%2Fwww.facebook.com%2Fshare%2F1CZYbTg1zQ%2F" target="_blank" title="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://www.booking.com/hotel/it/amunin.it.html?aid=964694&app_hotel_id=15313738&checkin=2025-12-27&checkout=2025-12-29&from_sn=android&group_adults=2&group_children=0&label=hotel_details-ixj11u%401764710303&no_rooms=1&req_adults=2&req_children=0&room1=A%2CA&chal_t=1765230953365&force_referer=" target="_blank" title="Booking">
                    <i class="fas fa-bed"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2025 C'Amunin. Tutti i diritti riservati. - CIN: IT014020C25KZ2NAGV - CIR: 014020-LNI-00006</p>
 <p>Realizzato da: <a href="https://emilioverri.altervista.org/" target="_blank" style="color: #db7343;">V3RR1L0G1C</a></p>
    </div>
</footer>

    <script>
        // Loading Screen
        window.addEventListener('load', () => {
            setTimeout(() => {
                document.getElementById('loadingScreen').classList.add('hidden');
            }, 1000);
        });

        // Menu Hamburger Toggle
        function toggleMenu() {
            const hamburger = document.querySelector('.hamburger');
            const menuOverlay = document.getElementById('menuOverlay');
            hamburger.classList.toggle('active');
            menuOverlay.classList.toggle('active');
        }

        // Scroll Animations
        const observerOptions = {
            threshold: 0.2,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate');
                }
            });
        }, observerOptions);

        // Observe all animated sections
        document.addEventListener('DOMContentLoaded', () => {
            const animatedElements = document.querySelectorAll('.contact-hero, .form-section, .contact-info-section');
            animatedElements.forEach(el => observer.observe(el));
        });

        // Form Validation
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            const privacy = document.getElementById('privacy');
            
            if (!privacy.checked) {
                e.preventDefault();
                alert('Devi accettare la Privacy Policy per inviare il modulo.');
                privacy.focus();
            }
        });

        // Smooth scroll for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Header scroll effect
        window.addEventListener('scroll', () => {
            const header = document.querySelector('header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>