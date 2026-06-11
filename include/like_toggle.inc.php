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

        // 1. Fetch current liked_events string from the users table
        $query = "SELECT liked_events FROM users WHERE id = :user_id;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $likedEvents = [];
        if ($user && !empty($user['liked_events'])) {
            // Split string into an array, filtering out empty values
            $likedEvents = array_filter(explode(',', $user['liked_events']));
        }

        // 2. Toggle the ID in the array
        if (in_array($eventId, $likedEvents)) {
            // If already liked, remove it (Unlike operation)
            $likedEvents = array_diff($likedEvents, [$eventId]);
            $action = "unliked";
        } else {
            // If not liked yet, add it (Like operation)
            $likedEvents[] = $eventId;
            $action = "liked";
        }

        // 3. Re-combine array back into a comma-separated string
        $newLikedString = implode(',', $likedEvents);

        // 4. Update the database table row
        $updateQuery = "UPDATE users SET liked_events = :liked_events WHERE id = :user_id;";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->bindParam(':liked_events', $newLikedString, PDO::PARAM_STR);
        $updateStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $updateStmt->execute();

        // Send confirmation back to JavaScript
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