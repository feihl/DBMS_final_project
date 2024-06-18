  <?php
include('include/db_connect.php');
$userInfo = $conn->query("SELECT * FROM tbl_user_information WHERE user_account_id = " . $_SESSION['login_id'] . " LIMIT 1")->fetch_array();
$name = ucwords($userInfo['fName']) . " " . ucwords($userInfo['mName'][0]) . ". " . ucwords($userInfo['lName']);

  ?>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
    <i class="bi bi-list toggle-sidebar-btn"></i>
      <a href="../basicRental/index.php" class="logo d-flex align-items-center">
        <img src="Public/assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">BlockBusterBox<br>Movie Rental</span>
      </a>
    </div><!-- End Logo -->
    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
      </form>
    </div><!-- End Search Bar -->
    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item d-block d-lg-none">
        </li><!-- End Search Icon-->
        </li><!-- End Messages Nav -->
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="Public/assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo isset($name) ? $name : 'Guest'; ?></span>
          </a><!-- End Profile Iamge Icon -->
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li>
              <a class="dropdown-item d-flex align-items-center" href="ajax.php?action=logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>
          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->
      </ul>
    </nav><!-- End Icons Navigation -->
  </header><!-- End Header -->