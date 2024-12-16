<?php
session_start();
include_once "../includes/connect.php";
include_once "../includes/classes.php";

$object = new admin($connect);

if ($object->validateAuthorization()) {
    session_unset();
    session_destroy();
    header("location:../login.php");
    die();
}
