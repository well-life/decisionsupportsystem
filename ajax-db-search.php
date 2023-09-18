<?php

include "config.php";

// Untuk menjalankan autocomplete pada pencarian
if (isset($_POST['search'])) {
  $nama_posisi = $_POST['search'];

  // $query = "SELECT * FROM jabatan WHERE nama_posisi LIKE '{$nama_posisi}%' LIMIT 15";
  $query = "SELECT * FROM jabatan WHERE nama_posisi LIKE '{$nama_posisi}%' LIMIT 12";
  $result = $conn->query($query);

  //mendeklarasikan sebuah array untuk menyimpan value dan label dari jabatan yang muncul pada kotak autocomplete, kemudian mengencode nya menjadi JSON
  $response = array();
  while ($row = $result->fetch_assoc()) {
    $response[] = array("value" => $row['kode_posisi'], "label" => $row['nama_posisi']);
  }

  echo json_encode($response);
}

exit;
