<?php
$settings = array();

$settings['database']['hostname'] = "localhost";
$settings['database']['database'] = "rbl";
$settings['database']['username'] = "root";
$settings['database']['password'] = "";

$settings['ip']['ignored'] = array(
    '8.8.8.8',
    '8.8.4.4'
);

$mysqli = new mysqli($settings['database']['hostname'], $settings['database']['username'], $settings['database']['password'], $settings['database']['database']);

/* check connection */ 
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$mysqli->query("set names utf8;");
