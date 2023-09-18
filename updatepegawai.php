<?php

// Untuk mengedit data pegawai
include 'config.php';
$id = $_POST['nip'];
$name = $_POST['name'];
$datebirth = $_POST['tanggal-lahir'];
$grade = $_POST['grade'];
$tmt_grade = $_POST['tmt-grade'];
$marital_status = $_POST['marital-status'];
$work_contract_type = $_POST['work-contract-type'];

mysqli_query($conn, "UPDATE pegawai SET tanggal_lahir = '$datebirth', PS_group = '$grade', tmt_grade = '$tmt_grade', marital_status = '$marital_status', work_contract= '$work_contract_type' WHERE nip='$id'");
header("location:index.php");
?>