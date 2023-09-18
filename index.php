<?php

//Memulai sesi berdasarkan data yang diinput saat login
session_start();
$dataNIP = array();
$dataPegawai = array();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
$kode_jabatan = "";
$nama_posisi = "";
$id = $_SESSION['id_user'];
?>

<!DOCTYPE html>
<html>

<head>

    <!-- Kumpulan library yang diimport -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/Main.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <script src="script/sweetalert.js"></script>
    <script src="script/pagination.js"></script>
    <script src="script/jquery.js"></script>
    <script src="script/list.js"></script>
    <script src="script/jquery-ui.min.js"></script>

    <div class="banner">
        <div class="mandiribanner2" onclick="location.href='index.php';" style="cursor: pointer;">
            <img src="images/mandiri_kuning.png" alt="banner_index">

        </div>
        <div class="user_detail">
            <p></p>
            <!-- Menampilkan data user pada header-->
            <?php
            include 'config.php';

            $username = $_SESSION['username'];
            $sql = "SELECT * FROM user WHERE username='$username'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    $id_user = $row["nip"];
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
            <a href="logout.php" class="btna">Logout</a>
        </div>
    </div>
    <style>
        #loader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid rgba(89, 59, 0, 100);
            width: 120px;
            height: 120px;
            position: absolute;
            top: 50%;
            left: 45%;
            transform: translate(-50%, -50%);
            -webkit-animation: spin 2s linear infinite;
            /* Safari */
            animation: spin 2s linear infinite;
        }

        /* Safari */
        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .search {
            padding: 5px;
        }

        .Icon-inside {
            position: relative;
        }

        .Icon-inside i {
            position: absolute;
            right: 32%;
            top: 12px;
            padding: 10px 10px;
        }
    </style>

</head>

<body style="background-image: url('images/bank-mandiri_background3.png');background-size: cover; background-attachment: fixed;">


    <div id="st-container" class="st-container">
        <!-- Isi pada menu yang muncul saat menekan tombol drawer -->
        <button data-effect="st-effect-1" class="button3" style="background-color: #C4C4C4; width: 50px; border-radius: 5px; font-size:20px;cursor:pointer; position: absolute; top: 100; right: 0; margin: 0px 0px 5px 5px">&#9776;</button><br><br>
        <nav class="st-menu st-effect-1" id="menu-1">
            <div class="banner">
                <div class="mandiribanner2" onclick="location.href='index.php';" style="cursor: pointer;">
                    <img src="images/mandiri_kuning.png" alt="banner_index">

                </div>
            </div>
            <!-- Daftar list yang terdapat pada halaman -->
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
                    <!-- extra div for emulating position:fixed of the menu -->
                    <!-- Top Navigation -->

                    <form id="form_index2" action="" method="POST" class="form_index" onsubmit="submit_form();">
                    <!-- Untuk mendeklarasikan variabel nama posisi dan kode posisi. Jika terdapat $_POST nama posisi dan kode posisi, maka nilainya dimasukkan kedua variabel tersebut -->
                        <?php
                        if (!isset($_POST['nama_posisi']) && !isset($_POST['kode_posisi'])) {
                            $txt = "";
                            $number = "";
                        } else {
                            $txt = $_POST['nama_posisi'];
                            $number = $_POST['kode_jabatan'];
                        }
                        ?>

                        <div class="form_div">
                            <label class="label_index" style="margin-right: 200px;">

                                <span class="field">ADVANCED SEARCH: POSITION</span></br>
                                <br>

                                <div class="Icon-inside">
                                    <i class="fa fa-search fa-lg fa-fw" aria-hidden="true"></i>
                                    <input class="search" type="text" name="nama_posisi" id="nama_posisi" value="<?= $txt ?>" placeholder="Search..." style="width: 751px; height: 45px; margin-left: 40px; padding-left:10px;">
                                </div>
                            </label>

                            <!-- Untuk memproses pencarian autocomplete saat menginput nama jabatan yang ingin dicari -->
                            <script type='text/javascript'>
                                $(function() {
                                    $("#nama_posisi").autocomplete({
                                        source: function(request, response) {

                                            $.ajax({
                                                url: "ajax-db-search.php",
                                                type: 'post',
                                                dataType: "json",
                                                data: {
                                                    search: request.term
                                                },
                                                // Jika berhasil, maka nama jabatan yang sama akan ditampilkan 1 saja pada interface
                                                success: function(data) {
                                                    let temp = []
                                                    data2 = data.filter((item) => {
                                                        if (!temp.includes(item.label)) {
                                                            temp.push(item.label)
                                                            return true;
                                                        }
                                                    });
                                                    response(data2);
                                                }
                                            });
                                        },

                                        //fungsi ini untuk mendapat kode posisi jabatan secara otomatis saat pointer di arahkan ke jabatan-jabatan yang muncul 
                                        //dari kotak autocomplete
                                        select: function(event, ui) {
                                            $('#nama_posisi').val(ui.item.label); // display the selected text
                                            $('#kode_jabatan').val(ui.item.value); // save selected id to input
                                            return false;

                                        },
                                        //fungsi ini untuk mengisi kolom nama jabatan dan kode posisi secara otomatis saat pointer sudah diarahkan ke jabatan-
                                        //jabatan dari kotak autocomplete. Namun kode posisi tidak terlihat pada layar karena di-hidden.
                                        focus: function(event, ui) {
                                            $("#nama_posisi").val(ui.item.label);
                                            $("#kode_jabatan").val(ui.item.value);
                                            return false;
                                        },
                                    });

                                    // Multiple select

                                });

                            </script>
                            <div class="button_index">
                                <button class="btn3" name="reset" id="clear" onClick="window.location.href=window.location.href" style="margin-right: 90px;"><span><i class="fa fa-refresh" style="font-size: 15px; z-index:99;"></span></i></button>
                                <button class="btn3b" type="submit" name="cari" id="SUBMIT"><span>SEARCH</span></button>
                            </div>

                        </div>
                        <label class="label_index2" style="display:flex; padding: 15px;">
                            <br>
                            <input type="hidden" readonly="true" value="<?= $number ?>" name="kode_jabatan" id="kode_jabatan" style="border: none; border-radius: 0px; border-bottom: 2px solid black; font-size: 15px; font-weight: bold; text-align: center; width: 100px; align-self: flex-end; padding: 0px; margin:auto; margin-top: 20px; margin-bottom: -30px;">
                            
                            <!-- Pada halaman ini seharusnya terdapat kolom input untuk kode jabatan, tetapi dihilangkan pada interface -->
                            <script>
                                $("#kode_jabatan").focus(function() {
                                    $(this).blur();
                                });
                            </script>

                        </label>

                        <br>
                        <br>


                        <!-- Fungsi untuk menampilkan hasil pencarian berdasarkan nama jabatan yang diinput -->
                        <?php
                        function showResult()
                        {
                            echo '<div class="button_index4">';

                            echo '<input type="submit" name="submit" value="COMPARE" style="margin-right: 90px; cursor: pointer;">';
                            echo '</div>';
                            echo '<div class="button_index3">';
                            echo '<button class="btn3b" name="save" id="save" style = "margin: 5px 50px"><span>SAVE</span></a></button>';
                            echo '</div>';

                            include 'config.php';
                            if (isset($_POST['nama_posisi'])) {

                        ?>
                                <div class="container">
                                    <div class="label_form3" id="tableID">
                                        <table class="table1 table-list" style="font-family: sans-serif; margin: 10px; width: 100%;" data-currentpage="1">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Nama & NIP</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th>Jabatan</th>
                                                    <th>Kelas Unit Kerja</th>
                                                    <th>PL</th>
                                                    <th>TC</th>
                                                    <th>Grade</th>
                                                </tr>
                                            </thead>
                                        <?php

                                    } else {
                                        echo "0 results";
                                    }
                                        ?>

                                        <tbody class="list">
                                            <?php
                                            //Kode jabatan dimasukkan ke variabel untuk diproses ke dalam query
                                            $keyword_kode = $_POST['kode_jabatan'];
                                            $query = "SELECT * From jabatan WHERE kode_posisi = '$keyword_kode'";
                                            // filtering ini digunakan untuk pembedaan antara jabatan yang memiliki nilai kelas unit kerja dan yang tidak
                                            $filtering = $conn->query($query);
                                            $row = mysqli_fetch_assoc($filtering);
                                            //Ini merupakan pegawai dengan jabatan yang memiliki nilai kelas unit kerja
                                            if (strpos($row['nama_posisi'], ("BRANCH MGR")) !== FALSE or strpos($row['nama_posisi'], ("BRANCH OPS")) !== FALSE or strpos($row['nama_posisi'], ("AREA HEAD")) !== FALSE or strpos($row['nama_posisi'], ("REG")) !== FALSE or strpos($row['nama_posisi'], ("SME HEAD")) !== FALSE) {
                                                $sql = "SELECT pegawai.kode_posisi,pegawai.nip, pegawai.nilai_PL, pegawai.gender, pegawai.nilai_TC, pegawai.posisi, pegawai.tc, pegawai.pl, pegawai.nilai_kelas_uker, pegawai.nama, pegawai.PS_group, nilai_jabatan.nilai, pegawai.kelas_unker, pegawai.job_exposure, @nilai_exposure := IF(pegawai.job_exposure = (SELECT job_exposure FROM jabatan WHERE jabatan.kode_posisi = '$keyword_kode'), 5, 0), @nilai_sertifikasi := IF(sertifikasi.sertifikasi = (SELECT sertifikasi FROM jabatan WHERE jabatan.kode_posisi = '$keyword_kode'),1 ,0), sertifikasi.sertifikasi, @totalValue := (nilai_jabatan.nilai + pegawai.nilai_PL + pegawai.nilai_TC + pegawai.nilai_kelas_uker + @nilai_exposure + @nilai_sertifikasi + pegawai.nilai_kelas_uker), @nilai_exposure FROM pegawai JOIN nilai_jabatan ON pegawai.PS_group = nilai_jabatan.name JOIN sertifikasi ON pegawai.nip = sertifikasi.nip WHERE (nilai_jabatan.kode_posisi = '$keyword_kode' AND pegawai.kelas_unker != (SELECT kelas_uker FROM jabatan WHERE jabatan.kode_posisi = '$keyword_kode') AND pegawai.nilai_kelas_uker < (SELECT nilai_uker FROM jabatan WHERE jabatan.kode_posisi = '$keyword_kode')) ORDER BY @totalValue := (`nilai_jabatan`.`nilai` + `pegawai`.`nilai_PL` + `pegawai`.`nilai_kelas_uker` + `pegawai`.`nilai_TC` + @nilai_exposure + @nilai_sertifikasi) + `pegawai`.`nilai_kelas_uker` DESC, gender ASC, pegawai.nama ASC";

                                                $result2 = $conn->query($sql);

                                                while ($row = mysqli_fetch_assoc($result2)) {
                                                    $nip = $row["nip"];
                                                    // $image_path = $row["image_path"];
                                            ?>
                                                    <tr onclick='somefunction(event, <?php echo $nip ?>, <?php echo $keyword_kode ?>)' style="height:70px; font-size: 12px;">
                                                        <td><input type="checkbox" id="checkbox_id" name='dataPegawai[]' value="<?php echo $nip ?>"></td>
                                                        <td><?php echo $row["nama"]; ?><br><?php echo $row["nip"]; ?></td>
                                                        <td><?php echo $row["gender"]; ?></td>
                                                        <td><?php echo $row["posisi"]; ?></td>
                                                        <td><?php echo $row["kelas_unker"]; ?></td>
                                                        <td><?php echo $row["pl"]; ?></td>
                                                        <td><?php echo $row["tc"]; ?></td>
                                                        <td><?php echo $row["PS_group"]; ?></td>
                                                    </tr>
                                    </div>
                                <?php };
                                            } else {
                                                // Sedangkan ini yang tidak memiliki nilai kelas unit kerja
                                                $sql = "SELECT pegawai.kode_posisi,pegawai.nip, pegawai.nilai_PL, pegawai.gender, pegawai.nilai_TC, pegawai.posisi, pegawai.tc, pegawai.pl, pegawai.nama, pegawai.PS_group, nilai_jabatan.nilai, pegawai.kelas_unker, pegawai.job_exposure, sertifikasi.sertifikasi, @nilai_exposure := IF(pegawai.job_exposure = (SELECT job_exposure FROM jabatan WHERE jabatan.kode_posisi = '$keyword_kode'), 5, 0), @nilai_sertifikasi := IF(sertifikasi.sertifikasi = (SELECT sertifikasi FROM jabatan WHERE jabatan.kode_posisi = '$keyword_kode'),1 ,0), sertifikasi.sertifikasi, @totalValue := (nilai_jabatan.nilai + pegawai.nilai_PL + pegawai.nilai_TC + pegawai.nilai_kelas_uker + @nilai_exposure + @nilai_sertifikasi) FROM pegawai JOIN nilai_jabatan ON pegawai.PS_group = nilai_jabatan.name JOIN sertifikasi ON pegawai.nip = sertifikasi.nip WHERE (nilai_jabatan.kode_posisi = '$keyword_kode') ORDER BY @totalValue := (`nilai_jabatan`.`nilai` + `pegawai`.`nilai_PL` + `pegawai`.`nilai_TC` + `pegawai`.`nilai_kelas_uker` +  @nilai_exposure + @nilai_sertifikasi) DESC, gender ASC";
                                                $result2 = $conn->query($sql);

                                                while ($row = mysqli_fetch_assoc($result2)) {
                                                    $nip = $row["nip"];
                                                    // $image_path = $row["image_path"];
                                ?>
                                <!-- Untuk mengantar user ke halaman detail pegawai. Fungsinya berupa JavaScript -->
                                    <tr onclick='somefunction(event, <?php echo $nip ?>, <?php echo $keyword_kode ?>)'>
                                        <td><input type="checkbox" id="checkbox_id" name='dataPegawai[]' value="<?php echo $nip ?>"></td>
                                        <td><?php echo $row["nama"]; ?><br><?php echo $row["nip"]; ?></td>
                                        <td><?php echo $row["gender"]; ?></td>
                                        <td><?php echo $row["posisi"]; ?></td>
                                        <td><?php echo $row["kelas_unker"]; ?></td>
                                        <td><?php echo $row["pl"]; ?></td>
                                        <td><?php echo $row["tc"]; ?></td>
                                        <td><?php echo $row["PS_group"]; ?></td>
                                    </tr>
                                </div>
                        <?php };
                                            }




                        ?>
                        </tbody>
                        <tfoot>
                            <!-- Merupakan list pagination -->
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
                </div>
                <br>
            </div>
        <?php

                            $conn->close();
                        }

                        // Mengecek kondisi berdasarkan tindakan yang diambil oleh user
                        if (array_key_exists('cari', $_POST)) {
                            showResult();
                        }

                        if (array_key_exists('save', $_POST)) {
                            saveResult();
                            // header("Location: history_search.php");        
                        }

                        if (array_key_exists('submit', $_POST)) {
                            compareResult();
                        }

        ?>
        </div>
        <script>
            // Fungsi untuk menyimpan hasil pencarian
            <?php
            function saveResult()
            {
                include 'config.php';
                global $dataNIP;

                //query di bawah ini sama dengan yang terdapat pada query di fungsi showResult. Karena menggunakan PHP Native, jadi harus dideklarasikan
                //sama dengan fungsi yang menunjukkan hasil pencarian, agar dapat disimpan saat melakukan penyimpanan.
                $keyword_kode = $_POST['kode_jabatan'];
                $query = "SELECT * From jabatan WHERE kode_posisi = '$keyword_kode'";
                $filtering = $conn->query($query);
                $row = mysqli_fetch_assoc($filtering);
                if (strpos($row['nama_posisi'], ("BRANCH MGR")) !== FALSE or strpos($row['nama_posisi'], ("BRANCH OPS")) !== FALSE or strpos($row['nama_posisi'], ("AREA HEAD")) !== FALSE or strpos($row['nama_posisi'], ("REG")) !== FALSE or strpos($row['nama_posisi'], ("SME HEAD")) !== FALSE) {
                    $sql = "SELECT pegawai.kode_posisi, pegawai.nip, pegawai.nilai_PL, pegawai.gender, pegawai.nilai_TC, pegawai.posisi, pegawai.tc, pegawai.pl, pegawai.nilai_kelas_uker, pegawai.nama, pegawai.PS_group, nilai_jabatan.nilai, pegawai.kelas_unker, pegawai.job_exposure, @nilai_exposure := IF(pegawai.job_exposure = (SELECT job_exposure FROM jabatan WHERE jabatan.kode_posisi = '$keyword_kode'), 5, 0), @nilai_sertifikasi := IF(sertifikasi.sertifikasi = (SELECT sertifikasi FROM jabatan WHERE jabatan.kode_posisi = '$keyword_kode'),1 ,0), sertifikasi.sertifikasi, @totalValue := (nilai_jabatan.nilai + pegawai.nilai_PL + pegawai.nilai_TC + @nilai_exposure + @nilai_sertifikasi + pegawai.nilai_kelas_uker), @nilai_exposure FROM pegawai JOIN nilai_jabatan ON pegawai.PS_group = nilai_jabatan.name JOIN sertifikasi ON pegawai.nip = sertifikasi.nip WHERE (nilai_jabatan.kode_posisi = '$keyword_kode' AND pegawai.kelas_unker != (SELECT kelas_uker FROM jabatan WHERE jabatan.kode_posisi = '$keyword_kode') AND pegawai.nilai_kelas_uker < (SELECT nilai_uker FROM jabatan WHERE jabatan.kode_posisi = '$keyword_kode')) ORDER BY @totalValue := (`nilai_jabatan`.`nilai` + `pegawai`.`nilai_PL` + `pegawai`.`nilai_TC` + @nilai_exposure + @nilai_sertifikasi) + `pegawai`.`nilai_kelas_uker` DESC, gender ASC, pegawai.nama ASC";


                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // output data of each row
                        while ($row = $result->fetch_assoc()) {
                            $nip = $row["nip"];
                            array_push($dataNIP, $nip);
                        };
                    };
                } else {
                    $sql = "SELECT pegawai.kode_posisi, pegawai.nip, pegawai.nilai_PL, pegawai.gender, pegawai.nilai_TC, pegawai.posisi, pegawai.tc, pegawai.pl, pegawai.nama, pegawai.PS_group, nilai_jabatan.nilai, pegawai.kelas_unker, pegawai.job_exposure, sertifikasi.sertifikasi, @nilai_exposure := IF(pegawai.job_exposure = (SELECT job_exposure FROM jabatan WHERE jabatan.kode_posisi = '$keyword_kode'), 5, 0), @nilai_sertifikasi := IF(sertifikasi.sertifikasi = (SELECT sertifikasi FROM jabatan WHERE jabatan.kode_posisi = '$keyword_kode'),1 ,0), sertifikasi.sertifikasi, @totalValue := (nilai_jabatan.nilai + pegawai.nilai_PL + pegawai.nilai_TC + @nilai_exposure + @nilai_sertifikasi) FROM pegawai JOIN nilai_jabatan ON pegawai.PS_group = nilai_jabatan.name JOIN sertifikasi ON pegawai.nip = sertifikasi.nip WHERE (nilai_jabatan.kode_posisi = '$keyword_kode') ORDER BY @totalValue := (`nilai_jabatan`.`nilai` + `pegawai`.`nilai_PL` + `pegawai`.`nilai_TC` + @nilai_exposure + @nilai_sertifikasi) DESC, gender ASC";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // output data of each row
                        while ($row = $result->fetch_assoc()) {
                            $nip = $row["nip"];
                            array_push($dataNIP, $nip);
                        };
                    };
                }

                // Data yang disimpan berdasarkan user yang login
                $username = $_SESSION['username'];
                $sql2 = "SELECT * FROM user WHERE username='$username'";
                $result_2 = $conn->query($sql2);
                $user = $result_2->fetch_assoc();
                $id_user = $user["id_user"];
                $kode_jabatan = $_POST['kode_jabatan'];

                // Menginsert data ke tabel history_pencarian
                $sql3 = "INSERT INTO history_pencarian (id_user, kode_posisi, tanggal)
                        VALUES ($id_user, $kode_jabatan, CURRENT_TIMESTAMP)";
                $result_3 = $conn->query($sql3);
                // Cara mengecek query SQL error di PHP
                if (!$result_3) {;
                }
                if ($result_3 === TRUE) {
                    for ($i = 0; $i < sizeof($dataNIP); $i++) {
                        $sql4 = "SELECT MAX(id_history_pencarian) AS id_tertinggi FROM history_pencarian";
                        $result2 = $conn->query($sql4);
                        $row2 = $result2->fetch_assoc();
                        $id_history_pencarian = $row2["id_tertinggi"];
                        $sql5 = "INSERT INTO detail_history_pencarian (id_history_pencarian, nip)
                                VALUES ($id_history_pencarian, $dataNIP[$i])";
                        if ($conn->query($sql5) === TRUE) {
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }
                    }
                };

                $conn->close();
            }
            ?>

            // Fungsi untuk membandingkan 2 pegawai
            <?php
            function compareResult()
            {
                include 'config.php';

                if ($_POST["submit"] == "COMPARE") {

                    if (!empty($_POST['dataPegawai'])) {

                        $temp = ($_POST['dataPegawai']);
                        // Akan muncul kotak peringatan jika yang dipilih kurang atau lebih dari 2
                        if (sizeof($temp) <= 1) {
                            showResult();
                            echo '<script type="text/javascript">
                                                $(document).ready(function() {
                                                    swal({
                                                        title: "Pesan!!",
                                                        text: "Pilih 2 Pegawai untuk Perbandingan :)",
                                                        icon: "warning",
                                                        button: "Ok",
                                                        timer: 3000
                                                    });
                                                });
                                            </script>';
                        } elseif (sizeof($temp) >= 3) {
                            showResult();
                            echo '<script type="text/javascript">
                                                $(document).ready(function() {
                                                    swal({
                                                        title: "Pesan!!",
                                                        text: "Pilih 2 Pegawai untuk Perbandingan :)",
                                                        icon: "warning",
                                                        button: "Ok",
                                                        timer: 3000
                                                    });
                                                });
                                            </script>';
                        }
                        //Jika berhasil, maka data dibawa ke halaman baru
                        else {
                            echo "'<script>window.location.href = 'graphdetailpegawai.php?" . http_build_query(array(
                                "data" => $temp
                            )) . "';</script>'";
                        }
                    } else {
                        showResult();
                        echo '<script type="text/javascript">
                                                $(document).ready(function() {
                                                    swal({
                                                        title: "Pesan!!",
                                                        text: "Pilih Pegawai untuk Perbandingan :)",
                                                        icon: "warning",
                                                        button: "Ok",
                                                        timer: 3000
                                                    });
                                                });
                                            </script>';
                    }
                } else {
                    echo '';
                }
            }
            ?>
        </script>
        </form>
        <div id="loader" style="display: none;"></div>
        <!-- /main -->
    </div>
    <!-- /st-content-inner -->
    </div>
    <!-- /st-content -->
    </div>

</body>
<footer>
</footer>

</html>

<script>
    // Untuk memproses kemunculan dan menutup Menu
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
        console.log(e.target.getAttribute('data-effect'));
    }

    function closeMenu(el) {
        // if the click target has this class then we close the menu by removing all the classes
        if (el.target.classList.contains('st-pusher')) {
            menu.classList.toggle(effect);
            menu.classList.toggle('st-menu-open');
            // console.log(el.target);
        }
    }

    // Untuk mengatur pagination menggunakan jQuery
    var pagingRows = 10;

    var paginationOptions = {
        innerWindow: 5,

    };
    var options = {
        page: pagingRows,
        plugins: [ListPagination(paginationOptions)],
    };

    var tableList = new List('tableID', options);

    //Jika diklik next, maka halaman akan berpindah ke halaman selanjutnya
    $('.jTablePageNext').on('click', function() {
        var list = $('.pagination').find('li');
        $.each(list, function(position, element) {
            if ($(element).is('.active')) {
                $(list[position + 1]).trigger('click');
            }
        })
    })
    //Jika diklik previous, maka halaman akan berpindah ke halaman sebelumnya
    $('.jTablePagePrev').on('click', function() {
        var list = $('.pagination').find('li');
        $.each(list, function(position, element) {
            if ($(element).is('.active')) {
                $(list[position - 1]).trigger('click');
            }
        })
    })

    // Untuk mengatur agar user mengeklik 1 baris tertentu dari hasil pencarian, akan membuka jendela baru yaitu detail pegawai. Dan diatur hal ini dikecualikan untuk checkbox
    function somefunction(e, id, posisi) {
        if (e.target.cellIndex != undefined) {
            window.open("detailedemployee.php?id=" + id + "&kode_posisi=" + posisi);
        }
    }
</script>
<script>
    // Untuk membuat loader
    function submit_form() {
        document.getElementById("loader").style.display = "";
    }
</script>