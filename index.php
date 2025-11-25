<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wine Hotel San Carlo - Relax a 360°</title>
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
        .menu-overlay.active .nav-links li:nth-child(4) { transition-delay: 0.4s; }
        .menu-overlay.active .nav-links li:nth-child(5) { transition-delay: 0.5s; }

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

        /* Hero Slider */
        .hero-slider {
            height: 70vh;
            position: relative;
            overflow: hidden;
            margin-top: 0;
            padding-top: 80px;
        }

        .slide {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .slide::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1;
        }

        .slide.active {
            opacity: 1;
        }

        .slide1 {
            background-color: #db7343;
            background-image: url('https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1920');
        }

        .slide2 {
            background-color: #db7343;
            background-image: url('https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=1920');
        }

        .slide3 {
            background-color: #db7343;
            background-image: url('https://images.unsplash.com/photo-1540553016722-983e48a2cd10?w=1920');
        }

        .hero-content {
            max-width: 800px;
            padding: 2rem;
            animation: fadeInUp 1s ease;
            position: relative;
            z-index: 2;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-content h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            font-weight: 300;
            letter-spacing: 3px;
        }

        .hero-content p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            font-style: italic;
        }

        .cta-button {
            display: inline-block;
            padding: 1rem 2.5rem;
            background: white;
            color: #db7343;
            text-decoration: none;
            border-radius: 30px;
            transition: all 0.3s;
            font-size: 1rem;
            font-weight: 600;
        }

        .cta-button:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(255,255,255,0.3);
        }

        /* Slider Dots */
        .slider-dots {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 15px;
            z-index: 10;
        }

        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255,255,255,0.5);
            cursor: pointer;
            transition: all 0.3s;
        }

        .dot.active {
            background: white;
            width: 30px;
            border-radius: 6px;
        }

        /* Intro Section */
        .intro {
            max-width: 1200px;
            margin: 5rem auto;
            padding: 0 2rem;
            text-align: center;
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s ease;
        }

        .intro.animate {
            opacity: 1;
            transform: translateY(0);
        }

        .intro h2 {
            font-size: 2.5rem;
            color: #db7343;
            margin-bottom: 2rem;
            font-weight: 300;
        }

        .intro p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #555;
            margin-bottom: 1.5rem;
        }

        /* Features Section */
        .features {
            background: #f9f9f9;
            padding: 5rem 2rem;
            overflow: hidden;
        }

        .features-container {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 3rem;
        }

        .feature-card {
            background: white;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.5s ease;
            opacity: 0;
            transform: translateY(50px);
        }

        .feature-card.animate {
            opacity: 1;
            transform: translateY(0);
        }

        .feature-card:nth-child(1).animate { transition-delay: 0.1s; }
        .feature-card:nth-child(2).animate { transition-delay: 0.3s; }
        .feature-card:nth-child(3).animate { transition-delay: 0.5s; }

        .feature-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .feature-image {
            width: 100%;
            height: 300px;
            background: linear-gradient(135deg, #db7343 0%, #c5633a 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: white;
            transition: all 0.3s;
        }

        .feature-card:hover .feature-image {
            transform: scale(1.1);
        }

        .feature-content {
            padding: 2rem;
        }

        .feature-content h3 {
            font-size: 1.8rem;
            color: #db7343;
            margin-bottom: 1rem;
        }

        .feature-content p {
            color: #666;
            line-height: 1.8;
        }

        /* History Section */
        .history {
            max-width: 1200px;
            margin: 5rem auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
            opacity: 0;
            transform: translateX(-50px);
            transition: all 0.8s ease;
        }

        .history.animate {
            opacity: 1;
            transform: translateX(0);
        }

        .history-content h2 {
            font-size: 2.5rem;
            color: #db7343;
            margin-bottom: 1.5rem;
            font-weight: 300;
        }

        .history-content p {
            font-size: 1.1rem;
            color: #555;
            line-height: 1.8;
            margin-bottom: 1rem;
        }

        .history-image {
            width: 100%;
            height: 400px;
            background: linear-gradient(45deg, #db7343 0%, #c5633a 100%);
            border-radius: 5px;
            transition: all 0.5s ease;
        }

        .history.animate .history-image {
            animation: slideInRight 1s ease;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Location Section */
        .location {
            background: #db7343;
            color: white;
            padding: 5rem 2rem;
            text-align: center;
            opacity: 0;
            transform: scale(0.9);
            transition: all 0.8s ease;
        }

        .location.animate {
            opacity: 1;
            transform: scale(1);
        }

        .location h2 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            font-weight: 300;
        }

        .location p {
            font-size: 1.1rem;
            max-width: 800px;
            margin: 0 auto 2rem;
            line-height: 1.8;
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

        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.5rem;
            }

            .history {
                grid-template-columns: 1fr;
            }

            .features-container {
                grid-template-columns: 1fr;
            }

            .nav-links a {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Loading Screen -->
    <div class="loading-screen" id="loadingScreen">
        <img src="./images/logoA.webp" alt="Loading Logo" class="loading-logo">
    </div>

    <header>
        <nav>
            <div class="nav-left">
                <img src="https://cdn.pixabay.com/photo/2017/03/16/21/18/logo-2150297_1280.png" alt="Wine Hotel San Carlo Logo" class="logo">
            </div>
            <div class="nav-right">
                <a href="#" class="book-button">PRENOTA</a>
                <div class="hamburger" onclick="toggleMenu()">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </nav>
    </header>

    <div class="menu-overlay" id="menuOverlay">
        <ul class="nav-links">
            <li><a href="#home" onclick="toggleMenu()">Home</a></li>
            <li><a href="#camere" onclick="toggleMenu()">Camere</a></li>
            <li><a href="#spa" onclick="toggleMenu()">SPA</a></li>
            <li><a href="#ristorante" onclick="toggleMenu()">Ristorante</a></li>
            <li><a href="#contatti" onclick="toggleMenu()">Contatti</a></li>
        </ul>
    </div>

    <section class="hero-slider" id="home">
        <div class="slide slide1 active">
            <div class="hero-content">
                <h1>RELAX A 360°</h1>
                <p>"Un Ristorante, un Wine Hotel, una SPA: un'esperienza di puro benessere"</p>
                <a href="#" class="cta-button">SCOPRI DI PIÙ</a>
            </div>
        </div>
        <div class="slide slide2">
            <div class="hero-content">
                <h1>ELEGANZA & COMFORT</h1>
                <p>"12 camere esclusive con materassi Tempur e design raffinato"</p>
                <a href="#camere" class="cta-button">LE NOSTRE CAMERE</a>
            </div>
        </div>
        <div class="slide slide3">
            <div class="hero-content">
                <h1>TRADIZIONE DAL 1843</h1>
                <p>"Cucina locale e 200 etichette di vino selezionate"</p>
                <a href="#ristorante" class="cta-button">IL RISTORANTE</a>
            </div>
        </div>
        <div class="slider-dots">
            <span class="dot active" onclick="currentSlide(0)"></span>
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
        </div>
    </section>

    <section class="intro">
        <h4>La Nostra Storia</h2>
        <h2>ACCOGLIERE CON AMORE</h2>
        <p>Ciao! Sono Sara e gestisco C'Amunin, la nostra casa vacanze, con l'aiuto del mio compagno Michael e dei miei genitori.</p>
        <p>C'Amunin non è semplicemente una casa vacanze, ma un dono prezioso lasciato dal mio caro nonno materno. Il nome della casa, è ispirato al suo cognome, Amonini, come omaggio alle nostre radici e alla sua memoria.</p>
        <p>Oggi mettiamo il nostro impegno e il nostro cuore in ogni dettaglio, per far sentire chi soggiorna qui accolto come in famiglia.</p>
        <p>Io, la mia famiglia e il nostro cane Teo, che vive liberamente in casa nostra, vi aspettiamo!</p>
    </section>

    <section class="features" id="camere">
        <div class="features-container">
            <div class="feature-card">
                <div class="feature-image">🛏️</div>
                <div class="feature-content">
                    <h3>Camere e Suite</h3>
                    <p>Dove il legno incontra l'eleganza, con materassi Tempur per il massimo del comfort e dettagli di design e pregio che creano un ambiente raffinato e accogliente.</p>
                </div>
            </div>

            <div class="feature-card" id="spa">
                <div class="feature-image">💆</div>
                <div class="feature-content">
                    <h3>Area Benessere</h3>
                    <p>Un angolo di puro relax all'ultimo piano, dove il legno avvolge sauna, bagno turco e doccia orizzontale per un'esperienza di rigenerazione unica.</p>
                </div>
            </div>

            <div class="feature-card" id="ristorante">
                <div class="feature-image">🍷</div>
                <div class="feature-content">
                    <h3>Ristorante di Tradizione dal 1843</h3>
                    <p>Dove i sapori autentici si tramandano da generazioni. Menù à la carte che celebra la cucina locale, con una cantina piccola boutique visitabile con 200 etichette di vino selezionate.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="history">
        <div class="history-content">
            <h2>La Nostra Storia</h2>
            <p>Dal 1843, il Wine Hotel San Carlo rappresenta un punto di riferimento per l'ospitalità in Valtellina. Nata come stazione di posta, la nostra struttura ha saputo mantenere intatto il fascino storico, rinnovandosi con eleganza per offrire tutti i comfort moderni.</p>
            <p>Ogni angolo della nostra struttura racconta una storia di tradizione, passione per l'accoglienza e amore per il territorio.</p>
        </div>
        <div class="history-image"></div>
    </section>

    <section class="location">
        <h2>La Nostra Posizione</h2>
        <p>Situato a Chiuro, patria del Nebbiolo valtellinese, il nostro hotel è la base ideale per scoprire le meraviglie della Valtellina, tra sapori, vino, trekking, ciclismo, sci e il Trenino Rosso del Bernina a pochi chilometri, per un'esperienza completa tra natura, gusto e benessere.</p>
        <a href="#" class="cta-button">SCOPRI IL TERRITORIO</a>
    </section>

    <footer id="contatti">
        <div class="footer-content">
            <div class="footer-section">
                <h3>Wine Hotel San Carlo</h3>
                <p>Via Roma, 1</p>
                <p>23030 Chiuro (SO)</p>
                <p>Valtellina - Italia</p>
            </div>
            <div class="footer-section">
                <h3>Contatti</h3>
                <p>Tel: +39 0342 482131</p>
                <p>Email: info@winehotelsancarlo.it</p>
            </div>
            <div class="footer-section">
                <h3>Seguici</h3>
                <a href="#">Facebook</a>
                <a href="#">Instagram</a>
                <a href="#">TripAdvisor</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Wine Hotel San Carlo. Tutti i diritti riservati.</p>
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

        // Hero Slider
        let currentSlideIndex = 0;
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.dot');

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.remove('active');
                dots[i].classList.remove('active');
            });
            
            slides[index].classList.add('active');
            dots[index].classList.add('active');
        }

        function nextSlide() {
            currentSlideIndex = (currentSlideIndex + 1) % slides.length;
            showSlide(currentSlideIndex);
        }

        function currentSlide(index) {
            currentSlideIndex = index;
            showSlide(index);
        }

        // Auto slide every 5 seconds
        setInterval(nextSlide, 5000);

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

        // Observe all animated elements
        document.addEventListener('DOMContentLoaded', () => {
            const animatedElements = document.querySelectorAll('.intro, .feature-card, .history, .location');
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