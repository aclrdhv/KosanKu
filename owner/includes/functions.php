<?php

function checkCompleteess($email, $password, $nik, $alamat, $noTelepon)
{
    // check if not null fields is filled

    $isComplete = $email && $password && $nik && $alamat && $noTelepon ? TRUE : FALSE;

    return $isComplete;
}