<?php

define("HOSTNAME", "localhost");
define("USERNAME", "root");
define("PASSWORD", "");
define("DATABASE", "CRUD");  // ← Change made here

$conn = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE);

$status = "";
$connected = false;

if (!$conn) {
    $status = "Disconnected";
    $connected = false;
} else {
    $status = "Connected";
    $connected = true;
}
?>
