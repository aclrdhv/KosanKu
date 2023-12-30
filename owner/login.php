<?php

require('core/init.php');

session_start();

if (isset($_POST["btn_submit"])) {
    // cek ketersediaan akun di DB
    $email = $_POST['email'];
    $password = $_POST['password'];
    $_SESSION['id_pemilik'] = getUniqueId($email);

    $verify = verifyLogin($email, $password);
    echo "<script> console.log('Masuk') </script>";
    if ($verify) {
        $_SESSION['login-admin'] = true;
        header('Location: index.php');
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
    <title>Login - Owner</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/app/css/custom.style.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;900&family=Ubuntu:wght@500&display=swap"
        rel="stylesheet">
    <!-- FavIcon -->
    <link rel=" icon" href="assets/icons/KosanKu2.png">
</head>

<body>
    <!-- Main baru -->
    <main>
        <section class="section-sign-in" style="background-color: #ffffff;">
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
                                            <h4 class="mt-1 mb-5 pb-1"> <img class="pb-2 pe-2"
                                                    src="../owner/assets/icons/KosanKu.png"
                                                    style="width: 150px; height:100px;" alt="logo"></h4>
                                        </div>

                                        <form class="form-signin" method="POST">
                                            <p class="fw-bold">Please login to your account</p>
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
                                            <button class="w-100 btn btn-lg btn-primary btn-login mt-1" type="submit"
                                                name="btn_submit">Sign
                                                in
                                            </button>
                                            <!-- <a class="text-muted ms-2" href="#!">Forgot password?</a> -->

                                            <div class="d-flex align-items-center justify-content-center">
                                                <p class="me-2 mt-3 ms-2">Don't have an account?</p>
                                                <a class="user-signup" href="signup.php">Sign Up</a>
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
    <div class="alert alert-danger d-flex align-items-center" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
            <use xlink:href="#exclamation-triangle-fill" />
        </svg>
        <div>
            incorrect email or password
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="assets/app/js/jquery.min.js"></script>

    <!-- Alert saat salah password atau username -->
    <?php if (isset($_POST['btn_submit'])) : ?>
    <script type="text/javascript">
    let isVerify = "<?= $verify; ?>"
    let alert = $(".alert-danger")


    if (!isVerify) {
        alert.addClass('alert-on');
        setTimeout(() => {
            alert.removeClass('alert-on');
        }, 2500);
    }
    </script>
    <?php endif; ?>

</body>

</html>