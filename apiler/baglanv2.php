<?php

$host = '';
$username = '';
$password = 'Fastcheck@123*';
$database = '';

$con = new mysqli($host, $username, $password, $database);
$con->set_charset("utf8mb4");
if ($con->connect_error) {
    die("Connection Failed: $con->connect_error");
} else {
    return $con;
}
?>