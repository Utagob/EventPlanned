<?php
require_once 'config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION["user_id"])) {
    $userId = $_SESSION["user_id"];
    $eventId = filter_input(INPUT_POST, 'event_id', FILTER_VALIDATE_INT);

    if (!$eventId) {
        echo json_encode(["status" => "error", "message" => "Invalid Event ID."]);
        exit();
    }

    try {
        require_once 'dbh.inc.php';

        $query = "SELECT liked_events FROM users WHERE id = :user_id;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $likedEvents = [];
        if ($user && !empty($user['liked_events'])) {
            $likedEvents = array_filter(explode(',', $user['liked_events']));
        }

        if (in_array($eventId, $likedEvents)) {
            $likedEvents = array_diff($likedEvents, [$eventId]);
            $action = "unliked";
        } else {
            $likedEvents[] = $eventId;
            $action = "liked";
        }

        $newLikedString = implode(',', $likedEvents);

        $updateQuery = "UPDATE users SET liked_events = :liked_events WHERE id = :user_id;";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->bindParam(':liked_events', $newLikedString, PDO::PARAM_STR);
        $updateStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $updateStmt->execute();

        header('Content-Type: application/json');
        echo json_encode(["status" => "success", "action" => $action]);
        exit();

    } catch (PDOException $e) {
        header('Content-Type: application/json');
        echo json_encode(["status" => "error", "message" => "Database error occurred."]);
        exit();
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(["status" => "error", "message" => "Unauthorized access."]);
    exit();
}