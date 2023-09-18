<?php

// Untuk mengupdate data user
include 'config.php';
$id = $_POST['id'];
$username = $_POST['username'];
$name = $_POST['name'];
$nip = $_POST['nip'];
$password = $_POST['password'];

mysqli_query($conn, "UPDATE user SET username = '$username', nip='$nip', name = '$name' WHERE id_user='$id'");
header("location:index.php");
?>