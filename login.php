<?php
session_start();
include_once "includes/connect.php";
include_once "includes/classes.php";

$object = new login($connect);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $object->collectUserInput();
    $object->checkCredentials();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" type="text/css" href="login.css">
</head>

<body>
    <!-- *****login form ***** -->
    <div class="wrapper">
        <span class="icon-close">
            <ion-icon name="close"></ion-icon>
        </span>
        <div class="form-box login">
            <h2>Admin Login</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="input-box">
                    <span class="icon">
                        <ion-icon name="mail"></ion-icon>
                    </span>
                    <input type="email" name="email" id="email" required>
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <input type="password" id="password" name="password" required>
                    <label>Password</label>
                </div>
                <button type="submit" class="btn">Login</button>
            </form>
            <a href="./index.php" class="back-to-home">Back to Home</a>
        </div>
    </div>
</body>

</html>