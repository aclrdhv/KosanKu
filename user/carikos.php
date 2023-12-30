<?php

require('core/init.php');

session_start();

$dataKost = getalldata('kost');

if (isset($_POST['set-filter'])) {
    $filterJenis = $_POST['jenis-filter'];
    $minHarga = $_POST['min-harga'];
    $maxHarga = $_POST['max-harga'];
    $dataKost = filterSearch($filterJenis, $minHarga, $maxHarga);
}



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
    <!-- Star Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Cari Kosan</title>
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

    <main class="container-fluid">
        <section class="filter-field">
            <form method="POST">
                <select class="form-select" aria-label="Default select example" name="jenis-filter">
                    <option selected value="">Semua</option>
                    <option value="Putra">Putra</option>
                    <option value="Putri">Putri</option>
                    <option value="Campur">Campur</option>
                </select>
                <input type="text" class="form-control filter-input" placeholder="Rp. 0" name="min-harga">
                <input type="text" class="form-control filter-input" placeholder="Rp. 1.000.000" name="max-harga">
                <button class="btn btn-primary" type="submit" name="set-filter">Filter</button>
            </form>
        </section>

        <section class="kos-field">
            <div class="row">
                <?php foreach ($dataKost as $kos) : ?>
                    <div class="col-2" style="margin-right:200px ; margin-bottom: 30px;">
                        <a href="detailKosan.php?q=<?= $kos['id'] ?>">
                            <div class="card" style="width: 18.1rem;">
                                <img src="../assets/upload/<?= $kos['gambar_preview'] ?>" class="card-img-top">
                                <div class="card-body">
                                    <h4 class="card-text card-title">
                                        <?= $kos['nama']; ?>
                                    </h4>
                                    <p class="card-text">
                                        <?php if (strlen($kos['alamat'] > 35)) : ?>
                                            <?= substr($kos['alamat'], 0, 31) . "..." ?>
                                        <?php else : ?>
                                            <?php echo "$kos[alamat]"; ?>
                                        <?php endif; ?>
                                    </p>
                                    <p>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                    </p>
                                    <p class="card-text harga-text">
                                        <?php
                                        $floatHarga = (float) $kos['harga'];
                                        $hargaFormatted = number_format($floatHarga);
                                        echo "Rp $hargaFormatted.00";
                                        ?>
                                        <span class="subs-text">/ bulan</span>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
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
    <!-- Copyright -->
    <div class="text-center p-3 text-white fw-bold mt-3" style="background-color: #2155cd;">
        2023 © Copryright <a class="text-white" href="#kosanku.com">KOSANKU</a> - All rights reserved - Made in Telkom University Bandung
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="assets/js/scripts.js"></script>
</body>

</html>