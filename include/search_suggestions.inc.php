<?php
header('Content-Type: application/json');

$searchQuery = isset($_GET['q']) ? trim($_GET['q']) : '';

if ($searchQuery === '') {
    echo json_encode([]);
    exit();
}

try {
    require_once "dbh.inc.php";

    $sql = "SELECT id, event_name, event_location, image FROM events 
            WHERE event_name LIKE :query OR description LIKE :query OR event_location LIKE :query 
            LIMIT 6;";
            
    $stmt = $pdo->prepare($sql);
    $wildcardQuery = '%' . $searchQuery . '%';
    $stmt->bindParam(':query', $wildcardQuery, PDO::PARAM_STR);
    $stmt->execute();
    
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results);
    exit();

} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Database exception handling processing context."]);
    exit();
}