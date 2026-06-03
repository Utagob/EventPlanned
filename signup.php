<?php
    require_once 'include/config_session.inc.php';
    require_once 'include/signup_view.inc.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/signUp.css">
</head>

<body>
<div class="Form">
    <h3 class="Form-title">Sign Up</h3>
    <form action="include/signup.inc.php" method="POST" class="Form-input-section">
        <?php signup_inputs();?>
        <button>SignUp</button>
        <button>LogIn</button>
    </form>
    <?php check_signup_errors();?>
</div>

</body>

</html>