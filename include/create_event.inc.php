<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $eventName = trim($_POST["eventName"]);
    $eventCategory = trim($_POST["eventCategory"]);
    $eventTime = trim($_POST["eventTime"]);
    $eventPrice = floatval($_POST["eventPrice"]);
    $eventLocation = trim($_POST["eventLocation"]);
    $eventDescription = trim($_POST["eventDescription"]);
    $eventImageFile = $_FILES["eventImage"];

    try {
        require_once "dbh.inc.php";
        require_once "events_model.inc.php";
        require_once "config_session.inc.php";

        $errors = [];

        if (empty($eventName) || empty($eventTime) || empty($eventLocation) || empty($eventDescription) || empty($eventCategory)) {
            $errors["empty_fields"] = "Te rugăm să completezi toate câmpurile obligatorii!";
        }

        if (!$eventImageFile || $eventImageFile["error"] !== UPLOAD_ERR_OK) {
            $errors["image_error"] = "Eroare la încărcarea imaginii de copertă.";
        } else {
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            $imageExtension = strtolower(pathinfo($eventImageFile["name"], PATHINFO_EXTENSION));
            
            if (!in_array($imageExtension, $allowedExtensions)) {
                $errors["image_error"] = "Formatul imaginii nu este valid (doar JPG, PNG, WEBP).";
            }
        }

        if (!empty($errors)) {
            $_SESSION["create_event_errors"] = $errors;
            header("Location: ../createEvent.php");
            die();
        }

        $newImageName = "event_" . time() . "_" . uniqid("", true) . "." . $imageExtension;
        
        $uploadTargetDirectory = "../uploads/";
        if (!is_dir($uploadTargetDirectory)) {
            mkdir($uploadTargetDirectory, 0755, true);
        }
        
        $destinationPath = $uploadTargetDirectory . $newImageName;

        if (move_uploaded_file($eventImageFile["tmp_name"], $destinationPath)) {
            $databaseImagePath = "uploads/" . $newImageName;

            create_event($pdo, $eventName, $eventTime, $eventLocation, $databaseImagePath, $eventPrice, $eventDescription, $_SESSION["user_id"], $eventCategory);

            $_SESSION["create_event_success"] = "Evenimentul a fost adăugat cu succes!";
            header("Location: ../createEvent.php");
            die();
        } else {
            $_SESSION["create_event_errors"] = ["upload_failed" => "Nu s-a putut salva fișierul de imagine pe server."];
            header("Location: ../createEvent.php");
            die();
        }

    } catch (PDOException $e) {
        $_SESSION["create_event_errors"] = ["db_error" => "Eroare de conexiune la baza de date: " . $e->getMessage()];
        header("Location: ../createEvent.php");
        die();
    }
} else {
    header("Location: ../createEvent.php");
    die();
}