<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
}

?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="css/Main.css">
  <link rel="stylesheet" href="css/all.min.css">
  <link rel="stylesheet" href="css/jquery-ui.css">
  <script src="script/sweetalert.js"></script>
  <script src="script/pagination.js"></script>
  <script src="script/jquery.js"></script>
  <script src="script/list.js"></script>
  <script src="script/jquery-ui.min.js"></script>
  <style>
    .table1 td:nth-child(2) {
      padding: 0px 0px;
      color: #fff;
      font-weight: normal;
      text-align: center;
    }

    .label_index span {
      margin-left: 67px;
    }

    .label_text3 span {
      margin-left: 60px;
      font-family: montserrat;
      font-size: 15px;
    }

    .button_index input,
    button {
      outline: none;
      overflow: hidden;
      position: relative;
      background-color: #003D79;
      cursor: pointer;
      margin: 10px 30px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.20);
    }

    .button2b span {
      position: relative;
      margin: 10px 30px;
      font-weight: 700;
      font-size: 14.3px;
      z-index: 1;
    }

    .label_index select {
      margin-left: 70px;
    }

    .circle-icon:hover {
      border-radius: 10%;
      transform: rotate(360deg);
    }
  </style>
  <div class="banner">
    <div class="mandiribanner2" onclick="location.href='history_search.php';" style="cursor: pointer;">
      <img src="images/mandiri_kuning.png" alt="banner_index">

    </div>
    <div class="user_detail">
      <p></p>
      <?php
      include 'config.php';

      $username = $_SESSION['username'];
      $sql = "SELECT * FROM user WHERE username='$username'";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
          echo $row["name"] . "<br>";
          echo "<br>";
          echo $row["nip"] . "<br>";
          echo "<br>";
        }
      } else {
        echo "0 results";
      }
      $conn->close();
      ?>
      <a href="logout.php" class="btn">Logout</a>
    </div>
  </div>
</head>

<body style="background-image: url('images/bank-mandiri_background3.png');background-size: cover; background-attachment: fixed;">
  <div id="st-container" class="st-container">
    <button data-effect="st-effect-1" class="button3" style="background-color: #C4C4C4; width: 50px; border-radius: 5px; font-size:20px;cursor:pointer; position: absolute; top: 100; right: 0; margin: 0px 0px 5px 5px">&#9776;</button><br><br>

    <nav class="st-menu st-effect-1" id="menu-1">
      <div class="banner">
        <div class="mandiribanner2" onclick="location.href='history_search.php';" style="cursor: pointer;">
          <img src="images/mandiri_kuning.png" alt="banner_index">
        </div>
      </div>
      <ul class="pointer">
        <li><a class="icon icon-data" href="index.php">&emsp;<i class="fa fa-home" aria-hidden="true" style="font-size: 1.3em;"></i>&emsp;Home</a></li>
        <li><a href="advancedFilter.php">&emsp;<i class="fa-solid fa-filter" aria-hidden="true" style="font-size: 1.3em;"></i>&emsp;Advanced Searching</a></li>
        <li><a href="history_search.php">&emsp;<i class="fa-solid fa-clock-rotate-left" aria-hidden="true" style="font-size: 1.3em;"></i>&emsp;History Search</a></li>
        <li><a href="settingPage.php">&emsp;<i class="fa fa-cog" aria-hidden="true" style="font-size: 1.3em;"></i>&emsp;Setting</a></li>
      </ul>
    </nav>
    <div class="st-pusher">
      <!-- 	
                        example menus 
                        these menus will be under the push wrapper
                    -->
      <div class="st-content">
        <!-- this is the wrapper for the content -->
        <div class="st-content-inner">
          <form action="" method="POST" class="form_index" onsubmit="submit_form();">
            <br>
            <label class="label_index">
              <span class="field" style = "font-size: 20px">History Search</span>
              </br>

              <br>
              <?php
              $keyword_kode = "";
              if (isset($_POST['history'])) {
                $keyword_kode = $_POST['history'];
              }
              ?>
              <select name="history" id="history" class="select">
                <option value="" selected></option>
                <?php
                include 'config.php';
                $username = $_SESSION['username'];
                $sql2 = "SELECT * FROM user WHERE username='$username'";
                $result_2 = $conn->query($sql2);
                $user = $result_2->fetch_assoc();
                $id_user = $user["id_user"];

                // Query untuk menampilkan data pada dropdown select dengan kode_posisi, nama_posisi, dan tanggal pencarian
                $sql = "SELECT *, CONCAT (history_pencarian.kode_posisi,'-', tj.nama_posisi,'-', history_pencarian.tanggal)  AS kategori  FROM history_pencarian JOIN jabatan AS tj ON history_pencarian.kode_posisi = tj.kode_posisi WHERE history_pencarian.id_user = '$id_user'";
                $result = $conn->query($sql);
                if (!$result) {
                  trigger_error('Invalid query: ' . $conn->error);
                }
                $history = $_POST['history'];

                // Menggunakan jQuery untuk memilih select dropdown berdasarkan id_history_pencarian
                if ($result->num_rows > 0) { ?>
                  <?php while ($row = $result->fetch_assoc()) {
                    echo "<option value=\"" . $row["id_history_pencarian"] . "\"";
                    if ($history == $row["id_history_pencarian"]) echo 'selected';
                    echo ">" . $row["kategori"] . "</option>;"

                  ?>

                  <?php }
                  ?>
                <?php } ?>
              </select>
              <!-- Button untuk menjalankan fungsi reset, menampilkan data, dan menampilkan data dalam bentuk pdf -->
              <button class="button2b" type="clear" name="reset" id="clear" onClick="window.location.href=window.location.href"><span>CLEAR</span></button>
              <button class="button2b" type="submit" name="show" id="show"><span>SHOW</span></button>
              <button class="button2b" formaction="outputpdf.php?" formtarget="_blank"><SPAN>PDF</SPAN></button>

            </label>
            <br><br>

            <!-- Fungsi untuk Menampilkan Data -->
            <?php
            function showResult()
            {
              include 'config.php';
              if (isset($_POST['history'])) {

                //query di bawah untuk menampilkan data sesuai dengan yang tersimpan pada tabel detail_history_pencarian dan dijoin dengan tabel
                //pegawai agar dapat diakses data-datanya. Tentu saja data yang diambil harus sesuai dengan id dari detail_history_pencarian yang
                //ditentukan berdasarkan inputan user yang disimpan pada variabel $keyword_kode
                $keyword_kode = trim($_POST['history']);
                // $sql = "SELECT *, @nilai_exposure := IF(tp.job_exposure = (SELECT job_exposure FROM jabatan WHERE jabatan.kode_posisi = hp.kode_posisi), 5, 0), @nilai_sertifikasi := IF(sertifikasi.sertifikasi = (SELECT sertifikasi FROM jabatan WHERE jabatan.kode_posisi = hp.kode_posisi),1 ,0),  @totalValue := (tnj.nilai + tp.nilai_PL + tp.nilai_TC + @nilai_exposure + @nilai_sertifikasi + tp.nilai_kelas_uker) FROM detail_history_pencarian JOIN pegawai AS tp ON detail_history_pencarian.nip = tp.nip JOIN nilai_jabatan AS tnj ON tp.PS_group = tnj.name JOIN sertifikasi ON tp.nip = sertifikasi.nip JOIN history_pencarian AS hp ON detail_history_pencarian.id_history_pencarian = hp.id_history_pencarian JOIN jabatan ON hp.kode_posisi = jabatan.kode_posisi  WHERE tnj.kode_posisi = hp.kode_posisi AND hp.id_history_pencarian LIKE '" . $keyword_kode . "' ORDER BY @totalValue := (`tnj`.`nilai` + `tp`.`nilai_PL` + `tp`.`nilai_TC` + @nilai_exposure + @nilai_sertifikasi + `tp`.`nilai_kelas_uker`) DESC, gender ASC, tp.nama ASC";
                $sql = "SELECT * FROM detail_history_pencarian JOIN pegawai AS tp ON detail_history_pencarian.nip = tp.nip JOIN nilai_jabatan AS tnj ON tp.PS_group = tnj.name JOIN history_pencarian AS hp ON detail_history_pencarian.id_history_pencarian = hp.id_history_pencarian JOIN jabatan ON jabatan.kode_posisi = hp.kode_posisi WHERE tnj.kode_posisi = hp.kode_posisi AND hp.id_history_pencarian = $keyword_kode ORDER BY detail_history_pencarian.id_detail_history ASC";
                if ($conn->query($sql)) {
                  $result = $conn->query($sql);

                  $_SESSION['keyword_kode'] = $keyword_kode;

                  if (mysqli_num_rows($result) > 0) {
                    $row2 = mysqli_fetch_assoc($result);
                    //Jika data ada maka keterangan jabatan dan tanggal ditampilkan sesuai data. Dan juga ditampilkan header tabel
                    echo '
                        <div class = "label_form">
                            <label class="label_text">
                              <span class="field">Jabatan: ' . $row2['nama_posisi'] . '</span><br>
                            </label>
                            <label class="label_text">
                            <span class="field">Tanggal Pencarian: &nbsp;' . $row2['tanggal'] . '</span><br>
                            </br>
                            </label>
                            <label class="label_text2">
                        </div>
                        <div class="label_form4" id = "tableID">
                            <table class="table1">
                            <thead>
                            <tr>
                            <th>No</th>
                            <th></th>
                            <th>Nama & NIP</th>
                            <th>Gender</th>
                            <th>Jabatan</th>
                            <th>Kelas Unit Kerja</th>
                            <th>PL</th>
                            <th>TC</th>
                            <th>Grade</th>
                            
                            </tr>
                            </thead>
                      ';
                  }
                } else {
                  //Jika data tidak ada, maka keterangan tanggal dan jabatan kosong serta dimunculkan header tabel
                  echo '
                        <div class = "label_form">
                            <label class="label_text">
                            <span class="field">Jabatan: </span><br>
                            </label>
                            </label>
                            <label class="label_text">
                            <span class="field">Tanggal Pencarian: &nbsp;</span><br>
                            </br>
                        </div>
                        <div class="label_form4">
                            <table class="table1">
                              <thead>
                                <tr>
                                  <th>No</th>
                                  <th></th>
                                  <th>Nama & NIP</th>
                                  <th>Gender</th>
                                  <th>Jabatan</th>
                                  <th>Kelas Unit Kerja</th>
                                  <th>PL</th>
                                  <th>TC</th>
                                  <th>Grade</th>
                                </tr>
                              </thead>
                            ';
                }
            ?>
                <tbody class="list">
                  <?php

                  $index = 1;
                  if ($conn->query($sql)) {
                    $result = $conn->query($sql);
                    if (mysqli_num_rows($result) > 0) {
                      // output data of each row
                      while ($row = $result->fetch_assoc()) {
                        // $image_path = $row["image_path"];
                        $kode_jabatan = $row2['kode_posisi'];
                        //Untuk menampilkan data dalam bentuk baris dan kolom, serta barisnya dapat diklik untuk menghantar ke halaman detail pegawai
                        echo '
                    <tr onclick="somefunction(event, ' . $row["nip"] . ', ' . $kode_jabatan . ')">
                            <td>' . $index . '</td>
                            <td><div class="employee_photo" style="display: flex; justify-content: center; margin-top:5px; margin-bottom:5px">
                              
                            </div></td>
                              <td>' . $row["nama"] . '<br>' . $row["nip"] . '</td>
                              <td>' . $row["gender"] . '</td>
                              <td>' . $row["posisi"] . '</td>
                              <td>' . $row["kelas_unker"] . '</td>
                              <td>' . $row["pl"] . '</td>
                              <td>' . $row["tc"] . '</td>
                              <td>' . $row["PS_group"] . '</td>
                              
                        </tr>
                    ';
                        $index++;
                      }
                    }
                  ?>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="11" style="position: inline-block" ;>
                      <ul style="display:flex;justify-content:center; align-items: center; padding: 0px 0px 0px 0px; margin:0px">
                        <button type="button" class="btn-tablepage jTablePagePrev" style="width:60px; height:35px; background: gray; margin-left: 15px; margin-right: 15px;">&laquo;</button>
                        <li class="pagination"></li>
                        <button type="button" class="btn-tablepage jTablePageNext" style="width:60px; height:35px; background: gray; margin-left: 15px; margin-right: 15px;">&raquo;</button>
                      </ul>
                    </td>
                  </tr>
                </tfoot>
                </table>
        </div>;
  <?php
                  } else {
                    echo "";
                  }
                }
                $conn->close();
              }
              if (array_key_exists('show', $_POST)) {
                showResult();
              }
  ?>

  </form>
  <iframe src="loading.php" id='loader' style="padding: 50px;">
    
  </iframe>
      </div>
    </div>
  </div>

</body>
<footer>
</footer>

</html>
<script>
  //Sama seperti halaman sebelumnya, ini untuk membuat kotak menu menjadi interaktif pada halaman website
  var click = document.querySelectorAll('.button3');
  var menu = document.querySelector('#st-container');
  var pusher = document.querySelector('.st-pusher');
  // to store the corresponding effect
  var effect;

  // adding a click event to all the buttons
  for (var i = 0; i < click.length; i++) {
    click[i].addEventListener('click', addClass)
  }

  pusher.addEventListener('click', closeMenu);

  function addClass(e) {
    // to get the correct effect
    effect = e.target.getAttribute('data-effect');
    // adding the effects
    menu.classList.toggle(effect);
    menu.classList.toggle('st-menu-open');
  }

  function closeMenu(el) {
    // if the click target has this class then we close the menu by removing all the classes
    if (el.target.classList.contains('st-pusher')) {
      menu.classList.toggle(effect);
      menu.classList.toggle('st-menu-open');
    }
  }
</script>

<script>
  window.onload = function() {
    document.getElementById('loader').style.display = "none";
  }
</script>

<script>
  function somefunction(e, id, posisi) {
    if (e.target.cellIndex != undefined) {
      window.open("detailedemployee.php?id=" + id + "&kode_posisi=" + posisi);
    }
  }
</script>
<script>
  //Sama seperti di halaman sebelumnya, ini untuk membuat pagination
  var pagingRows = 10;

  var paginationOptions = {
    innerWindow: 5,

  };
  var options = {
    page: pagingRows,
    plugins: [ListPagination(paginationOptions)],
  };

  var tableList = new List('tableID', options);

  //Bila tombol next diklik, halaman akan berlanjut ke halaman berikutnya
  $('.jTablePageNext').on('click', function() {
    var list = $('.pagination').find('li');
    $.each(list, function(position, element) {
      if ($(element).is('.active')) {
        $(list[position + 1]).trigger('click');
      }
    })
  })

  //Bila diklik tombol previous, user akan dihantar ke halaman sebelumnya
  $('.jTablePagePrev').on('click', function() {
    var list = $('.pagination').find('li');
    $.each(list, function(position, element) {
      if ($(element).is('.active')) {
        $(list[position - 1]).trigger('click');
      }
    })
  })
</script>

<script>
  //Fungsi ini untuk menghilangkan beberapa pilihan yang bernilai sama pada kolom hasil pencarian yang sudah disimpan
  $(".select option").each(function() {
    $(this).siblings('[value="' + this.value + '"]').remove();
  });
</script>