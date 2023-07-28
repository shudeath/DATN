<?php
    include "php/init.php";
    include "php/loginhandle.php";
?>
<!DOCTYPE html>
<html lang="vi" id="fullpage">
<head>
    <base target="_parent">
    <link rel="shortcut icon" href="img/logo-haui-size.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trang chủ</title>
    
    <script src="https://unpkg.com/react@17/umd/react.development.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@17/umd/react-dom.development.js" crossorigin></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Font Awesome -->
    <link ref="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet"/>
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.11.0/mdb.min.css" rel="stylesheet"/>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.11.0/mdb.min.js"></script>
    <!--Icon-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <script type="text/javascript" src="js/script.js"></script>
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="css/responsive.css">
</head>
<body id="body-pd">
    <!--Main Navigation-->
<header>
  <!-- Sidebar -->
  <?php if(isset($_SESSION['logged'])){ ?>
  <nav id="sidebarMenu" class="d-lg-block sidebar bg-white collapse" style="">
    <div class="position-sticky">
      <div class="list-group list-group-flush mx-3 mt-4">
        <?php if ($_SESSION["Quan_ly"] == true){ ?>
        <a href="javascript:void(0)" class="list-group-item list-group-item-action py-2 ripple active" 
        onclick='loadpage(this.id)' id="view/ql_dashboard.php">
            <i class="fas fa-fw  fa-solid fa-chart-pie me-3"></i>
            <span>Admin dashboard</span>
        </a>
        <a href="javascript:void(0)" class="list-group-item list-group-item-action py-2 ripple" 
        onclick='loadpage(this.id)' id="view/dashboard.php">
            <i class="fas fa-fw  fa-solid fa-gauge-high me-3"></i>
            <span>Main dashboard</span>
        </a>
        <?php } else { ?>
        <a href="javascript:void(0)" class="list-group-item list-group-item-action py-2 ripple active" 
        onclick='loadpage(this.id)' id="view/dashboard.php">
            <i class="fas fa-fw  fa-solid fa-gauge-high me-3"></i>
            <span>Main dashboard</span>
        </a>
        <?php } ?>
        <a href="javascript:void(0)" class="list-group-item list-group-item-action py-2 ripple"
        onclick="loadpage(this.id)" id="view/bcc.php">
            <i class="fas fa-fw  fa-solid fa-calendar-days me-3"></i>
            <span>Bảng chấm công</span>
        </a>
        <a href="javascript:void(0)" class="list-group-item list-group-item-action py-2 ripple"
        onclick="loadpage(this.id)" id="view/dmk.php">
            <i class="fas fa-fw  fa-solid fa-key me-3"></i>
            <span>Đổi mật khẩu</span>
        </a>
        <a href="javascript:void(0)" class="list-group-item list-group-item-action py-2 ripple" style=""
        onclick="loadpage(this.id)" id="view/ttcn.php">
            <i class="fas fa-fw  fa-solid fa-address-card me-3"></i>
            <span>Thông tin cá nhân</span>
        </a>
        <a href="javascript:void(0)" class="list-group-item list-group-item-action py-2 ripple"
        onclick="loadpage(this.id)" id="view/dsnv.php">
            <i class="fas fa-fw fa-solid fa-address-book me-3"></i>
            <span>Danh sách nhân viên</span>
        </a>
        <?php if(isset( $_SESSION["Quan_ly"]) && $_SESSION["Quan_ly"] == true){ ?>
        <a href="javascript:void(0)" class="list-group-item list-group-item-action py-2 ripple"
        onclick="loadpage(this.id)" id="view/qlnv.php">
            <i class="fas fa-fw  fa-solid fa-bars-progress me-3"></i>
            <span>Quản lý nhân viên</span>
        </a>
        <a href="javascript:void(0)" class="list-group-item list-group-item-action py-2 ripple"
        onclick="loadpage(this.id)" id="view/tnv.php">
            <i class="fas fa-fw  fa-solid fa-user-plus me-3"></i>
            <span>Thêm tài khoản nhân viên</span>
        </a>
        <!--a href="javascript:void(0)" class="list-group-item list-group-item-action py-2 ripple"
        onclick="loadpage(this.id)" id="view/cam.php">
            <i class="fas fa-fw  fa-solid fa-video me-3"></i>
            <span>Camera</span>
        </a-->
        <?php } ?>
        <a href="javascript:void(0)" class="list-group-item list-group-item-action py-2 ripple"
        onclick="loadpage(this.id)" id="view/info.php">
            <i class="fas fa-fw  fa-solid fa-circle-info me-3"></i>
            <span>About</span>
        </a>
      </div>
    </div>
  </nav>
  <?php }?>
  <!-- Sidebar -->
  <!-- Navbar -->
  <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
    <!-- Container wrapper -->
    <div class="container-fluid">
      <!-- Toggle button -->
      <button class="navbar-toggler collapsed" type="button" data-mdb-toggle="collapse" 
      data-mdb-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" 
      aria-label="Toggle navigation" id="navButton">
        <i class="fas fa-fw fa-solid fa-bars"></i>
      </button>

      <!-- Brand -->
      <a class="navbar-brand text-primary" href="/">
        <!--img src="img/logo.png" height="20" alt="" loading="lazy"/-->
        <i class="fa-fw fa-solid fa-house me-2"></i>
        <span class="">HOME</span>
      </a>
      <!-- Right links -->
      <ul class="navbar-nav ms-auto d-flex flex-row">
        <!-- Notification dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link me-3 me-lg-0 dropdown-toggle hidden-arrow" href="#" 
          id="navbarDropdownMenuLink" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-bell"></i>
            <span class="badge rounded-pill badge-notification bg-danger">0</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="#">Thông báo mới</a></li>
            <li><a class="dropdown-item" href="#">Thông báo cá nhân</a></li>
            <li>
              <a class="dropdown-item" href="#">Thông báo công ty</a>
            </li>
          </ul>
        </li>

        <!-- Icon dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link me-3 me-lg-0 dropdown-toggle hidden-arrow" 
          href="#" id="navbarDropdown" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
            <i class="flag-vietnam flag m-0"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <li>
              <a class="dropdown-item" href="#"><i class="flag-vietnam flag"></i>Việt Nam
                <i class="fa fa-check text-success ms-2"></i></a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item" href="#"><i class="united kingdom flag"></i>English</a>
            </li>
            <li>
              <a class="dropdown-item" href="#"><i class="poland flag"></i>Polski</a>
            </li>
            <li>
              <a class="dropdown-item" href="#"><i class="china flag"></i>中文</a>
            </li>
            <li>
              <a class="dropdown-item" href="#"><i class="japan flag"></i>日本語</a>
            </li>
            <li>
              <a class="dropdown-item" href="#"><i class="germany flag"></i>Deutsch</a>
            </li>
            <li>
              <a class="dropdown-item" href="#"><i class="france flag"></i>Français</a>
            </li>
            <li>
              <a class="dropdown-item" href="#"><i class="spain flag"></i>Español</a>
            </li>
            <li>
              <a class="dropdown-item" href="#"><i class="russia flag"></i>Русский</a>
            </li>
            <li>
              <a class="dropdown-item" href="#"><i class="portugal flag"></i>Português</a>
            </li>
          </ul>
        </li>

        <!-- Avatar -->
        <?php if(isset($_SESSION['logged'])){ ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle hidden-arrow d-flex align-items-center" 
          href="#" id="navbarDropdownMenuLink" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
             <i class="iconify" data-icon="ic:round-account-circle"></i>
            <span class="ms-1 me-1">
                <?php if (isset($_SESSION["Ten"])) echo $_SESSION["Ten"];?>
            </span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink" 
          data-popper-placement="null" data-mdb-popper="none">
            <li><a class="dropdown-item" href="#"  
              onclick="loadpage('view/ttcn.php')">Thông tin cá nhân</a></li>
            <!--li><a class="dropdown-item" href="#">Cài đặt</a></li-->
            <li><a class="dropdown-item" href="php/logout.php">Đăng xuất</a></li>
          </ul>
        </li>
        <?php }?>
      </ul>
    </div>
    <!-- Container wrapper -->
  </nav>
  <!-- Navbar -->
</header>
<!--Main Navigation-->
<!--Main layout-->
<?php if(isset($_SESSION['logged'])){ ?>
<main style="margin-top: 58px;">
    <div id="maincontent">
        <?php if(isset( $_SESSION["Quan_ly"]) && $_SESSION["Quan_ly"] == true){ 
            include "view/ql_dashboard.php";
        } else include "view/dashboard.php";
        ?>
    </div>
</main>
<?php } else include "php/login.php" ?>
<!--Main layout-->
<script>
    var navBar = document.getElementById("main-navbar");
    var navSide = String(window.innerHeight-navBar.offsetHeight) + "px";
    //console.log(navSide);
    document.getElementById("maincontent").style.minHeight = navSide;
    function loadpage(page){
        spinner();
        const nodes = document.getElementsByClassName("list-group-item");
        for (let i = 0; i < nodes.length; i++) {
            nodes[i].classList.remove("active");
        }
        const bt = document.getElementById("navButton");
        if(!bt.classList.contains("collapsed")){
            bt.click();
        }
        const setactive = document.getElementById(page);
        setactive.classList.add("active");
        $("#maincontent").load(page);
        //loadPage(page,"maincontent","GET");
        //myLoad(page,"maincontent");
    }
    /*function myLoad(page,id){
        var file = {
            <?php 
                //include "view/bcc.php";
            ?>
        };
        //console.log(file);
        document.getElementById(id).innerHTML = file;
    }*/
</script>
</body>
</html>
<script src="js/hidefooter.js"></script>