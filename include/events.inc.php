<?php

try {
    require_once("dbh.inc.php");
    require_once("events_model.inc.php");
    require_once("events_view.inc.php");

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $userId = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;

    // Capture filter variables safely from parameters
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $category = isset($_GET['category']) ? trim($_GET['category']) : '';

    if ($search !== '' || $category !== '') {
        // Dynamic search conditional builder
        $query = "SELECT * FROM events WHERE 1=1";
        $params = [];

        if ($search !== '') {
            $query .= " AND (event_name LIKE :search OR description LIKE :search OR event_location LIKE :search)";
            $params[':search'] = '%' . $search . '%';
        }

        if ($category !== '') {
            $query .= " AND label = :category";
            $params[':category'] = $category;
        }

        $query .= " ORDER BY id DESC;";
        
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Fallback default execution configuration when parameters are empty
        $result = all_events($pdo, $userId);
    }

    if (!empty($result)) {
        show_events_by_label($result);
    } else {
        echo '<p class="no-events-found" style="text-align:center; width:100%; grid-column: 1/-1; padding: 40px 0; color: var(--text-2); font-style: italic;">Nu a fost găsit niciun eveniment.</p>';
    }

} catch(PDOException $e){
    echo "Error fetching data: " . $e->getMessage();
}