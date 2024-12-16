<?php
session_start();
include_once "../includes/connect.php";
include_once "../includes/classes.php";

$object = new places_on_campus($connect);

if ($object->validateAuthorization()) {

    $object->fetchUserDetails($_SESSION["admin_id"]);

    // If a new Place is added
    if (isset($_POST["add_place"])) {
        $object->collectInputs();
        $object->collectImageInfo();
        $object->processImage();
    }

    // If a place is editted and submitted
    if (isset($_POST["submit_changes"])) {
        $object->processEditPlace();
    }

    // If a place is confirmed to be deleted
    if (isset($_POST["delete_place"])) {
        $object->processDeletePlace();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Campus Naviagtion System</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="../assets/vendors/jquery-bar-rating/css-stars.css" />
    <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.min.css" />
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="../assets/css/demo_2/style.css" />
    <!-- End layout styles -->
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_horizontal-navbar.html -->
        <div class="horizontal-menu">
            <nav class="navbar top-navbar col-lg-12 col-12 p-0">
                <div class="container">
                    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                        <a class="navbar-brand brand-logo" href="./dashboard.php">
                            <h>Campus N.S</h>
                            <span class="font-12 d-block font-weight-light">Navigation made easy </span>
                        </a>
                        <a class="navbar-brand brand-logo-mini" href="./dashboard.php"><img src="../assets/images/logo-mini.svg" alt="logo" /></a>
                    </div>
                    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                        <ul class="navbar-nav mr-lg-2">

                        </ul>
                        <ul class="navbar-nav navbar-nav-right">
                            <li class="nav-item nav-profile dropdown">
                                <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                                    <div class="nav-profile-img">
                                        <img src="../assets/images/faces/face1.jpg" alt="image" />
                                    </div>
                                    <div class="nav-profile-text">
                                        <p class="text-black font-weight-semibold m-0"> <?php echo $object->user_email; ?> </p>
                                        <span class="font-13 online-color">online <i class="mdi mdi-chevron-down"></i></span>
                                    </div>
                                </a>
                                <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                                    <a class="dropdown-item" href="./logout.php">
                                        <i class="mdi mdi-logout mr-2 text-primary"></i> Signout </a>
                                </div>
                            </li>
                        </ul>
                        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
                            <span class="mdi mdi-menu"></span>
                        </button>
                    </div>
                </div>
            </nav>
            <nav class="bottom-navbar">
                <div class="container">
                    <ul class="nav page-navigation">
                        <li class="nav-item">
                            <a class="nav-link" href="./dashboard.php">
                                <i class="mdi mdi-compass-outline menu-icon"></i>
                                <span class="menu-title">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="places-on-campus.php">
                                <i class="mdi mdi-contacts menu-icon"></i>
                                <span class="menu-title">Buildings On Campus</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="navigations.php">
                                <i class="mdi mdi-contacts menu-icon"></i>
                                <span class="menu-title">Navigations</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <div class="nav-link d-flex">
                                <button class="btn btn-sm bg-danger text-white mr-3"> Nice to have you on board, Admin </button>
                                <a class="text-white" href="./dashboard.php"><i class="mdi mdi-home-circle"></i></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper pb-0">
                    <div class="page-header flex-wrap">
                        <div class="header-left">
                        </div>
                        <div class="header-right d-flex flex-wrap mt-md-2 mt-lg-0">
                            <div class="d-flex align-items-center">
                                <a href="#">
                                    <p class="m-0 pr-3">Dashboard</p>
                                </a>
                                <a class="pl-3 mr-4" href="#">
                                    <p class="m-0">Places On Campus</p>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Inner content row starts here -->
                    <div class="row justify-content-center">
                        <div class="col-md-8 grid-margin stretch-card">
                            <div class="card position-relative">
                                <?php echo $object->message; ?>
                                <div class="card-body">
                                    <h4 class="card-title">Add Building</h4>
                                    <p class="card-description">Add a Popular building on Campus</p>
                                    <form class="forms-sample" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Building Name</label>
                                            <input type="text" class="form-control" name="place_name" id="exampleInputUsername1" placeholder="Ex: School Library" required />
                                        </div>
                                        <div class="form-group">
                                            <label>Image</label>
                                            <div class="input-group col-xs-12">
                                                <input type="file" name="image" class="form-control file-upload-info" placeholder="Upload Image" accept=".jpg, .png," required />
                                                <span class="input-group-append">
                                                    <button class="file-upload-browse btn btn-primary" type="button"> Upload </button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleTextarea1">Description</label>
                                            <textarea class="form-control" name="description" id="exampleTextarea1" rows="4" required></textarea>
                                        </div>
                                        <button type="submit" name="add_place" class="btn btn-primary mr-2"> Add Place </button>
                                        <button type="reset" class="btn btn-light">Reset</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-12 stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Buildings</h4>
                                    <p class="card-description"> Buildings <code>On Campus</code>
                                    </p>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Image</th>
                                                    <th>Description</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = $object->fetchPlacesFrmDB();
                                                $row_number = 1;
                                                while ($row = $sql->fetch_assoc()) {
                                                ?>
                                                    <tr class="table-info">
                                                        <td><?php echo $row_number; ?></td>
                                                        <td><?php echo $row["name"]; ?></td>
                                                        <td>
                                                            <div class="nav-profile-img">
                                                                <img src="../places/<?php echo $row["image_name"]; ?>" alt="image" />
                                                            </div>
                                                        </td>
                                                        <td class="text-wrap"><?php echo $row["description"]; ?></td>
                                                        <td>
                                                            <button class="btn" title="Edit" data-toggle="modal" data-target="#edit-place-<?php echo $row["place_id"]; ?>">
                                                                <i class="mdi mdi-tooltip-edit"></i>
                                                            </button>
                                                            <button class="btn" title="Delete" id="js-delete-place" data-toggle="modal" data-target="#delete-place" data-place-id="<?php echo $row["place_id"]; ?>">
                                                                <i class="mdi mdi-delete"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <!-- Edit Place Modal -->
                                                    <div class="modal fade" id="edit-place-<?php echo $row["place_id"]; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="edit-place" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="staticBackdropLabel">Edit Place</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form class="forms-sample" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                                                                        <input type="hidden" name="place_id" value="<?php echo $row["place_id"]; ?>" />
                                                                        <div class="form-group">
                                                                            <label for="exampleInputUsername1">Place Name</label>
                                                                            <input type="text" name="place_name" class="form-control" id="exampleInputUsername1" value="<?php echo $row["name"]; ?>" />
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Image</label>
                                                                            <div class="input-group col-xs-12">
                                                                                <input type="file" class="form-control file-upload-info" name="image" placeholder="Upload Image" />
                                                                                <span class="input-group-append">
                                                                                    <button class="file-upload-browse btn btn-primary" type="button"> Upload </button>
                                                                                </span>
                                                                            </div>
                                                                            <small class="text-secondary">Leave empty to maintain previous image</small>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="exampleTextarea1">Description</label>
                                                                            <textarea class="form-control" id="exampleTextarea1" name="description" rows="4" required><?php echo $row["description"]; ?></textarea>
                                                                        </div>
                                                                        <button type="submit" name="submit_changes" class="btn btn-primary mr-2"> Submit Changes </button>
                                                                    </form>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                    $row_number++;
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="container">
                        <div class="d-sm-flex justify-content-center justify-content-sm-between">
                            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © Campus Navigation System 2024</span>
                            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Designed by <a href="#" target="_blank">Muhammad Al-amin</a></span>
                        </div>
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>

    <!-- Delete Place Modal -->
    <div class="modal fade" id="delete-place" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="delete-place" aria-hidden="true">
        <div class="modal-dialog modal-dialog-center">
            <div class="modal-content">
                <div class="modal-body">
                    <p>This action is irrevocable, Do you want to proceed?</p>
                    <div class="d-flex">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <input type="hidden" name="place_id" value="" id="js-place-id">
                            <button type="submit" name="delete_place" class="btn btn-success h-100">Yes</button>
                        </form>
                        <button type="button" class="btn btn-danger ml-3 h-100" data-dismiss="modal">No</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="../assets/vendors/jquery-bar-rating/jquery.barrating.min.js"></script>
    <script src="../assets/vendors/chart.js/Chart.min.js"></script>
    <script src="../assets/vendors/flot/jquery.flot.js"></script>
    <script src="../assets/vendors/flot/jquery.flot.resize.js"></script>
    <script src="../assets/vendors/flot/jquery.flot.categories.js"></script>
    <script src="../assets/vendors/flot/jquery.flot.fillbetween.js"></script>
    <script src="../assets/vendors/flot/jquery.flot.stack.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../assets/js/off-canvas.js"></script>
    <script src="../assets/js/hoverable-collapse.js"></script>
    <script src="../assets/js/misc.js"></script>
    <script src="../assets/js/settings.js"></script>
    <script src="../assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="../assets/js/dashboard.js"></script>
    <!-- End custom js for this page -->

    <script>
        document.querySelectorAll("#js-delete-place").forEach((button) => {
            button.addEventListener("click", () => {
                let placeId = button.dataset.placeId;
                let inputBoxPlaceId = document.querySelector("#js-place-id");
                inputBoxPlaceId.value = placeId;
            });
        });
    </script>
</body>

</html>