<?php
class login
{
    public $connect;
    public $email;
    public $password;
    public $invalid_credential;

    public function __construct($connect)
    {
        $this->connect = $connect;
    }

    public function collectUserInput()
    {
        $this->email = $_POST["email"];
        $this->password = $_POST["password"];
    }

    public function checkCredentials()
    {
        $sql = $this->connect->query("SELECT * FROM `admin` WHERE email = '$this->email' AND password = '$this->password'");

        if ($sql->num_rows > 0) {
            $_SESSION["admin_id"] = $this->collectUserID($sql);
            echo "
                <script>
                    window.location.href='./Admin/dashboard.php';
                </script>
            ";
            die();
        } else {
            $this->showErrorMessage();
        }
    }

    public function collectUserID($sql)
    {
        $result = $sql->fetch_assoc();
        return $result["admin_id"];
    }

    public function showErrorMessage()
    {
        echo '
            <div style="background-color: blueviolet; padding:20px;margin:0px 0px 5px 0px" class="js-error-message">
                <p style="color: white; text-align:center;">Invalid Credential</p>
            </div>
        ';
        echo "
            <script>
                setInterval(()=>{
                    document.querySelector('.js-error-message').style.display='none';
                },3000);
            </script>";
    }
}

class admin
{
    public $connect;
    public $message;
    public $user_email;

    public function __construct($connect)
    {
        $this->connect = $connect;
    }

    public function validateAuthorization()
    {
        if (!isset($_SESSION["admin_id"])) {
            $this->redirectToLoginPage();
            die();
        } else {
            return true;
        }
    }

    public function redirectToLoginPage()
    {
        header("location:../login.php");
    }

    public function fetchUserDetails($session)
    {
        $sql = $this->connect->query("SELECT * FROM `admin` WHERE admin_id = $session");
        $result = $sql->fetch_assoc();
        $this->user_email = $result["email"];
    }

    public function insertIntoDB($sql)
    {
        if ($this->connect->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function showMessage($message_type, $message)
    {
        $this->message = '
            <div class="d-flex justify-content-end" id="message">
                <div class="alert alert-' . $message_type . ' position-absolute">
                    <span class="mr-3">' . $message . '</span> 
                    <button class="close" data-dismiss="alert">&times;</button>
                </div>
            </div>
        ';
        echo "
            <script>
                setInterval(()=>{
                    document.querySelector('#message').style.display='none';
                },3000);
            </script>
        ";
    }

    public function fetchPlacesFrmDB()
    {
        $sql = $this->connect->query("SELECT * FROM `places`");
        return $sql;
    }

    public function fetchPopularPlacesFrmDB()
    {
        $sql = $this->connect->query("SELECT * FROM `places` LIMIT 6");
        return $sql;
    }

    public function fetchNavigationsFrmDB()
    {
        $sql = $this->connect->query("SELECT * FROM navigation INNER JOIN `places` AS places1 ON navigation.location = `places1`.place_id INNER JOIN `places` AS places2 ON navigation.destination = `places2`.place_id");
        return $sql;
    }
}
final class dashboard extends admin
{
    public $noOfPlaces;
    public $noOfUsers;

    public function fetchNoOfPlaces()
    {
        $sql = $this->connect->query("SELECT COUNT(place_id) AS noOfPlaces FROM `places`");
        $result = $sql->fetch_assoc();
        $this->noOfPlaces = $result["noOfPlaces"];
    }

    public function fetchNoOfUsers()
    {
        $sql = $this->connect->query("SELECT COUNT(admin_id) AS noOfAdmin FROM `admin`");
        $result = $sql->fetch_assoc();
        $this->noOfUsers = $result["noOfAdmin"];
    }
}
final class places_on_campus extends admin
{
    public $place_id;
    public $place_name;
    public $image;
    public $description;
    public $message;

    public $real_image_name;
    public $location;
    public $pathinfo_array;
    public $image_extension;

    public function collectInputs()
    {
        $this->place_name = $_POST["place_name"];
        $this->image = $_FILES["image"];
        $this->description = $_POST["description"];
    }

    public function collectImageInfo()
    {
        $this->real_image_name = $this->image["name"];
        $this->location = "../places/" . $this->real_image_name;
        $this->pathinfo_array = pathinfo($this->real_image_name, PATHINFO_ALL);
        $this->image_extension = strtolower($this->pathinfo_array["extension"]);
    }

    public function processImage()
    {
        $sql = "INSERT INTO `places` (`name`,image_name,`description`) VALUES ('$this->place_name','$this->real_image_name','$this->description')";

        if (move_uploaded_file($this->image["tmp_name"], $this->location)) {
            if ($this->insertIntoDB($sql)) {
                $this->showMessage("success", "Success!");
            } else {
                $this->showMessage("danger", $this->connect->error);
            }
        } else {
            $this->showMessage("danger", "Error while moving image!");
        }
    }

    public function processEditPlace()
    {
        $this->collectInputs();
        $this->place_id = $_POST["place_id"];

        // If image is changed
        if ($this->image["name"]) {
            $this->collectImageInfo();
            $sql = "UPDATE `places` SET name = '$this->place_name', image_name = '$this->real_image_name',description = '$this->description' WHERE place_id = $this->place_id";

            if (move_uploaded_file($this->image["tmp_name"], $this->location)) {
                $update_db = $this->connect->query($sql);
                if ($update_db) {
                    $this->showMessage("success", "Update Successful!");
                } else {
                    $this->showMessage("danger", $this->connect->error);
                }
            } else {
                $this->showMessage("danger", "Error while moving image!");
            }
        } else {
            // If image is not changed
            $sql = "UPDATE `places` SET name = '$this->place_name',description = '$this->description' WHERE place_id = $this->place_id";
            $update_db = $this->connect->query($sql);

            if ($update_db) {
                $this->showMessage("success", "Updated successfully!");
            }
        }
    }

    public function processDeletePlace()
    {
        $place_id = $_POST["place_id"];
        $sql = $this->connect->query("DELETE FROM `places` WHERE place_id = $place_id");
        if ($sql) {
            $this->showMessage("success", "Deleted successfully!");
        } else {
            $this->showMessage("danger", "Error while deleting!");
        }
    }
}

final class navigations extends admin
{
    public $location;
    public $destination;
    public $direction;
    public $navigation_id;

    public function collectInputs()
    {
        $this->location = $_POST["location"];
        $this->destination = $_POST["destination"];
        $this->direction = $_POST["direction"];
    }

    public function addToDB()
    {
        $sql = "INSERT INTO `navigation` (`location`,destination,direction) VALUES ('$this->location','$this->destination','$this->direction')";

        if ($this->insertIntoDB($sql)) {
            $this->showMessage("success", "Successfully added!");
        } else {
            $this->showMessage("danger", "Error while adding: " . $this->connect->error);
        }
    }
    public function processEditNavigation()
    {
        $this->collectInputs();
        $this->navigation_id = $_POST["navigation_id"];

        $sql = "UPDATE `navigation` SET location = $this->location,destination = $this->destination,direction = '$this->direction' WHERE navigation_id = $this->navigation_id";
        $update_db = $this->connect->query($sql);

        if ($update_db) {
            $this->showMessage("success", "Updated successfully!");
        }
    }

    public function processDeleteNavigation()
    {
        $navigation_id = $_POST["navigation_id"];
        $sql = $this->connect->query("DELETE FROM `navigation` WHERE navigation_id = $navigation_id");
        if ($sql) {
            $this->showMessage("success", "Deleted successfully!");
        } else {
            $this->showMessage("danger", "Error while deleting!");
        }
    }
}

final class userPage extends admin
{
    public $place_name;
    public $image_name;
    public $description;


    public $htmlNavigationElement;

    public function fetchPlaceDetails($place_id)
    {
        $sql = $this->connect->query("SELECT * FROM `places` WHERE place_id = $place_id");
        $result = $sql->fetch_assoc();
        $this->place_name = $result["name"];
        $this->image_name = $result["image_name"];
        $this->description = $result["description"];
    }

    public function processNavigationResult()
    {
        $location_name = htmlspecialchars($_POST["location_name"]);
        $location_id = htmlspecialchars($_POST["location_id"]);
        $destination_name = htmlspecialchars($_POST["destination_name"]);
        $destination_id = htmlspecialchars($_POST["destination_id"]);

        $query = "SELECT places1.name AS location_name,places1.image_name AS location_image,places2.name AS destination_name,places2.image_name AS destination_image,direction FROM navigation INNER JOIN places AS places1 ON navigation.location = places1.place_id INNER JOIN places AS places2 ON navigation.destination = places2.place_id WHERE navigation.location = $location_id AND navigation.destination = $destination_id";

        $sql = $this->connect->query($query);

        if ($sql->num_rows > 0) {
            $result = $sql->fetch_assoc();

            $this->htmlNavigationElement = '
                <!-- Section for displaying location and destination images -->
        <div class="images" id="images-section">
            <div>
                <h4>Location: ' . $result["location_name"] . '</h4>
                <img id="location-image" src="./places/' . $result["location_image"] . '" alt="Location Image">
            </div>
            <div>
                <h4>Destination: ' . $result["destination_name"] . '</h4>
                <img id="destination-image" src="./places/' . $result["destination_image"] . '" alt="Destination Image">
            </div>
        </div>
    
        <!-- Step-by-step directions -->
        <div class="directions" id="directions-section">
            <h3>Step-by-Step Directions:</h3>
            <ul id="directions-list">
                <li>
                    ' . $result["direction"] . '
                </li>
            </ul>
        </div>
    
            ';
        } else {
            $this->htmlNavigationElement = '
                <!-- Location not found -->
                <div class="directions" id="directions-section">
                    <center>
                        <h3>Oops! The Navigation you are looking for doesn\'t exist</h3>
                    </center>
                </div>

            ';
        }
    }
}
