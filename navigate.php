<?php
session_start();
include_once "includes/connect.php";
include_once "includes/classes.php";

$object = new userPage($connect);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $object->processNavigationResult();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SNC Map Page</title>
    <style>
        /* Add some basic styling */
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 90%;
            background-color: black;
            padding: 20px 100px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 99;
        }

        header a {
            width: 30%;
            margin-left: -5.1%;
        }

        .navbar {
            color: #fff;
            user-select: none;
        }

        .navbar a {
            position: relative;
            font-size: 1.1em;
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            margin-left: 40px;
            margin-right: 30px;
        }

        .navbar a:hover {
            color: #008000;
        }

        .navi {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 10px;
            font-size: 2em;
            font-weight: 800;
            color: black;
            letter-spacing: 1px;
        }

        .navi span {
            color: #008000;
        }

        #controls {
            margin-top: 50px;
            margin: 10px;
            padding: 10px;
            background-color: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            border-radius: 4px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #controls input {
            width: 250px;
            padding: 10px;
            margin-bottom: 10px;
        }

        #controls button {
            padding: 10px;
        }

        .images {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }

        .images img {
            width: 400px;
            height: 400px;
            object-fit: cover;
            border: 2px solid #ccc;
            border-radius: 10px;
        }

        .directions {
            margin-top: 20px;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;

        }

        #directions-list {
            list-style-type: none;
            padding: 0;
        }

        #directions-list li {
            margin-bottom: 10px;
            font-size: 1.1em;
        }
    </style>
</head>

<header>
    <a href="index.php"><img src="images/nsuklogo.png" alt="logo"></a>
    <nav class="navbar">
        <a href="index.php">Home</a>
        <a href="places.php">Explore Campus</a>
        <a href="navigate.php">Navigate</a>
    </nav>
</header>

<body>
    <br><br><br><br><br><br>
    <div class="navi">
        <p>NAVIGATE <span>CAMPUS</span></p>
    </div>

    <div id="controls">
        <!-- Location and Destination Input Forms -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" autocomplete="off">
            <!-- Current Location Input -->
            <input list="locations" id="location_input" name="location_name" placeholder="Enter your current location" required>
            <datalist id="locations">
                <?php
                $sql = $object->fetchPlacesFrmDB();
                while ($row = $sql->fetch_assoc()) {
                ?>
                    <option value="<?php echo $row["name"]; ?>" data-place-id="<?php echo $row["place_id"]; ?>"></option>
                <?php } ?>
            </datalist>

            <!-- Hidden input to store the place_id for location -->
            <input type="hidden" name="location_id" id="location_id">

            <!-- Destination Input -->
            <input list="destinations" id="destination_input" name="destination_name" placeholder="Enter your destination" required>
            <datalist id="destinations">
                <?php
                $sql = $object->fetchPlacesFrmDB();
                while ($row = $sql->fetch_assoc()) {
                ?>
                    <option value="<?php echo $row["name"]; ?>" data-place-id="<?php echo $row["place_id"]; ?>"></option>
                <?php } ?>
            </datalist>

            <!-- Hidden input to store the place_id for destination -->
            <input type="hidden" name="destination_id" id="destination_id">

            <button type="submit">Navigate</button>
        </form>
    </div>

    <!-- Navigation Result is displayed dynamically here -->
    <?php
    echo $object->htmlNavigationElement;
    ?>
    <script>
        // Handle location selection and place_id population
        document.getElementById('location_input').addEventListener('input', function() {
            const inputValue = this.value;
            const datalist = document.getElementById('locations');
            const options = datalist.querySelectorAll('option');

            // Loop through the datalist options and find the matching one for location
            options.forEach(option => {
                if (option.value === inputValue) {
                    // Set the place_id to the hidden input for location
                    document.getElementById('location_id').value = option.getAttribute('data-place-id');
                }
            });
        });

        // Handle destination selection and place_id population
        document.getElementById('destination_input').addEventListener('input', function() {
            const inputValue = this.value;
            const datalist = document.getElementById('destinations');
            const options = datalist.querySelectorAll('option');

            // Loop through the datalist options and find the matching one for destination
            options.forEach(option => {
                if (option.value === inputValue) {
                    // Set the place_id to the hidden input for destination
                    document.getElementById('destination_id').value = option.getAttribute('data-place-id');
                }
            });
        });
    </script>
</body>

</html>