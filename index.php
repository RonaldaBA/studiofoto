<?php
session_start();

if (isset($_SESSION['login'], $_SESSION['role']) && $_SESSION['role'] === 'manajer') {
    header('Location: dashboard/dashboard_manager.php');
} else if (isset($_SESSION['login'], $_SESSION['role']) && $_SESSION['role'] === 'customer service') {
    header('Location: dashboard/dashboard_customerservice.php');
} else if (isset($_SESSION['login'], $_SESSION['role']) && $_SESSION['role'] === 'fotografer') {
    header('Location: dashboard/dashboard_photographer.php');
} else {
    header('Location: home.php');
}
exit;
