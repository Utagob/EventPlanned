<?php

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        require_once 'dbh.inc.php';
        require_once 'signup_model.inc.php';
        require_once 'signup_contr.inc.php';

        // error handler
        $errors = [];

        if(is_input_empty($username, $password, $email)){
            $errors['empty_input'] = 'Fill in all fields!';
        }
        if(is_email_invalid($email)){
            $errors['invalid_email'] = 'Invalid email used!';
        }
        if(is_username_taken($pdo, $username)){
            $errors['username_used'] = 'Username alredy taken!';
        }
        if(is_email_registered($pdo, $email)){
            $errors['empty_used'] = 'Email already registered!';
        }

        require_once 'config_session.inc.php';

        if($errors){
            $_SESSION['errors_signup'] = $errors;
            header('Location: ../signup.php');
        }
    } catch (PDOException $e) {
        die('Query failed: '.$e->getMessage());
    }
} else {
    header('Location: ../signup.php');
    die();
}