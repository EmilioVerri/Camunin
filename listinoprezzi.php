<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./images/favicon.ico">
    <title>Camunin - Casa Vacanze</title>
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
            position: fixed;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
            padding: 0.8rem 0;
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
            border-radius: 30px;
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
            padding-top: 80px;
            min-height: calc(100vh - 400px);
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

        @media (max-width: 768px) {
            .nav-links a {
                font-size: 2rem;
            }
        }

        /* SEZIONE OLIMPIADI */
        .olimpiadi-section {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            padding: 5rem 2rem;
            position: relative;
            overflow: hidden;
            color: white;
            text-align: center;
        }

        .olimpiadi-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(255,255,255,.03) 35px, rgba(255,255,255,.03) 70px),
                repeating-linear-gradient(-45deg, transparent, transparent 35px, rgba(255,255,255,.03) 35px, rgba(255,255,255,.03) 70px);
            opacity: 0.5;
            pointer-events: none;
        }

        .olimpiadi-content {
            max-width: 900px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s ease;
        }

        .olimpiadi-section.animate .olimpiadi-content {
            opacity: 1;
            transform: translateY(0);
        }

        .olimpiadi-content h2 {
            font-size: 3rem;
            font-weight: 600;
            letter-spacing: 3px;
            margin-bottom: 1rem;
            color: white;
        }

        .olimpiadi-date {
            font-size: 1.8rem;
            color: #db7343;
            font-style: italic;
            margin-bottom: 2rem;
            font-family: 'Georgia', serif;
        }

        .olimpiadi-subtitle {
            font-size: 1.1rem;
            color: #ccc;
            margin-bottom: 3rem;
        }

        .olimpiadi-pricing {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            border: 1px solid rgba(219, 115, 67, 0.3);
            transition: all 0.3s ease;
            opacity: 0;
            transform: translateX(-50px);
        }

        .olimpiadi-section.animate .price-row {
            opacity: 1;
            transform: translateX(0);
        }

        .olimpiadi-section.animate .price-row:nth-child(1) {
            transition-delay: 0.3s;
        }

        .olimpiadi-section.animate .price-row:nth-child(2) {
            transition-delay: 0.5s;
        }

        .price-row:hover {
            background: rgba(219, 115, 67, 0.1);
            border-color: #db7343;
            transform: translateY(-5px);
        }

        .price-label {
            font-size: 1.3rem;
            color: #db7343;
            font-style: italic;
        }

        .price-value {
            font-size: 2rem;
            font-weight: 600;
            color: white;
        }

        /* SEZIONE LISTINO PREZZI */
        .listino-section {
            background: #f9f9f9;
            padding: 5rem 2rem;
        }

        .listino-header {
            text-align: center;
            max-width: 900px;
            margin: 0 auto 4rem;
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease;
        }

        .listino-section.animate .listino-header {
            opacity: 1;
            transform: translateY(0);
        }

        .listino-header h2 {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 1rem;
            font-weight: 400;
        }

        .listino-description {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 1.5rem;
        }

        .listino-contacts {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
            font-size: 0.95rem;
            color: #666;
        }

        .listino-contacts a {
            color: #db7343;
            text-decoration: none;
            transition: color 0.3s;
        }

        .listino-contacts a:hover {
            color: #c5633a;
        }

        .listino-container {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
            gap: 3rem;
        }

        .season-column {
            background: white;
            padding: 2.5rem;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s ease;
        }

        .listino-section.animate .season-column {
            opacity: 1;
            transform: translateY(0);
        }

        .listino-section.animate .season-column:nth-child(1) {
            transition-delay: 0.2s;
        }

        .listino-section.animate .season-column:nth-child(2) {
            transition-delay: 0.4s;
        }

        .season-column h3 {
            font-size: 2rem;
            color: #db7343;
            margin-bottom: 1rem;
            font-weight: 500;
        }

        .season-months {
            font-size: 1rem;
            color: #555;
            margin-bottom: 0.5rem;
            line-height: 1.6;
        }

        .season-note {
            font-size: 0.9rem;
            color: #888;
            font-style: italic;
            margin-bottom: 2rem;
            line-height: 1.5;
        }

        .price-card {
            background: #f9f9f9;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #db7343;
            transition: all 0.3s ease;
        }

        .price-card:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(219, 115, 67, 0.15);
        }

        .price-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .price-header h4 {
            font-size: 1.2rem;
            color: #333;
            font-weight: 500;
        }

        .price-tag {
            font-size: 1.8rem;
            color: #db7343;
            font-weight: 600;
        }

        .price-note {
            font-size: 0.9rem;
            color: #666;
            line-height: 1.5;
        }

        @media (max-width: 768px) {
            .olimpiadi-content h2 {
                font-size: 2rem;
            }
            
            .olimpiadi-date {
                font-size: 1.3rem;
            }
            
            .price-row {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            
            .price-label {
                font-size: 1.1rem;
            }
            
            .price-value {
                font-size: 1.8rem;
            }

            .listino-container {
                grid-template-columns: 1fr;
            }
            
            .listino-header h2 {
                font-size: 2rem;
            }
            
            .price-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <!-- Loading Screen -->
         <div class="nav-left">
                <a href="./index.php">
                    <img src="./images/logoA.webp" style="height:80px" alt="Camunin Logo" class="logo">
                </a>
            </div>

    <!-- Header -->
    <header>
        <nav>
            <div class="nav-left">
                <img src="./images/logoA.webp" style="height:80px" alt="Camunin Logo" class="logo">
            </div>
            <div class="nav-right">
                <a href="./contatti.php" class="book-button">CONTATTACI</a>
                <div class="hamburger" onclick="toggleMenu()">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </nav>
    </header>

    <!-- Menu Overlay -->
    <div class="menu-overlay" id="menuOverlay">
        <ul class="nav-links">
            <li><a href="#home" onclick="toggleMenu()">Home</a></li>
            <li><a href="./listinoprezzi.php" onclick="toggleMenu()">Listino Prezzi</a></li>
            <li><a href="./contatti.php" onclick="toggleMenu()">Contatti</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <main>
        <!-- SEZIONE SPECIALE OLIMPIADI -->
        <section class="olimpiadi-section">
            <div class="olimpiadi-pattern"></div>
            <div class="olimpiadi-content">
                <h2>SPECIALE OLIMPIADI</h2>
                <p class="olimpiadi-date">Dal 6 al 22 febbraio 2026</p>
                <p class="olimpiadi-subtitle">Tariffe indicate per notte. Pernottamento minimo 2 notti.</p>
                
                <div class="olimpiadi-pricing">
                    <div class="price-row">
                        <span class="price-label">Pernottamento per 1 o 2 ospiti</span>
                        <span class="price-value">€ 400</span>
                    </div>
                    <div class="price-row">
                        <span class="price-label">Pernottamento per 3 o 4 ospiti</span>
                        <span class="price-value">€ 500</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- SEZIONE LISTINO PREZZI -->
        <section class="listino-section">
            <div class="listino-header">
                <h2>Listino prezzi</h2>
                <p class="listino-description">Il nostro listino prezzi varia a seconda del periodo stagionale. Tariffe indicate per notte.</p>
                <div class="listino-contacts">
                    <span>📱 +39. 366.8283156</span>
                    <span>|</span>
                    <a href="mailto:camunin.casavacanze@gmail.com">✉️ camunin.casavacanze@gmail.com</a>
                    <span>|</span>
                    <a href="#contatti">💬 Sezione Contatti</a>
                </div>
            </div>

            <div class="listino-container">
                <!-- BASSA STAGIONE -->
                <div class="season-column">
                    <h3>Bassa stagione</h3>
                    <p class="season-months">Marzo, Aprile, Maggio, Giugno, Settembre, Ottobre e Novembre</p>
                    <p class="season-note">*esclusi ponti festivi e weekend Wine Trail: si applicano le tariffe di Alta stagione</p>

                    <div class="price-card">
                        <div class="price-header">
                            <h4>Pernottamento per 1 o 2 persone</h4>
                            <span class="price-tag">€ 120,00</span>
                        </div>
                        <p class="price-note">Bambini fino a 4 anni gratuiti. Culla disponibile gratuitamente</p>
                    </div>

                    <div class="price-card">
                        <div class="price-header">
                            <h4>Pernottamento per 3 o 4 persone</h4>
                            <span class="price-tag">€ 200,00</span>
                        </div>
                        <p class="price-note">Bambini fino a 4 anni gratuiti. Culla disponibile gratuitamente.</p>
                    </div>
                </div>

                <!-- ALTA STAGIONE -->
                <div class="season-column">
                    <h3>Alta stagione</h3>
                    <p class="season-months">Dicembre, Gennaio, Febbraio, Luglio* e Agosto*</p>
                    <p class="season-note">*Luglio e Agosto pernottamento minimo 5 notti.</p>

                    <div class="price-card">
                        <div class="price-header">
                            <h4>Pernottamento per 1 o 2 persone</h4>
                            <span class="price-tag">€ 140,00</span>
                        </div>
                        <p class="price-note">Bambini fino a 4 anni gratuiti. Culla disponibile gratuitamente</p>
                    </div>

                    <div class="price-card">
                        <div class="price-header">
                            <h4>Pernottamento per 3 o 4 persone</h4>
                            <span class="price-tag">€ 220,00</span>
                        </div>
                        <p class="price-note">Bambini fino a 4 anni gratuiti. Culla disponibile gratuitamente.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer id="contatti">
        <div class="footer-content">
            <div class="footer-section">
                <h3>Camunin</h3>
                <p>Via Adda, 18 Chiuro (SO)</p>
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
                <a href="https://www.instagram.com/camunin.casavacanze/" target="_blank">Instagram</a>
                <a href="#" target="_blank">Booking</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 Camunin. Tutti i diritti riservati. - CIN: IT014020C25KZ2NAGV</p>
            <p>Realizzato da: <a href="https://emilioverri.altervista.org/" target="_blank">Emilio Verri</a></p>
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

        // Scroll Animations (come nella homepage)
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
            const animatedElements = document.querySelectorAll('.olimpiadi-section, .listino-section');
            animatedElements.forEach(el => observer.observe(el));
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
    </script>
</body>
</html>