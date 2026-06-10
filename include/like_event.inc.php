<?php
require_once("config_session.inc.php");

header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "error" => "not_logged_in"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "error" => "invalid_request_method"]);
    exit;
}

$input = json_decode(file_get_contents("php://input"), true);
if (!isset($input['event_id'])) {
    echo json_encode(["success" => false, "error" => "missing_event_id"]);
    exit;
}

$eventId = (int)$input['event_id'];
$userId = (int)$_SESSION['user_id'];

try {
    require_once("dbh.inc.php");
    require_once("events_model.inc.php");

    $status = toggle_event_like($pdo, $userId, $eventId);

    echo json_encode(["success" => true, "status" => $status]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => "database_error"]);
}