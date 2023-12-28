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

    $data_query = mysqli_query($conn, "SELECT * FROM $table WHERE `NIK`=$id");

    $fetched = mysqli_num_rows($data_query) ? TRUE : FALSE;

    if (!$fetched) {
        return FALSE;
    }

    return mysqli_fetch_assoc($data_query);
}

function verifyLogin($email, $password)
{
    global $conn;
    $query = mysqli_query($conn, "SELECT * FROM pemilik WHERE email='$email'");

    $verif = mysqli_num_rows($query) ? TRUE : FALSE;

    if (!$verif) {
        echo "MAsuk";
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

function registerAccount($email, $password, $nama_depan, $nama_belakang, $nik, $alamat, $noTelepon)
{
    global $conn;

    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    $nama_depan = mysqli_real_escape_string($conn, $nama_depan);
    $nama_belakang = mysqli_real_escape_string($conn, $nama_belakang);
    $nik = mysqli_real_escape_string($conn, $nik);
    $alamat = mysqli_real_escape_string($conn, $alamat);
    $noTelepon = mysqli_real_escape_string($conn, $noTelepon);
    $nama = "$nama_depan $nama_belakang";

    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = mysqli_query($conn, "INSERT INTO pemilik(NIK, nama,  noTelp, email, keypassword, alamat) VALUES('$nik', '$nama', '$noTelepon', '$email', '$password', '$alamat') ");

    if ($query) {
        $q = mysqli_query($conn, "SELECT * FROM pemilik WHERE email='$email'");
        $user = mysqli_fetch_assoc($q);

        var_dump($user);
        return $user['NIK'];
    }

    return FALSE;
}

// function findMaxHarga()
// {
//     global $conn;

//     $query = mysqli_query($conn, "SELECT `harga` FROM kost ORDER BY harga DESC LIMIT 0, 1");
//     $maxValue = mysqli_fetch_assoc($query);

//     return $maxValue['harga'];
// }

// function findMinHarga()
// {
//     global $conn;

//     $query = mysqli_query($conn, "SELECT `harga` FROM kost ORDER BY harga ASC LIMIT 0, 1");
//     $minValue = mysqli_fetch_assoc($query);

//     return $minValue['harga'];
// }

// function filterSearch($jenis, $minHarga, $maxHarga)
// {
//     global $conn;
//     $retVal = [];

//     if (!$minHarga) {
//         $minHarga = findMinHarga() - 1000;
//     }

//     if (!$maxHarga) {
//         $maxHarga = findMaxHarga() + 1000;
//     }

//     if (!$jenis && !$minHarga && !$maxHarga) {
//         $query = mysqli_query($conn, "SELECT * FROM kost");
//     } else if (!$jenis) {
//         $query = mysqli_query($conn, "SELECT * FROM kost WHERE harga BETWEEN $minHarga AND $maxHarga");
//     } else {
//         $query = mysqli_query($conn, "SELECT * FROM kost WHERE jenis='$jenis' AND (harga BETWEEN $minHarga AND $maxHarga)");
//     }

//     while ($data = mysqli_fetch_assoc($query)) {
//         array_push($retVal, $data);
//     }

//     return $retVal;
// }

function uploadImage($imgURL)
{
    $imageName = $imgURL['name'];
    $imageSize = $imgURL['size'];
    $err = $imgURL['error'];
    $tmp = $imgURL['tmp_name'];

    if ($err === 4) {
        echo "<script> 
                alert('Please upload an image');
            </script>";

        return false;
    }

    $VALID_EXTENSION = ['jpg', 'jpeg', 'png'];

    $imgFormat = explode('.', $imageName);
    $imgFormat = strtolower($imgFormat[count($imgFormat) - 1]);

    // another way to get image extension
    // $format = pathinfo($imageName, PATHINFO_EXTENSION);

    // check file format
    if (!in_array($imgFormat, $VALID_EXTENSION)) {
        echo "<script> 
                alert('Format not supported');
            </script>";

        return false;
    }

    // check file size
    // valid if size is < 2mb
    if ($imageSize > 2000000) {
        echo "<script> 
                alert('Size too large');
            </script>";

        return false;
    }

    // generate new name for the image
    $newName = uniqid() . ".$imgFormat";

    // upload the image into permanent folder
    // the path view is from where we use the function
    move_uploaded_file($tmp, '../assets/upload/' . $newName);

    return $newName;
}

function addFasilKost($idKost, $namaFasil)
{
    global $conn;
    $idFasil = mysqli_query($conn, "SELECT id FROM fasilitas WHERE nama = $namaFasil");
    $query = mysqli_query($conn, "INSERT INTO fasil_kost(`id_kost`, `id_fasil`) VALUES ($idKost, $idFasil)");

    if (!$query) {
        return false;
    }

    return true;
}

function registerKost($namaKos, $alamat, $jumlahKamar, $harga, $jenis, $gambar, $idPemilik, $fasilitas)
{
    global $conn;

    $namaKos = mysqli_real_escape_string($conn, $namaKos);
    $jumlahKamar = mysqli_real_escape_string($conn, $jumlahKamar);
    $harga = mysqli_real_escape_string($conn, $harga);
    $jenis = mysqli_real_escape_string($conn, $jenis);
    $alamat = mysqli_real_escape_string($conn, $alamat);
    // $fasilitas = mysqli_real_escape_string($conn, $fasilitas);

    $gambar = uploadImage($gambar);

    if (!$gambar) {
        return FALSE;
    }

    $query = mysqli_query($conn, "INSERT INTO kost(nama, alamat, jumlahKamar, NIK_Pemilik, harga, jenis, gambar_preview, fasilitas) VALUES ('$namaKos', '$alamat', '$jumlahKamar', '$idPemilik', '$harga', '$jenis', '$gambar', '$fasilitas')");

    if (!$query) {
        return FALSE;
    }

    $idKosQuery = mysqli_query($conn, "SELECT id FROM kost WHERE nama='$namaKos'");

    if (!$idKosQuery) {
        return FALSE;
    }

    $idKos = mysqli_fetch_assoc($idKosQuery);

    return ["isSuccess" => TRUE, "idKost" => $idKos['id']];
}

function getDataPesanan($idpemilik)
{
    global $conn;
    $data = [];
    // $query = mysqli_query($conn, "SELECT users.firstName, users.lastName, pesanan.idPesanan, pesanan.mulaiSewa, pesanan.akhirSewa, pesanan.tglPemesanan, pesanan.totalPembayaran, pesanan.idPemesan FROM pesanan INNER JOIN users ON pesanan.idPemesan=users.NIK WHERE pesanan.idKost='$idKost'");
    $query = mysqli_query($conn, "SELECT users.firstName, users.lastName, pesanan.idPesanan, pesanan.mulaiSewa, pesanan.akhirSewa, pesanan.tglPemesanan, pesanan.totalPembayaran, pesanan.idPemesan FROM pesanan INNER JOIN users ON pesanan.idPemesan=users.NIK INNER JOIN kost on pesanan.idKost=kost.id INNER JOIN pemilik on kost.NIK_Pemilik=pemilik.NIK WHERE pemilik.NIK='$idpemilik'");

    if ($query) {

        while ($dt = mysqli_fetch_assoc($query)) {
            array_push($data, $dt);
        }
        // var_dump($data);
        return $data;
    }

    return FALSE;
}

function getDataKost($nik)
{
    global $conn;
    $data = [];
    $query = mysqli_query($conn, "SELECT id, alamat, nama, jumlahKamar, NIK_Pemilik, harga, jenis, gambar_preview FROM kost WHERE NIK_Pemilik='$nik'");
    if ($query) {

        while ($dt = mysqli_fetch_assoc($query)) {
            array_push($data, $dt);
        }
        // var_dump($data);
        return $data;
    }

    return FALSE;
}


function rejectPemesanan($id)
{
    global $conn;

    $query = mysqli_query($conn, "DELETE FROM pesanan WHERE `idPesanan`='$id'");

    if ($query) {
        return TRUE;
    }

    return FALSE;
}

function getUniqueId($email)
{
    global $conn;

    $query = mysqli_query($conn, "SELECT `NIK` FROM pemilik WHERE email='$email'");

    if (!$query) {
        return FALSE;
    }
    $resQuery = mysqli_fetch_assoc($query);

    return $resQuery['NIK'];
}

function getUniqueIdKostByNIK($nik)
{
    global $conn;

    $query = mysqli_query($conn, "SELECT kost.id FROM kost INNER JOIN pemilik ON kost.NIK_Pemilik=pemilik.NIK WHERE pemilik.NIK='$nik'");

    if (!$query) {
        return FALSE;
    }

    return mysqli_fetch_assoc($query);
}

function countDataKos($nik)
{
    global $conn;
    $query = mysqli_query($conn, "SELECT COUNT(id) as kost FROM kost WHERE NIK_Pemilik='$nik'");

    if (!$query) {
        return FALSE;
    }

    return mysqli_fetch_assoc($query);
}

function countPesanan($idKost)
{
    global $conn;

    $query = mysqli_query($conn, "SELECT COUNT(idPesanan) as pesanan FROM pesanan WHERE idKost='$idKost'");

    if (!$query) {
        return FALSE;
    }

    return mysqli_fetch_assoc($query);
}

function countDataKamar($idPemilik)
{
    global $conn;

    $query = mysqli_query($conn, "SELECT COUNT(kamar.idKamar) as kamar  FROM kamar INNER JOIN kost ON kamar.id_kost=kost.id WHERE NIK_Pemilik='$idPemilik'");

    if (!$query) {
        return FALSE;
    }

    return mysqli_fetch_assoc($query);
}

function countJumlahPenghuni($id)
{
    global $conn;

    $query = mysqli_query($conn, "SELECT COUNT(penyewaan.id) as penghuni FROM penyewaan WHERE penyewaan.idKost = ANY
    (SELECT kost.id FROM kost WHERE kost.NIK_Pemilik='$id')");

    if (!$query) {
        return FALSE;
    }
    return mysqli_fetch_assoc($query);
}

function insertKamarData($idKost, $lebar, $panjang)
{
    global $conn;

    $idKamar = uniqid();
    $status = "KOSONG";

    $query = mysqli_query($conn, "INSERT INTO kamar(`id_kost`, `status`, `lebar`, `panjang`, `idKamar`) VALUES ('$idKost', '$status', '$lebar', '$panjang', '$idKamar')");

    if (!$query) {
        return FALSE;
    }

    return TRUE;
}

function generateKamar($jumlahKamar, $idKost, $lebar, $panjang)
{
    for ($i = 0; $i < $jumlahKamar; $i++) {
        $valid = insertKamarData($idKost, $lebar, $panjang);

        echo $valid;

        if (!$valid) {
            return FALSE;
        }
    }
    return TRUE;
}

function countPenghuniKost()
{
    global $conn;
    $query = mysqli_query($conn, "SELECT COUNT(id) as id_penghuni FROM penyewaan");

    if (!$query) {
        return FALSE;
    }

    return mysqli_fetch_assoc($query)['id_penghuni'];
}

function getDataPemilik($nikAkun)
{

    global $conn;

    $pemilik = mysqli_query($conn, "SELECT * FROM pemilik WHERE NIK='$nikAkun'");
    $dataPemilik = mysqli_fetch_assoc($pemilik);

    return $dataPemilik;
}

function generateRekening($namaBank, $rekening, $nikPemilik)
{
    global $conn;

    $query = mysqli_query($conn, "INSERT INTO rekening(`NoRekening`, `bank`, `NIK_Pemilik`) VALUES ('$rekening', '$namaBank', '$nikPemilik')");

    if (!$query) {
        return FALSE;
    }

    return TRUE;
}

function getOwnerKostDataKamar($id)
{
    global $conn;

    $data_array = [];
    $data_query = mysqli_query($conn, "SELECT * FROM kamar INNER JOIN kost ON kamar.id_kost=kost.id WHERE NIK_Pemilik='$id'");

    while ($data = mysqli_fetch_assoc($data_query)) {
        array_push($data_array, $data);
    }

    return $data_array;
}

function deleteDataKost($idKost)
{
    global $conn;
    $query = mysqli_query($conn, "DELETE FROM kost WHERE id='$idKost'");
    if (!$query) {
        return FALSE;
    }
}
// function getUniqueIdKost($idPemilik)
// {
//     global $conn;

//     $query = mysqli_query($conn, "SELECT id FROM kost WHERE NIK_Pemilik=$idPemilik'");

//     if (!$query) {
//         return FALSE;
//     }
//     $resQuery = mysqli_fetch_assoc($query);

//     return $resQuery['id'];
// }

function setUserToKamar($idPenyewa, $tglMulai, $tglAkhir, $idKost, $idPesanan)
{
    global $conn;

    $query = mysqli_query($conn, "SELECT idKamar from kamar WHERE status='KOSONG'");

    if (!$query) {
        return FALSE;
    }

    $arr = [];
    while ($data = mysqli_fetch_assoc($query)) {
        array_push($arr, $data);
    }

    $idKamar = $arr[array_rand($arr, 1)]['idKamar'];
    // var_dump($idKamar);

    $kamarQuery = mysqli_query($conn, "INSERT INTO penyewaan(`NIK_Penyewa`, `tannggal_mulai`, `tanggal_akhir`, `idKamar`, `idKost`) VALUE ('$idPenyewa', '$tglMulai', '$tglAkhir', '$idKamar', '$idKost')");

    if (!$kamarQuery) {
        return FALSE;
    }

    mysqli_query($conn, "UPDATE kamar SET `status`='TERISI' WHERE `idKamar`='$idKamar'");

    $query = mysqli_query($conn, "DELETE FROM pesanan WHERE `idPesanan`='$idPesanan'");

    if ($query) {
        return TRUE;
    }

    return FALSE;
}

function getInfoPesananById($idPesanan)
{
    global $conn;

    $query = mysqli_query($conn, "SELECT idPemesan, mulaiSewa, akhirSewa FROM pesanan WHERE idPesanan='$idPesanan'");

    if (!$query) {
        return FALSE;
    }

    return mysqli_fetch_assoc($query);
}

function getDataPenyewaanById($idKost)
{
    global $conn;

    $data_array = [];
    $data_query = mysqli_query($conn, "SELECT penyewaan.tannggal_mulai, penyewaan.tanggal_akhir, penyewaan.idKamar, penyewaan.NIK_penyewa, kost.nama, users.firstName, users.lastName FROM penyewaan INNER JOIN kost ON penyewaan.idKost=kost.id INNER JOIN users ON penyewaan.NIK_penyewa=users.NIK WHERE idKost='$idKost'");

    while ($data = mysqli_fetch_assoc($data_query)) {
        array_push($data_array, $data);
    }

    return $data_array;
}

function getSewaMasukByBulan($bulan, $idKost)
{
    global $conn;

    $query = mysqli_query($conn, "SELECT COUNT(id) as jumlah_penyewa FROM penyewaan WHERE (tannggal_mulai BETWEEN '2022-$bulan-01' AND '2022-$bulan-31') AND idKost='$idKost'");

    if (!$query) {
        return FALSE;
    }

    return mysqli_fetch_assoc($query)['jumlah_penyewa'];
}

function getSewaKeluarByBulan($bulan, $idKost)
{
    global $conn;

    $query = mysqli_query($conn, "SELECT COUNT(id) as jumlah_penyewa FROM penyewaan WHERE (tanggal_akhir BETWEEN '2022-$bulan-01' AND '2022-$bulan-31') AND idKost='$idKost'");

    if (!$query) {
        return FALSE;
    }

    return mysqli_fetch_assoc($query)['jumlah_penyewa'];
}
function getInfoPenyewaByNIK($NIK)
{
    global $conn;

    $query = mysqli_query($conn, "SELECT no_telepon, email FROM users WHERE NIK='$NIK'");

    if (!$query) {
        return FALSE;
    }

    return mysqli_fetch_assoc($query);
}
function countDataPeminatKost($gender)
{
    global $conn;

    $query = mysqli_query($conn, "SELECT COUNT(penyewaan.NIK_penyewa) AS jumlah_minat FROM penyewaan INNER JOIN kost ON penyewaan.idKost=kost.id WHERE kost.jenis='$gender'");

    if (!$query) {
        return FALSE;
    }

    return mysqli_fetch_assoc($query)['jumlah_minat'];
}
