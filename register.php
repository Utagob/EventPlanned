 <?php
    require_once 'include/config_session.inc.php';
    require_once 'include/login_view.inc.php';
    require_once 'include/signup_view.inc.php';

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if (isset($_POST['home'])) {
            header('Location: index.php');
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <div class="access-form" method="POST">
        <div class="signup">
            <form action="include/signup.inc.php" method="POST" class="Form-input-section">
            <?php signup_inputs();?>
            <button>Sign Up</button>
            </form>
            <?php check_signup_errors();?>
        </div>
        <div class="login">
            <form action="include/login.inc.php" method="POST" class="Form-input-section">
                <input type="text" name="username" placeholder="Username">
                <input type="password" name="pwd" placeholder="Password">
                <button>Log In</button>
            </form>
        <?php check_login_errors();?>
        </div>
        <button class="open-form" name="signup">Sign Up</button>
        <button class="open-form" name="login">Log In</button>
        <form method="POST">
            <button class="open-form home" name="home" type="submit">Home</button>
        </form>
    </div>

<script src="js/register.js"></script>
</body>
</html>