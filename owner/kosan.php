<?php
session_start();
require('core/init.php');

$nikAkun = $_SESSION["id_pemilik"];

global $conn;

$pemilik = mysqli_query($conn, "SELECT * FROM pemilik WHERE NIK='$nikAkun'");
$dataPemilik = mysqli_fetch_assoc($pemilik);
$kost = mysqli_query($conn, "SELECT * FROM kost WHERE NIK_Pemilik = $nikAkun");
$dataKost = $kost->fetch_array();

if (isset($_POST['logout-owner-btn'])) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}

if (!isset($_SESSION['login-admin'])) {
    header("Location: login.php");
    exit;
}
// get username
$id = $_SESSION['id_pemilik'];
$data = getDataFromId("pemilik", $id);

// get data kost by NIK
// $dataKost = getDataKost($id);

// hapus data kost beserta value di foreign key nya
if (isset($_GET['hapus'])) {
    $idKost = $_GET['hapus'];
    echo $idKost;
    // var_dump($idKost);
    deleteDataKost($idKost);
    echo "<script> 
            alert('Data kost berhasil dihapus!');
            document.location.href = 'kosan.php';
        </script>
    ";
}


if (isset($_POST["edit"])) {
    $nama = $_POST["nama"];
    $alamat = $_POST["alamat"];
    $jmlKamar = $_POST["jmlKamar"];
    // var_dump($_GET);
    $id = $_POST["id"];

    $query = "UPDATE kost SET 
                nama = '$nama',
                alamat = '$alamat',
                jumlahKamar = '$jmlKamar',
            WHERE id = '$id'";
    mysqli_query($conn, $query);

    if (mysqli_affected_rows($conn) > 0) {
        echo "<script> document.location.href = 'kosan.php'; </script>";
    };
}

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
    <link href="../owner/dist/css/index.css" rel="stylesheet">
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
                                                <a class="nav-link active" href="kosan.php"><i class="fa-solid fa-database me-3"></i>Data Kosan</a>
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
                                <a class="nav-link" href="pesanan.php"><i class="fas fa-fw fa-tachometer-alt me-2"></i>Pesanan Kosan</a>
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
                        <div id="content-wrapper" class="d-flex flex-column">
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
                                    <!-- DataTales -->
                                    <div class="card shadow">
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between mb-2 mt-2">
                                                <h1 class="h3 mb-0 text-gray-800"><i class="fa-solid fa-database me-3"></i>Data Kosan</h1>
                                                <a href="addKosan.php" class="tambah-data-kost float-right" style="text-decoration:none ;">
                                                    <i class="fa-solid fa-plus me-2"></i>Tambah Data Kosan</a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>ID Kosan</th>
                                                            <th>Nama Kosan</th>
                                                            <th>Alamat</th>
                                                            <th>Fasilitas</th>
                                                            <th>Jumlah Kamar</th>
                                                            <th>Gambar</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <!-- <tfoot>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>ID Kost</th>
                                                            <th>Nama Kost</th>
                                                            <th>Alamat</th>
                                                            <th>Fasilitas</th>
                                                            <th>Jmlh Kamar</th>
                                                            <th>Gambar</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </tfoot> -->
                                                    <tbody>
                                                        <form action="" method="POST">
                                                            <?php
                                                            // var_dump($dataKost["id"]);
                                                            if (empty($dataKost["id"])) {
                                                                echo "<tr>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                    </tr>";
                                                            } else {
                                                                $nomor = 1;
                                                                $kost = mysqli_query($conn, "SELECT * FROM kost WHERE NIK_Pemilik = $nikAkun");
                                                                while ($dataKost = $kost->fetch_array()) {
                                                                    $idKost = $dataKost["id"];
                                                                    $fasilitas = mysqli_query($conn, "SELECT nama FROM fasilitas WHERE id = ANY(SELECT id_fasil FROM fasil_kost WHERE id_kost = $idKost)");
                                                                    $allFasilitas = "";
                                                                    $i = 0;
                                                                    while ($fasil = $fasilitas->fetch_array()) {
                                                                        $nama = $fasil["nama"];
                                                                        if ($i > 0) {
                                                                            $allFasilitas = $allFasilitas . ", " . $nama;
                                                                        } else {
                                                                            $allFasilitas = $nama;
                                                                        }
                                                                        $i++;
                                                                    }
                                                                    echo "<tr>
                                                                            <td>" . $nomor . "</td>
                                                                            <td>" . $idKost . "</td>
                                                                            <td>" . $dataKost["nama"] . "</td>
                                                                            <td>" . $dataKost["alamat"] . "</td>
                                                                            <td>" . $dataKost['fasilitas'] . "</td>
                                                                            <td>" . $dataKost["jumlahKamar"] . "</td>
                                                                            <td>" . $dataKost["gambar_preview"] . "</td>
                                                                            <td>
                                                                                <a href='kosan.php?idKost=$idKost'>
                                                                                    <button type='submit' name='edit' class='btn btn-success'>edit</button>
                                                                                </a>
                                                                                <a href='deleteKosan.php?idKost=$idKost'>
                                                                                    <button type='submit' name='hapus' class='btn btn-danger'>hapus</button>
                                                                                </a>
                                                                            </td>
                                                                        </tr>";
                                                                    $nomor++;
                                                                }
                                                            }
                                                            ?>
                                                        </form>
                                                    </tbody>
                                                </table>
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

    <script src="../owner/dist/js/jquery.js"></script>
    <script src="../owner/assets/app/js/bootstrap.bundle.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/owner/dist/js/hehe.js"></script>

    <!-- JS data tabel -->
    <script src="../owner/dist/js/datatables.min.js"></script>
    <script src="../owner/dist/js/dataTabel.js"></script>

</body>

</html>