<?php
include("config.php");
session_start();

$id = $_GET['id'];
$posisi = $_GET['kode_posisi'];
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

?>


<!DOCTYPE HTML>
<html>

<head>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css/Main.css">
    <script src="script/jquery.js"></script>
    <script src="script/sweetalert.js"></script>
    <script src="script/pagination.js"></script>
    <script src="script/list.js"></script>
    <style>
        .form-graph {
            width: 60%;
            height: 100%;
            margin: auto;
        }

        .st-content-inner {
            padding: 30px;
            background-color: #002D44;
            width: 1210px;
            height: 900px;
            margin: auto;
            color: white;
            border: 3px solid orange;
        }
    </style>
    <div class="banner">
        <div class="mandiribanner2" onClick="window.location.href=window.location.href" style="cursor: pointer;">
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
            <a href="logout.php" class="btna">Logout</a>
        </div>
    </div>
</head>

<body style="background-image: url('images/bank-mandiri_background3.png'); background-size: cover; background-attachment: fixed;">
    <div id="st-container" class="st-container">
        <button data-effect="st-effect-1" class="button3" style="background-color: #C4C4C4; width: 50px; border-radius: 5px; font-size:20px;cursor:pointer; position: absolute; top: 100; right: 0; margin: 0px 0px 5px 5px">&#9776;</button><br><br>
        <nav class="st-menu st-effect-1" id="menu-1">
            <div class="banner">
                <div class="mandiribanner2" onClick="window.location.href=window.location.href" style="cursor: pointer;">
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

                <!-- Menampilkan seluruh detail pegawai berdasarkan nip yang diterima dari halaman sebelumnya -->
                <div class="detailedemployeecontainer">
                    <?php
                    include("config.php");
                    $sql = "SELECT * FROM pegawai JOIN history_jabatan ON pegawai.nip = history_jabatan.nip JOIN sertifikasi ON pegawai.nip = sertifikasi.nip WHERE pegawai.nip AND history_jabatan.nip = $id ";

                    $sql3 = "SELECT * FROM pegawai JOIN history_jabatan ON pegawai.nip = history_jabatan.nip JOIN sertifikasi ON pegawai.nip = sertifikasi.nip WHERE pegawai.nip AND history_jabatan.nip = $id ";
                    $result = $conn->query($sql);

                    $result3 = $conn->query($sql3);
                    $line_break = "<br>";
                    $sizeArr = array();
                    while ($row3 = mysqli_fetch_assoc($result3)) {
                        array_push($sizeArr, $row3['nama_posisi']);
                    };

                    if ($result->num_rows > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $image_path = $row["image_path"];
                        $today = new DateTime();
                        $birthdate = new DateTime($row["tanggal_lahir"]);
                        $interval = $today->diff($birthdate);
                        echo '
                        <div class="first_section">
                            <div class="employee_photo" style="display: flex; float: left; margin-top:43px; margin-left:50px; margin-right:25px;">
                                <img src=' . $image_path . ' width="150px" height="150px" style = "border: solid 2px; border-radius: 5px; color: white; object-fit: fill;">
                            </div>
                            <div class="employee_detail_1" style="display: flex; flex-direction: column;  float: left; width:20%; height: 255px; justify-content: space-between;  margin-left:10px; margin-top: 20px;">
                                <p style="font-size:17.5px;"> <b> Name </b> </p>
                                <p style = "margin-top: 10px;"> ' . $row["nama"] . ' </p>
                                <br>
                                <p style="font-size:17.5px;"> <b> NIP </b> </p>
                                <p style = "margin-top: 10px;"> ' . $row["nip"] . ' </p>
                            </div>
                            <div class="employee_detail_2" style="display: flex; flex-direction: column; float: left; width:20%; height: 255px; justify-content: space-between;margin-left:10px; margin-top: 20px;">
                                <p style="font-size:17.5px;"> <b> Grade </b> </p>
                                <p style = "margin-top: 10px;"> ' . $row["PS_group"] . ' </p>
                                <br>
                                <p style="font-size:17.5px;"> <b> TMT Grade </b> </p>
                                <p style = "margin-top: 10px;"> ' . $row["tmt_grade"] . ' </p>
                            </div>
                            <div class="employee_detail_3" style="display: flex; flex-direction: column; float: left; width:20%; height: 255px; justify-content: space-between;margin-left:10px; margin-top: 20px;">
                                <p style="font-size:17.5px;"> <b> Age </b> </p>
                                <p style = "margin-top: 10px;"> ' . $interval->format('%y Years') . ' </p>
                                <br>
                                <p style="font-size:17.5px;"> <b> Marital Status </b> </p>
                                <p style = "margin-top: 10px;"> ' . $row["marital_status"] . ' </p>
                            </div>
                            <div class="employee_detail_4" style="float: left; width:20%; margin-left:0px; margin-top: 20px;">
                                <p style="font-size:17.5px;"> <b> Work Contract Type </b> </p>
                                <p style = "margin-top: 35px;"> ' . $row["work_contract"] . ' </p>
                                <br>
                            </div>
                        </div>

                        <div class="first_section2">
                            <div class="pendidikan">
                                <h3> Pendidikan </h3>
                                <hr class="solid">
                                <div class = "detail_section">
                                
                            </div>
                        
                        </div>';

                        echo '<div class="sertifikasi">
                                <h3> Sertifikasi </h3>
                                <hr class="solid">
                                <div class = "section_detil">
                                <p style = "margin: 15px;">' . $row['sertifikasi'] . '</p>
                        </div>
                                <br>
                            </div>
                        </div>
                    
                        <div class="last_section">
                            <div class="riwayat_jabatan">
                                <h3> Riwayat Jabatan </h3>
                                <hr class="solid">
                                <div class = "detail_section">
                                <table style = "border-collapse: collapse; ">
                                ';

                                // Ini untuk mengatur section riwayat jabatan
                        while ($row = mysqli_fetch_assoc($result)) {
                            $monthNum = date("m", strtotime($row["start_date"]));
                            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                            $monthName = $dateObj->format('F');
                            $year = date("Y", strtotime($row["start_date"]));
                            echo '<tr>
                            <td style = "text-align: left; padding:3px; padding-right: 20px;">' . $monthName . ' - ' . $year . '</td>
                            <td style = "text-align: left; padding:3px; padding-left:0">' . $row["nama_posisi"] . '</td>                            
                            </tr>';
                        };
                        echo '</table>
                            </div>
                        
                        </div>';

                        // Untuk menampilkan Performance Level
                        include("config.php");
                        $sql2 = "SELECT * FROM pegawai WHERE nip = $id";
                        $result2 = $conn->query($sql2);
                        echo '<div class="performance_level">
                                <h3> Performance Level </h3>
                                <hr class="solid">
                                <div class = "detail_section">
                                <table>
                                <tr>
                                    <th>PL 2019</th>
                                    <th>PL 2020</th>
                                    <th>PL</th>
                                </tr>
                                
                                ';
                        if ($result2->num_rows > 0) {
                            $row2 = mysqli_fetch_assoc($result2);
                            echo '<tr>
                            <td>' . $row2["pl_2019"] . '</td>
                            <td>' . $row2["pl_2020"] . '</td>
                            <td>' . $row2["pl"] . '</td>
                            </tr>';
                        }
                        echo '
                        </table>
                        </div>
                                <br>
                            </div>
                        </div>
                    ';
                    }
                    ?>

                </div>
                <?php
                include 'config.php';

                // Untuk menampilkan grafik radar dari pegawai

                $query = "SELECT * FROM pegawai join nilai_jabatan ON pegawai.PS_group = nilai_jabatan.name WHERE nilai_jabatan.kode_posisi = $posisi AND (pegawai.nip= $id)";
                $hasil = $conn->query($query);
                if (mysqli_num_rows($hasil) != 0) {
                    echo '
                <div class="st-content-inner">
                    <h2 style = "margin-bottom: 70px;">
                        <center>
                            GRAPH KOMPETENSI PEGAWAI
                        </center>
                    </h2>
                    <div class="form-graph">';
                ?>

                    <canvas id="canvas" width="1400" height="1400" style="display: block; height: 500px; width: 700px; padding: 10px; background:rgb(239,239,239)"></canvas>
                    <script src='script/chart.js'></script>
                    <script src='script/moment.js'></script>

                    <?php
                    include 'config.php';
                    if (isset($_GET['id'])) {
                        $labeling = array();
                        $sql = "SELECT * FROM pegawai join nilai_jabatan ON pegawai.PS_group = nilai_jabatan.name WHERE nilai_jabatan.kode_posisi = $posisi AND (pegawai.nip= $id)";
                        $result = $conn->query($sql);
                        while ($row = mysqli_fetch_array($result)) {
                            array_push($labeling, $row);
                        }
                    }
                    ?>
                    <script>
                        window.chartColors = {
                            red: 'rgb(255, 99, 132)',
                            orange: 'rgb(255, 159, 64)',
                            yellow: 'rgb(255, 205, 86)',
                            green: 'rgb(75, 192, 192)',
                            blue: 'rgb(54, 162, 235)',
                            purple: 'rgb(153, 102, 255)',
                            grey: 'rgb(231,233,237)'
                        };

                        window.randomScalingFactor = function() {
                            return (Math.random() > 0.5 ? 1.0 : -1.0) * Math.round(Math.random() * 100);
                        }

                        var randomScalingFactor = function() {
                            return Math.round(Math.random() * 100);
                        };

                        var now = moment();
                        var dataTime1 = moment("2016-12-18T14:58:54.026Z");
                        var label1 = '<?php echo $labeling[0]['nama']; ?>';
                        var randomNumber1 = '<?php echo $labeling[0]['nilai']; ?>';
                        var randomNumber2 = '<?php echo $labeling[0]['nilai_PL']; ?>';
                        var randomNumber3 = '<?php echo $labeling[0]['nilai_TC']; ?>';

                        var color = Chart.helpers.color;
                        var config = {
                            type: 'radar',
                            data: {
                                labels: [
                                    "Grade", "Performance Level", "Talent Classification"
                                ],
                                datasets: [{
                                    label: label1,
                                    backgroundColor: color(window.chartColors.red).alpha(0.2).rgbString(),
                                    borderColor: window.chartColors.red,
                                    pointBackgroundColor: window.chartColors.red,
                                    data: [randomNumber1, randomNumber2, randomNumber3],
                                    notes: []
                                }, ]
                            },
                            options: {
                                legend: {
                                    position: 'top',
                                },
                                title: {
                                    display: true,

                                },
                                scale: {
                                    ticks: {
                                        beginAtZero: true
                                    }
                                },
                                tooltips: {
                                    enabled: false,
                                    callbacks: {
                                        label: function(tooltipItem, data) {
                                            var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                            //This will be the tooltip.body
                                            return datasetLabel + ': ' + tooltipItem.yLabel + ': ' + data.datasets[tooltipItem.datasetIndex].notes[tooltipItem.index];
                                        }
                                    },
                                    custom: function(tooltip) {
                                        // Tooltip Element
                                        var tooltipEl = document.getElementById('chartjs-tooltip');
                                        if (!tooltipEl) {
                                            tooltipEl = document.createElement('div');
                                            tooltipEl.id = 'chartjs-tooltip';
                                            tooltipEl.innerHTML = "<table></table>"
                                            document.body.appendChild(tooltipEl);
                                        }
                                        // Hide if no tooltip
                                        if (tooltip.opacity === 0) {
                                            tooltipEl.style.opacity = 0;
                                            return;
                                        }
                                        // Set caret Position
                                        tooltipEl.classList.remove('above', 'below', 'no-transform');
                                        if (tooltip.yAlign) {
                                            tooltipEl.classList.add(tooltip.yAlign);
                                        } else {
                                            tooltipEl.classList.add('no-transform');
                                        }

                                        function getBody(bodyItem) {
                                            return bodyItem.lines;
                                        }
                                        // Set Text
                                        if (tooltip.body) {
                                            var titleLines = tooltip.title || [];
                                            var bodyLines = tooltip.body.map(getBody);
                                            var innerHtml = '<thead>';
                                            titleLines.forEach(function(title) {
                                                innerHtml += '<tr><th>' + title + '</th></tr>';
                                            });
                                            innerHtml += '</thead><tbody>';
                                            bodyLines.forEach(function(body, i) {
                                                var colors = tooltip.labelColors[i];
                                                var style = 'background:' + colors.backgroundColor;
                                                style += '; border-color:' + colors.borderColor;
                                                style += '; border-width: 3px';
                                                // var span = '<span class="chartjs-tooltip-key" style="' + style + '"></span>';
                                                innerHtml += '<tr><td>' + span + body + '</td></tr>';
                                            });
                                            innerHtml += '</tbody>';
                                            var tableRoot = tooltipEl.querySelector('table');
                                            tableRoot.innerHTML = innerHtml;
                                        }
                                        var position = this._chart.canvas.getBoundingClientRect();
                                        // Display, position, and set styles for font
                                        tooltipEl.style.opacity = 1;
                                        tooltipEl.style.left = position.left + tooltip.caretX + 'px';
                                        tooltipEl.style.top = position.top + tooltip.caretY + 'px';
                                        tooltipEl.style.fontFamily = tooltip._fontFamily;
                                        tooltipEl.style.fontSize = tooltip.fontSize;
                                        tooltipEl.style.fontStyle = tooltip._fontStyle;
                                        tooltipEl.style.padding = tooltip.yPadding + 'px ' + tooltip.xPadding + 'px';
                                    }
                                }
                            }
                        };
                        window.onload = function() {
                            window.myRadar = new Chart(document.getElementById("canvas"), config);
                        };
                    </script>
            </div>
        </div>
    <?php } ?>
    </div>
    </div>
    </div>

</body>

</html>
<script>

    // Sama seperti di halaman index, untuk menampilkan dan menutup menu
    var click = document.querySelectorAll('div button');
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