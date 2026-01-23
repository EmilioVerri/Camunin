<?php
require_once 'auth_check.php';

// API Handler
if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_GET['action'])) {
    header('Content-Type: application/json');
    
    $imagesDir = '../images/';
    
    // GET Request - List images
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'list') {
        $images = [];
        
        if (is_dir($imagesDir)) {
            $files = scandir($imagesDir);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..' && preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file)) {
                    $filePath = $imagesDir . $file;
                    $images[] = [
                        'name' => $file,
                        'size' => filesize($filePath)
                    ];
                }
            }
        }
        
        echo json_encode(['success' => true, 'images' => $images]);
        exit;
    }
    
    // POST Request - Upload or Delete
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        
        // Upload Images
        if ($action === 'upload') {
            if (!isset($_FILES['images'])) {
                echo json_encode(['success' => false, 'message' => 'Nessuna immagine ricevuta']);
                exit;
            }
            
            if (!is_dir($imagesDir)) {
                mkdir($imagesDir, 0755, true);
            }
            
            $uploaded = 0;
            $errors = [];
            
            foreach ($_FILES['images']['name'] as $key => $name) {
                $tmpName = $_FILES['images']['tmp_name'][$key];
                $size = $_FILES['images']['size'][$key];
                $error = $_FILES['images']['error'][$key];
                
                if ($error !== UPLOAD_ERR_OK) {
                    $errors[] = "Errore caricamento $name";
                    continue;
                }
                
                if ($size > 5 * 1024 * 1024) {
                    $errors[] = "$name supera i 5MB";
                    continue;
                }
                
                $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    $errors[] = "$name non è un formato valido";
                    continue;
                }
                
                // Sanitize filename
                $safeName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $name);
                $destination = $imagesDir . $safeName;
                
                // Handle duplicate names
                $counter = 1;
                while (file_exists($destination)) {
                    $nameWithoutExt = pathinfo($safeName, PATHINFO_FILENAME);
                    $safeName = $nameWithoutExt . '_' . $counter . '.' . $ext;
                    $destination = $imagesDir . $safeName;
                    $counter++;
                }
                
                if (move_uploaded_file($tmpName, $destination)) {
                    $uploaded++;
                } else {
                    $errors[] = "Errore spostamento $name";
                }
            }
            
            if ($uploaded > 0) {
                echo json_encode([
                    'success' => true,
                    'uploaded' => $uploaded,
                    'message' => "$uploaded immagini caricate"
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Nessuna immagine caricata. ' . implode(', ', $errors)
                ]);
            }
            exit;
        }
        
        // Delete Images
        if ($action === 'delete') {
            $images = json_decode($_POST['images'] ?? '[]', true);
            
            if (empty($images)) {
                echo json_encode(['success' => false, 'message' => 'Nessuna immagine da eliminare']);
                exit;
            }
            
            $deleted = 0;
            foreach ($images as $imageName) {
                $filePath = $imagesDir . basename($imageName);
                if (file_exists($filePath) && unlink($filePath)) {
                    $deleted++;
                }
            }
            
            echo json_encode([
                'success' => true,
                'deleted' => $deleted,
                'message' => "$deleted immagini eliminate"
            ]);
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <link rel="icon" type="image/x-icon" href="../images/favicon.ico">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Galleria - Camunin</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
        }
        
        /* Header */
        .header {
            background: #db7343;
            color: white;
            padding: 15px 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .menu-toggle {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            padding: 5px;
            display: flex;
            align-items: center;
        }
        
        .header h1 {
            font-size: 24px;
            font-weight: 600;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }
        
        /* Sidebar */
        .sidebar {
            position: fixed;
            left: -280px;
            top: 0;
            width: 280px;
            height: 100vh;
            background: white;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            transition: left 0.3s;
            z-index: 200;
            overflow-y: auto;
        }
        
        .sidebar.active {
            left: 0;
        }
        
        .sidebar-header {
            background: #db7343;
            color: white;
            padding: 20px;
            font-size: 20px;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .close-sidebar {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
        }
        
        .sidebar-menu li {
            border-bottom: 1px solid #f0f0f0;
        }
        
        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px 20px;
            color: #333;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .sidebar-menu a:hover {
            background: #f8f8f8;
            color: #db7343;
        }
        
        .sidebar-menu a.active {
            background: #db7343;
            color: white;
        }
        
        /* Overlay */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 150;
        }
        
        .overlay.active {
            display: block;
        }
        
        /* Main Content */
        .main-content {
            padding: 30px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .page-title {
            color: #333;
            font-size: 28px;
            margin-bottom: 30px;
            font-weight: 600;
        }
        
        /* Section */
        .section {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .section-title {
            color: #db7343;
            font-size: 20px;
            margin-bottom: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        /* Upload Area */
        .upload-area {
            border: 3px dashed #db7343;
            border-radius: 10px;
            padding: 40px;
            text-align: center;
            background: #fff8f5;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 20px;
        }
        
        .upload-area:hover {
            background: #ffe8dc;
            border-color: #c56237;
        }
        
        .upload-area.dragover {
            background: #ffe8dc;
            border-color: #c56237;
            transform: scale(1.02);
        }
        
        .upload-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
        
        .upload-text {
            font-size: 16px;
            color: #333;
            margin-bottom: 10px;
        }
        
        .upload-hint {
            font-size: 14px;
            color: #666;
        }
        
        #fileInput {
            display: none;
        }
        
        /* Selected Files Preview */
        .selected-files {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        
        .selected-file {
            position: relative;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
            background: white;
        }
        
        .selected-file img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }
        
        .selected-file-name {
            padding: 8px;
            font-size: 12px;
            text-align: center;
            background: #f8f8f8;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .remove-selected {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(220, 53, 69, 0.9);
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            cursor: pointer;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Buttons */
        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background-color: #db7343;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #c56237;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(219, 115, 67, 0.3);
        }
        
        .btn-primary:disabled {
            background-color: #ccc;
            cursor: not-allowed;
            transform: none;
        }
        
        .btn-danger {
            background-color: #dc3545;
            color: white;
        }
        
        .btn-danger:hover {
            background-color: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }
        
        .btn-danger:disabled {
            background-color: #ccc;
            cursor: not-allowed;
            transform: none;
        }
        
        .upload-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        
        /* Gallery Grid */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .gallery-item {
            position: relative;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
            background: white;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        
        .gallery-item.selected {
            border-color: #db7343;
            box-shadow: 0 0 0 3px rgba(219, 115, 67, 0.2);
        }
        
        .gallery-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
        }
        
        .gallery-item-info {
            padding: 12px;
            background: #f8f8f8;
        }
        
        .gallery-item-name {
            font-size: 13px;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .gallery-item-size {
            font-size: 11px;
            color: #666;
        }
        
        .selection-checkbox {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 24px;
            height: 24px;
            cursor: pointer;
            z-index: 10;
        }
        
        /* Alert */
        .alert {
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }
        
        /* Actions Bar */
        .actions-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f8f8;
            border-radius: 8px;
        }
        
        .selection-info {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }
        
        .selection-count {
            color: #db7343;
        }
        
        /* Loading Spinner */
        .loading {
            text-align: center;
            padding: 40px;
            color: #666;
        }
        
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #db7343;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 15px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        @media (max-width: 768px) {
            .gallery-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 15px;
            }
            
            .gallery-item img {
                height: 150px;
            }
            
            .actions-bar {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-left">
            <button class="menu-toggle" onclick="toggleSidebar()">☰</button>
            <h1>Gestione Galleria</h1>
        </div>
        <div class="user-info">
            <span>👤 Admin</span>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <span>Menu</span>
            <button class="close-sidebar" onclick="toggleSidebar()">✕</button>
        </div>
        <ul class="sidebar-menu">
            <li><a href="index.php">📊 Listino Prezzi</a></li>
            <li><a href="galleria.php" class="active">🖼️ Galleria</a></li>
            <li><a href="logout.php">🚪 Logout</a></li>
        </ul>
    </div>

    <!-- Overlay -->
    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

    <!-- Main Content -->
    <div class="main-content">
        <h2 class="page-title">Gestione Galleria Immagini</h2>

        <div id="alertContainer"></div>

        <!-- Upload Section -->
        <div class="section">
            <h3 class="section-title">📤 Carica Nuove Immagini</h3>
            
            <div class="upload-area" id="uploadArea" onclick="document.getElementById('fileInput').click()">
                <div class="upload-icon">📁</div>
                <div class="upload-text">Clicca per selezionare o trascina qui le immagini</div>
                <div class="upload-hint">Formati supportati: JPG, PNG, GIF, WEBP (max 5MB per immagine)</div>
            </div>
            
            <input type="file" id="fileInput" multiple accept="image/*">
            
            <div id="selectedFilesContainer" style="display: none;">
                <h4 style="margin-bottom: 15px; color: #333;">Immagini selezionate:</h4>
                <div class="selected-files" id="selectedFiles"></div>
                
                <div class="upload-buttons">
                    <button class="btn btn-primary" id="uploadBtn" onclick="uploadImages()">
                        ⬆️ Carica Immagini
                    </button>
                    <button class="btn btn-danger" onclick="clearSelection()">
                        ✕ Annulla
                    </button>
                </div>
            </div>
        </div>

        <!-- Gallery Section -->
        <div class="section">
            <h3 class="section-title">🖼️ Galleria Immagini</h3>
            
            <div class="actions-bar">
                <div class="selection-info">
                    <span class="selection-count" id="selectionCount">0</span> immagini selezionate
                </div>
                <button class="btn btn-danger" id="deleteSelectedBtn" onclick="deleteSelected()" disabled>
                    🗑️ Elimina Selezionate
                </button>
            </div>
            
            <div class="gallery-grid" id="galleryGrid">
                <div class="loading">
                    <div class="spinner"></div>
                    Caricamento galleria...
                </div>
            </div>
        </div>
    </div>

    <script>
        let selectedFiles = [];
        let selectedImages = new Set();

        // Toggle Sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        // Show Alert
        function showAlert(message, type) {
            const alertContainer = document.getElementById('alertContainer');
            const alert = document.createElement('div');
            alert.className = `alert alert-${type}`;
            alert.textContent = message;
            alertContainer.appendChild(alert);
            
            setTimeout(() => {
                alert.remove();
            }, 5000);
        }

        // Drag and Drop
        const uploadArea = document.getElementById('uploadArea');
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, () => {
                uploadArea.classList.add('dragover');
            }, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, () => {
                uploadArea.classList.remove('dragover');
            }, false);
        });
        
        uploadArea.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }

        // File Input Change
        document.getElementById('fileInput').addEventListener('change', (e) => {
            handleFiles(e.target.files);
        });

        // Handle Files
        function handleFiles(files) {
            selectedFiles = Array.from(files).filter(file => {
                if (!file.type.startsWith('image/')) {
                    showAlert(`${file.name} non è un'immagine valida`, 'error');
                    return false;
                }
                if (file.size > 5 * 1024 * 1024) {
                    showAlert(`${file.name} supera i 5MB`, 'error');
                    return false;
                }
                return true;
            });
            
            if (selectedFiles.length > 0) {
                displaySelectedFiles();
            }
        }

        // Display Selected Files
        function displaySelectedFiles() {
            const container = document.getElementById('selectedFilesContainer');
            const filesDiv = document.getElementById('selectedFiles');
            
            filesDiv.innerHTML = '';
            
            selectedFiles.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const div = document.createElement('div');
                    div.className = 'selected-file';
                    div.innerHTML = `
                        <img src="${e.target.result}" alt="${file.name}">
                        <div class="selected-file-name">${file.name}</div>
                        <button class="remove-selected" onclick="removeSelectedFile(${index})">✕</button>
                    `;
                    filesDiv.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
            
            container.style.display = 'block';
        }

        // Remove Selected File
        function removeSelectedFile(index) {
            selectedFiles.splice(index, 1);
            if (selectedFiles.length === 0) {
                clearSelection();
            } else {
                displaySelectedFiles();
            }
        }

        // Clear Selection
        function clearSelection() {
            selectedFiles = [];
            document.getElementById('fileInput').value = '';
            document.getElementById('selectedFilesContainer').style.display = 'none';
        }

        // Upload Images
        async function uploadImages() {
            if (selectedFiles.length === 0) return;
            
            const uploadBtn = document.getElementById('uploadBtn');
            uploadBtn.disabled = true;
            uploadBtn.textContent = '⏳ Caricamento...';
            
            const formData = new FormData();
            formData.append('action', 'upload');
            selectedFiles.forEach(file => {
                formData.append('images[]', file);
            });
            
            try {
                const response = await fetch('galleria.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showAlert(`${data.uploaded} immagini caricate con successo!`, 'success');
                    clearSelection();
                    loadGallery();
                } else {
                    showAlert(data.message || 'Errore durante il caricamento', 'error');
                }
            } catch (error) {
                console.error('Errore:', error);
                showAlert('Errore di connessione', 'error');
            } finally {
                uploadBtn.disabled = false;
                uploadBtn.textContent = '⬆️ Carica Immagini';
            }
        }

        // Load Gallery
        async function loadGallery() {
            const galleryGrid = document.getElementById('galleryGrid');
            
            try {
                const response = await fetch('galleria.php?action=list');
                const data = await response.json();
                
                if (data.success && data.images.length > 0) {
                    galleryGrid.innerHTML = data.images.map(img => `
                        <div class="gallery-item ${selectedImages.has(img.name) ? 'selected' : ''}" 
                             onclick="toggleImageSelection('${img.name}', event)">
                            <input type="checkbox" 
                                   class="selection-checkbox" 
                                   ${selectedImages.has(img.name) ? 'checked' : ''}
                                   onclick="event.stopPropagation(); toggleImageSelection('${img.name}', event)">
                            <img src="../images/${img.name}" alt="${img.name}">
                            <div class="gallery-item-info">
                                <div class="gallery-item-name" title="${img.name}">${img.name}</div>
                                <div class="gallery-item-size">${formatFileSize(img.size)}</div>
                            </div>
                        </div>
                    `).join('');
                } else {
                    galleryGrid.innerHTML = `
                        <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #999;">
                            📷 Nessuna immagine presente nella galleria
                        </div>
                    `;
                }
            } catch (error) {
                console.error('Errore caricamento galleria:', error);
                galleryGrid.innerHTML = `
                    <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #dc3545;">
                        ❌ Errore nel caricamento della galleria
                    </div>
                `;
            }
        }

        // Toggle Image Selection
        function toggleImageSelection(imageName, event) {
            if (event.target.type !== 'checkbox') {
                event.stopPropagation();
            }
            
            if (selectedImages.has(imageName)) {
                selectedImages.delete(imageName);
            } else {
                selectedImages.add(imageName);
            }
            
            updateSelectionUI();
            loadGallery();
        }

        // Update Selection UI
        function updateSelectionUI() {
            document.getElementById('selectionCount').textContent = selectedImages.size;
            document.getElementById('deleteSelectedBtn').disabled = selectedImages.size === 0;
        }

        // Delete Selected
        async function deleteSelected() {
            if (selectedImages.size === 0) return;
            
            const count = selectedImages.size;
            if (!confirm(`Sei sicuro di voler eliminare ${count} immagine/i?`)) return;
            
            const deleteBtn = document.getElementById('deleteSelectedBtn');
            deleteBtn.disabled = true;
            deleteBtn.textContent = '⏳ Eliminazione...';
            
            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('images', JSON.stringify(Array.from(selectedImages)));
            
            try {
                const response = await fetch('galleria.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showAlert(`${data.deleted} immagini eliminate con successo!`, 'success');
                    selectedImages.clear();
                    updateSelectionUI();
                    loadGallery();
                } else {
                    showAlert(data.message || 'Errore durante l\'eliminazione', 'error');
                }
            } catch (error) {
                console.error('Errore:', error);
                showAlert('Errore di connessione', 'error');
            } finally {
                deleteBtn.disabled = false;
                deleteBtn.textContent = '🗑️ Elimina Selezionate';
            }
        }

        // Format File Size
        function formatFileSize(bytes) {
            if (bytes < 1024) return bytes + ' B';
            if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
            return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
        }

        // Initialize
        window.addEventListener('DOMContentLoaded', () => {
            loadGallery();
        });
    </script>
</body>
</html>