<?php
require_once 'config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION["user_id"])) {
    $userId = $_SESSION["user_id"];
    $eventId = filter_input(INPUT_POST, 'event_id', FILTER_VALIDATE_INT);

    if (!$eventId) {
        echo json_encode(["status" => "error", "message" => "ID de eveniment invalid."]);
        exit();
    }

    try {
        require_once 'dbh.inc.php';
        require_once 'events_model.inc.php';

        if (delete_event($pdo, $eventId, $userId)) {
            header('Content-Type: application/json');
            echo json_encode(["status" => "success"]);
            exit();
        } else {
            header('Content-Type: application/json');
            echo json_encode(["status" => "error", "message" => "Eroare la ștergerea evenimentului."]);
            exit();
        }
    } catch (PDOException $e) {
        header('Content-Type: application/json');
        echo json_encode(["status" => "error", "message" => "Eroare de bază de date."]);
        exit();
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(["status" => "error", "message" => "Acces neautorizat."]);
    exit();
}