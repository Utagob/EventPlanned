<?php

try {
    require_once("dbh.inc.php");
    require_once("events_model.inc.php");
    require_once("events_view.inc.php");

    $userId = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
    $result = all_events($pdo, $userId);

    show_events_by_label($result);

} catch(PDOException $e){
    echo "Error fetching data: " . $e->getMessage();
}