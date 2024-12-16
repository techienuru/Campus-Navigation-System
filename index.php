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
    <title>Campus Naviagtion System</title>
    <link rel="stylesheet" type="text/css" href="./style.css">
    <!-- <link rel="stylesheet" href="responsive.css"> -->
</head>

<body>
    <!-- *****container ***** -->
    <div class="container">
        <div class="row">
            <header>
                <a href="index.php"><img src="images/nsuklogo.png" alt="logo"></a>
                <nav class="navbar">
                    <a href="index.php">Home</a>
                    <a href="places.php">Explore Campus</a>
                    <a href="navigate.php">Navigate</a>
                    <a href="login.php">Login</a>
                </nav>
            </header>
            <div class="image-box">
                <img src="images/logo.png" alt="nav">
            </div>
        </div>
    </div>
    <!-- *****content***** -->
    <div class="content">
        <div class="caption">
            <h1>Welcome to <span>CNS</span></h1>
            <p>NASARAWA STATE UNIVERSITY CAMPUS NAVIGATION SYSTEM. Our Campus navigation system is designed to
                make your experience at Nasarawa State University, Keffi (NSUK) smoother, more efficient, and
                enjoyable. wheather you're a student, or a visitor our University system is here to guide you
                through the campus seamlessly.</p>
            <a href="navigate.php">Navigate Campus</a>
        </div>

    </div>
    </div>
    </div>

    <!-- *****popular place ***** -->
    <div class="plcs-header">
        <h1>POPULAR PLACES ON CAMPUS</h1>
    </div>
    <div class="mssn-excos">
        <?php
        $sql = $object->fetchPopularPlacesFrmDB();
        while ($row = $sql->fetch_assoc()) {
        ?>

            <div class="excos1">
                <div class="Ameer">
                    <a href="./places-details.php?place_id='<?php echo $row["place_id"] ?>'"><img src="./places/<?php echo $row["image_name"]; ?>" alt="Faculty"></a>
                </div>
                <div class="content-par">
                    <a href="./places-details.php?place_id='<?php echo $row["place_id"] ?>'">
                        <p><?php echo $row["name"] ?></p>
                    </a>
                </div>
            </div>
        <?php } ?>

    </div>

    <div class="btn" style="margin: 0 auto; width:fit-content;">
        <a href="places.php">View More</a>
    </div>

    <div class="senate-building">
        <h1>Nasarawa State University</h1>
        <h2>Senate Buildings</h2>
        <img src="./images/STN.jpg" alt="University Senate Building">
    </div>

    <footer>
        <p>&copy; 2024 Campus Navigation System. All Rights Reserved.</p>
    </footer>
    <script src="script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>