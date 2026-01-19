

<?php
// Avvia la sessione
session_start();

// Configurazione database
$host = 'localhost';
$dbname = 'my_camunin';
$username = 'root';
$password = '';

// Connessione al database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Errore di connessione: " . $e->getMessage());
}

// Variabili per messaggi
$errore = '';

// Gestione del form di login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username'] ?? '');
    $pass = $_POST['password'] ?? '';
    
    if (empty($user) || empty($pass)) {
        $errore = 'Inserisci username e password';
    } else {
        // Prepara la query per evitare SQL injection
        $stmt = $pdo->prepare("SELECT id, username, password FROM login WHERE username = :username LIMIT 1");
        $stmt->bindParam(':username', $user);
        $stmt->execute();
        
        $utente = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($utente && password_verify($pass, $utente['password'])) {
            // Login riuscito
            $_SESSION['admin_logged'] = true;
            $_SESSION['admin_id'] = $utente['id'];
            $_SESSION['admin_username'] = $utente['username'];
            
            // Reindirizza a prezzi.php
            header('Location: prezzi.php');
            exit;
        } else {
            $errore = 'Username o password non validi';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Camunin</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #db7343;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-header h1 {
            color: #db7343;
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .login-header p {
            color: #666;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }
        
        .form-group input {
            width: 100%;
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
        
        .error-message {
            background-color: #fee;
            color: #c33;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
            border-left: 4px solid #c33;
        }
        
        .btn-login {
            width: 100%;
            padding: 14px;
            background-color: #db7343;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            background-color: #c56237;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(219, 115, 67, 0.3);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .login-footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #999;
        }
        
        .icon-lock {
            width: 60px;
            height: 60px;
            margin: 0 auto 20px;
            background-color: #db7343;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 30px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <div class="icon-lock">🔒</div>
            <h1>Area Admin</h1>
            <p>Camunin - Accesso riservato</p>
        </div>
        
        <?php if ($errore): ?>
            <div class="error-message">
                ⚠️ <?php echo htmlspecialchars($errore); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    placeholder="Inserisci username"
                    value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                    required
                    autocomplete="username"
                >
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="Inserisci password"
                    required
                    autocomplete="current-password"
                >
            </div>
            
            <button type="submit" class="btn-login">
                Accedi
            </button>
        </form>
        
        <div class="login-footer">
            © 2025 Camunin. Tutti i diritti riservati.
        </div>
    </div>
</body>
</html>