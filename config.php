<?php 
 
//  Untuk menghubungkan website ke database
$server = "localhost";
$user = "root";
$pass = "";
$database = "decision_support_system";
 
$conn = mysqli_connect($server, $user, $pass, $database);

if (!$conn) {
    die("<script>alert('Gagal tersambung dengan database.')</script>");
} 
?>