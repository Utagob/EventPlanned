<?php
    require_once 'include/config_session.inc.php';
    require_once 'include/signup_view.inc.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Sign Up</title>
</head>

<body>
    <h3>Sign Up</h3>

    <form action="include/signup.inc.php" method="POST">
        <?php
        signup_inputs();
        ?>
        <button>SignUp</button>
    </form>

    <?php
        check_signup_errors();
    ?>

</body>

</html>