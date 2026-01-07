<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./images/favicon.ico">
    <title>Galleria - C'Amunin Casa Vacanze</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>


/* Aggiungi questo nel tuo <style> */
@media (max-width: 768px) {
    .lightbox-prev,
    .lightbox-next {
        font-size: 40px;
        padding: 15px;
        background: rgba(0, 0, 0, 0.5);
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .lightbox-prev {
        left: 10px;
    }

    .lightbox-next {
        right: 10px;
    }

    .lightbox-close {
        top: 10px;
        right: 10px;
        font-size: 35px;
        background: rgba(0, 0, 0, 0.5);
        border-radius: 50%;
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
}
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
            transition: all 0.3s ease;
        }

        header.scrolled {
            background: rgba(255, 255, 255, 0.7);
            box-shadow: 0 2px 15px rgba(0,0,0,0.15);
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
            padding-top: 80px;
            min-height: calc(100vh - 400px);
        }

        /* Gallery Section */
        .gallery-section {
            padding: 5rem 2rem;
            background: #f9f9f9;
        }

        .gallery-header {
            text-align: center;
            max-width: 900px;
            margin: 0 auto 4rem;
        }

        .gallery-header h1 {
            font-size: 3rem;
            color: #333;
            margin-bottom: 1rem;
            font-weight: 400;
        }

        .gallery-header p {
            font-size: 1.2rem;
            color: #666;
        }

        .gallery-grid {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: all 0.3s ease;
            aspect-ratio: 4/3;
        }

        .gallery-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.1);
        }

        /* Lightbox */
        .lightbox {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.95);
            z-index: 10000;
            align-items: center;
            justify-content: center;
        }

        .lightbox.active {
            display: flex;
        }

        .lightbox-content {
            position: relative;
            max-width: 90%;
            max-height: 90vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .lightbox-content img {
            max-width: 100%;
            max-height: 90vh;
            object-fit: contain;
            border-radius: 5px;
        }

        .lightbox-close {
            position: absolute;
            top: 20px;
            right: 30px;
            font-size: 40px;
            color: white;
            cursor: pointer;
            z-index: 10001;
            transition: all 0.3s;
        }

        .lightbox-close:hover {
            color: #db7343;
            transform: rotate(90deg);
        }

        .lightbox-prev,
        .lightbox-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 50px;
            color: white;
            cursor: pointer;
            padding: 20px;
            transition: all 0.3s;
            user-select: none;
        }

        .lightbox-prev {
            left: 20px;
        }

        .lightbox-next {
            right: 20px;
        }

        .lightbox-prev:hover,
        .lightbox-next:hover {
            color: #db7343;
        }

        .lightbox-counter {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            color: white;
            font-size: 1.2rem;
            background: rgba(0, 0, 0, 0.5);
            padding: 10px 20px;
            border-radius: 20px;
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
            .gallery-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 1rem;
            }

            .gallery-header h1 {
                font-size: 2rem;
            }

            .lightbox-prev,
            .lightbox-next {
                font-size: 30px;
                padding: 10px;
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
            <li><a href="./galleria.php" onclick="toggleMenu()">Galleria</a></li>
            <li><a href="./contatti.php" onclick="toggleMenu()">Contatti</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <main>
        <section class="gallery-section">
            <div class="gallery-header">
                <h1>Galleria Fotografica</h1>
                <p>Scopri la bellezza di C'Amunin attraverso le nostre immagini</p>
            </div>

            <div class="gallery-grid" id="galleryGrid">
                <?php
                $imageDir = './images/';
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                $excludeFiles = ['logoA.webp', 'favicon.ico']; // Escludi logo e favicon
                
                if (is_dir($imageDir)) {
                    $images = array_diff(scandir($imageDir), array('..', '.'));
                    $imageCount = 0;
                    
                    foreach ($images as $image) {
                        $extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));
                        
                        if (in_array($extension, $allowedExtensions) && !in_array($image, $excludeFiles)) {
                            echo '<div class="gallery-item" onclick="openLightbox(' . $imageCount . ')">';
                            echo '<img src="' . $imageDir . $image . '" alt="Galleria C\'Amunin" loading="lazy">';
                            echo '</div>';
                            $imageCount++;
                        }
                    }
                }
                ?>
            </div>
        </section>
    </main>

    <!-- Lightbox -->
    <div class="lightbox" id="lightbox">
        <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
        <span class="lightbox-prev" onclick="changeImage(-1)">&#10094;</span>
        <span class="lightbox-next" onclick="changeImage(1)">&#10095;</span>
        <div class="lightbox-content">
            <img src="" alt="Immagine ingrandita" id="lightboxImg">
        </div>
        <div class="lightbox-counter" id="lightboxCounter"></div>
    </div>

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
            <p>Realizzato da: <a href="https://emilioverri.altervista.org/" target="_blank">Emilio Verri</a></p>
        </div>
    </footer>

  <script>
        // Raccogli tutte le immagini
        let galleryImages = [];
        let currentImageIndex = 0;

        window.addEventListener('DOMContentLoaded', () => {
            const galleryItems = document.querySelectorAll('.gallery-item img');
            galleryItems.forEach(img => {
                galleryImages.push(img.src);
            });
        });

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

        // Header scroll effect
        window.addEventListener('scroll', () => {
            const header = document.querySelector('header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Lightbox Functions
        function openLightbox(index) {
            currentImageIndex = index;
            const lightbox = document.getElementById('lightbox');
            const lightboxImg = document.getElementById('lightboxImg');
            const counter = document.getElementById('lightboxCounter');
            
            lightboxImg.src = galleryImages[currentImageIndex];
            counter.textContent = `${currentImageIndex + 1} / ${galleryImages.length}`;
            lightbox.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            const lightbox = document.getElementById('lightbox');
            lightbox.classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        function changeImage(direction) {
            currentImageIndex += direction;
            
            if (currentImageIndex >= galleryImages.length) {
                currentImageIndex = 0;
            } else if (currentImageIndex < 0) {
                currentImageIndex = galleryImages.length - 1;
            }
            
            const lightboxImg = document.getElementById('lightboxImg');
            const counter = document.getElementById('lightboxCounter');
            
            lightboxImg.src = galleryImages[currentImageIndex];
            counter.textContent = `${currentImageIndex + 1} / ${galleryImages.length}`;
        }

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            const lightbox = document.getElementById('lightbox');
            if (lightbox.classList.contains('active')) {
                if (e.key === 'Escape') {
                    closeLightbox();
                } else if (e.key === 'ArrowLeft') {
                    changeImage(-1);
                } else if (e.key === 'ArrowRight') {
                    changeImage(1);
                }
            }
        });

        // Close lightbox when clicking outside the image
        document.getElementById('lightbox').addEventListener('click', (e) => {
            if (e.target.id === 'lightbox') {
                closeLightbox();
            }
        });

        // ============================================
        // TOUCH SUPPORT PER MOBILE (SWIPE)
        // ============================================
        let touchStartX = 0;
        let touchEndX = 0;

        const lightbox = document.getElementById('lightbox');

        lightbox.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        }, false);

        lightbox.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        }, false);

        function handleSwipe() {
            const swipeThreshold = 50; // Minimo movimento per considerarlo swipe
            
            if (touchEndX < touchStartX - swipeThreshold) {
                // Swipe left - immagine successiva
                changeImage(1);
            }
            
            if (touchEndX > touchStartX + swipeThreshold) {
                // Swipe right - immagine precedente
                changeImage(-1);
            }
        }
</script>




</body>
</html>