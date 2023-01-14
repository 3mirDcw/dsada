<?php

$host = 'localhost';
$username = 'Fastche_users';
$password = 'xv9pXALTTNRm';
$database = 'Fastche_users';

$con = new mysqli($host, $username, $password, $database);

if ($con->connect_error) {
    die("Connection Failed: $con->connect_error");
} else {
    return $con;
}
?>