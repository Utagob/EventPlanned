<?php

declare(strict_types= 1);

function all_events(object $pdo, ?int $userId = null) {
    if ($userId !== null) {
        $query = 'SELECT *, IF(FIND_IN_SET(:user_id, liked) > 0, 1, 0) AS is_liked FROM events;';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    } else {
        $query = 'SELECT *, 0 AS is_liked FROM events;';
        $stmt = $pdo->prepare($query);
    }
    
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_event(object $pdo, string $event_name) {
    $query = 'SELECT * FROM events WHERE event_name = :event_name;';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':event_name', $event_name);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function create_event(object $pdo, string $eventName, string $eventTime, string $eventLocation, string $eventImage, float $eventPrice, string $eventDescription, int $eventOrganiserId, string $eventCategory) {
    $query = "INSERT INTO events (event_name, event_time, event_location, image, price, description, organiser_id, label) 
              VALUES (:event_name, :event_time, :event_location, :image, :price, :description, :user_id, :eventCategory);";
    
    $stmt = $pdo->prepare($query);
    
    $stmt->bindParam(":event_name", $eventName);
    $stmt->bindParam(":event_time", $eventTime);
    $stmt->bindParam(":event_location", $eventLocation);
    $stmt->bindParam(":image", $eventImage);
    $stmt->bindParam(":price", $eventPrice);
    $stmt->bindParam(":description", $eventDescription);
    $stmt->bindParam(":user_id", $eventOrganiserId);
    $stmt->bindParam(":eventCategory", $eventCategory);
    
    $stmt->execute();
}

function toggle_event_like(object $pdo, int $userId, int $eventId): string {
    $queryEvent = "SELECT liked FROM events WHERE id = :event_id;";
    $stmtEvent = $pdo->prepare($queryEvent);
    $stmtEvent->execute([':event_id' => $eventId]);
    $event = $stmtEvent->fetch(PDO::FETCH_ASSOC);

    $queryUser = "SELECT liked_events FROM users WHERE id = :user_id;";
    $stmtUser = $pdo->prepare($queryUser);
    $stmtUser->execute([':user_id' => $userId]);
    $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

    if (!$event || !$user) {
        return 'error';
    }

    $likedUsers = !empty($event['liked']) ? explode(',', $event['liked']) : [];
    $likedUsers = array_map('trim', $likedUsers);
    $likedUsers = array_filter($likedUsers);

    $likedEvents = !empty($user['liked_events']) ? explode(',', $user['liked_events']) : [];
    $likedEvents = array_map('trim', $likedEvents);
    $likedEvents = array_filter($likedEvents);

    if (in_array((string)$userId, $likedUsers)) {
        $likedUsers = array_diff($likedUsers, [(string)$userId]);
        $likedEvents = array_diff($likedEvents, [(string)$eventId]);
        $status = 'unliked';
    } else {
        $likedUsers[] = (string)$userId;
        $likedEvents[] = (string)$eventId;
        $status = 'liked';
    }

    $newLikedUsers = implode(',', $likedUsers);
    $newLikedEvents = implode(',', $likedEvents);

    $updateEvent = $pdo->prepare("UPDATE events SET liked = :liked WHERE id = :event_id;");
    $updateEvent->execute([':liked' => $newLikedUsers, ':event_id' => $eventId]);

    $updateUser = $pdo->prepare("UPDATE users SET liked_events = :liked_events WHERE id = :user_id;");
    $updateUser->execute([':liked_events' => $newLikedEvents, ':user_id' => $userId]);

    return $status;
}