<?php

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'nti_day8_task';

try {
    $conn = mysqli_connect($host, $username, $password, $dbname);
} catch (mysqli_sql_exception) {
    echo 'SERVER ERROR!';
    die;
}

?>