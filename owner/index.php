<?php
session_start();

require('core/init.php');

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

$nikAkun = $_SESSION["id_pemilik"];
$dataPemilik = getDataPemilik($nikAkun);

$currentDate = date("Y-m-d'", time());
$currentYear = explode("-", $currentDate)[0];

$idKost = getUniqueIdKostByNIK($_SESSION['id_pemilik'])['id'];

// $kamarGenereated = generateKamar(21, 3, 3, 4);

$countPesanan = countPesanan($idKost)['pesanan'];
$countKamar = countDataKamar($nikAkun)['kamar'];
// var_dump($countKamar);

// get count data kost tiap owner 
$id = $_SESSION['id_pemilik'];
$countDataKost = countDataKos($id)['kost'];

// get count penghuni kost tiap owner 
$countPenghuni = countPenghuniKost($id);

// get username
$data = getDataFromId("pemilik", $id);

$putra = countDataPeminatKost("Putra");
$putri = countDataPeminatKost("Putri");
$campur = countDataPeminatKost("Campur");


$dataPoints = array(
    array("label" => "Putra", "y" => $putra),
    array("label" => "Putri", "y" => $putri),
    array("label" => "Campur", "y" => $campur),
);

$janMasuk = getSewaMasukByBulan("01", $idKost);
$febMasuk = getSewaMasukByBulan("02", $idKost);
$marMasuk = getSewaMasukByBulan("03", $idKost);
$aprMasuk = getSewaMasukByBulan("04", $idKost);
$mayMasuk = getSewaMasukByBulan("05", $idKost);
$junMasuk = getSewaMasukByBulan("06", $idKost);
$julMasuk = getSewaMasukByBulan("07", $idKost);
$augMasuk = getSewaMasukByBulan("08", $idKost);
$sepMasuk = getSewaMasukByBulan("09", $idKost);
$octMasuk = getSewaMasukByBulan("10", $idKost);
$novMasuk = getSewaMasukByBulan("11", $idKost);
$decMasuk = getSewaMasukByBulan("12", $idKost);

$janKeluar = getSewaKeluarByBulan("01", $idKost);
$febKeluar = getSewaKeluarByBulan("02", $idKost);
$marKeluar = getSewaKeluarByBulan("03", $idKost);
$aprKeluar = getSewaKeluarByBulan("04", $idKost);
$mayKeluar = getSewaKeluarByBulan("05", $idKost);
$junKeluar = getSewaKeluarByBulan("06", $idKost);
$julKeluar = getSewaKeluarByBulan("07", $idKost);
$augKeluar = getSewaKeluarByBulan("08", $idKost);
$sepKeluar = getSewaKeluarByBulan("09", $idKost);
$octKeluar = getSewaKeluarByBulan("10", $idKost);
$novKeluar = getSewaKeluarByBulan("11", $idKost);
$decKeluar = getSewaKeluarByBulan("12", $idKost);

$dataPoints1 = array(
    array("label" => "Jan", "y" => $janMasuk),
    array("label" => "Feb", "y" => $febMasuk),
    array("label" => "Mar", "y" => $marMasuk),
    array("label" => "Apr", "y" => $aprMasuk),
    array("label" => "May", "y" => $mayMasuk),
    array("label" => "Jun", "y" => $junMasuk),
    array("label" => "Jul", "y" => $julMasuk),
    array("label" => "Aug", "y" => $augMasuk),
    array("label" => "Sep", "y" => $sepMasuk),
    array("label" => "Oct", "y" => $octMasuk),
    array("label" => "Nov", "y" => $novMasuk),
    array("label" => "Dec", "y" => $decMasuk)
);

$dataPoints2 = array(
    array("label" => "Jan", "y" => $janKeluar),
    array("label" => "Feb", "y" => $febKeluar),
    array("label" => "Mar", "y" => $marKeluar),
    array("label" => "Apr", "y" => $aprKeluar),
    array("label" => "May", "y" => $mayKeluar),
    array("label" => "Jun", "y" => $junKeluar),
    array("label" => "Jul", "y" => $julKeluar),
    array("label" => "Aug", "y" => $augKeluar),
    array("label" => "Sep", "y" => $sepKeluar),
    array("label" => "Oct", "y" => $octKeluar),
    array("label" => "Nov", "y" => $novKeluar),
    array("label" => "Dec", "y" => $decKeluar)
);

$barChartData = array(
    array("y" => 7, "label" => "March"),
    array("y" => 12, "label" => "April"),
    array("y" => 28, "label" => "May"),
    array("y" => 18, "label" => "June"),
    array("y" => 41, "label" => "July")
);

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
    <link href=" assets/app/css/style.css" rel="stylesheet"">
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
                                <a class="nav-link active" aria-current="page" href="index.php"><i class="fas fa-fw fa-tachometer-alt me-2 active"></i>
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

                                <!-- Begin Page Content -->
                                <div class="container-fluid">
                                    <!-- Page Heading -->
                                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                                    </div>

                                    <!-- Content Row -->
                                    <div class="row">
                                        <!-- Earnings (Monthly) Card Example -->
                                        <div class="col-xl-3 col-md-6 mb-4">
                                            <div class="card border-left-primary shadow h-100 py-2">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                Jumlah Kosan</div>
                                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                <?= $countDataKost ?></div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Earnings (Monthly) Card Example -->
                                        <div class="col-xl-3 col-md-6 mb-4">
                                            <div class="card border-left-success shadow h-100 py-2">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                                Jumlah Kamar</div>
                                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                <?= $countKamar ?></div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Earnings (Monthly) Card Example -->
                                        <div class="col-xl-3 col-md-6 mb-4">
                                            <div class="card border-left-info shadow h-100 py-2">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                                Jumlah Penghuni
                                                            </div>
                                                            <div class="row no-gutters align-items-center">
                                                                <div class="col-auto">
                                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                                        <?= $countPenghuni ?></div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="progress progress-sm mr-2">
                                                                        <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Pending Requests Card Example -->
                                        <div class="col-xl-3 col-md-6 mb-4">
                                            <a href="pesanan.php">
                                                <div class="card border-left-warning shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">
                                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                                    Pesanan Menunggu</div>
                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    <?= $countPesanan  ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Content Row -->

                                    <div class="row">
                                        <!-- Area Chart -->
                                        <div class="col-xl-8 col-lg-7">
                                            <div class="card shadow mb-4">
                                                <!-- Card Header - Dropdown -->
                                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                                    <h6 class="m-0 font-weight-bold text-primary">Jumlah Keluar/Masuk
                                                        Penyewa</h6>
                                                    <div class="dropdown no-arrow">
                                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                                            <div class="dropdown-header">Dropdown Header:</div>
                                                            <a class="dropdown-item" href="#">Action</a>
                                                            <a class="dropdown-item" href="#">Another action</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item" href="#">Something else here</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Card Body -->
                                                <div class="card-body">
                                                    <div class="chart-area">
                                                        <!-- <canvas id="myChart"></canvas> -->
                                                        <div id="myChart" style="height: 370px; width: 100%;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Pie Chart -->
                                        <div class="col-xl-4 col-lg-5">
                                            <div class="card shadow mb-4">
                                                <!-- Card Header - Dropdown -->


                                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                                    <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
                                                    <div class="dropdown no-arrow">
                                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                                            <div class="dropdown-header">Dropdown Header:</div>
                                                            <a class="dropdown-item" href="#">Action</a>
                                                            <a class="dropdown-item" href="#">Another action</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item" href="#">Something else here</a>
                                                        </div>
                                                    </div>
                                                </div>


                                                <!-- Card Body -->
                                                <div class="card-body">
                                                    <div class="chart-pie pt-4 pb-2">
                                                        <!-- <canvas id="myPieChart"></canvas> -->
                                                        <div id="pieChartContainer" style="height: 370px; width: 100%;">
                                                        </div>
                                                    </div>
                                                    <!-- <div class="mt-4 text-center small">
                                                    <span class="mr-2">
                                                        <i class="fas fa-circle text-primary"></i> Direct
                                                    </span>
                                                    <span class="mr-2">
                                                        <i class="fas fa-circle text-success"></i> Social
                                                    </span>
                                                    <span class="mr-2">
                                                        <i class="fas fa-circle text-info"></i> Referral
                                                    </span>
                                                </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Content Row -->
                                    <div class="row">
                                        <!-- Content Column -->
                                        <div class="col-lg-6 mb-4">

                                            <!-- Project Card Example -->
                                            <div class="card shadow mb-4">
                                                <div class="card-header py-3">
                                                    <h6 class="m-0 font-weight-bold text-primary">Perbandingan
                                                        Pendapatan Kos Berdasarkan Jenis</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div id="barChartContainer" style="height: 370px; width: 100%;">
                                                    </div>
                                                </div>
                                            </div>
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

    <!-- <script src="../owner/assets/app/js/bootstrap.min.js"></script> -->
    <script src="../owner/dist/js/jquery.js"></script>
    <script src="../owner/assets/app/js/bootstrap.bundle.min.js"></script>

    <!-- Custom scripts for all pages-->
    <!-- <script src="/owner/dist/js/hehe.js"></script> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="assets/app/js/canvasjs.min.js"></script>

    <script>
        window.onload = function() {

            const chart = new CanvasJS.Chart("myChart", {
                animationEnabled: true,
                theme: "light2",
                title: {
                    text: "Jumlah Penyewa Tahun <?= $currentYear ?>"
                },
                axisY: {
                    includeZero: true
                },
                legend: {
                    cursor: "pointer",
                    verticalAlign: "center",
                    horizontalAlign: "right",
                    itemclick: toggleDataSeries
                },
                data: [{
                    type: "column",
                    name: "Penyewa Masuk",
                    indexLabel: "{y}",
                    // yValueFormatString: "$#0.##",
                    showInLegend: true,
                    dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
                }, {
                    type: "column",
                    name: "Penyewa Keluar",
                    indexLabel: "{y}",
                    // yValueFormatString: "$#0.##",
                    showInLegend: true,
                    dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();

            function toggleDataSeries(e) {
                if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                } else {
                    e.dataSeries.visible = true;
                }
                chart.render();
            }

            const pieChart = new CanvasJS.Chart("pieChartContainer", {
                animationEnabled: true,
                exportEnabled: true,
                title: {
                    text: "Kos dengan minat terbanyak "
                },
                subtitles: [{
                    text: "Jumlah penyewa kos "
                }],
                data: [{
                    type: "pie",
                    showInLegend: "true",
                    legendText: "{label}",
                    indexLabelFontSize: 16,
                    indexLabel: "{label} - #percent%",
                    // yValueFormatString: "฿#,##0",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            pieChart.render();

        }

        const barChart = new CanvasJS.Chart("barChartContainer", {
            animationEnabled: true,
            title: {
                text: "Pendapatan"
            },
            axisY: {
                title: "Revenue (in IDR)",
                includeZero: true,
                prefix: "Rp",
                suffix: "k"
            },
            data: [{
                type: "bar",
                yValueFormatString: "IDR#,##0K",
                indexLabel: "{y}",
                indexLabelPlacement: "inside",
                indexLabelFontWeight: "bolder",
                indexLabelFontColor: "white",
                dataPoints: <?php echo json_encode($barChartData, JSON_NUMERIC_CHECK); ?>
            }]
        });
        barChart.render();
    </script>

</body>

</html>