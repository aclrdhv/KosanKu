<?php

session_start();

require('core/init.php');

$nikAkun = $_SESSION["userNIK"];

global $conn;

if (isset($_POST["update"])) {
    $nik = $_POST["nik"];
    $namaDepan = $_POST["namaDepan"];
    $namaBelakang = $_POST["namaBelakang"];
    $jk = $_POST["jk"];
    $email = $_POST["email"];
    $pass = $_POST["pass"];

    $query = "UPDATE users SET 
                NIK = '$nik',
                email = '$email',
                firstName = '$namaDepan',
                lastName = '$namaBelakang',
                jenisKelamin = '$jk',
                keypassword = '$pass'
            WHERE NIK = $nik";
    mysqli_query($conn, $query);

    if (mysqli_affected_rows($conn) > 0) {
        echo "<script> document.location.href = 'profile.php'; </script>";
    };
}

$user = mysqli_query($conn, "SELECT * FROM users WHERE NIK='$nikAkun'");
$dataUser = mysqli_fetch_assoc($user);
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
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;900&family=Ubuntu:wght@500&display=swap"
        rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" href="assets/icon/Logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Profile</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    <img src="assets/icon/KosanKu.png" alt="#logo" style="width:120px;height:80px;">
                </a>

                <a class="navbar-brand" href="index.php"></a>
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
                                <span>Profile</span>
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
    <main>
        <div class="container mb-5">
            <!-- DataTales -->
            <div class="card shadow w-100">
                <div class="card-header" style="background-color:#2155CD ;">
                    <div class="d-flex justify-content-between mb-2 mt-2">
                        <h1 class="h3 mb-0 text-gray-800 fw-bold text-white">Profile Penyewa</h1>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-5">
                            <img class="img-fluid" src="../owner/assets/app/images/profile.jpg" height="400" width="400"
                                alt="profile">
                        </div>
                        <div class="col-12 col-sm-12 col-md-7" style="overflow:auto ;">
                            <form action="" method="POST">
                                <table class="table">
                                    <tbody>
                                        <tr style="height:60px">
                                            <th>NIK</th>
                                            <td> : </td>
                                            <td><input type="text" id="nik" name="nik" 
                                                    value="<?= $dataUser["NIK"] ?>">
                                        </tr>
                                        <tr style="height:60px">
                                            <th>Nama Depan</th>
                                            <td> : </td>
                                            <td><input type="text" id="nama" name="namaDepan"
                                                    value="<?= $dataUser["firstName"] ?>">
                                            </td>
                                        </tr>
                                        <tr style="height:60px">
                                            <th>Nama Belakang</th>
                                            <td> : </td>
                                            <td><input type="text" id="nama" name="namaBelakang"
                                                    value="<?= $dataUser["lastName"] ?>">
                                        </tr>
                                        <tr style="height:60px">
                                            <th>Jenis Kelamin </th>
                                            <td> : </td>
                                            <td><input type="text" id="jk" name="jk"
                                                    value="<?= $dataUser["jenisKelamin"] ?>">
                                        </tr>
                                        <tr style="height:60px">
                                            <th>Email </th>
                                            <td> : </td>
                                            <td><input type="text" id="email" name="email"
                                                    value="<?= $dataUser["email"] ?>">
                                        </tr>
                                        <!-- <tr style="height:60px">
                                        <th>Username</th>
                                        <td> : Jrunss</td>
                                    </tr> -->
                                        <tr style="height:60px">
                                            <th>Password</th>
                                            <td> : </td>
                                            <td><input type="text" id="pass" name="pass"
                                                    value="<?= $dataUser["keypassword"] ?>">
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="submit" name="update" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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

</body>

</html>