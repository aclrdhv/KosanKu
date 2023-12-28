<?php
    session_start();
    require('core/init.php');

    global $conn;
    $idKost = $_GET["idKost"]; 
    $sql = mysqli_query($conn, "DELETE FROM kost WHERE id = $idKost");

    if($sql){
        echo "<script>alert('data berhasil dihapus!');
                document.location.href = 'kosan.php';
            </script>"
        ;
    }
    else{
        echo "
            <script>
                alert('data gagal dihapus!');
                document.location.href = 'kosan.php';
            </script>
        ";
    }
?>