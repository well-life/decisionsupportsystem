<?php
session_start();
$dataNIP = array();
$id_user = "1234";
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

    <div class="banner">
        <div class="mandiribanner2" onClick="window.location.href=window.location.href" style="cursor: pointer;">
            <img src="images/mandiri_kuning.png" alt="banner_index">

        </div>
        <br>
        <div class="user_detail">
            <?php
            include 'config.php';

            if (isset($_GET['data'])) {
                $id = $_GET['data'];
            } else {
                $id = array();
            }

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

            <a href="logout.php" class="btn">Logout</a>
        </div>
    </div>
    </div>
    <style>
        .fa-user:before {
            color: #C4C4C4;
            content: "\f007";
        }
    </style>
</head>

<body style="background-image: url('images/bank-mandiri_background3.png');background-size: cover; background-attachment: fixed;">

    <div id="st-container" class="st-container">
        <button data-effect="st-effect-1" class="button3" style="background-color: #C4C4C4; width: 50px; border-radius: 5px; font-size:20px;cursor:pointer; position: absolute; top: 100; right: 0; margin: 0px 3px 15px 0px">&#9776;</button><br><br>

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
                <div class="st-content-inner">
                    <h1>
                        <center>
                            GRAPH DETAIL PEGAWAI
                        </center>
                    </h1>
                    <div class="form-pegawai-container">
                        <div class="riwayat_jabatan2" style="display: flex; flex-direction: row;">


                            <div id="chartjs-radar" style="display: flex; flex-direction: column;">
                                <h3>
                                    <center> Graph Kompentensi Pegawai </center>
                                </h3>
                                <!-- Untuk menampilkan grafik radar pada website -->
                                <canvas id="canvas" width="600" height="600" style="display: block; width: 600px; height: 600px; padding: 5px"></canvas>
                                <script src='script/chart.js'></script>
                                <script src='script/moment.js'></script>

                                <div class="container">
                                    <canvas id="myChart" width="100" height="100">
                                        <script></script>
                                    </canvas>
                                </div>
                                <!-- Data pada grafik radar diatur agar sesuai dengan pegawai 1 dan pegawai 2 yang dibandingkan -->
                                <?php
                                include 'config.php';
                                if (isset($_GET['data'])) {
                                    //query ini untuk mengakses tabel jabatan yang dijoin dengan tabel nilai_jabatan agar nilainya dapat diambil
                                    //dan data yang muncul harus sesuai antara nip pegawai yang satu dan nip pegawai dengan pegawai yang kedua
                                    //dari hasil compare sebelumnya. Dan grade pegawai (PS_group) harus sesuai dengan nama dari nilai_jabatan dan
                                    //kode posisi pegawai juga harus sama dengan kode posisi pada tabel nilai_jabatan
                                    $labeling = array();
                                    $sql = "SELECT * FROM pegawai join nilai_jabatan WHERE (pegawai.nip= $id[0] OR pegawai.nip= $id[1]) AND pegawai.PS_group = nilai_jabatan.name AND pegawai.kode_posisi = nilai_jabatan.kode_posisi";
                                    $result = $conn->query($sql);
                                    //Untuk menyimpan seluruh data dari kedua ke dalam array, agar lebih gampang diakses nanti
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
                                    
                                    //Untuk variabel-variabel yang akan diproses dalam menampilkan grafik chart
                                    var label1 = '<?php echo $labeling[0]['nama']; ?>';
                                    var label2 = '<?php echo $labeling[1]['nama']; ?>';
                                    var randomNumber1 = '<?php echo $labeling[0]['nilai']; ?>';
                                    var randomNumber2 = '<?php echo $labeling[0]['nilai_PL']; ?>';
                                    var randomNumber3 = '<?php echo $labeling[0]['nilai_TC']; ?>';
                                    var randomNumber4 = '<?php echo $labeling[1]['nilai']; ?>';
                                    var randomNumber5 = '<?php echo $labeling[1]['nilai_PL']; ?>';
                                    var randomNumber6 = '<?php echo $labeling[1]['nilai_TC']; ?>';
                                    var nip = '<?php echo $labeling[0]['nip'] ?>';
                                    
                                    console.log(nip);
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
                                            }, {
                                                label: label2,
                                                backgroundColor: color(window.chartColors.blue).alpha(0.2).rgbString(),
                                                borderColor: window.chartColors.blue,
                                                pointBackgroundColor: window.chartColors.blue,
                                                data: [randomNumber4, randomNumber5, randomNumber6],
                                                notes: []
                                            }]
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
                                                            style += '; border-width: 2px';
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

                                    var colorNames = Object.keys(window.chartColors);
                                </script>
                            </div>
                        </div>
                        <div class="detail-graph-pegawai">

                            <h3> Detail Pegawai </h3>
                            <!-- Ini untuk menampilkan data-data kedua pegawai dalam bentuk card -->
                            <?php include 'config.php';
                            $username = $_SESSION['username'];
                            if (isset($_GET['data'])) {
                                $sql = "SELECT * FROM pegawai WHERE nip = '$id[0]' OR nip = '$id[1]'";
                                $result = $conn->query($sql);
                                $index = 0;
                                if ($result->num_rows > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $nip = $row["nip"];
                                        $kode_jabatan = $row['kode_posisi'];
                                        echo '
                                                <div class="detail-pegawai-container">
                                                <div class="detail-pegawai" onClick="somefunction(event, ' . $nip . ', ' . $kode_jabatan . ')">
                                                <center><center><div class = "photo" style = "width: 190px; height: 220px; margin: 20px auto; padding: 15px;"><img src= ' . $row["image_path"] . ' width="100%" height="100%" style = "border: solid 2px; border-radius: 5px; object-fit: fill"></div></center></center>
                                                <hr class="solid">
                                                <div class="employee_detail-container" style = "display:flex; flex-direction: column;  margin-left: 15px;">
                                                    <div id = "nama" style = "display:flex;">
                                                        <div class = "field"><p> Nama: </p></div>
                                                        <div class = "data" style = "margin-left: 43px"><p> ' . $row["nama"] . ' </p></div>
                                                    </div>
                                                    
                                                    <div id = "nip" style = "display:flex;">
                                                        <div class = "field"><p> NIP: </p></div>
                                                        <div class = "data" style = "margin-left: 55px; justify-content: center;"><p> ' . $row["nip"] . ' </p></div>
                                                    </div>
                                                    <div id = "grade" style = "display:flex;">
                                                        <div class = "field"><p> Grade: </p></div>
                                                        <div class = "data" style = "margin-left: 45px; justify-content: center;"><p> ' . $row["PS_group"] . ' </p></div>
                                                    </div>
                                                    <div id = "tmt-grade" style = "display:flex; ">
                                                        <div class = "field" ><p> TMT Grade: </p></div>
                                                        <div class = "data" style = "margin-left: 7px; justify-content: center;"><p> ' . $row["tmt_grade"] . ' </p></div>
                                                    </div>
                                                </div>
                                            </div>
                                                ';
                                    }
                                } else {
                                    echo "";
                                }
                            } else {
                                echo "";
                            }

                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
<script>
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

        // console.log(e.target.getAttribute('data-effect'));
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
    function somefunction(e, id, posisi) {
        window.open("detailedemployee.php?id=" + id + "&kode_posisi=" + posisi);
    }
</script>