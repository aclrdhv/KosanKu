<?php

require('core/init.php');

session_start();

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: index.php');
    exit;
};

if (isset($_POST["btn_submit"])) {
    // cek ketersediaan akun di DB
    $email = $_POST['email'];
    $password = $_POST['password'];

    $verify = verifyLogin($email, $password);
    // var_dump($verify);

    if ($verify) {
        $NIK = getUniqueId($email);
        $_SESSION['userNIK'] = $NIK;
        $_SESSION['login'] = TRUE;
        header('Location: index.php');
        exit;
    }
}

$response = ['error' => FALSE];

if (isset($_POST['button_signup'])) {
    $nama_depan = $_POST['nama_depan'];
    $nama_belakang = $_POST['nama_belakang'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $nik = $_POST['nik'];
    $noTelp = $_POST['noTelp'];

    $isComplete = checkCompleteess($email, $password, $nik);

    if ($isComplete) {
        // procees to checking regitered account by email
        $isRegistred = checkRegistredUser($email);

        if (!$isRegistred) {
            // make account if email is not set yet in the database
            $regis = registerAccount($email, $password, $nama_depan, $nama_belakang, $jenis_kelamin, $nik, $noTelp);

            if ($regis) {
                // regis is success 
                $response['error'] = FALSE;
                $response['user']['name'] = $regis['email'];
                $response['user']['key'] = $regis['NIK'];

                // echo json_encode($response);
            } else {
                // give warnings about failing to insert
                $response['error'] = TRUE;
                $response['error_msg'] = "failed insertion";

                // echo json_encode($response);
            }
        } else {
            // give warnings if email is used before
            $response['error'] = TRUE;
            $response['error_msg'] = "email is already registred";
            // echo json_encode($response);
        }
    } else {
        // give warnings unfinished data fillings
        echo "
        <script> alert('Some fields are not filled'); </script>
        ";
    }
}

$teks1 = "Mencatat setiap pengeluaran penting untuk 
mengetahui keluar masuknya uang dan membantu menyusun prioritas kebutuhan.";
$teks2 = "Membuat target IPK tiap semester, buat target IPK tiap semester besaran IPK menjadi penentu jumlah 
SKS yang bisa kamu ambil di semester berikutnya. Semakin besar IPK, semakin banyak pula SKS yang bisa kamu ambil.";
$teks3 = "Ketahui fasilitas kosan yang benar-benar penting,misalnya sudah tersedia kasur, lemari, dan internet, 
karena beberapa kosan murah hanya menawarkan kamar kosongan saja. Fokus pada fasilitas yang kamu butuhkan, bukan yang kamu inginkan.";
$teks4 = "Menyusun target belajar, karena memiliki target waktu untuk menguasai materi 
pelajaran tertentu akan membuat anda tertantang. Karena itu, susunlah jadwal dan bagi waktu belajar dengan baik. 
Bila berhasil mencapai target, berilah diri Anda hadiah kecil misal membeli camilan favorit.";
$teks5 = "Atur jadwal tidur,  Mulailah atur jadwal tidurmu dari sekarang. Kamu harus menargetkan diri untuk tidur 
lebih awal serta durasi waktunya yaitu sekitar 7-9 jam. Meski pada hari libur pun tetap saja lakukan jadwal tersebut agar 
dapat membiasakan diri untuk selalu bangun pagi";

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;900&family=Ubuntu:wght@500&display=swap"
        rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" href="assets/icon/Logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>KosanKu</title>
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
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="carikos.php">Cari Kosan</a>
                        </li>
                    </ul>
                    <?php if (!isset($_SESSION['login'])) : ?>
                    <!-- <form class="d-flex" method="POST"> -->
                    <button class="btn btn-outline-primary btn-nav" type="submit" name="signin" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">Sign In</button>
                    <!-- <button class="btn btn-outline-primary btn-nav" type="submit" name="signup">Sign Up</button> -->
                    <!-- </form> -->
                    <?php else : ?>
                    <form class="d-flex" method="POST">
                        <button class="btn btn-outline-primary btn-nav" type="submit" name="logout">Log Out</button>
                    </form>
                    <ul class="navbar-nav me-4">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdownMenuButton1" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <span></span>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="profile.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                            </div>
                        </li>
                    </ul>
                    <?php endif; ?>
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
                                <path
                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                            </symbol>
                            <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                            </symbol>
                            <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
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
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                    data-bs-target="#home" type="button" role="tab" aria-controls="home"
                                    aria-selected="true">Sign In</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                    type="button" role="tab" aria-controls="profile" aria-selected="false">Sign
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
                                    <img class="mb-4 icon-img" src="assets/icon/KosanKu.png" alt="" width="180"
                                        height="120">
                                    <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="floatingInput"
                                            placeholder="name@example.com" name="email" autocomplete="off">
                                        <label for="floatingInput">Email address</label>
                                    </div>
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="floatingPassword"
                                            placeholder="Password" name="password">
                                        <label for="floatingPassword">Password</label>
                                    </div>
                                    <div class="checkbox mb-3">
                                        <label>
                                            <input type="checkbox" value="true" name="is_remember"> Remember me
                                        </label>
                                    </div>
                                    <button class="w-100 btn btn-lg btn-primary btn-login" type="submit"
                                        name="btn_submit">Sign
                                        in</button>
                                </form>

                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <form class="form-signin" method="POST">
                                    <img class="mb-4 icon-img" src="assets/icon/KosanKu.png" alt="" width="180"
                                        height="120">

                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="floatingInput"
                                            placeholder="name@example.com" name="email" autocomplete="off">
                                        <label for="floatingInput">Email address</label>
                                    </div>

                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="floatingPassword"
                                            placeholder="password" name="password" autocomplete="off">
                                        <label for="floatingPassword">Password</label>
                                    </div>

                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingInput"
                                            placeholder="nama depan" name="nama_depan" autocomplete="off">
                                        <label for="floatingInput">Nama Depan</label>
                                    </div>

                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingInput"
                                            placeholder="nama belakang" name="nama_belakang" autocomplete="off">
                                        <label for="floatingInput">Nama Belakang</label>
                                    </div>

                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingInput" placeholder="NIK"
                                            name="nik" autocomplete="off">
                                        <label for="floatingInput">NIK</label>
                                    </div>

                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="floatingInput" placeholder="NIK"
                                            name="noTelp" autocomplete="off">
                                        <label for="floatingInput">No.Telepon</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin"
                                            id="flexRadioDefault1" value="L">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            Laki-laki
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin"
                                            id="flexRadioDefault2" checked value="P">
                                        <label class="form-check-label" for="flexRadioDefault2">
                                            Perempuan
                                        </label>
                                    </div>

                                    <button class="btn btn-primary" type="submit" name="button_signup">Submit</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <section id="slider" class="pt-5">
            <div class="container" >
                <!-- <h1 class="text-center"><b>Cari Kos</b></h1> -->
                <div class="slider">
                    <div class="owl-carousel" data-bs-ride="carousel">
                        <div class="slider-card">
                            <div class="d-flex justify-content-center align-items-center mb-4">
                                <img src="assets/images/owl5.jpg" alt="bangun pagi">
                            </div>
                            <h5 class="mb-0 text-center"><b>Tips Menghemat ala Anak Kos</b></h5>
                            
                            <p class="text-center p-4"><?= substr($teks1, 0, 97) . " ..." ?></p>   
                        </div>
                        <div class="slider-card">
                            <div class="d-flex justify-content-center align-items-center mb-4">
                                <img src="assets/images/owl2.jpg" alt="cepat lulus">
                            </div>
                            <h5 class="mb-0 text-center"><b>Tips Cepat Lulus</b></h5>
                            <p class="text-center p-4"><?= substr($teks2, 0, 97) . " ..." ?></p>
                        </div>
                        <div class="slider-card">
                            <div class="d-flex justify-content-center align-items-center mb-4">
                                <img src="assets/images/owl3.jpg" alt="kost terbaik">
                            </div>
                            <h5 class="mb-0 text-center"><b>Tempat Mencari Kosan Terbaik</b></h5>
                            <p class="text-center p-4"><?= substr($teks3, 0, 97) . " ..." ?></p>
                        </div>
                        <div class="slider-card">
                            <div class="d-flex justify-content-center align-items-center mb-4">
                                <img src="assets/images/owl4.jpg" alt="belajar efektif">
                            </div>
                            <h5 class="mb-0 text-center"><b>Tips Belajar Efektif</b></h5>
                            <p class="text-center p-4"><?= substr($teks4, 0, 97) . " ..." ?></p>
                        </div>
                        <div class="slider-card">
                            <div class="d-flex justify-content-center align-items-center mb-4">
                                <img src="assets/images/owl1.jpg" alt="">
                            </div>
                            <h5 class="mb-0 text-center"><b>Tips Bangun Pagi Rutin</b></h5>
                            <p class="text-center p-4"><?= substr($teks5, 0, 97) . " ..." ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="content-section">
            <div class="row">
                <div class="col">
                    <img src="assets/images/bed.jpg" alt="">
                </div>
                <div class="col ">
                    <h3>Anda bingung mencari kosan tapi males ke lokasi?</h3>
                    <p> Tenang!! KosanKu solusinya, anda bisa mencari kosan dimanapun dan kapanpun tanpa harus datang ke
                        lokasi.
                    </p>
                </div>
            </div>
        </section>

        <section class="content-section">
            <div class="row">
                <div class="col ">
                    <h3>Ingin tahu apa saja yang tersedia di KosanKu?</h3>
                    <p> Fast Response 24/7, Foto Properti Akurat, Foto Area & Informasi lengkap
                    </p>
                </div>
                <div class="col">
                    <img src="assets/images/bed2.jpg" alt="">
                </div>
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
                        <li><a href="#aboutus">Tentang Kami</a></li>
                        <li><a href="../owner">Promosikan Kosan Anda</a></li>
                        <li><a href="#bantuan">Pusat Bantuan</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 pt-3">
                    <h5 class="text-black mb-3 fw-bold">Hubungi Kami</h5>

                    <ul class="list-unstyled text-muted">
                        <li>
                            <!-- Facebook -->
                            <a class="social-media-ref" href="https://facebook.com">
                                <i class="fa-brands fa-facebook me-2"></i>Facebook
                            </a>
                        </li>
                        <li>
                            <!-- Twitter -->
                            <a class="social-media-ref" href="https://x.com">
                                <i class="fa-brands fa-twitter me-2 "></i>Twitter
                            </a>
                        </li>
                        <li>
                            <!-- Instagram -->
                            <a class="social-media-ref" href="https://instagram.com">
                                <i class="fa-brands fa-instagram me-2"></i>Instagram
                            </a>
                        </li>
                        <li>
                            <a class="social-media-ref" href="https://linkedin.com">
                                <i class="fa-brands fa-linkedin me-2"></i>LinkedIn
                            </a>
                        </li>
                        <li>
                            <a class="social-media-ref" href="https://mail.google.com">
                                <i class="fa-regular fa-envelope me-2"></i>kosanku@gmail.com
                            </a>
                        </li>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="assets/js/scripts.js"></script>

    <!-- Alert saat salah password atau username -->
    <?php if (isset($_POST['btn_submit'])) : ?>
    <script src="assets/js/alert.js"></script>
    <?php endif; ?>

</body>

</html>