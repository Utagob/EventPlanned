<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit-contact"])) {
    $name = htmlspecialchars($_POST["name"], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST["email"], ENT_QUOTES, 'UTF-8');
    $subject = htmlspecialchars($_POST["subject"], ENT_QUOTES, 'UTF-8');
    $message = htmlspecialchars($_POST["message"], ENT_QUOTES, 'UTF-8');

    try {
        require_once "dbh.inc.php"; 

        $query = "INSERT INTO contact_messages (name, email, subject, message) VALUES (:name, :email, :subject, :message);";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":subject", $subject);
        $stmt->bindParam(":message", $message);

        $stmt->execute();

        $pdo = null;
        $stmt = null;

        header("Location: ../index.php?success=true");
        die();

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../contact.php");
    die();
}