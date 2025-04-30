<?php
// Get the current week's start and end dates
$startDate = date('Y-m-d', strtotime('this week'));
$endDate = date('Y-m-d', strtotime('this week +6 days'));

// Query to fetch new users created within the current week
$query = "SELECT COUNT(*) AS total_notif FROM `notifications` WHERE `status`=0";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
$total_notif = $row['total_notif'];
?>

<aside
  class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
  id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
      aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href=".">
      <img src="./assets/img/logo-ct.png" class="navbar-brand-img h-100" alt="main_logo">
      <span class="ms-1 font-weight-bold text-white">Pamana Dashboard</span>
    </a>
  </div>
  <hr class="horizontal light mt-0 mb-2">
  <div class="collapse navbar-collapse  w-auto" id="sidenav-collapse-main" style="min-height: 32rem;">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link text-white" href="index.php">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">dashboard</i>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white " href="notifications.php">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">notifications</i>
          </div>
          <span class="nav-link-text ms-1">Notifications</span>
          <span class="badge bg-gradient-danger badge-counter ms-3">
            <?= $total_notif ?>
          </span>
        </a>
      </li>
      <!-- toggle NCP item -->
      <li class="nav-item user-select-none" id="ncpManage">
        <a class="nav-link text-white" role="button" aria-expanded="false" aria-controls="manageNCP">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">table_view</i>
          </div>
          <span class="nav-link-text ms-1 me-auto">Manage NCP</span>
          <i id="accordionIcon" class="material-icons opacity-10">keyboard_arrow_down</i>
        </a>
      </li>
      <div class="" id="ncpMenu">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link ms-5" href="requestncp.php"> NCP Upload Request</a>
          </li>
          <li class="nav-item">
            <a class="nav-link ms-5" href="ncpdatarequest.php"> NCP Data Request</a>
          </li>
          <li class="nav-item">
            <a class="nav-link ms-5" href="view_uploaded_ncp.php">NCP User Uploaded</a>
          </li>
          <li class="nav-item">
            <a class="nav-link ms-5" href="managencp.php">NCP Data</a>
          </li>
        </ul>
      </div>
      <!-- toggle LSS item -->
      <li class="nav-item user-select-none" id="lssManage">
        <a class="nav-link text-white" role="button" aria-expanded="false" aria-controls="manageLSS">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">table_view</i>
          </div>
          <span class="nav-link-text ms-1 me-auto">Manage LCP</span>
          <i id="accordionIconlss" class="material-icons opacity-10">keyboard_arrow_down</i>
        </a>
      </li>
      <div class="" id="lssMenu">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link ms-5" href="requestlss.php"> LCP Upload Request</a>
          </li>
          <li class="nav-item">
            <a class="nav-link ms-5" href="lssdatarequest.php"> LCP Data Request</a>
          </li>
          <li class="nav-item">
            <a class="nav-link ms-5" href="view_uploaded_lss.php">LCP User Uploaded</a>
          </li>
          <li class="nav-item">
            <a class="nav-link ms-5" href="managelss.php">LCP Data</a>
          </li>
        </ul>
      </div>
      <li class="nav-item">
        <a class="nav-link text-white " href="tables.php">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">table_view</i>
          </div>
          <span class="nav-link-text ms-1">Manage Users</span>
        </a>
      </li>
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Account pages</h6>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white " href="#">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">person</i>
          </div>
          <span class="nav-link-text ms-1">Profile</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white " href="logout.php">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">login</i>
          </div>
          <span class="nav-link-text ms-1">Logout</span>
        </a>
        <!-- </li>
      <li class="nav-item">
        <a class="nav-link text-white " href="sign_in.php">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">login</i>
          </div>
          <span class="nav-link-text ms-1">Sign In</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white " href="sign_up.php">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">assignment</i>
          </div>
          <span class="nav-link-text ms-1">Sign Up</span>
        </a>
      </li> -->
    </ul>
  </div>
</aside>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
  <!-- Navbar -->
  <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
    data-scroll="true">
    <div class="container-fluid py-1 px-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
          <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Index</a></li>
          <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
        </ol>
        <h6 class="font-weight-bolder mb-0">Dashboard</h6>
      </nav>
      <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
        <div class="ms-md-auto pe-md-3 d-flex mx-auto text-center">
          <!-- <div class="input-group input-group-outline">
            <input type="text" class="form-control" placeholder="Type here!">
          </div> -->
        </div>
        <ul class="navbar-nav  justify-content-end">

          <li class="nav-item dropdown pe-1 d-flex align-items-center">
            <a href="javascript:;" class="nav-link text-body p-0 font-weight-bold" id="dropdownUserMenu"
              data-bs-toggle="dropdown" aria-expanded="false">

              <span class="d-sm-inline d-none"></span>
              <i class="fa fa-user ms-2"></i>
            </a>
            <ul class="dropdown-menu  dropdown-menu-end  px-4 py-3 me-sm-n4 mx-auto" aria-labelledby="dropdownUserMenu">
              <li class="mb-2">
                <a href="sign_in.php" class="nav-link text-body px-0 m-0">
                  <i class="fa fa-user me-sm-1"></i>
                  <span class="d-sm-inline d-none">Profile</span>
                  <span class="d-inline d-sm-none ms-3"></span>
                </a>
              </li>
              <li class="mb-2">
                <a href="#" class="nav-link text-body px-0 m-0">
                  <i class="fa fa-cog cursor-pointer"></i>
                  <span class="d-sm-inline d-none">Settings</span>
                </a>
              </li>
              <li class="mb-2">
                <a href="sign_in.php" class="nav-link text-body px-0 m-0">
                  <i class="fa fa-book" aria-hidden="true"></i>

                  <span class="d-sm-inline d-none">Activity Log</span>
                </a>
              </li>
              <li class="mb-2">
                <form action="functions.php" method="post" class="p-0">
                  <button type="submit" name="logout_user"
                    class="btn btn-style-none nav-link text-body px-0 rounded-0 m-0 w-100 text-start"><i
                      class="fa fa-user me-sm-1"></i>
                    <span class="d-sm-inline d-none text-capitalize">Logout</span></button>
                </form>
              </li>
            </ul>
          </li>
          <li class="nav-item ps-3 d-flex align-items-center">
            <a href="javascript:;" data-id="desktopNav" class="nav-link text-body p-0" id="iconNavbarSidenav">
              <div class="sidenav-toggler-inner">
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
              </div>
            </a>
          </li>
          <li class="nav-item px-3 d-flex align-items-center">
            <a href="javascript:;" class="nav-link text-body p-0">
              <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
            </a>
          </li>
          <li class="nav-item dropdown pe-2 d-flex align-items-center">
            <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown"
              aria-expanded="false">
              <i class="fa fa-bell cursor-pointer"></i>
            </a>
            <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
              <li class="mb-2">
                <a class="dropdown-item border-radius-md" href="javascript:;">
                  <div class="d-flex py-1">
                    <div class="my-auto">
                      <img src="./assets/img/team-2.jpg" class="avatar avatar-sm  me-3 ">
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="text-sm font-weight-normal mb-1">
                        <span class="font-weight-bold">New message</span> from Laur
                      </h6>
                      <p class="text-xs text-secondary mb-0">
                        <i class="fa fa-clock me-1"></i>
                        13 minutes ago
                      </p>
                    </div>
                  </div>
                </a>
              </li>
              <li class="mb-2">
                <a class="dropdown-item border-radius-md" href="javascript:;">
                  <div class="d-flex py-1">
                    <div class="my-auto">
                      <img src="./assets/img/small-logos/logo-spotify.svg"
                        class="avatar avatar-sm bg-gradient-dark  me-3 ">
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="text-sm font-weight-normal mb-1">
                        <span class="font-weight-bold">New album</span> by Travis Scott
                      </h6>
                      <p class="text-xs text-secondary mb-0">
                        <i class="fa fa-clock me-1"></i>
                        1 day
                      </p>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <a class="dropdown-item border-radius-md" href="javascript:;">
                  <div class="d-flex py-1">
                    <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">
                      <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <title>credit-card</title>
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                          <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">
                            <g transform="translate(1716.000000, 291.000000)">
                              <g transform="translate(453.000000, 454.000000)">
                                <path class="color-background"
                                  d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z"
                                  opacity="0.593633743"></path>
                                <path class="color-background"
                                  d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z">
                                </path>
                              </g>
                            </g>
                          </g>
                        </g>
                      </svg>
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="text-sm font-weight-normal mb-1">
                        Payment successfully completed
                      </h6>
                      <p class="text-xs text-secondary mb-0">
                        <i class="fa fa-clock me-1"></i>
                        2 days
                      </p>
                    </div>
                  </div>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>


  <script>
    const sideNav = document.getElementById('sidenav-main');
    const btnNav = document.querySelector('[data-id="desktopNav"]');
    let parentDiv = null;

    btnNav.addEventListener('click', () => {
      if (window.innerWidth > 1200) {

        sideNav.classList.toggle('d-xl-none');
        if (!parentDiv) {
          parentDiv = document.createElement('div');
          parentDiv.classList.add('parent-div'); // Add any desired class to the parent div
          sideNav.parentNode.insertBefore(parentDiv, sideNav);
          parentDiv.appendChild(sideNav);
        } else {
          parentDiv.parentNode.insertBefore(sideNav, parentDiv);
          parentDiv.remove();
          parentDiv = null;
        }
      }
    });

    const manageNcpBtn = document.getElementById('ncpManage');
    const manageNcpShow = document.getElementById('ncpMenu');
    const accordionIcon = document.getElementById('accordionIcon');
    const accordionIconlss = document.getElementById('accordionIconlss');
    manageNcpBtn.addEventListener('click', () => {
      manageNcpShow.classList.toggle('d-none')
      if (!manageNcpShow.classList.contains('d-none')) {
        accordionIcon.innerHTML = 'keyboard_arrow_up';
      } else {
        accordionIcon.innerHTML = 'keyboard_arrow_down';
      }
    })
    const manageLssBtn = document.getElementById('lssManage');
    const manageLssShow = document.getElementById('lssMenu');

    manageLssBtn.addEventListener('click', () => {
      manageLssShow.classList.toggle('d-none')
      if (!manageLssShow.classList.contains('d-none')) {
        accordionIconlss.innerHTML = 'keyboard_arrow_up';
      } else {
        accordionIconlss.innerHTML = 'keyboard_arrow_down';
      }
    })



  </script>