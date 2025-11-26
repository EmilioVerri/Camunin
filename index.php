<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./images/favicon.ico">
    <title>Camunin</title>
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
   /* Header e Navigation */
header {
    position: fixed;
    width: 100%;
    background: rgba(255, 255, 255, 0.95); /* bianco opaco iniziale */
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    z-index: 1000;
    padding: 0.8rem 0;
    transition: all 0.3s ease; /* ← AGGIUNGI questa riga */
}

/* ← AGGIUNGI questa nuova classe */
header.scrolled {
    background: rgba(255, 255, 255, 0.7); /* più trasparente quando scrolla */
    box-shadow: 0 2px 15px rgba(0,0,0,0.15);
    backdrop-filter: blur(10px); /* effetto vetro smerigliato */
    -webkit-backdrop-filter: blur(10px); /* compatibilità Safari */
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
            background-image: url('./images/camunin7.jpeg');
        }

        .slide2 {
            background-color: #db7343;
            background-image: url('./images/camunin3.webp');
        }

        .slide3 {
            background-color: #db7343;
            background-image: url('./images/camunin11.webp');
        }
                .slide3 {
            background-color: #db7343;
            background-image: url('./images/camunin12.webp');
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

    <!-- Menu Overlay -->
    <div class="menu-overlay" id="menuOverlay">
        <ul class="nav-links">
            <li><a href="./index.php" onclick="toggleMenu()">Home</a></li>
            <li><a href="./listinoprezzi.php" onclick="toggleMenu()">Listino Prezzi</a></li>
            <li><a href="./contatti.php" onclick="toggleMenu()">Contatti</a></li>
        </ul>
    </div>
    <section class="hero-slider" id="home">
        <div class="slide slide1 active">
            <div class="hero-content">
                <h1>RELAX A 360°</h1>
                <p>"Un’oasi di tranquillità nel cuore di Chiuro, dove natura, comfort e silenzio si incontrano."</p>
                <a href="./listinoprezzi.php" class="cta-button">SCOPRI DI PIÙ</a>
            </div>
        </div>
        <div class="slide slide2">
            <div class="hero-content">
                <h1>ELEGANZA & COMFORT</h1>
                <p>"Il posto ideale per rigenerarsi tra i vigneti della Valtellina, avvolti da pace e autenticità."</p>
                <a href="./listinoprezzi.php" class="cta-button">LE NOSTRE CAMERE</a>
            </div>
        </div>
        <div class="slide slide3">
            <div class="hero-content">
                <h1>Un avventura Valtellinese</h1>
                <p>"La tua pausa perfetta tra natura, gusto e tranquillità."</p>
                <a href="./listinoprezzi.php" class="cta-button">IL RISTORANTE</a>
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

  <!-- HTML + CSS + JS COMPLETO PER FEATURES -->

<!-- SOSTITUISCI LA SEZIONE FEATURES ESISTENTE CON QUESTA -->
<section class="features" id="camere">
    <div class="features-container">
        <div class="feature-card">
            <div class="feature-image" style="background-image: url('./images/openspace.webp');">
                <div class="feature-overlay"></div>
            </div>
            <div class="feature-content">
                <h3>Openspace</h3>
                <p>Salotto e cucina attrezzata (no lavastoviglie) con vista.</p>
            </div>
        </div>

        <div class="feature-card">
            <div class="feature-image" style="background-image: url('./images/terrazzo.webp');">
                <div class="feature-overlay"></div>
            </div>
            <div class="feature-content">
                <h3>Terrazzo</h3>
                <p>Terrazzo di 25 mq panoramico.</p>
            </div>
        </div>

        <div class="feature-card">
            <div class="feature-image" style="background-image: url('./images/giardino.webp');">
                <div class="feature-overlay"></div>
            </div>
            <div class="feature-content">
                <h3>Giardino</h3>
                <p>Grande giardino completamente recintato.</p>
            </div>
        </div>
    </div>
</section>

<style>
/* MODIFICA QUESTI STILI NELLA SEZIONE FEATURES DEL TUO CSS */
.feature-image {
    width: 100%;
    height: 300px;
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
    transition: all 0.5s ease;
}

.feature-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(219, 115, 67, 0.2);
    transition: all 0.3s ease;
}

.feature-card:hover .feature-image {
    transform: scale(1.05);
}

.feature-card:hover .feature-overlay {
    background: rgba(219, 115, 67, 0.1);
}
</style>

 <!-- HTML + CSS + JS COMPLETO PER HISTORY SLIDER -->

<!-- SOSTITUISCI LA SEZIONE HISTORY ESISTENTE CON QUESTA -->
<section class="history">
    <div class="history-content">
        <h4>Nella nostra casa</h4>
        <h2>VIVI UNA VERA ESPERIENZA MONTANA</h2>
        <p>Assapora il fascino delle perline in legno e travi a vista del 1980. Arredo su misura con un tocco di modernità.</p>
        <p>Cesto di Benvenuto per tutti i nostri ospiti con prodotti locali.</p>
        <p>A disposizione spazio interno per riporre le proprie bici in sicurezza oppure le vostre attrezzature sciistiche.</p>
        <p>Disponibili 2 city bike e 3 bici da bambini, due piccole e una grande.</p>
    </div>
    <div class="history-slider">
        <div class="history-slide active" style="background-image: url('./images/camunin1.webp');"></div>
        <div class="history-slide" style="background-image: url('./images/camunin2.webp');"></div>
        <div class="history-slide" style="background-image: url('./images/camunin3.webp');"></div>
        <div class="history-slide" style="background-image: url('./images/camunin4.webp');"></div>
        <div class="history-slide" style="background-image: url('./images/camunin5.webp');"></div>
        <div class="history-slide" style="background-image: url('./images/camunin6.webp');"></div>
        <div class="history-slide" style="background-image: url('./images/camunin7.webp');"></div>
        <div class="history-slide" style="background-image: url('./images/camunin8.webp');"></div>
        <div class="history-slide" style="background-image: url('./images/camunin9.webp');"></div>
        <div class="history-slider-nav">
            <button class="history-prev" onclick="changeHistorySlide(-1)">‹</button>
            <button class="history-next" onclick="changeHistorySlide(1)">›</button>
        </div>
    </div>
</section>

<style>
/* SOSTITUISCI GLI STILI .history-image CON QUESTI NEL TUO CSS */
.history-slider {
    width: 100%;
    height: 400px;
    position: relative;
    border-radius: 5px;
    overflow: hidden;
}

.history-slide {
    position: absolute;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    opacity: 0;
    transition: opacity 0.8s ease;
}

.history-slide.active {
    opacity: 1;
}

.history-slider-nav {
    position: absolute;
    bottom: 20px;
    right: 20px;
    display: flex;
    gap: 10px;
    z-index: 10;
}

.history-prev,
.history-next {
    width: 45px;
    height: 45px;
    background: rgba(255, 255, 255, 0.9);
    border: none;
    border-radius: 50%;
    font-size: 2rem;
    color: #db7343;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.history-prev:hover,
.history-next:hover {
    background: white;
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
}
</style>

<script>
// AGGIUNGI QUESTO JAVASCRIPT PRIMA DELLA CHIUSURA DEL TAG 
let currentHistorySlide = 0;
const historySlides = document.querySelectorAll('.history-slide');

function changeHistorySlide(direction) {
    historySlides[currentHistorySlide].classList.remove('active');
    currentHistorySlide = (currentHistorySlide + direction + historySlides.length) % historySlides.length;
    historySlides[currentHistorySlide].classList.add('active');
}

// Auto avanzamento ogni 4 secondi
setInterval(() => {
    changeHistorySlide(1);
}, 4000);
</script>

<!-- HTML + CSS COMPLETO PER ROOM SECTION (FOTO SINISTRA) -->

<!-- SOSTITUISCI LA ROOM-SECTION PRECEDENTE CON QUESTA -->
<section class="room-section">
    <div class="room-container">
        <div class="room-image" style="background-image: url('./images/camunin2.webp');">
            <div class="room-image-overlay"></div>
        </div>
        <div class="room-content">
            <h2>Camera matrimoniale</h2>
            <h3>Comfort e Relax</h3>
            <p>La prima camera matrimoniale con vista sul giardino.</p>
            <a href="./listinoprezzi.php" class="cta-button" style="background: #db7343; color: white;">SCOPRI I PREZZI</a>
        </div>
    </div>
</section>

<style>
/* AGGIUNGI QUESTI STILI NUOVI NEL TUO CSS */
.room-section {
    padding: 5rem 0;
    background: linear-gradient(135deg, rgba(255, 247, 243, 1) 0%, rgba(255, 252, 250, 1) 100%);
    position: relative;
    overflow: hidden;
}

.room-section::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 200px;
    background-image: 
        url("data:image/svg+xml,%3Csvg width='100' height='120' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M50 10 L45 40 L40 45 L35 50 L40 55 L45 60 L50 110 L55 60 L60 55 L65 50 L60 45 L55 40 Z' fill='%23db7343' opacity='0.15'/%3E%3C/svg%3E"),
        url("data:image/svg+xml,%3Csvg width='80' height='100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M40 8 L36 32 L32 36 L28 40 L32 44 L36 48 L40 88 L44 48 L48 44 L52 40 L48 36 L44 32 Z' fill='%23db7343' opacity='0.12'/%3E%3C/svg%3E"),
        url("data:image/svg+xml,%3Csvg width='90' height='110' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M45 9 L40 35 L36 40 L32 45 L36 50 L40 55 L45 100 L50 55 L54 50 L58 45 L54 40 L50 35 Z' fill='%23db7343' opacity='0.1'/%3E%3C/svg%3E");
    background-size: 180px 220px, 140px 180px, 160px 200px;
    background-position: 10% bottom, 40% bottom, 70% bottom;
    background-repeat: no-repeat;
    pointer-events: none;
    z-index: 1;
}

.room-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    align-items: center;
    position: relative;
    z-index: 2;
}

.room-content {
    opacity: 0;
    transform: translateX(50px);
    transition: all 0.8s ease;
}

.room-section.animate .room-content {
    opacity: 1;
    transform: translateX(0);
}

.room-content h2 {
    font-size: 2.5rem;
    color: #db7343;
    margin-bottom: 0.5rem;
    font-weight: 300;
}

.room-content h3 {
    font-size: 1.8rem;
    color: #333;
    margin-bottom: 1.5rem;
    font-weight: 400;
}

.room-content p {
    font-size: 1.1rem;
    color: #555;
    line-height: 1.8;
    margin-bottom: 1.5rem;
}

.room-content .cta-button {
    margin-top: 1rem;
}

.room-image {
    width: 100%;
    height: 500px;
    background-size: cover;
    background-position: center;
    border-radius: 10px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    opacity: 0;
    transform: translateX(-50px);
    transition: all 0.8s ease;
}

.room-section.animate .room-image {
    opacity: 1;
    transform: translateX(0);
}

.room-image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(219, 115, 67, 0.1) 0%, rgba(0, 0, 0, 0.05) 100%);
    transition: all 0.3s ease;
}

.room-image:hover .room-image-overlay {
    background: linear-gradient(135deg, rgba(219, 115, 67, 0.05) 0%, rgba(0, 0, 0, 0.02) 100%);
}

@media (max-width: 768px) {
    .room-container {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .room-image {
        height: 350px;
    }
}
</style>


<!-- HTML + CSS + JS COMPLETO PER PARALLAX SECTION -->

<!-- AGGIUNGI QUESTA NUOVA SEZIONE DOPO LA "room-section" -->
<section class="parallax-section">
    <div class="parallax-content">
        <h2>Vivi un'Esperienza Unica</h2>
        <p>Lasciati avvolgere dalla bellezza della Valtellina</p>
    </div>
</section>

<style>
/* AGGIUNGI QUESTI STILI NUOVI NEL TUO CSS */
.parallax-section {
    height: 70vh;
    min-height: 500px;
    background-image: url('./images/camunin12.webp');
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.parallax-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(219, 115, 67, 0.3);
    z-index: 1;
}

.parallax-content {
    position: relative;
    z-index: 2;
    text-align: center;
    color: white;
    opacity: 0;
    transform: translateY(30px);
    transition: all 1s ease;
}

.parallax-section.animate .parallax-content {
    opacity: 1;
    transform: translateY(0);
}

.parallax-content h2 {
    font-size: 3.5rem;
    font-weight: 300;
    margin-bottom: 1rem;
    letter-spacing: 2px;
    text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);
}

.parallax-content p {
    font-size: 1.5rem;
    font-style: italic;
    text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.3);
}

/* Mobile: rimuovi fixed per compatibilità */
@media (max-width: 768px) {
    .parallax-section {
        background-attachment: scroll;
        height: 50vh;
        min-height: 400px;
    }
    
    .parallax-content h2 {
        font-size: 2.5rem;
    }
    
    .parallax-content p {
        font-size: 1.2rem;
    }
}
</style>

<script>
// AGGIUNGI QUESTO AL TUO JAVASCRIPT ESISTENTE (modifica la parte DOMContentLoaded)
document.addEventListener('DOMContentLoaded', () => {
    const animatedElements = document.querySelectorAll('.intro, .feature-card, .history, .location, .room-section, .parallax-section');
    animatedElements.forEach(el => observer.observe(el));
});
</script>
    

<!-- HTML + CSS COMPLETO PER ROOM SECTION ALTERNATIVA (FOTO DESTRA) - VERSIONE CORRETTA -->

<!-- AGGIUNGI QUESTA NUOVA SEZIONE DOPO LA "parallax-section" -->
<section class="room-section-alt">
    <div class="room-container-alt">
        <div class="room-content-alt">
            <h2>Camera matrimoniale + culla</h2>
            <h3>Design e Natura</h3>
            <p>La seconda camera matrimoniale + culla con doppia esposizione, vista sia sul giardino sia verso il paese e le Alpi Retiche.</p>
            <a href="./listinoprezzi.php" class="cta-button" style="background: #db7343; color: white;">SCOPRI I PREZZI</a>
        </div>
        <div class="room-image-alt" style="background-image: url('./images/camunin3.webp');">
            <div class="room-image-overlay-alt"></div>
        </div>
    </div>
</section>

<style>
/* AGGIUNGI QUESTI STILI NUOVI NEL TUO CSS */
.room-section-alt {
    padding: 5rem 0;
    background: linear-gradient(135deg, rgba(255, 252, 250, 1) 0%, rgba(255, 247, 243, 1) 100%);
    position: relative;
    overflow: hidden;
}

.room-section-alt::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 200px;
    background-image: 
        url("data:image/svg+xml,%3Csvg width='100' height='120' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M50 10 L45 40 L40 45 L35 50 L40 55 L45 60 L50 110 L55 60 L60 55 L65 50 L60 45 L55 40 Z' fill='%23db7343' opacity='0.15'/%3E%3C/svg%3E"),
        url("data:image/svg+xml,%3Csvg width='80' height='100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M40 8 L36 32 L32 36 L28 40 L32 44 L36 48 L40 88 L44 48 L48 44 L52 40 L48 36 L44 32 Z' fill='%23db7343' opacity='0.12'/%3E%3C/svg%3E"),
        url("data:image/svg+xml,%3Csvg width='90' height='110' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M45 9 L40 35 L36 40 L32 45 L36 50 L40 55 L45 100 L50 55 L54 50 L58 45 L54 40 L50 35 Z' fill='%23db7343' opacity='0.1'/%3E%3C/svg%3E");
    background-size: 180px 220px, 140px 180px, 160px 200px;
    background-position: 20% bottom, 50% bottom, 80% bottom;
    background-repeat: no-repeat;
    pointer-events: none;
    z-index: 1;
}

.room-container-alt {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    align-items: center;
    position: relative;
    z-index: 2;
}

.room-content-alt {
    opacity: 0;
    transform: translateX(-50px);
    transition: all 0.8s ease;
    order: 1;
}

.room-section-alt.animate .room-content-alt {
    opacity: 1;
    transform: translateX(0);
}

.room-content-alt h2 {
    font-size: 2.5rem;
    color: #db7343;
    margin-bottom: 0.5rem;
    font-weight: 300;
}

.room-content-alt h3 {
    font-size: 1.8rem;
    color: #333;
    margin-bottom: 1.5rem;
    font-weight: 400;
}

.room-content-alt p {
    font-size: 1.1rem;
    color: #555;
    line-height: 1.8;
    margin-bottom: 1.5rem;
}

.room-content-alt .cta-button {
    margin-top: 1rem;
    display: inline-block;
    padding: 1rem 2.5rem;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
}

.room-content-alt .cta-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(219, 115, 67, 0.4);
}

.room-image-alt {
    width: 100%;
    height: 500px;
    background-size: cover;
    background-position: center;
    border-radius: 10px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    opacity: 0;
    transform: translateX(50px);
    transition: all 0.8s ease;
    order: 2;
}

.room-section-alt.animate .room-image-alt {
    opacity: 1;
    transform: translateX(0);
}

.room-image-overlay-alt {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(219, 115, 67, 0.1) 0%, rgba(0, 0, 0, 0.05) 100%);
    transition: all 0.3s ease;
}

.room-image-alt:hover .room-image-overlay-alt {
    background: linear-gradient(135deg, rgba(219, 115, 67, 0.05) 0%, rgba(0, 0, 0, 0.02) 100%);
}

@media (max-width: 768px) {
    .room-container-alt {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .room-content-alt {
        order: 2;
    }
    
    .room-image-alt {
        height: 350px;
        order: 1;
    }
}
</style>

<script>
// ASSICURATI CHE NEL TUO JAVASCRIPT CI SIA ANCHE .room-section-alt
document.addEventListener('DOMContentLoaded', () => {
    const animatedElements = document.querySelectorAll('.intro, .feature-card, .history, .location, .room-section, .room-section-alt, .parallax-section, .contact-section');
    animatedElements.forEach(el => observer.observe(el));
});
</script>



<!-- HTML + CSS COMPLETO PER CONTACT SECTION CON GOOGLE MAPS -->

<!-- AGGIUNGI QUESTA NUOVA SEZIONE PRIMA DEL FOOTER -->
<section class="contact-section" id="contatti-mappa">
    <div class="contact-header">
        <h2>Contattaci per prenotare o richiedere il tuo preventivo</h2>
    </div>
    <div class="contact-container">
        <div class="contact-map">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2766.8406754872844!2d10.091234876928437!3d46.16499997113308!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47841f5e8e8e8e8f%3A0x8e8e8e8e8e8e8e8e!2sVia%20Adda%2C%2018%2C%2023030%20Chiuro%20SO!5e0!3m2!1sit!2sit!4v1234567890123!5m2!1sit!2sit" 
                width="100%" 
                height="100%" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
        <div class="contact-info">
            <div class="contact-item">
                <div class="contact-icon">📍</div>
                <div class="contact-text">
                    <h3>C'Amunin - Casa Vacanze</h3>
                    <p>Via Adda, 18 Chiuro (SO) Valtellina, Lombardia</p>
                </div>
            </div>

            <div class="contact-item">
                <div class="contact-icon">📞</div>
                <div class="contact-text">
                    <h3>Telefono</h3>
                    <p><a href="tel:+393668283156">+39 366.8283156</a></p>
                </div>
            </div>

            <div class="contact-item">
                <div class="contact-icon">✉️</div>
                <div class="contact-text">
                    <h3>Email</h3>
                    <p><a href="mailto:camunin.casavacanze@gmail.com">camunin.casavacanze@gmail.com</a></p>
                </div>
            </div>

            <div class="contact-item">
                <div class="contact-icon">📱</div>
                <div class="contact-text">
                    <h3>Instagram</h3>
                    <p><a href="https://instagram.com/camunin.casavacanze" target="_blank">@camunin.casavacanze</a></p>
                </div>
            </div>

            <div class="contact-directions">
                <h3>Dove ci troviamo?</h3>
                <ul>
                    <li><strong>C'Amunin - Stazione dei treni e pullman di Chiuro:</strong> 260 mt (3 min. a piedi)</li>
                    <li><strong>C'Amunin - Tirano:</strong> 20 min.</li>
                    <li><strong>C'Amunin - Sondrio:</strong> 15 min.</li>
                    <li><strong>C'Amunin - Bormio:</strong> 50 min.</li>
                    <li><strong>C'Amunin - Livigno:</strong> 1 h e 45 min.</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<style>
/* AGGIUNGI QUESTI STILI NUOVI NEL TUO CSS */
.contact-section {
    background: #f9f9f9;
    padding: 5rem 0;
}

.contact-header {
    text-align: center;
    margin-bottom: 3rem;
    padding: 0 2rem;
}

.contact-header h2 {
    font-size: 2.2rem;
    color: #333;
    font-weight: 400;
}

.contact-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.8s ease;
}

.contact-section.animate .contact-container {
    opacity: 1;
    transform: translateY(0);
}

.contact-map {
    width: 100%;
    height: 600px;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

.contact-info {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.contact-item {
    display: flex;
    gap: 1.5rem;
    align-items: flex-start;
}

.contact-icon {
    font-size: 2.5rem;
    min-width: 60px;
    height: 60px;
    background: #db7343;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(219, 115, 67, 0.3);
}

.contact-text h3 {
    font-size: 1.3rem;
    color: #db7343;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.contact-text p {
    font-size: 1.05rem;
    color: #555;
    line-height: 1.6;
}

.contact-text a {
    color: #555;
    text-decoration: none;
    transition: color 0.3s;
}

.contact-text a:hover {
    color: #db7343;
}

.contact-directions {
    background: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    margin-top: 1rem;
}

.contact-directions h3 {
    font-size: 1.5rem;
    color: #db7343;
    margin-bottom: 1.5rem;
    font-weight: 500;
}

.contact-directions ul {
    list-style: none;
    padding: 0;
}

.contact-directions ul li {
    font-size: 1rem;
    color: #555;
    padding: 0.8rem 0;
    border-bottom: 1px solid #f0f0f0;
    line-height: 1.6;
}

.contact-directions ul li:last-child {
    border-bottom: none;
}

.contact-directions ul li strong {
    color: #333;
}

@media (max-width: 968px) {
    .contact-container {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .contact-map {
        height: 400px;
    }
    
    .contact-header h2 {
        font-size: 1.8rem;
    }
}
</style>

<script>
// MODIFICA IL TUO JAVASCRIPT AGGIUNGENDO ANCHE LE NUOVE SEZIONI
document.addEventListener('DOMContentLoaded', () => {
    const animatedElements = document.querySelectorAll('.intro, .feature-card, .history, .location, .room-section, .room-section-alt, .parallax-section, .contact-section');
    animatedElements.forEach(el => observer.observe(el));
});
</script>
    <footer id="contatti">
        <div class="footer-content">
            <div class="footer-section">
                <h3>Camunin</h3>
                <p>Via Adda, 18 Chiuro (SO) Valtellina, Lombardia</p>
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
            <p>Realizzato da: <a href="https://emilioverri.altervista.org/" target="_blank" style="color: #db7343;">Emilio Verri</a>
</p>
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