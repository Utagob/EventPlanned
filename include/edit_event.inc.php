<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $eventId = intval($_POST["eventId"]);
    $eventName = trim($_POST["eventName"]);
    $eventCategory = trim($_POST["eventCategory"]);
    $eventTime = trim($_POST["eventTime"]);
    $eventPrice = floatval($_POST["eventPrice"]);
    $eventLocation = trim($_POST["eventLocation"]);
    $eventDescription = trim($_POST["eventDescription"]);
    $existingImage = trim($_POST["existingImage"]);
    $eventImageFile = $_FILES["eventImage"];

    try {
        require_once "dbh.inc.php";
        require_once "events_model.inc.php";
        require_once "config_session.inc.php";

        $errors = [];

        // Verify entity ownership
        $eventData = get_single_event($pdo, $eventId);
        if (!$eventData || (int)$eventData['organiser_id'] !== (int)$_SESSION["user_id"]) {
            header("Location: ../profile.php");
            die();
        }

        if (empty($eventName) || empty($eventTime) || empty($eventLocation) || empty($eventDescription) || empty($eventCategory)) {
            $errors["empty_fields"] = "Te rugăm să completezi toate câmpurile obligatorii!";
        }

        $databaseImagePath = $existingImage;

        // Process picture optionally if a new file is uploaded
        if ($eventImageFile && $eventImageFile["error"] === UPLOAD_ERR_OK) {
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            $imageExtension = strtolower(pathinfo($eventImageFile["name"], PATHINFO_EXTENSION));
            
            if (!in_array($imageExtension, $allowedExtensions)) {
                $errors["image_error"] = "Formatul imaginii nu este valid (JPG, JPEG, PNG, WEBP sunt acceptate).";
            }

            if (empty($errors)) {
                $newImageName = "event_" . time() . "_" . uniqid("", true) . "." . $imageExtension;
                $uploadTargetDirectory = "../uploads/";
                if (!is_dir($uploadTargetDirectory)) {
                    mkdir($uploadTargetDirectory, 0755, true);
                }
                if (move_uploaded_file($eventImageFile["tmp_name"], $uploadTargetDirectory . $newImageName)) {
                    $databaseImagePath = "uploads/" . $newImageName;
                } else {
                    $errors["upload_failed"] = "Nu s-a putut salva fișierul de imagine pe server.";
                }
            }
        }

        if (!empty($errors)) {
            $_SESSION["edit_event_errors"] = $errors;
            header("Location: ../editEvent.php?id=" . $eventId);
            die();
        }

        update_event($pdo, $eventId, $eventName, $eventTime, $eventLocation, $databaseImagePath, $eventPrice, $eventDescription, $eventCategory);

        $_SESSION["edit_event_success"] = "Evenimentul a fost modificat cu succes!";
        header("Location: ../editEvent.php?id=" . $eventId);
        die();

    } catch (PDOException $e) {
        $_SESSION["edit_event_errors"] = ["db_error" => "Eroare de conexiune la baza de date."];
        header("Location: ../editEvent.php?id=" . $eventId);
        die();
    }
} else {
    header("Location: ../profile.php");
    die();
}