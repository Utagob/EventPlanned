<?php
    require_once 'include/config_session.inc.php';
    require_once 'include/login_view.inc.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/signUp.css">
</head>

<body>
<div class="Form">
    <h3 class="Form-title">LogIn</h3>
    <form action="include/login.inc.php" method="POST" class="Form-input-section">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="pwd" placeholder="Password">
        <button>LogIn</button>
        <button>SignUp</button>
    </form>
    <?php check_login_errors();?>
</div>


    <h3 class="Form-title">Logout</h3>
    <form action="include/logout.inc.php" method="POST" class="Form-input-section">
        <button>Logout</button>
    </form>

</body>

</html>