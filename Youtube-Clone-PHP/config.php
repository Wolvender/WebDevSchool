<?php
session_start();

/**
 * Voor de MAC gebruikers;
 */
// $dbhost = "localhost";
// $dbuser = "root";
// $dbpass = "root";
// $dbname = "youtube-test";

/**
 * Voor de Windows gebruikers;
 */
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "Youtube-clone";

$con = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($con -> connect_errno) {
    echo "Failed to connect to MySQL: " . $con -> connect_error;
    exit();
}

function prettyDump ( $var ) {
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
}