<?php

// all database realted functions is here

function getalldata($table)
{
    global $conn;

    $data_array = [];
    $data_query = mysqli_query($conn, "SELECT * FROM $table");

    while ($data = mysqli_fetch_assoc($data_query)) {
        array_push($data_array, $data);
    }

    return $data_array;
}

function getDataFromId($table, $id)
{
    global $conn;

    $data_query = mysqli_query($conn, "SELECT * FROM $table WHERE `id`=$id");

    $fetched = mysqli_num_rows($data_query) ? TRUE : FALSE;

    if (!$fetched) {
        return;
    }

    return mysqli_fetch_assoc($data_query);
}

function verifyLogin($email, $password)
{
    global $conn;
    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    $verif = mysqli_num_rows($query) ? TRUE : FALSE;

    if (!$verif) {
        return FALSE;
    }

    $queryPassword = mysqli_fetch_assoc($query)['keypassword'];
    $passwordVerif = password_verify($password, $queryPassword);

    if (!$passwordVerif) {
        return FALSE;
    }

    return TRUE;
}

function checkRegistredUser($email)
{
    global $conn;
    $query = mysqli_query($conn, "SELECT email from users WHERE email='$email'");

    $isRegistred = mysqli_num_rows($query) ? TRUE : FALSE;

    return $isRegistred;
}

function registerAccount($email, $password, $nama_depan, $nama_belakang, $jenis_kelamin, $nik, $noTelp)
{
    global $conn;

    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    $nama_depan = mysqli_real_escape_string($conn, $nama_depan);
    $nama_belakang = mysqli_real_escape_string($conn, $nama_belakang);
    $jenis_kelamin = mysqli_real_escape_string($conn, $jenis_kelamin);
    $nik = mysqli_real_escape_string($conn, $nik);
    $noTelp = mysqli_real_escape_string($conn, $noTelp);

    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = mysqli_query($conn, "INSERT INTO users(NIK, firstName, lastName, email, jenisKelamin, keypassword, no_telepon) VALUES('$nik', '$nama_depan', '$nama_belakang', '$email', '$jenis_kelamin', '$password', '$noTelp') ");

    if ($query) {
        $q = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        $user = mysqli_fetch_assoc($q);

        return $user;
    }

    return FALSE;
}

function findMaxHarga()
{
    global $conn;

    $query = mysqli_query($conn, "SELECT `harga` FROM kost ORDER BY harga DESC LIMIT 0, 1");
    $maxValue = mysqli_fetch_assoc($query);

    return $maxValue['harga'];
}

function findMinHarga()
{
    global $conn;

    $query = mysqli_query($conn, "SELECT `harga` FROM kost ORDER BY harga ASC LIMIT 0, 1");
    $minValue = mysqli_fetch_assoc($query);

    return $minValue['harga'];
}

function filterSearch($jenis, $minHarga, $maxHarga)
{
    global $conn;
    $retVal = [];

    if (!$minHarga) {
        $minHarga = findMinHarga() - 1000;
    }

    if (!$maxHarga) {
        $maxHarga = findMaxHarga() + 1000;
    }

    if (!$jenis && !$minHarga && !$maxHarga) {
        $query = mysqli_query($conn, "SELECT * FROM kost");
    } else if (!$jenis) {
        $query = mysqli_query($conn, "SELECT * FROM kost WHERE harga BETWEEN $minHarga AND $maxHarga");
    } else {
        $query = mysqli_query($conn, "SELECT * FROM kost WHERE jenis='$jenis' AND (harga BETWEEN $minHarga AND $maxHarga)");
    }

    while ($data = mysqli_fetch_assoc($query)) {
        array_push($retVal, $data);
    }

    return $retVal;
}

function getUniqueId($email)
{
    global $conn;

    $query = mysqli_query($conn, "SELECT `NIK` FROM users WHERE email='$email'");
    $resQuery = mysqli_fetch_assoc($query);

    return $resQuery['NIK'];
}

function getUserData($nik)
{
    global $conn;

    $query = mysqli_query($conn, "SELECT `firstName`, `lastName`, `email`, `no_telepon` FROM users WHERE NIK='$nik'");
    $resQuery = mysqli_fetch_assoc($query);

    return $resQuery;
}

function findKostOwner($nama)
{
    global $conn;

    $query = mysqli_query($conn, "SELECT NIK_Pemilik FROM kost WHERE nama='$nama'");

    $resQuery = mysqli_fetch_assoc($query);

    return $resQuery['NIK_Pemilik'];
}

function getRekeningInfo($nik)
{
    global $conn;

    $query = mysqli_query($conn, "SELECT rekening.noRekening, pemilik.nama, rekening.bank FROM rekening INNER JOIN pemilik ON rekening.NIK_Pemilik=pemilik.NIK WHERE rekening.NIK_Pemilik='$nik'");


    $resQuery = mysqli_fetch_assoc($query);

    return $resQuery;
}
function addPesanan($idPemesan, $idKost, $mulaiSewa, $akhirSewa, $totalPembayaran)
{
    global $conn;

    $idPesanan = uniqid();
    $idPemesan = mysqli_real_escape_string($conn, $idPemesan);
    $idKost = mysqli_real_escape_string($conn, $idKost);
    $tglPesanan = date('Y-m-d', time());
    $mulaiSewa = mysqli_real_escape_string($conn, $mulaiSewa);
    $akhirSewa = mysqli_real_escape_string($conn, $akhirSewa);

    $query = mysqli_query($conn, "INSERT INTO pesanan(idPesanan, idPemesan, idKost, tglPemesanan, mulaiSewa, akhirSewa, totalPembayaran) VALUES ('$idPesanan', '$idPemesan', '$idKost', '$tglPesanan', '$mulaiSewa', '$akhirSewa', $totalPembayaran)");

    if (!$query) {
        return FALSE;
    }

    return TRUE;
}
