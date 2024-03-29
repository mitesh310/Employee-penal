<?php
ob_start();
session_start();
if ($_SESSION['loginStatus'] == '') {
    header("location: ../");
}



?>



<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://localhost:8080/getnotificationbyemployeeid/'. $_SESSION['employeeId'],
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);
curl_close($curl);
$result_notification = json_decode($response,true);

// echo $response;
?>

<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>Weblock Infosoft - Employee Panel</title>
    
  <!-- theme meta -->
  <meta name="theme-name" content="mono" />

  <!-- GOOGLE FONTS -->
  <link href="https://fonts.googleapis.com/css?family=Karla:400,700|Roboto" rel="stylesheet">
  <link href="../plugins/simplebar/simplebar.css" rel="stylesheet" />
  <link href="../plugins/material/css/materialdesignicons.min.css" rel="stylesheet" />
  
  <!-- PLUGINS CSS STYLE -->
  <link href="../plugins/nprogress/nprogress.css" rel="stylesheet" />
  
  <link href="../plugins/DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css" rel="stylesheet" />
  
  <link href="../plugins/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" />
  
  <link href="../plugins/daterangepicker/daterangepicker.css" rel="stylesheet" />
  
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
  
  <link href="../plugins/toaster/toastr.min.css" rel="stylesheet" />

  <link id="main-css-href" rel="stylesheet" href="../css/style.css" />

  <link href="../images/favicona.png" rel="shortcut icon" />

  <script src="../plugins/nprogress/nprogress.js"></script>
</head>

<style>
    #left-sidebar #sidebar-menu .active{
      background-color: rgb(9,175,244);
    }
  </style>
  <body class="navbar-fixed sidebar-fixed" id="body">
    <!-- <script>
      NProgress.configure({ showSpinner: false });
      NProgress.start();
    </script> -->

    
    <div id="toaster"></div>
    

    <div class="wrapper">
      
    
        <aside class="left-sidebar sidebar-dark" id="left-sidebar">
          <div id="sidebar" class="sidebar sidebar-with-footer">
            <div class="app-brand">
              <a href="../dashboard">
                <img src="../images/logo-1.png" alt="Weblock">
                <!-- <span class="brand-name">MONO</span> -->
              </a>
            </div>
            <div class="sidebar-left" data-simplebar style="height: 100%;">
              <ul class="nav sidebar-inner" id="sidebar-menu">
                  <li <?php if($pageName=="Dashboard") { ?> class="active" <?php } ?>>
                    <a class="sidenav-item-link" href="../dashboard">
                      <i class="mdi mdi-briefcase-account-outline"></i>
                      <span class="nav-text">Dashboard</span>
                    </a>
                  </li>
                  <li <?php if($pageName=="Projects") { ?> class="active" <?php } ?>>
                    <a class="sidenav-item-link" href="../project">
                      <i class="mdi mdi-account-group"></i>
                      <span class="nav-text">Projects</span>
                    </a>
                  </li>
                  <li <?php if($pageName=="Task") { ?> class="active" <?php } ?>>
                    <a class="sidenav-item-link" href="../task">
                      <i class="mdi mdi-account-group"></i>
                      <span class="nav-text">Tasks</span>
                    </a>
                  </li>
                  <!-- <li <?php if($pageName=="Profile") { ?> class="active" <?php } ?>>
                    <a class="sidenav-item-link" href="../profile/">
                      <i class="mdi mdi-account"></i>
                      <span class="nav-text">My Profile</span>
                    </a>
                  </li> -->
                  <li <?php if($pageName=="Attendance") { ?> class="active" <?php } ?>>
                    <?php
                      $currentMonth = date('m');
                      $currentYear = date('Y');
                    ?>
                    <a class="sidenav-item-link" href="../attendance/?month=<?php echo $currentMonth; ?>&year=<?php echo $currentYear; ?>">
                      <i class="mdi mdi-calendar"></i>
                      <span class="nav-text">Attendance</span>
                    </a>
                  </li>
                  <li <?php if($pageName=="Leave") { ?> class="active" <?php } ?>>
                    <a class="sidenav-item-link" href="../leave">
                      <i class="mdi mdi-account-arrow-right"></i>
                      <span class="nav-text">Leave</span>
                    </a>
                  </li>
                  <li <?php if($pageName=="Salary") { ?> class="active" <?php } ?>>
                    <a class="sidenav-item-link" href="../salary">
                      <i class="mdi mdi-sack"></i>
                      <span class="nav-text">Salary</span>
                    </a>
                  </li>
                  <li <?php if($pageName=="Policy") { ?> class="active" <?php } ?>>
                    <a class="sidenav-item-link" href="../policy">
                      <i class="mdi mdi-podcast"></i>
                      <span class="nav-text">Company Policy</span>
                    </a>
                  </li>

                  <?php
                  if($_SESSION['designation']=="HR")
                  {
                  ?>
                  <li <?php if($pageName=="Request") { ?> class="active" <?php } ?>>
                    <a class="sidenav-item-link" href="../request">
                      <i  class="mdi mdi-alarm-light"></i>
                      <span class="nav-text">Request</span>
                      
                    </a>
                  </li>
                  <?php
                  }
                  ?>
              </ul>

            </div>

            
          </div>
        </aside>

      
      <div class="page-wrapper">
        
          <!-- Header -->
          <header class="main-header" id="header">
            <nav class="navbar navbar-expand-lg navbar-light" id="navbar">
              <!-- Sidebar toggle button -->
              <button id="sidebar-toggler" class="sidebar-toggle">
                <span class="sr-only">Toggle navigation</span>
              </button>

              <span class="page-title"><?php echo $_SESSION['name']; ?></span>

              <div class="navbar-right ">

                <ul class="nav navbar-nav">
                  
                  <li class="custom-dropdown">
                    <button class="notify-toggler custom-dropdown-toggler">
                      <i class="mdi mdi-bell-outline icon"></i>
                      <span class="badge badge-xs rounded-circle"><?php echo $result_notification['data']['numberOfnotifications']; ?></span>
                    </button>
                    <div class="dropdown-notify">
                      <header>
                        <div class="nav nav-underline" id="nav-tab" role="tablist">
                          <a class="nav-item nav-link active"  data-toggle="tab" href="#all" role="tab" aria-controls="nav-home"
                            aria-selected="true">All (<?php echo $result_notification['data']['numberOfnotifications']; ?>)</a>
                         
                        </div>
                      </header>

                      <div class="" data-simplebar style="height: 325px;">
                        <div class="tab-content" id="myTabContent">
                      
                          <div class="tab-pane fade show active"  role="tabpanel" aria-labelledby="all-tabs">

                            <div class="media media-sm bg-warning-10 p-4 mb-0">
                              
                              <?php
                                        foreach($result_notification['data']['notificationsData'] as $notification)
                                        {
                                        ?>
                              <div class="media-body">
                                <a href="<?php if($notification['notificationType']=="Project") { ?>../project/<?php } ?>">
                                  <span class="title mb-0"><?php echo $notification['fromDetails']['name']; ?></span>
                                  <span class="discribe"><?php echo $notification['notificationTitle']; ?></span>
                                  <span class="time">
                                    <time><?php echo $notification['notificationBody']; ?></time>
                                  </span>
                                </a>
                              </div>
                              <?php
                                        }
                                        ?>
                            </div>

                           

                          </div>

                          
                        </div>
                      </div>

                      
                    </div>
                  </li>
                  <!-- User Account -->
                  <li class="dropdown user-menu">
                    <button class="dropdown-toggle nav-link" data-toggle="dropdown">
                      <img src="../images/user/user-xs-01.jpg" class="user-image rounded-circle" alt="User Image" />
                      <span class="d-none d-lg-inline-block"><?php echo $_SESSION['name']; ?></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                      <li>
                        <a class="dropdown-link-item" href="../profile">
                          <i class="mdi mdi-account-outline"></i>
                          <span class="nav-text">My Profile</span>
                        </a>
                      </li>
                      
                      

                      <li class="dropdown-footer">
                        <a class="dropdown-link-item" href="../include/logout.php"> <i class="mdi mdi-logout"></i> Log Out </a>
                      </li>
                    </ul>
                  </li>
                </ul>
              </div>
            </nav>


          </header>