<?php
$server_name = "localhost";
$server_username = "root";
$server_password = "1234567890";
$server_db_name = "campus_ns";

$connect = new mysqli($server_name, $server_username, $server_password, $server_db_name);

if ($connect->connect_error) {
    die("Error while connecting to DB: <b>" . $connect->connect_error . "<b>");
}
