<?php
$conn = mysqli_connect("127.0.0.1", "root", "", "water_meter", 3306);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>