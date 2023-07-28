<?php
//DB details
$dbHost = 'toys-pizzadb.crljnq1eyagb.us-east-1.rds.amazonaws.com';
$dbUsername = 'admin';
$dbPassword = 'buenasnoches123,-';
$dbName = 'BDTOYS';

//Create connection and select DB
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($db->connect_error) {
    die("Unable to connect database: " . $db->connect_error);
}
?>