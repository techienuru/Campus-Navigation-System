<?php
session_start();
include_once "../includes/connect.php";
include_once "../includes/classes.php";

$object = new dashboard($connect);

if ($object->validateAuthorization()) {
  $object->fetchUserDetails($_SESSION["admin_id"]);
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
                    <p class="text-black font-weight-semibold m-0 text-wrap"> <?php echo $object->user_email; ?> </p>
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
                <button class="btn btn-sm bg-danger text-white mr-3"> Welcome Admin </button>
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
                  <p class="m-0">Home</p>
                </a>
              </div>
            </div>
          </div>

          <!-- Summary row starts here -->
          <div class="row">
            <div class="col-sm-6 col-xl-4 mx-auto stretch-card grid-margin">
              <div class="card color-card-wrapper">
                <div class="card-body">
                  <img class="img-fluid card-top-img w-100" src="../assets/images/dashboard/img_5.jpg" alt="" />
                  <div class="d-flex flex-wrap justify-content-around color-card-outer">
                    <div class="col-6 p-0 mb-4">
                      <div class="color-card primary m-auto">
                        <i class="mdi mdi-clock-outline"></i>
                        <p class="font-weight-semibold mb-0">Buildings on Campus</p>
                        <span class="small">
                          <?php $object->fetchNoOfPlaces();
                          echo $object->noOfPlaces; ?>
                        </span>
                      </div>
                    </div>
                    <div class="col-6 p-0 mb-4">
                      <div class="color-card bg-success m-auto">
                        <i class="mdi mdi-tshirt-crew"></i>
                        <p class="font-weight-semibold mb-0">Users</p>
                        <span class="small">
                          <?php $object->fetchNoOfUsers();
                          echo $object->noOfUsers; ?>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- image card row starts here -->
          <div class="row">
            <?php
            $sql = $object->fetchPlacesFrmDB();
            while ($row = $sql->fetch_assoc()) {
            ?>
              <div class="col-sm-4 stretch-card grid-margin">
                <div class="card">
                  <img src="../places/<?php echo $row["image_name"]; ?>" class="card-img-top" style="object-fit: cover;" height="400" alt="...">
                  <div class="card-body px-3 text-dark">
                    <div class="d-flex justify-content-between">
                      <p class="text-muted font-13 mb-0">BUILDINGS IN CAMPUS</p>
                      <i class="mdi mdi-heart-outline"></i>
                    </div>
                    <h5 class="font-weight-semibold"> <?php echo $row["name"]; ?> </h5>
                  </div>
                </div>
              </div>
            <?php } ?>
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
</body>

</html>