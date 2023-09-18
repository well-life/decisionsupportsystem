<?php
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
<!doctype html>
<html lang="en">

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

    <!-- Untuk menampilkan accordion -->
    <script>
        $(function() {
            $("#accordion").accordion({});
        });
    </script>
    <div class="banner">
        <div class="mandiribanner2" onclick="location.href='advancedFilter.php';" style="cursor: pointer;">
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

        .accordion {
            color: #444;
            padding: 18px;
            width: 97.5%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
            transition: 0.4s;
            margin: auto;
            margin-bottom: -75px;
        }

        .ui-accordion-header {
            background-color: rgb(103, 178, 232);
            height: 70px;

        }

        .search-label {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }

        #input_filter[type=text],
        #select_filter {
            width: 300px;
            padding: 12px 20px;
            margin: 8px 0;
            display: block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        #input_submit[type=submit] {
            width: 150px;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 25px 0;
            margin-right: 90px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        #input_submit[type=submit]:hover {
            background-color: #45a049;
        }

        .search-box {
            margin: 0px 0px;
            width: 500px;
            height: 180px;
            display: grid;
            grid-template-columns: 400px 400px 100px;
        }

        form {
            padding: 10px;
        }
    </style>
</head>

<body style="background-image: url('images/bank-mandiri_background3.png');background-size: cover; background-attachment: fixed;">
    <div id="st-container" class="st-container">
        <button data-effect="st-effect-1" class="button3" style="background-color: #C4C4C4; width: 50px; border-radius: 5px; font-size:20px;cursor:pointer; position: absolute; top: 100; right: 0; margin: 0px 0px 5px 5px">&#9776;</button><br><br>
        <nav class="st-menu st-effect-1" id="menu-1">
            <div class="banner">
                <div class="mandiribanner2" onclick="location.href='advancedFilter.php';" style="cursor: pointer;">
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
                    <!-- Kotak pencarian menggunakan accordion yang secara default langsung tampil -->
                    <div id="accordion" class="accordion" stye>
                        <h3 style="font-size: 17px;"><span style="position: relative; top: 11px;">ADVANCED FILTERING SEARCH</span></h3>
                        <div class="panel active">
                            <form name="frmSearch" id="filter-form" method="POST">
                                <!-- Setiap variabel dideklarasikan sesuai labelnya -->
                                <div class="search-box">
                                    <div>
                                        <?php
                                        $kata_kunci = "";
                                        ?>
                                        <label class="search-label">Nama:</label>
                                        <input type="text" name="kata_kunci" id="input_filter" value="<?php echo $kata_kunci; ?>" />
                                    </div>

                                    <div>
                                        <?php
                                        $kata_kunci1 = "";
                                        ?>
                                        <label class="search-label">NIP:</label>
                                        <input type="text" name="kata_kunci1" id="input_filter" value="<?php echo $kata_kunci1; ?>" />
                                    </div>

                                    <div>
                                        <?php
                                        $kata_kunci2 = "";
                                        ?>
                                        <label class="search-label">Posisi:</label>
                                        <input type="text" name="kata_kunci2" id="input_filter" value="<?php echo $kata_kunci2; ?>" />
                                    </div>

                                    <div>
                                        <?php
                                        $kata_kunci3 = "";
                                        ?>
                                        <label class="search-label">Grade:</label>
                                        <input type="text" name="kata_kunci3" id="input_filter" value="<?php echo $kata_kunci3; ?>" />
                                    </div>

                                    <div>
                                        <?php
                                        $kata_kunci4 = "";
                                        ?>
                                        <label class="search-label">PL:</label>
                                        <select name="kata_kunci4" id="select_filter" class="demoInputBox">
                                            <option value=""></option>
                                            <option value="PL1">PL1</option>
                                            <option value="PL2">PL2</option>
                                            <option value="PL3">PL3</option>
                                        </select>
                                    </div>
                                    <div>
                                        <?php
                                        $kata_kunci5 = "";
                                        ?>
                                        <label class="search-label">TC:</label>
                                        <select name="kata_kunci5" id="select_filter" class="demoInputBox">
                                            <option value=""></option>
                                            <option value="CR">CR</option>
                                            <option value="HIPO">HIPO</option>
                                            <option value="KC">KC</option>
                                        </select>
                                    </div>
                                </div>
                                <div style="display: flex; justify-content: flex-end">
                                    <input type="submit" name="search" class="btnSearch" id="input_submit" value="Search">

                                </div>
                            </form>

                        </div>
                    </div>
                    <?php
                    // Fungsi untuk menampilkan hasil pencarian berdasarkan kata kunci yang telah diinput
                    function ShowResultAdvanced()
                    {
                        include "config.php";
                        if (isset($_POST['kata_kunci']) or isset($_POST['kata_kunci1']) or isset($_POST['kata_kunci2']) or isset($_POST['kata_kunci3']) or isset($_POST['kata_kunci4']) or isset($_POST['kata_kunci5'])) {
                            $kata_kunci = trim($_POST['kata_kunci']);
                            $kata_kunci1 = trim($_POST['kata_kunci1']);
                            $kata_kunci2 = trim($_POST['kata_kunci2']);
                            $kata_kunci3 = trim($_POST['kata_kunci3']);
                            $kata_kunci4 = trim($_POST['kata_kunci4']);
                            $kata_kunci5 = trim($_POST['kata_kunci5']);
                            // query ini untuk mencari pegawai yang join dengan tabel jabatan dan dicari berdasarkan kata-kata kunci yang ada menggunakan "like" dan operator AND
                            $sql = "select * from pegawai join jabatan ON pegawai.kode_posisi = jabatan.kode_posisi where pegawai.nama like '%" . $kata_kunci . "%' AND pegawai.nip like '%" . $kata_kunci1 . "%' AND pegawai.posisi like '%" . $kata_kunci2 . "%' AND pegawai.PS_group like '%" . $kata_kunci3 . "%' AND pegawai.pl like '%" . $kata_kunci4 . "%' AND pegawai.tc like '%" . $kata_kunci5 . "%'order by pegawai.nama asc";
                            $hasil = mysqli_query($conn, $sql);
                    ?>

                            <div class="label_form3" id="tableID">
                                <table class="table1">
                                    <br>
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Nama & NIP</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Jabatan</th>
                                            <th>Organization Unit</th>
                                            <th>PL</th>
                                            <th>TC</th>
                                            <th>Range Grade</th>
                                            <th>Job Exposure</th>
                                        </tr>
                                    </thead>
                                <?php
                            } else {
                                echo "Data not Found";
                            }

                                ?>
                                <tbody class="list">
                                    <?php



                                    if ($hasil->num_rows > 0) {
                                        // output data of each row
                                        while ($row = $hasil->fetch_assoc()) {
                                            $nip = $row["nip"];
                                            $kode_jabatan = $row['kode_posisi'];
                                    ?>
                                    <!-- Untuk menampilkan hasil dalam bentuk tabel, di mana setiap baris dari hasil pencarian dapat diklik untuk masuk ke halaman detail pegawai -->
                                            <tr style="height:100px; font-size: 12px;" onclick='somefunction(event, <?php echo $nip ?>, <?php echo $kode_jabatan ?>)'>
                                                <td><img src="<?php echo $row["image_path"] ?>" alt="" height=90 width=90 border=1px style="border-radius: 5px; margin-left: 10px; object-fit: fill"></td>
                                                <td><?php echo $row["nama"]; ?><br><?php echo $row["nip"]; ?></td>
                                                <td><?php echo $row["gender"]; ?></td>
                                                <td><?php echo $row["posisi"]; ?></td>
                                                <td><?php echo $row["organizational_unit"]; ?></td>
                                                <td><?php echo $row["pl"]; ?></td>
                                                <td><?php echo $row["tc"]; ?></td>
                                                <td><?php echo $row["grade_min"] . '-' . $row['grade_max'] ?></td>
                                                <td><?php echo $row["job_exposure"] ?></td>
                                            </tr>
                            </div>
                    <?php
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

                <?php
                        $conn->close();
                    }
                    if (array_key_exists('search', $_POST)) {
                        ShowResultAdvanced();
                    } ?>

                </div>
            </div>
        </div>
    </div>
</body>

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
</script>

<script>
    window.onload = function() {
        document.getElementById('loader').style.display = "none";
    }
</script>
<script>
    //Untuk mengatur pagination pada hasil pencarian, persis seperti pada halaman index
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