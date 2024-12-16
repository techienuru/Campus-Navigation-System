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

    <!-- explore header -->
    <div class="developers">
        <div class="dev-header">
            <p><span>BUILDINGS</span> AND <span>FACULTY</span> ON <span>CAMPUS.</span></p>
        </div>
        <div class="mssn-excos">
            <?php
            $sql = $object->fetchPlacesFrmDB();
            while ($row = $sql->fetch_assoc()) {
            ?>
                <div class="excos1">
                    <div class="Ameer">
                        <a href="./places-details.php?place_id='<?php echo $row["place_id"] ?>'"><img src="./places/<?php echo $row["image_name"]; ?>" alt="faculty"></a>
                    </div>
                    <div class="content">
                        <a href="./places-details.php?place_id='<?php echo $row["place_id"] ?>'">
                            <p><?php echo $row["name"] ?></p>
                        </a>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</body>