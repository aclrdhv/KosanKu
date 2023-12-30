<?php

require('core/init.php');

session_start();


if (isset($_POST['btn-kos-singup'])) {

    $namaKos = $_POST['nama-kos'];
    $alamatKos = $_POST['alamat-kos'];
    $jumlahKamarKos = $_POST['jumlahkamar'];
    $hargaKos = $_POST['harga'];
    $jenisKos = $_POST['jenis'];
    $namabank = $_POST['nama-bank'];
    $rekening = $_POST['rekening'];
    $fasilitas = implode(', ', $_POST['fasilitas']);

    $idPemilik = $_SESSION['id_pemilik'];
    $gambar = $_FILES['kost-gambar'];
    $regis = registerKost($namaKos, $alamatKos, $jumlahKamarKos, $hargaKos, $jenisKos, $gambar, $idPemilik, $fasilitas);
    $kamarGenereated = generateKamar($jumlahKamarKos, $regis['idKost'], 3, 4);
    $rekeningGenerated = generateRekening($namabank, $rekening, $idPemilik);
    $idKost = $regis['idKost'];

    // var_dump($fasilitas);
    // foreach($fasilitas as $fasil){
    //     $fasilGenerated = addFasilKost($idKost, $fasil);
    //     var_dump($fasil);
    //     var_dump($fasilGenerated);
    // }

    if ($regis['isSuccess'] && $kamarGenereated && $rekeningGenerated && !$_SESSION['login-admin']) {
        header("Location: login.php");
        exit;
    } else if ($regis['isSuccess'] && $kamarGenereated && $rekeningGenerated && $_SESSION['login-admin']) {
        header("Location: kosan.php");
        exit;
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/app/css/custom.style.css">
    <!-- FavIcon -->
    <link rel=" icon" href="assets/icons/KosanKu2.png">
</head>

<body>

    <!-- MAIN BARU -->
    <main>
        <section class="section-sign-up" style="background-color: #ffffff;">
            <div class="container">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-xl-10">
                        <div class="card rounded-3 text-black">
                            <div class="row">
                                <div class="col-lg-6 d-flex align-items-center gradient-custom-2 bg-primary">
                                    <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel"
                                            data-bs-interval=3500>
                                            <div class="carousel-indicators">
                                                <button type="button" data-bs-target="#carouselExampleCaptions"
                                                    data-bs-slide-to="0" class="active" aria-current="true"
                                                    aria-label="Slide 1"></button>
                                                <button type="button" data-bs-target="#carouselExampleCaptions"
                                                    data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                <button type="button" data-bs-target="#carouselExampleCaptions"
                                                    data-bs-slide-to="2" aria-label="Slide 3"></button>
                                            </div>
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <img src="assets/app/images/login.png" class="d-block w-100"
                                                        alt="...">
                                                    <div class="carousel-caption d-none d-md-block">
                                                        <h5>First slide label</h5>
                                                        <p>Some representative placeholder content for the first slide.
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="carousel-item">
                                                    <img src="assets/app/images/login2.png" class="d-block w-100"
                                                        alt="...">
                                                    <div class="carousel-caption d-none d-md-block">
                                                        <h5>Second slide label</h5>
                                                        <p>Some representative placeholder content for the second slide.
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="carousel-item">
                                                    <img src="assets/app/images/login3.png" class="d-block w-100"
                                                        alt="...">
                                                    <div class="carousel-caption d-none d-md-block">
                                                        <h5>Third slide label</h5>
                                                        <p>Some representative placeholder content for the third slide.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="carousel-control-prev" type="button"
                                                data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button"
                                                data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card-body p-md-3">
                                        <div class="text-center">
                                            <h4> <img class="pb-2 pe-2" src="../owner/assets/icons/KosanKu2.png"
                                                    style="width: 50px; height:50px;" alt="logo">KosanKu</h4>
                                        </div>
                                        <form class="form-signin" method="POST" enctype="multipart/form-data">
                                            <p class="fw-bold text-center">CREATE KOSAN</p>
                                            <div class="form-floating">
                                                <input type="text" class="form-control pt-1" id="floatingInput"
                                                    placeholder="name@example.com" name="nama-kos" autocomplete="off">
                                                <label for="floatingInput">Nama Kosan</label>
                                            </div>

                                            <div class="form-floating">
                                                <input type="text" class="form-control sign-up-input"
                                                    id="floatingPassword" placeholder="alamat" name="alamat-kos"
                                                    autocomplete="off">
                                                <label for="floatingPassword">Alamat Kosan</label>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <div class="form-floating">
                                                        <input type="number" class="form-control sign-up-input"
                                                            id="floatingInput" placeholder="Jumlah kamar"
                                                            name="jumlahkamar" autocomplete="off">
                                                        <label for="floatingInput">Jumlah Kamar</label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control sign-up-input"
                                                            id="floatingInput" placeholder="Harga" name="harga"
                                                            autocomplete="off">
                                                        <label for="floatingInput">Harga Kosan</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-floating">
                                                <select class="form-select" aria-label="Default select example"
                                                    name="jenis">
                                                    <option value="Putra" selected>Putra</option>
                                                    <option value="Putri">Putri</option>
                                                    <option value="Campuran">Campuran</option>
                                                </select>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col">
                                                    <div class="form-floating">
                                                        <select class="form-select" aria-label="Default select example"
                                                            name="nama-bank">
                                                            <option selected>Pilih Bank</option>
                                                            <option value="Bank Rakyat Indonesia">Bank Rakyat Indonesia
                                                            </option>
                                                            <option value="Bank Mandiri">Bank Mandiri</option>
                                                            <option value="Bank Negara Indonesia">Bank Negara Indonesia
                                                            </option>
                                                            <option value="Bank Syariah Indonesia">Bank Syariah
                                                                Indonesia</option>
                                                            <option value="Bank Central Asia">Bank Central Asia</option>
                                                            <option value="Bank BPD DIY">Bank BPD DIY</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" id="floatingInput"
                                                            placeholder="No Rekening" name="rekening"
                                                            autocomplete="off">
                                                        <label for="floatingInput">No Rekening</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="fasilitas">
                                                <div class="row">
                                                    <div class="col-3">
                                                        <input type="checkbox" id="ac" name="fasilitas[]" value="AC">
                                                        <label for="ac"> AC </label><br>
                                                    </div>
                                                    <div class="col-3">
                                                        <input type="checkbox" id="tv" name="fasilitas[]"
                                                            value="Kamar Mandi Dalam">
                                                        <label for="tv"> Kamar Mandi Dalam</label><br>
                                                    </div>
                                                    <div class="col-3">
                                                        <input type="checkbox" id="wifi" name="fasilitas[]"
                                                            value="Wifi">
                                                        <label for="kmdalam"> Wifi</label><br>
                                                    </div>
                                                    <div class="col-3">
                                                        <input type="checkbox" id="air" name="fasilitas[]" value="Air">
                                                        <label for="kasur"> Air </label><br>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-3">
                                                        <input type="checkbox" id="listrik" name="fasilitas[]"
                                                            value="Listrik">
                                                        <label for="meja"> Listrik</label><br>
                                                    </div>
                                                    <div class="col-3">
                                                        <input type="checkbox" id="kasur" name="fasilitas[]"
                                                            value="Kasur">
                                                        <label for="kasur"> Kasur </label><br>
                                                    </div>
                                                    <div class="col-3">
                                                        <input type="checkbox" id="lemari" name="fasilitas[]"
                                                            value="Lemari">
                                                        <label for="lemari"> Lemari</label><br>
                                                    </div>
                                                    <div class="col-3">
                                                        <input type="checkbox" id="meja" name="fasilitas[]"
                                                            value="Meja">
                                                        <label for="kasur"> Meja </label><br>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-2">
                                                <label class="label-upload" style="color:#2155CD;">Upload Foto
                                                    Kosan</label>
                                                <!-- <hr class="sidebar-divider bg-light"> -->
                                                <input type="file" class="form-control" id="inputGroupFile02"
                                                    name="kost-gambar"><br><br>
                                            </div>
                                            <button class="w-100 btn btn-lg btn-primary btn-login" type="submit"
                                                name="btn-kos-singup"
                                                style="margin-top:-35px ; margin-bottom:-30px;">Sign Up
                                            </button>
                                            <div class="d-flex align-items-center justify-content-center">
                                                <p class="me-2 mt-3 ms-2">Have an account?</p>
                                                <a class="user-signup" href="login.php">Sign In</a>
                                            </div>
                                        </form>
                                        <p class="mb-2 text-center" style="color:#2155CD ;">&copy;2023 KosanKu All
                                            rights reserved</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="assets/app/js/jquery.min.js"></script>

</body>

</html>