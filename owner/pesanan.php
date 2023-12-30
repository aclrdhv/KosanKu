<?php
require('core/init.php');

session_start();

$nikAkun = $_SESSION["id_pemilik"];
$dataPemilik = getDataPemilik($nikAkun);

if (!isset($_SESSION['login-admin'])) {
    header("Location: login.php");
    exit;
}


$idKost = getUniqueIdKostByNIK($_SESSION['id_pemilik'])['id'];
// var_dump($idKost);
$dataPemesan = getDataPesanan($nikAkun);
// var_dump($dataPemesan);

if (isset($_POST['logout-owner-btn'])) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}

if (isset($_POST['validation-btn'])) {
    $val = explode(" ", $_POST['validation-btn']);
    // var_dump($val);

    if ($val[0] == "accept") {
        // accept and set to random room
        $pesananUser = getInfoPesananById($val[1]);
        // var_dump($pesananUser);
        $valid = setUserToKamar($pesananUser['idPemesan'], $pesananUser['mulaiSewa'], $pesananUser['akhirSewa'], $idKost, $val[1]);

        if ($valid) {
            echo "<script> document.location.href = 'pesanan.php'; </script>";
        }
    } else {
        // reject, delete from data pemesanan 
        $valid = rejectPemesanan($val[1]);

        if ($valid) {
            echo "<script> document.location.href = 'pesanan.php'; </script>";
        }
    }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!--  CSS File -->
    <link href="../owner/dist/css/index.css" rel="stylesheet">
    <!-- CSS Data Tabel -->
    <link href=" assets/app/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel=" stylesheet" type="text/css" href="dist/css/datatables.min.css">
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
                            <a class="sidebar-brand d-flex align-items-center justify-content-center mb-3 text-decoration-none" href="index.php">
                                <div class="sidebar-brand-icon">
                                    <img src="../owner/assets/icons/KosanKu2.png" alt="#logo">
                                </div>
                                <h4 class="sidebar-brand-text ms-1 text-white mt-3">KOSANKU</h4>
                            </a>

                            <!-- Divider -->
                            <hr class="sidebar-divider mt-2 bg-light">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="index.php"><i class="fas fa-fw fa-tachometer-alt me-2"></i>
                                    Dashboard
                                </a>
                            </li>

                            <!-- Divider -->
                            <hr class="sidebar-divider mt-2 bg-light">
                            <div class="accordion" id="accordionPanelsStayOpenExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                            <i class="fa-solid fa-database me-3"></i>
                                            Master Data
                                        </button>
                                    </h2>
                                    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                                        <div class="accordion-body">
                                            <li class="nav-item">
                                                <a class="nav-link" href="kosan.php"><i class="fa-solid fa-database me-3"></i>Data Kosan</a>
                                            </li>
                                            <!-- Divider -->
                                            <hr class="sidebar-divider mt-2 bg-light">
                                            <li class="nav-item">
                                                <a class="nav-link" href="kamar.php"><i class="fa-solid fa-database me-3"></i>Data Kamar</a>
                                            </li>
                                            <!-- Divider -->
                                            <hr class="sidebar-divider mt-2 bg-light">
                                            <li class="nav-item">
                                                <a class="nav-link" href="penyewa.php"><i class="fa-solid fa-database me-3"></i>Data Penyewa</a>
                                            </li>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Divider -->
                            <hr class="sidebar-divider mt-2 bg-light">

                            <li class="nav-item">
                                <a class="nav-link active" href="pesanan.php"><i class="fas fa-fw fa-tachometer-alt me-2"></i>Pesanan Kosan</a>
                            </li>
                            <!-- Divider -->
                            <hr class="sidebar-divider mt-2 bg-light">
                            <div class="logout">
                                <li class="nav-item-logout">
                                    <form method="POST">
                                        <button class="btn btn-primary" type="submit" name="logout-owner-btn"><i class="fa-solid fa-power-off me-2"></i>Log Out</button>
                                    </form>
                                </li>
                            </div>

                        </ul>
                    </div>
                    <div class="main-content-header col-sm-8 col-md-9 col-lg-9 col-xxl-10" id="main-content-header">
                        <!-- Content Wrapper -->
                        <div id="content-wrapper" class="d-flex flex-column">

                            <!-- Main Content -->
                            <div id="main-content">

                                <!-- Topbar -->
                                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 shadow">

                                    <!-- Sidebar Toggle (Topbar) -->
                                    <button id="sidebarToggleTop" onclick="myFunction()" class="btn btn-link rounded-circle d-sm-none mr-3">
                                        <i class="fa fa-bars"></i>
                                    </button>

                                    <!-- Topbar Navbar -->
                                    <ul class="navbar-nav ms-auto me-4">
                                        <!-- Nav Item - User Information -->
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" id="dropdownMenuButton1" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="text-capitalize"><?= $dataPemilik["nama"] ?></span>
                                                <img class="img-profile rounded-circle ms-2 mb-1" width="20px" height="20px" src="../owner/assets/icons/logo.png">
                                            </a>
                                            <!-- Dropdown - User Information -->
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                                <a class="dropdown-item" href="profile.php">
                                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                                    Profile
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </nav>
                                <!-- End of Topbar -->

                                <!-- Begin Page Content -->
                                <div class="container-fluid">

                                    <!-- Page Heading -->
                                    <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
                                    <h1 class="h3 mb-0 text-gray-800">Data Pesanan Kost</h1>
                                </div> -->
                                </div>
                                <!-- /.container-fluid -->

                                <!-- DataTales -->
                                <div class="card shadow">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between mb-2 mt-2">
                                            <h1 class="h3 mb-0 text-gray-800"><i class="fa-solid fa-database me-3"></i>Data
                                                Pesanan
                                                Kosan</h1>
                                            <!-- <button class="tambah-data-kost float-right">Tambah Data Kost</button> -->
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="example" class="display" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>ID Pesanan</th>
                                                        <th>Nama Pemesan</th>
                                                        <th>Mulai Sewa</th>
                                                        <th>Akhir Sewa</th>
                                                        <th>Action</th>
                                                        <th style="display: none;">Tanggal Sewa</th>
                                                        <th style="display: none;">Total Pembayaran</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($dataPemesan as $data) : ?>
                                                        <tr>
                                                            <td class="dt-control"></td>
                                                            <td><?= $data['idPesanan'] ?></td>
                                                            <td><?= "$data[firstName] $data[lastName]" ?></td>
                                                            <td><?= $data['mulaiSewa'] ?></td>
                                                            <td><?= $data['akhirSewa'] ?></td>
                                                            <td>
                                                                <form method="POST">
                                                                    <button class="btn btn-success" value="accept <?= "$data[idPesanan]" ?>" name="validation-btn" onclick="return confirm('Terima Pesanan?');">Accept</button>
                                                                    <button class="btn btn-danger" value="reject <?= "$data[idPesanan]" ?>" name="validation-btn" onclick="return confirm('Tolak dan Hapus Pesanan?');">Reject</button>
                                                                </form>
                                                            </td>
                                                            <td style="display: none;"><?= $data['tglPemesanan'] ?></td>
                                                            <td style="display: none;"><?= $data['totalPembayaran'] ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- End of Main Content -->

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
                </div>
            </div>
        </div>
    </div>

    </div>

    <script src="../owner/dist/js/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <!-- Custom scripts for all pages-->
    <!-- <script src="/owner/dist/js/hehe.js"></script> -->
    <script src="assets/app/js/index.js"></script>

    <!-- JS data tabel -->
    <script src="../owner/dist/js/datatables.min.js"></script>
    <script src="../owner/dist/js/dataTabel.js"></script>

</body>

</html>