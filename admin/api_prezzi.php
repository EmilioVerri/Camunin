<?php
// api_prezzi.php
session_start();

// Verifica login (opzionale, decommentare se vuoi proteggere l'API)
// if (!isset($_SESSION['admin_logged'])) {
//     echo json_encode(['success' => false, 'message' => 'Non autorizzato']);
//     exit;
// }

header('Content-Type: application/json');

// Configurazione database
$host = 'localhost';
$dbname = 'my_avid4068866';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Errore di connessione: ' . $e->getMessage()]);
    exit;
}

$action = $_REQUEST['action'] ?? '';

switch($action) {
    // GET ALTA STAGIONE
    case 'getAltaStagione':
        try {
            $stmt = $pdo->query("SELECT id, descrizione, prezzo FROM altastagione ORDER BY id DESC");
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(['success' => true, 'data' => $data]);
        } catch(PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        break;
    
    // GET BASSA STAGIONE
    case 'getBassaStagione':
        try {
            $stmt = $pdo->query("SELECT id, descrizione, prezzo FROM bassastagione ORDER BY id DESC");
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(['success' => true, 'data' => $data]);
        } catch(PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        break;
    
    // ADD ALTA STAGIONE
    case 'addAltaStagione':
        try {
            $descrizione = trim($_POST['descrizione'] ?? '');
            $prezzo = floatval($_POST['prezzo'] ?? 0);
            
            if (empty($descrizione) || $prezzo <= 0) {
                echo json_encode(['success' => false, 'message' => 'Dati non validi']);
                exit;
            }
            
            $stmt = $pdo->prepare("INSERT INTO altastagione (descrizione, prezzo) VALUES (:descrizione, :prezzo)");
            $stmt->execute(['descrizione' => $descrizione, 'prezzo' => $prezzo]);
            
            echo json_encode(['success' => true, 'message' => 'Prezzo aggiunto']);
        } catch(PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        break;
    
    // ADD BASSA STAGIONE
    case 'addBassaStagione':
        try {
            $descrizione = trim($_POST['descrizione'] ?? '');
            $prezzo = floatval($_POST['prezzo'] ?? 0);
            
            if (empty($descrizione) || $prezzo <= 0) {
                echo json_encode(['success' => false, 'message' => 'Dati non validi']);
                exit;
            }
            
            $stmt = $pdo->prepare("INSERT INTO bassastagione (descrizione, prezzo) VALUES (:descrizione, :prezzo)");
            $stmt->execute(['descrizione' => $descrizione, 'prezzo' => $prezzo]);
            
            echo json_encode(['success' => true, 'message' => 'Prezzo aggiunto']);
        } catch(PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        break;
    
    // DELETE ALTA STAGIONE
    case 'deleteAltaStagione':
        try {
            $id = intval($_POST['id'] ?? 0);
            
            if ($id <= 0) {
                echo json_encode(['success' => false, 'message' => 'ID non valido']);
                exit;
            }
            
            $stmt = $pdo->prepare("DELETE FROM altastagione WHERE id = :id");
            $stmt->execute(['id' => $id]);
            
            echo json_encode(['success' => true, 'message' => 'Prezzo eliminato']);
        } catch(PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        break;
    
    // DELETE BASSA STAGIONE
    case 'deleteBassaStagione':
        try {
            $id = intval($_POST['id'] ?? 0);
            
            if ($id <= 0) {
                echo json_encode(['success' => false, 'message' => 'ID non valido']);
                exit;
            }
            
            $stmt = $pdo->prepare("DELETE FROM bassastagione WHERE id = :id");
            $stmt->execute(['id' => $id]);
            
            echo json_encode(['success' => true, 'message' => 'Prezzo eliminato']);
        } catch(PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        break;
    
    // GET ONLINE STATUS
    case 'getOnlineStatus':
        try {
            $stmt = $pdo->query("SELECT online FROM onlinelistino ORDER BY id DESC LIMIT 1");
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $online = $row ? $row['online'] : 'no';
            echo json_encode(['success' => true, 'online' => $online]);
        } catch(PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        break;
    
    // SET ONLINE STATUS
    case 'setOnlineStatus':
        try {
            $online = ($_POST['online'] ?? 'no') === 'si' ? 'si' : 'no';
            
            // Verifica se esiste già un record
            $stmt = $pdo->query("SELECT id FROM onlinelistino LIMIT 1");
            $exists = $stmt->fetch();
            
            if ($exists) {
                // Update
                $stmt = $pdo->prepare("UPDATE onlinelistino SET online = :online WHERE id = :id");
                $stmt->execute(['online' => $online, 'id' => $exists['id']]);
            } else {
                // Insert
                $stmt = $pdo->prepare("INSERT INTO onlinelistino (online) VALUES (:online)");
                $stmt->execute(['online' => $online]);
            }
            
            echo json_encode(['success' => true, 'message' => 'Stato aggiornato']);
        } catch(PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        break;
    
    default:
        echo json_encode(['success' => false, 'message' => 'Azione non valida']);
        break;
}
?>