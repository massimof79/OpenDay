<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

try {
    $pdo = new PDO('mysql:host=localhost;dbname=openday;charset=utf8mb4', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "INSERT INTO presenze (cognome, nome, scuola, data_nascita, indirizzo) 
            VALUES (:cognome, :nome, :scuola, :data_nascita, :indirizzo)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':cognome' => $data['cognome'],
        ':nome' => $data['nome'],
        ':scuola' => $data['scuola'],
        ':data_nascita' => $data['data_nascita'],
        ':indirizzo' => $data['indirizzo']
    ]);
    
    echo json_encode(['success' => true, 'message' => 'Presenza registrata con successo!']);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Errore: ' . $e->getMessage()]);
}
?>