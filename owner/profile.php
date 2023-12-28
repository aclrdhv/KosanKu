<?php
require('core/init.php');

session_start();
if (isset($_POST['logout-owner-btn'])) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}

$id = $_SESSION['id_pemilik'];
$dataPemilik = getDataPemilik($id);
$data = getDataFromId("pemilik", $id);

// var_dump($data);

if (!isset($_SESSION['login-admin'])) {
    header("Location: login.php");
    exit;
}
// get username
$id = $_SESSION['id_pemilik'];
$data = getDataFromId("pemilik", $id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pemilik Kosan</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link href="../owner/assets/icons/css/all.min.css" rel="stylesheet">
    <!-- CSS Bootstrap -->
    <link href="../owner/assets/app/css/bootstrap.min.css" rel="stylesheet">
    <!--  CSS File -->
    <link href="../owner/dist/css/index.css" rel="stylesheet"">
    <!-- CSS Data Tabel -->
    <link rel=" stylesheet" type="text/css" href="../owner/dist/css/datatables.min.css">
    <!-- FavIcon -->
    <link rel=" icon" href="assets/icons/KosanKu2.png">
</head>

<body>
    <!-- PAGE WRAPPER -->
    <div class=" wrapper">
        <div class="container-fluid">
            <!-- navbar header -->
            <nav class="navbar navbar-light fixed-top">
                <div class="container-fluid justify-content-center">
                    <h4 class="navbar-header text-white">
                        Selamat Datang di Sistem Informasi Kosan | KOSANKU
                    </h4>
                </div>
            </nav>
            <!--  CONTENT -->
            <div class="content mt-5">
                <div class="row">
                    <div class="side-nav1 col-sm-4 col-md-3 col-lg-3 col-xxl-2" id="side-nav1"></div>
                    <div class="side-nav col-sm-4 col-md-3 col-lg-3 col-xxl-2" id="side-nav">
                        <ul class="nav flex-column">
                            <a class="sidebar-brand d-flex align-items-center justify-content-center mb-3 text-decoration-none"
                                href="index.php">
                                <div class="sidebar-brand-icon">
                                    <img src="../owner/assets/icons/KosanKu2.png" alt="#logo">
                                </div>
                                <h4 class="sidebar-brand-text ms-1 text-white mt-3">KOSANKU</h4>
                            </a>

                            <!-- Divider -->
                            <hr class="sidebar-divider mt-2 bg-light">

                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="index.php"><i
                                        class="fas fa-fw fa-tachometer-alt me-2"></i>
                                    Dashboard
                                </a>
                            </li>

                            <!-- Divider -->
                            <hr class="sidebar-divider mt-2 bg-light">

                            <div class="accordion" id="accordionPanelsStayOpenExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                            aria-controls="panelsStayOpen-collapseOne">
                                            <i class="fa-solid fa-database me-3"></i>
                                            Master Data
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show"
                                        aria-labelledby="panelsStayOpen-headingOne">
                                        <div class="accordion-body">
                                            <li class="nav-item">
                                                <a class="nav-link" href="kosan.php"><i
                                                        class="fa-solid fa-database me-3"></i>Data Kosan</a>
                                            </li>
                                            <!-- Divider -->
                                            <hr class="sidebar-divider mt-2 bg-light">
                                            <li class="nav-item">
                                                <a class="nav-link" href="kamar.php"><i
                                                        class="fa-solid fa-database me-3"></i>Data Kamar</a>
                                            </li>
                                            <!-- Divider -->
                                            <hr class="sidebar-divider mt-2 bg-light">
                                            <li class="nav-item">
                                                <a class="nav-link" href="penyewa.php"><i
                                                        class="fa-solid fa-database me-3"></i>Data Penyewa</a>
                                            </li>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Divider -->
                            <hr class="sidebar-divider mt-2 bg-light">

                            <li class="nav-item">
                                <a class="nav-link" href="pesanan.php"><i
                                        class="fas fa-fw fa-tachometer-alt me-2"></i>Pesanan Kosan</a>
                            </li>

                            <!-- Divider -->
                            <hr class="sidebar-divider mt-2 bg-light">
                            <div class="logout">
                                <li class="nav-item-logout">
                                    <form method="POST">
                                        <button class="btn btn-primary" type="submit" name="logout-owner-btn"><i
                                                class="fa-solid fa-power-off me-2"></i>Log Out</button>
                                    </form>
                                </li>
                            </div>

                        </ul>
                    </div>
                    <div class="main-content-header col-sm-8 col-md-9 col-lg-9 col-xxl-10" id="main-content-header">
                        <div id="content-wrapper" class="d-flex flex-column">
                            <div id="main-content">
                                <!-- Topbar -->
                                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 shadow">
                                    <!-- Sidebar Toggle (Topbar) -->
                                    <button id="sidebarToggleTop" onclick="myFunction()"
                                        class="btn btn-link rounded-circle d-sm-none mr-3">
                                        <i class="fa fa-bars"></i>
                                    </button>
                                    <!-- Topbar Navbar -->
                                    <ul class="navbar-nav ms-auto me-4">
                                        <!-- Nav Item - User Information -->
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" id="dropdownMenuButton1"
                                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="text-capitalize"><?= $dataPemilik["nama"] ?></span>
                                                <img class="img-profile rounded-circle ms-2 mb-1" width="20px"
                                                    height="20px" src="../owner/assets/icons/logo.png">
                                            </a>
                                            <!-- Dropdown - User Information -->
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                                aria-labelledby="userDropdown">
                                                <a class="dropdown-item" href="profile.php">
                                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                                    Profile
                                                </a>
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </nav>
                                <!-- End of Topbar -->

                                <!-- Begin Page Content -->
                                <div class="container-fluid">
                                    <!-- DataTales -->
                                    <div class="card shadow">
                                        <div class="card-header" style="background-color:#2155CD ;">
                                            <div class="d-flex justify-content-between mb-2 mt-2">
                                                <h1 class="h3 mb-0 text-gray-800 fw-bold text-white">Profile Pemilik
                                                </h1>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 col-sm-12 col-md-5">
                                                    <img class="img-fluid" src="../owner/assets/app/images/profile.jpg"
                                                        height="400" width="400" alt="profile">
                                                </div>
                                                <div class="col-12 col-sm-12 col-md-7" style="overflow:auto ;">
                                                    <table class="table">
                                                        <tbody>
                                                            <tr style="height:60px">
                                                                <th>NIK</th>
                                                                <td> : <?= $data['NIK'] ?></td>
                                                            </tr>
                                                            <tr style="height:60px">
                                                                <th>Nama </th>
                                                                <td> : <?= $data['nama'] ?></td>
                                                            </tr>
                                                            <tr style="height:60px">
                                                                <th>No. Telp </th>
                                                                <td> : <?= $data['noTelp'] ?></td>
                                                            </tr>
                                                            <tr style="height:60px">
                                                                <th>Alamat </th>
                                                                <td> : <?= $data['alamat'] ?></td>
                                                            </tr>
                                                            <tr style="height:60px">
                                                                <th>Email</th>
                                                                <td> : <?= $data['email'] ?></td>
                                                            </tr>
                                                            <!-- <tr style="height:60px">
                                                                <th>Username</th>
                                                                <td> : Fajrun Shubhi</td>
                                                            </tr> -->
                                                            <!-- <tr style="height:60px">
                                                                <th>Password</th>
                                                                <td> : 1234567890</td>
                                                            </tr> -->
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <footer class="sticky-footer bg-white fixed-bottom">
                            <div class="container">
                                <div class="copyright text-center">
                                    <span>Copyright &copy; KosanKu 2023</span>
                                </div>
                            </div>
                        </footer>
                        <!-- End of Footer -->
                    </div>
                    <!-- End of Content Wrapper -->
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
    function myFunction() {
        var x = document.getElementById("side-nav");
        var y = document.getElementById("side-nav1");
        var a = document.getElementById("main-content-header");
        if (x.style.display === "block") {
            x.style.display = "none";
            y.style.display = "none";
        } else {
            x.style.display = "block";
            y.style.display = "block";
            a.style.width = "none";
        }
    }
    </script>
    <script src="../owner/dist/js/jquery.js"></script>
    <script src="../owner/assets/app/js/bootstrap.bundle.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/owner/dist/js/hehe.js"></script>

    <!-- JS data tabel -->
    <script src="../owner/dist/js/datatables.min.js"></script>
    <script src="../owner/dist/js/dataTabel.js"></script>

</body>

</html>