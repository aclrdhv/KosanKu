<?php

session_start();

require('core/init.php');

$kosId = $_GET['q'];
$kos = getDataFromId("kost", $kosId);

$fasilitas = $kos['fasilitas'];
$f = (explode(",", $fasilitas));


$mapKosAddr = explode(" ", $kos['alamat']);
$mapKosNama = explode(" ", $kos['nama']);

$floatHarga = (float) $kos['harga'];
$hargaFormatted = number_format($floatHarga);

if (isset($_POST["btn_submit"])) {
    // cek ketersediaan akun di DB
    $email = $_POST['email'];
    $password = $_POST['password'];

    $verify = verifyLogin($email, $password);

    if ($verify) {
        $NIK = getUniqueId($email);
        $_SESSION['userNIK'] = $NIK;
        $_SESSION['NIK'] = $NIK;
        $_SESSION['login'] = TRUE;
    }
}


if (isset($_POST['rent-btn'])) {
    $duration = $_POST['duration'];
    $startDate = $_POST['start-date'];

    if (checkRentFillness($startDate, $duration)) {
        $_SESSION['harga'] = (int) $floatHarga;
        $_SESSION['tgl_mulai'] = $startDate;
        $_SESSION['durasi'] = $duration;
        $_SESSION['id_pemilik'] = findKostOwner($kos['nama']);

        $idPemesan = $_SESSION['userNIK'];
        $durasi = 2628000 * $duration;
        $time = strtotime($startDate) + $durasi;
        $endDate = date('Y-m-d', $time);
        $qualify = addPesanan($idPemesan, $kosId, $startDate, $endDate, (int)$floatHarga * $duration);

        if ($qualify) {
            header("Location: transaksi.php");
            exit;
        }
    }
    echo "Belum terisi penuh";
}

// get kamar
$sql = "SELECT kamar.panjang, kamar.lebar FROM kamar";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);
// var_dump($data);
$panjangkamar = $data['panjang'];
$lebarkamar = $data['lebar'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;900&family=Ubuntu:wght@500&display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" href="assets/icon/Logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- xzoom -->
    <link rel="stylesheet" href="../user/assets/js/dist/xzoom.css">
    <title>Detail Kosan</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <div class="sidebar-brand-icon">
                    <a class="navbar-brand" href="index.php">
                        <img src="assets/icon/KosanKu.png" alt="#logo" style="width:120px;height:80px;">
                    </a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="carikos.php">Cari Kosan</a>
                        </li>
                    </ul>
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-primary" type="submit" name="search">Search</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>


    <main class="container">

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                            <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                            </symbol>
                            <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                            </symbol>
                            <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                            </symbol>
                        </svg>

                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                                <use xlink:href="#exclamation-triangle-fill" />
                            </svg>
                            <div>
                                incorrect email or password
                            </div>
                        </div>

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Sign In</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Sign
                                    Up</button>
                            </li>
                        </ul>
                        <!-- <h5 class="modal-title" id="exampleModalLabel">Sign In</h5> -->
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <!-- Form Login -->
                                <form class="form-signin" method="POST">
                                    <img class="mb-4 icon-img" src="assets/icon/KosanKu.png" alt="" width="72" height="57">
                                    <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email" autocomplete="off">
                                        <label for="floatingInput">Email address</label>
                                    </div>
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
                                        <label for="floatingPassword">Password</label>
                                    </div>
                                    <div class="checkbox mb-3">
                                        <label>
                                            <input type="checkbox" value="true" name="is_remember"> Remember me
                                        </label>
                                    </div>
                                    <button class="w-100 btn btn-lg btn-primary btn-login" type="submit" name="btn_submit">Sign
                                        in</button>
                                </form>

                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <form class="form-signin" method="POST">
                                    <img class="mb-4 icon-img" src="assets/icon/KosanKu.png" alt="" width="72" height="57">

                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email" autocomplete="off">
                                        <label for="floatingInput">Email address</label>
                                    </div>

                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="floatingPassword" placeholder="password" name="password" autocomplete="off">
                                        <label for="floatingPassword">Password</label>
                                    </div>

                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingInput" placeholder="nama depan" name="nama_depan" autocomplete="off">
                                        <label for="floatingInput">Nama Depan</label>
                                    </div>

                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingInput" placeholder="nama belakang" name="nama_belakang" autocomplete="off">
                                        <label for="floatingInput">Nama Belakang</label>
                                    </div>

                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingInput" placeholder="NIK" name="nik" autocomplete="off">
                                        <label for="floatingInput">NIK</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="flexRadioDefault1" value="L">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            Laki-laki
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="flexRadioDefault2" checked value="P">
                                        <label class="form-check-label" for="flexRadioDefault2">
                                            Perempuan
                                        </label>
                                    </div>

                                    <button class="btn btn-primary" type="submit" name="button_signup">Submit</button>
                                </form>
                            </div>
                        </div>

                    </div>
                    <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div> -->
                </div>
            </div>
        </div>
        <section class="display-kos-image">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 xzoom-container">
                    <img class="primary-img img-fluid rounded xzoom" xoriginal="assets/images/kamar_kos.jpg" id="xzoom-default" src="assets/images/kamar_kos.jpg" title="Gambar 1" alt="">
                    <div class="row mt-2">
                        <div class="col-3">
                            <a href="assets/images/kamar_kos.jpg">
                                <img class="primary-img img-fluid rounded xzoom-gallery" src="assets/images/kamar_kos.jpg" title="Gambar 2" alt="">
                            </a>
                        </div>
                        <div class="col-3">
                            <a href="assets/images/kos.jpg">
                                <img class="primary-img img-fluid rounded xzoom-gallery" src="assets/images/kos.jpg" title="Gambar 3" alt="">
                            </a>
                        </div>
                        <div class="col-3">
                            <a href="assets/images/kamar_kos.jpg">
                                <img class="primary-img img-fluid rounded xzoom-gallery" src="assets/images/kamar_kos.jpg" title="Gambar 4" alt="">
                            </a>
                        </div>
                        <div class="col-3">
                            <a href="assets/images/kos.jpg">
                                <img class="primary-img img-fluid rounded xzoom-gallery" src="assets/images/kos.jpg" title="Gambar 5" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <!-- kanan -->
                </div>

                <!-- <div class="col">
                    <div class="row">
                        <div class="col">
                            <img class="secondary-img" src="assets/images/kamar_kos.jpg" alt="">
                        </div>
                    </div>
                    <div class="row lower-row-galery">
                        <div class="col">
                            <img class="secondary-img" src="assets/images/kamar_kos.jpg" alt="">
                        </div>
                    </div>
                </div> -->
            </div>
        </section>

        <section class="">
            <div class="row">
                <div class="col specification-section">

                    <div class="kos-info">
                        <h3 class="section-heading"> <?= $kos['nama']; ?> </h3>
                        <span class="section-col" style="padding:5px; border: 1px solid black; border-radius:10px;"> <?= $kos['jenis'] ?> </span> <br><br>
                        <span class="section-col"> <?= $kos['alamat']; ?> </span>
                    </div>
                    <hr>
                    <div class="kos-specification">
                        <h4 class="section-heading"> Spesifikasi kamar </h4>
                        <span class="section-col"><i class="fa-solid fa-house-chimney-window me-2"></i> <?= $panjangkamar . '  x  ' . $lebarkamar ?> Meter </span>
                    </div>
                    <hr>
                    <div class="kos-facility">
                        <h4 class="section-heading"> Fasilitas </h4>
                        <?php foreach ($f as $fs) : ?>
                            <span class="me-4"> <?= $fs . ',' ?></span>
                        <?php endforeach; ?>
                    </div>
                    <hr>

                    <div class="kos-lokasi">
                        <h4 class="section-heading">Lokasi</h4>
                        <div class="mapouter">
                            <div class="gmap_canvas"><iframe width="400" height="300" id="gmap_canvas" src="https://maps.google.com/maps?q=<?= $mapKosNama[0] ?>%20<?= $mapKosNama[1] ?>%20<?= $mapKosAddr[0] ?>%20<?= $mapKosAddr[1] ?>%20<?= $mapKosAddr[2] ?>&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://123movies-to.org"></a><br>
                                <style>
                                    .mapouter {
                                        position: relative;
                                        text-align: right;
                                        height: 300px;
                                        width: 400px;
                                    }
                                </style><a href="https://www.embedgooglemap.net">google maps iframe embed</a>
                                <style>
                                    .gmap_canvas {
                                        overflow: hidden;
                                        background: none !important;
                                        height: 300px;
                                        width: 400px;
                                    }
                                </style>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col rent-section">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php
                                echo "Rp $hargaFormatted.00";
                                ?>
                                <span class="subs-text">/ bulan</span>
                            </h5>
                            <form method="POST">
                                <input class="form-control me-2 rent-input" type="date" placeholder="Mulai Sewa" aria-label="Search" name="start-date">
                                <input class="form-control me-2 rent-input" type="text" placeholder="Lama Sewa per bulan" aria-label="Search" name="duration">
                                <?php if (isset($_SESSION['login'])) : ?>
                                    <button class="btn btn-primary rent-btn" type="submit" name="rent-btn">Continue Payment</button>
                                <?php endif; ?>
                            </form>
                            <?php if (!isset($_SESSION['login'])) : ?>
                                <button class="btn btn-primary rent-btn hidden-btn" type="submit" name="rent-btn" data-bs-toggle="modal" data-bs-target="#exampleModal">Continue Payment</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="kos-review">
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Enim, possimus! Aperiam animi fugiat obcaecati
            laudantium dolorem nihil a rerum voluptatibus temporibus voluptatem ut id excepturi expedita, doloribus quas
            ex. Veritatis?
            Quos recusandae commodi corporis eos eum, ducimus quae? Eveniet at commodi iste repellendus pariatur
            corrupti reprehenderit, laudantium alias cupiditate! Sed ut sint omnis consequuntur pariatur! Eveniet,
            quidem. Odio, natus alias?
            Expedita dolorum, reprehenderit, corrupti nihil ad omnis neque cum aut quibusdam dolor quia dignissimos
            voluptatem dolores aliquid sint maiores nisi placeat amet qui doloribus soluta optio quae. Expedita,
            voluptatibus a?
            Assumenda dolorum consequatur, autem aliquam unde nulla fugit earum expedita consectetur optio omnis tempora
            similique aliquid minima, atque praesentium amet? Expedita cumque tempore maiores magnam debitis delectus
            quae qui ipsum?
            Dicta sunt nisi atque odio unde rerum quas error maiores qui, cupiditate recusandae quaerat possimus, eius
            autem fugiat est aperiam nulla, voluptatum ex. Aliquam eveniet, laborum ut maxime ipsum dolor.
        </section>
    </main>

    <footer class="w-100 py-4 flex-shrink-0">
        <div class="container">
            <div class="row gy-4 gx-5">
                <div class="col-lg-4 col-md-6">
                    <h5 class="h1 text-black mb-2">
                        <img src="assets/icon/KosanKu.png" class="mb-3 me-2" width="150" height="100" alt="logo">
                    </h5>
                    <p class="small text-muted fw-bold">Mencari kosan sangat mudah menggunakan KosanKu</p>
                    <ul class="list-unstyled text-muted">
                        <li><a href="#tentangkami">Tentang Kami</a></li>
                        <li><a href="#..">Promosikan Kosan Anda</a></li>
                        <li><a href="#bantuan">Pusat Bantuan</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 pt-3">
                    <h5 class="text-black mb-3 fw-bold">Hubungi Kami</h5>

                    <ul class="list-unstyled text-muted">
                        <li>
                            <!-- Facebook -->
                            <a class="social-media-ref" href="#Facebook">
                                <i class="fa-brands fa-facebook me-2"></i>Facebook
                            </a>
                        </li>
                        <li>
                            <!-- Twitter -->
                            <a class="social-media-ref" href="#Twitter">
                                <i class="fa-brands fa-twitter me-2 "></i>Twitter
                            </a>
                        </li>
                        <li>
                            <!-- Instagram -->
                            <a class="social-media-ref" href="#Instagram">
                                <i class="fa-brands fa-instagram me-2"></i>Instagram
                            </a>
                        </li>
                        <li>
                            <a class="social-media-ref" href="#LinkedIn">
                                <i class="fa-brands fa-linkedin me-2"></i>LinkedIn
                            </a>
                        </li>
                        <li>
                            <a class="social-media-ref" href="#Email">
                                <i class="fa-regular fa-envelope me-2"></i>kosanku@gmail.com
                            </a>
                        </li>
                        <!-- <li>
                            <a class="social-media-ref" href="#Whatsapp">
                                <i class="fab fa-whatsapp-square me-2"></i> +6281668909890
                            </a>
                        </li> -->
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5 class="text-black mb-3 fw-bold pt-3">Kebijakan</h5>
                    <ul class="list-unstyled text-muted">
                        <li><a href="#kebijakan">Kebijakan Privasi</a></li>
                        <li><a href="#syarat&ketentuan">Syarat dan Ketentuan Umum</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-Black fw-bold mb-3 pt-3">Bandung, Indonesia</h5>
                    <p class="small text-muted">Jika ada sesuatu hal yang ingin disampaikan silahkan kirimkan pesan
                        kepada kami.</p>
                    <form action="#">
                        <div class="input-group mb-3">
                            <input class="form-control" type="text" placeholder="Recipient's username"
                                aria-label="Recipient's username" aria-describedby="button-addon2">
                            <button class="btn btn-primary" id="button-addon2" type="button"><i
                                    class="fas fa-paper-plane"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </footer>
    <div class="text-center p-3 text-white fw-bold mt-3" style="background-color: #2155cd;">
        2023 © Copryright <a class="text-white" href="#kosanku.com">KOSANKU</a> - All rights reserved - Made in
        Telkom University Bandung
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- XZOOM -->
    <script src="../user/assets/js/dist/xzoom.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.xzoom, .xzoom-gallery').xzoom({
                zoomWidth: 500,
                zoomHeight: 300,
                title: true,
                tint: '#333',
                Xoffset: 50,
            })
        });
    </script>
</body>

</html>