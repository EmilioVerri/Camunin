<!DOCTYPE html>
<html lang="it">

<?php
require_once 'auth_check.php';
?>
<head>
        <link rel="icon" type="image/x-icon" href="../image/favicon.ico">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listino prezzi Admin - Camunin</title>
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
        
        /* Form */
        .form-row {
            display: grid;
            grid-template-columns: 2fr 1fr auto;
            gap: 15px;
            margin-bottom: 15px;
            align-items: end;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
        }
        
        .form-group label {
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }
        
        .form-group input {
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #db7343;
            box-shadow: 0 0 0 3px rgba(219, 115, 67, 0.1);
        }
        
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
        
        .btn-danger {
            background-color: #dc3545;
            color: white;
            padding: 8px 15px;
            font-size: 12px;
        }
        
        .btn-danger:hover {
            background-color: #c82333;
        }
        
        /* Table */
        .price-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .price-table thead {
            background: #f8f8f8;
        }
        
        .price-table th {
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #e0e0e0;
        }
        
        .price-table td {
            padding: 12px;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .price-table tbody tr:hover {
            background: #f8f8f8;
        }
        
        /* Toggle Button */
        .toggle-container {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px;
            background: #f8f8f8;
            border-radius: 8px;
        }
        
        .toggle-switch {
            position: relative;
            width: 70px;
            height: 34px;
        }
        
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 34px;
        }
        
        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }
        
        .toggle-switch input:checked + .toggle-slider {
            background-color: #4caf50;
        }
        
        .toggle-switch input:checked + .toggle-slider:before {
            transform: translateX(36px);
        }
        
        .toggle-label {
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }
        
        .toggle-status {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }
        
        .status-online {
            background: #d4edda;
            color: #155724;
        }
        
        .status-offline {
            background: #f8d7da;
            color: #721c24;
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
        
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .price-table {
                font-size: 12px;
            }
            
            .price-table th,
            .price-table td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-left">
            <button class="menu-toggle" onclick="toggleSidebar()">☰</button>
            <h1>Listino prezzi Admin</h1>
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
            <li><a href="./" class="active">📊 Listino Prezzi</a></li>
            <li><a href="galleria.php">⚙️ Galleria</a></li>
            <li><a href="logout.php">🚪 Logout</a></li>
        </ul>
    </div>

    <!-- Overlay -->
    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

    <!-- Main Content -->
    <div class="main-content">
        <h2 class="page-title">Gestione Listino Prezzi</h2>

        <div id="alertContainer"></div>

        <!-- Alta Stagione -->
        <div class="section">
            <h3 class="section-title">🌞 Alta Stagione</h3>
            
            <form id="formAltaStagione">
                <div class="form-row">
                    <div class="form-group">
                        <label for="descAltaStagione">Descrizione</label>
                        <input type="text" id="descAltaStagione" name="descrizione" required placeholder="Es: Camera Doppia">
                    </div>
                    <div class="form-group">
                        <label for="prezzoAltaStagione">Prezzo (€)</label>
                        <input type="number" id="prezzoAltaStagione" name="prezzo" step="0.01" required placeholder="0.00">
                    </div>
                    <div class="form-group">
                        <label style="visibility: hidden;">Azione</label>
                        <button type="submit" class="btn btn-primary">+ Aggiungi</button>
                    </div>
                </div>
            </form>

            <table class="price-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descrizione</th>
                        <th>Prezzo</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody id="tableAltaStagione">
                    <tr>
                        <td colspan="4" style="text-align: center; color: #999;">Caricamento...</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Bassa Stagione -->
        <div class="section">
            <h3 class="section-title">❄️ Bassa Stagione</h3>
            
            <form id="formBassaStagione">
                <div class="form-row">
                    <div class="form-group">
                        <label for="descBassaStagione">Descrizione</label>
                        <input type="text" id="descBassaStagione" name="descrizione" required placeholder="Es: Camera Doppia">
                    </div>
                    <div class="form-group">
                        <label for="prezzoBassaStagione">Prezzo (€)</label>
                        <input type="number" id="prezzoBassaStagione" name="prezzo" step="0.01" required placeholder="0.00">
                    </div>
                    <div class="form-group">
                        <label style="visibility: hidden;">Azione</label>
                        <button type="submit" class="btn btn-primary">+ Aggiungi</button>
                    </div>
                </div>
            </form>

            <table class="price-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descrizione</th>
                        <th>Prezzo</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody id="tableBassaStagione">
                    <tr>
                        <td colspan="4" style="text-align: center; color: #999;">Caricamento...</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Stato Sito -->
        <div class="section">
            <h3 class="section-title">🌐 Stato Listino Online</h3>
            
            <div class="toggle-container">
                <span class="toggle-label">Listino Online:</span>
                <label class="toggle-switch">
                    <input type="checkbox" id="toggleOnline" onchange="toggleListino()">
                    <span class="toggle-slider"></span>
                </label>
                <span class="toggle-status" id="statusLabel">
                    Offline
                </span>
            </div>
        </div>
    </div>

    <script>
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
            }, 3000);
        }

        // Load Alta Stagione
        async function loadAltaStagione() {
            try {
                const response = await fetch('api_prezzi.php?action=getAltaStagione');
                const data = await response.json();
                
                const tbody = document.getElementById('tableAltaStagione');
                
                if (data.success && data.data.length > 0) {
                    tbody.innerHTML = data.data.map(item => `
                        <tr>
                            <td>${item.id}</td>
                            <td>${item.descrizione}</td>
                            <td>€ ${parseFloat(item.prezzo).toFixed(2)}</td>
                            <td>
                                <button class="btn btn-danger" onclick="deletePrezzo('alta', ${item.id})">🗑️ Elimina</button>
                            </td>
                        </tr>
                    `).join('');
                } else {
                    tbody.innerHTML = '<tr><td colspan="4" style="text-align: center; color: #999;">Nessun prezzo inserito</td></tr>';
                }
            } catch (error) {
                console.error('Errore caricamento alta stagione:', error);
            }
        }

        // Load Bassa Stagione
        async function loadBassaStagione() {
            try {
                const response = await fetch('api_prezzi.php?action=getBassaStagione');
                const data = await response.json();
                
                const tbody = document.getElementById('tableBassaStagione');
                
                if (data.success && data.data.length > 0) {
                    tbody.innerHTML = data.data.map(item => `
                        <tr>
                            <td>${item.id}</td>
                            <td>${item.descrizione}</td>
                            <td>€ ${parseFloat(item.prezzo).toFixed(2)}</td>
                            <td>
                                <button class="btn btn-danger" onclick="deletePrezzo('bassa', ${item.id})">🗑️ Elimina</button>
                            </td>
                        </tr>
                    `).join('');
                } else {
                    tbody.innerHTML = '<tr><td colspan="4" style="text-align: center; color: #999;">Nessun prezzo inserito</td></tr>';
                }
            } catch (error) {
                console.error('Errore caricamento bassa stagione:', error);
            }
        }

        // Load Online Status
        async function loadOnlineStatus() {
            try {
                const response = await fetch('api_prezzi.php?action=getOnlineStatus');
                const data = await response.json();
                
                if (data.success) {
                    const isOnline = data.online === 'si';
                    document.getElementById('toggleOnline').checked = isOnline;
                    updateStatusLabel(isOnline);
                }
            } catch (error) {
                console.error('Errore caricamento stato online:', error);
            }
        }

        // Update Status Label
        function updateStatusLabel(isOnline) {
            const label = document.getElementById('statusLabel');
            if (isOnline) {
                label.textContent = '✓ Online';
                label.className = 'toggle-status status-online';
            } else {
                label.textContent = '✕ Offline';
                label.className = 'toggle-status status-offline';
            }
        }

        // Toggle Listino
        async function toggleListino() {
            const isOnline = document.getElementById('toggleOnline').checked;
            
            try {
                const formData = new FormData();
                formData.append('action', 'setOnlineStatus');
                formData.append('online', isOnline ? 'si' : 'no');
                
                const response = await fetch('api_prezzi.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    updateStatusLabel(isOnline);
                    showAlert(`Listino ${isOnline ? 'online' : 'offline'}!`, 'success');
                } else {
                    showAlert('Errore nell\'aggiornamento dello stato', 'error');
                }
            } catch (error) {
                console.error('Errore toggle listino:', error);
                showAlert('Errore di connessione', 'error');
            }
        }

        // Add Alta Stagione
        document.getElementById('formAltaStagione').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            formData.append('action', 'addAltaStagione');
            
            try {
                const response = await fetch('api_prezzi.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showAlert('Prezzo alta stagione aggiunto!', 'success');
                    e.target.reset();
                    loadAltaStagione();
                } else {
                    showAlert(data.message || 'Errore nell\'aggiunta', 'error');
                }
            } catch (error) {
                console.error('Errore:', error);
                showAlert('Errore di connessione', 'error');
            }
        });

        // Add Bassa Stagione
        document.getElementById('formBassaStagione').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            formData.append('action', 'addBassaStagione');
            
            try {
                const response = await fetch('api_prezzi.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showAlert('Prezzo bassa stagione aggiunto!', 'success');
                    e.target.reset();
                    loadBassaStagione();
                } else {
                    showAlert(data.message || 'Errore nell\'aggiunta', 'error');
                }
            } catch (error) {
                console.error('Errore:', error);
                showAlert('Errore di connessione', 'error');
            }
        });

        // Delete Prezzo
        async function deletePrezzo(tipo, id) {
            if (!confirm('Sei sicuro di voler eliminare questo prezzo?')) return;
            
            try {
                const formData = new FormData();
                formData.append('action', tipo === 'alta' ? 'deleteAltaStagione' : 'deleteBassaStagione');
                formData.append('id', id);
                
                const response = await fetch('api_prezzi.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showAlert('Prezzo eliminato!', 'success');
                    if (tipo === 'alta') {
                        loadAltaStagione();
                    } else {
                        loadBassaStagione();
                    }
                } else {
                    showAlert(data.message || 'Errore nell\'eliminazione', 'error');
                }
            } catch (error) {
                console.error('Errore:', error);
                showAlert('Errore di connessione', 'error');
            }
        }

        // Initialize
        window.addEventListener('DOMContentLoaded', () => {
            loadAltaStagione();
            loadBassaStagione();
            loadOnlineStatus();
        });
    </script>
</body>
</html>