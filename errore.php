<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./images/favicon.ico">
    <title>Errore - C'Amunin Casa Vacanze</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            background: linear-gradient(135deg, #f9f9f9 0%, #ffffff 100%);
        }

        /* Header e Navigation */
        header {
            position: fixed;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
            padding: 0.8rem 0;
            transition: all 0.3s ease;
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

        /* Error Section */
        .error-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            padding-top: 100px;
        }

        .error-container {
            text-align: center;
            max-width: 600px;
            animation: fadeIn 1s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .error-icon {
            font-size: 8rem;
            color: #db7343;
            margin-bottom: 2rem;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-20px);
            }
            60% {
                transform: translateY(-10px);
            }
        }

        .error-code {
            font-size: 6rem;
            font-weight: bold;
            color: #db7343;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        .error-title {
            font-size: 2rem;
            color: #333;
            margin-bottom: 1rem;
            font-weight: 400;
        }

        .error-message {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 3rem;
            line-height: 1.8;
        }

        .home-button {
            display: inline-block;
            padding: 1rem 3rem;
            background: #db7343;
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(219, 115, 67, 0.3);
        }

        .home-button:hover {
            background: #c5633a;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(219, 115, 67, 0.4);
        }

        .home-button i {
            margin-right: 0.5rem;
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

        @media (max-width: 768px) {
            .error-code {
                font-size: 4rem;
            }

            .error-title {
                font-size: 1.5rem;
            }

            .error-message {
                font-size: 1rem;
            }

            .error-icon {
                font-size: 5rem;
            }

            .nav-links a {
                font-size: 2rem;
            }

            .home-button {
                padding: 0.8rem 2rem;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
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
    <!-- Error Section -->
    <section class="error-section">
        <div class="error-container">
            <div class="error-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="error-code">404</div>
            <h1 class="error-title">Oops! Pagina non trovata</h1>
            <p class="error-message">
                La pagina che stai cercando potrebbe essere stata rimossa, 
                il suo nome è stato modificato o è temporaneamente non disponibile.
            </p>
            <a href="./index.php" class="home-button">
                <i class="fas fa-home"></i>
                Torna alla Home
            </a>
        </div>
    </section>

    <!-- Footer -->
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
            <p>Realizzato da: <a href="https://emilioverri.altervista.org/" target="_blank">V3RR1L0G1C</a></p>
        </div>
    </footer>

    <script>
        // Menu Hamburger Toggle
        function toggleMenu() {
            const hamburger = document.querySelector('.hamburger');
            const menuOverlay = document.getElementById('menuOverlay');
            hamburger.classList.toggle('active');
            menuOverlay.classList.toggle('active');
        }
    </script>
</body>
</html>