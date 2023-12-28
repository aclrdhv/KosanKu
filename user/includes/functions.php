<?php

function checkCompleteess($email, $password, $nik)
{
    // check if not null fields is filled

    $isComplete = $email && $password && $nik ? TRUE : FALSE;

    return $isComplete;
}

function checkRentFillness($startDate, $duration)
{
    if ($startDate && $duration) {
        return TRUE;
    }

    return FALSE;
}
