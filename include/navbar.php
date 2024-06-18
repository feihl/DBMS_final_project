<?php 
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
 $url = "https://";   
else  
 $url = "http://";   
    // Append the host(domain name, ip) to the URL.   
$url.= $_SERVER['HTTP_HOST'];   
    // Append the requested resource location to the URL   
$url.= $_SERVER['REQUEST_URI'];    
$final_url = explode("=", $url);
$indicator = $final_url[count($final_url)-1];
?>
<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">
    <?php if ($_SESSION['login_access'] == '0') {?>

     <?php 
    } elseif ($_SESSION['login_access'] == '1') { ?>
<!-- Display sidemenu items for access level 2 -->
      <li class="nav-item">
        <a class="nav-link <?php echo ($indicator == 'dashboard' ? '' : 'collapsed'); ?>" href="index.php?page=dashboard">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-heading">Menu</li>
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#components-navs" data-bs-toggle="collapse" href="#">
        <i class="bi bi-menu-button-wide"></i><span>Movies</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="components-navs" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a class="<?php echo($indicator == 'movies' ? 'active' : ''); ?>" href="index.php?page=movies">
            <i class="bi bi-circle"></i><span>All Movies</span>
          </a>
        </li>
        <li>
          <a class="<?php echo($indicator == 'genre' ? 'active' : ''); ?>" href="index.php?page=genre">
            <i class="bi bi-circle"></i><span>Genre</span>
          </a>
        </li>
        <li>
          <a class="<?php echo($indicator == 'inventory' ? 'active' : ''); ?>" href="index.php?page=inventory">
            <i class="bi bi-circle"></i><span>Inventory</span>
          </a>
        </li>
      </ul>
    </li><!-- End Components Nav -->
      <li class="nav-item">
        <a class="nav-link <?php echo ($indicator == 'customer' ? '' : 'collapsed'); ?>" href="index.php?page=customer">
          <i class="bi bi-question-circle"></i>
          <span>Customer</span>
        </a>
      </li><!-- End F.A.Q Page Nav -->
      <li class="nav-item">
        <a class="nav-link <?php echo ($indicator == 'report' ? '' : 'collapsed'); ?>" href="index.php?page=report">
          <i class="bi bi-envelope"></i>
          <span>Receipt</span>
        </a>
      </li><!-- End Contact Page Nav -->
      <li class="nav-item">
        <a class="nav-link <?php echo ($indicator == 'pos' ? '' : 'collapsed'); ?> " href="index.php?page=pos">
          <i class="bi bi-card-list"></i>
          <span>POS</span>
        </a>
      </li><!-- End Register Page Nav -->
            <!-- Display the "Settings" menu item only for access level 1 -->
   <li class="nav-heading">Admin Tools</li>
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-menu-button-wide"></i><span>Settings</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
<!--         <li>
          <a class="<?php echo($indicator == 'roles' ? 'active' : ''); ?>" href="index.php?page=roles">
            <i class="bi bi-circle"></i><span>Roles</span>
          </a>
        </li> -->
        <li>
          <a class="<?php echo($indicator == 'users' ? 'active' : ''); ?>" href="index.php?page=users">
            <i class="bi bi-circle"></i><span>Users</span>
          </a>
        </li>
        <li>
          <a class="<?php echo($indicator == 'website' ? 'active' : ''); ?>" href="index.php?page=website">
            <i class="bi bi-circle"></i><span>Website Settings</span>
          </a>
        </li>
<!--         <li>
          <a class="<?php echo($indicator == 'logs' ? 'active' : ''); ?>" href="index.php?page=logs">
            <i class="bi bi-circle"></i><span>Logs</span>
          </a>
        </li> -->
      </ul>
    </li><!-- End Components Nav -->

    <?php } elseif ($_SESSION['login_access'] == '2') { ?>
      <!-- Display sidemenu items for access level 2 -->
      <li class="nav-item">
        <a class="nav-link <?php echo ($indicator == 'dashboard' ? '' : 'collapsed'); ?>" href="index.php?page=dashboard">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link <?php echo ($indicator == 'customer' ? '' : 'collapsed'); ?>" href="index.php?page=customer">
          <i class="bi bi-question-circle"></i>
          <span>Customer</span>
        </a>
      </li><!-- End F.A.Q Page Nav -->
      <li class="nav-item">
        <a class="nav-link <?php echo ($indicator == 'report' ? '' : 'collapsed'); ?>" href="index.php?page=report">
          <i class="bi bi-envelope"></i>
          <span>Receipt</span>
        </a>
      </li><!-- End Contact Page Nav -->
      <li class="nav-item">
        <a class="nav-link <?php echo ($indicator == 'pos' ? '' : 'collapsed'); ?> " href="index.php?page=pos">
          <i class="bi bi-card-list"></i>
          <span>POS</span>
        </a>
      </li><!-- End Register Page Nav -->
    <?php } ?>
   

  </ul>
</aside><!-- End Sidebar -->

