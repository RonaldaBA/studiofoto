<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../helper/guest_auth.php";
require_once "../helper/check_guest_expired.php";

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>RichArt Studio Guest</title>

    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>

    body{
        background:#f8fafc;
        font-family:'Segoe UI',sans-serif;
        color:#1f2937;
    }

    .navbar-guest{
        background:#fff;
        box-shadow:0 2px 15px rgba(0,0,0,.05);
        padding:15px 25px;
    }

    .navbar-brand{
        font-weight:700;
        color:#16a34a !important;
    }

    .btn-upgrade{
        background:#22c55e;
        border:none;
        color:#fff;
    }

    .btn-upgrade:hover{
        background:#16a34a;
        color:#fff;
    }

    .page-wrapper{
        padding-top:30px;
        padding-bottom:30px;
        min-height:calc(100vh - 120px);
    }

    .card{
        border:none;
        border-radius:18px;
        box-shadow:0 10px 25px rgba(0,0,0,.05);
    }

    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light navbar-guest">

    <div class="container">

        <a class="navbar-brand" href="dashboard.php">
            RichArt Studio
        </a>

        <div>

            <a href="dashboard.php"
               class="btn btn-outline-success btn-sm">
               Dashboard
            </a>

            <a href="riwayat.php"
               class="btn btn-outline-primary btn-sm">
               Riwayat
            </a>

            <a href="upgrade.php"
               class="btn btn-upgrade btn-sm">
               Upgrade Member
            </a>

        </div>

    </div>

</nav>

<div class="page-wrapper">
<div class="container">