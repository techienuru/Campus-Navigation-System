<?php
session_start();
include_once "./includes/connect.php";
include_once "./includes/classes.php";

$object = new userPage($connect);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Campus</title>
    <link rel="stylesheet" type="text/css" href="places.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="responsive.css">
</head>

<body>
    <header>
        <a href="index.php"><img src="images/nsuklogo.png" alt="logo"></a>
        <nav class="navbar">
            <a href="index.php">Home</a>
            <a href="places.php">Explore Campus</a>
            <a href="navigate.php">Navigate</a>
        </nav>
    </header>

    <?php
    if (isset($_GET["place_id"])) {
        $object->fetchplaceDetails($_GET["place_id"]);
    ?>
        <div class="developers">
            <div class="dev-header">
                <p><span><?php echo $object->place_name; ?></p>
            </div>

            <div style="margin:20px 90px 10px;">
                <img src="./places/<?php echo $object->image_name; ?>" alt="" width="100%" height="700" style="object-fit: cover;">
                <div style="margin:30px 0px 30px 0px;text-align:justify;">
                    <?php echo $object->description; ?>
                </div>
            </div>
        </div>
    <?php
    }
    ?>

</body>