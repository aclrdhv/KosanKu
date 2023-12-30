<?php

require('core/init.php');

session_start();

$response = ['error' => FALSE];

if (isset($_POST['button_signup'])) {
    $nama_depan = $_POST['nama_depan'];
    $nama_belakang = $_POST['nama_belakang'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $alamat = $_POST['alamat'];
    $nik = $_POST['nik'];
    $noTelepon = $_POST['no-telepon'];

    $isComplete = checkCompleteess($email, $password, $nik, $alamat, $noTelepon);

    if ($isComplete) {
        // procees to checking regitered account by email
        $isRegistred = checkRegistredUser($email);

        if (!$isRegistred) {
            // make account if email is not set yet in the database
            $nik = registerAccount($email, $password, $nama_depan, $nama_belakang, $nik, $alamat, $noTelepon);

            if ($nik) {
                // regis is success 
                $response['error'] = FALSE;
                $response['user']['name'] = $regis['email'];
                $response['user']['key'] = $regis['NIK'];
                $_SESSION['id_pemilik'] = $nik;

                header("Location: signupKosan.php");
                exit;

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
            <div class="container py-5">
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
                                    <div class="card-body p-md-5">
                                        <div class="text-center">
                                            <h4> <img class="pb-2 pe-2" src="../owner/assets/icons/KosanKu2.png"
                                                    style="width: 50px; height:50px;" alt="logo">KosanKu</h4>
                                        </div>
                                        <form class="form-signin" method="POST">
                                            <p class="fw-bold text-center">CREATE ACCOUNT</p>
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
                                            <div class="row mb-2">
                                                <div class="col">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" id="floatingInput"
                                                            placeholder="nama depan" name="nama_depan"
                                                            autocomplete="off">
                                                        <label for="floatingInput">First Name</label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" id="floatingInput"
                                                            placeholder="nama belakang" name="nama_belakang"
                                                            autocomplete="off">
                                                        <label for="floatingInput">Last Name</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="floatingAlamat"
                                                    placeholder="alamat" name="alamat" autocomplete="off">
                                                <label for="floatingAlamat">Alamat</label>
                                            </div>

                                            <div class="form-floating">
                                                <input type="text" class="form-control sign-up-input" id="floatingInput"
                                                    placeholder="NIK" name="nik" autocomplete="off">
                                                <label for="floatingInput">NIK</label>
                                            </div>

                                            <div class="form-floating">
                                                <input type="text" class="form-control sign-up-input" id="floatingInput"
                                                    placeholder="NIK" name="no-telepon" autocomplete="off">
                                                <label for="floatingInput">No.Telp</label>
                                            </div>

                                            <button class="w-100 btn btn-lg btn-primary btn-login mt-4" type="submit"
                                                name="button_signup">Next
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