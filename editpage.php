<?php

use LDAP\Result;

include("config.php");
session_start();

$id = $_GET['id'];
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

        label {
            color: #000;
            font-weight: bold;
            width: 180px;
            float: left;

        }

        label:after {
            content: ": "
        }


        input {
            box-shadow: rgba(17, 17, 26, 0.1) 0px 4px 16px, rgba(17, 17, 26, 0.05) 0px 8px 32px;
            width: 80%;
            height: 35px;
            margin-top: -10px;
            padding: 5px;
            border: none;
            border-bottom: 2px solid black;
            border-radius: 5px;
            -webkit-transition: 0.5s;
            transition: 0.5s;
        }

        input:focus {
            border: 3px solid #555;
        }
    </style>

</head>

<body style="background-image: url('images/bank-mandiri_background3.png');background-size: cover; background-attachment: fixed;">


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
                <div class="st-content-inner">
                    <div class="detailedemployeecontainer2">
                        <?php
                        include 'config.php';
                        $sql = "SELECT * FROM pegawai WHERE nip='$id'";
                        $result = $conn->query($sql);
                        $image_path = $row["image_path"];
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                        <!-- Untuk mengedit data pegawai -->
                                <form method="POST" action="updatepegawai.php">
                                    <div class="header-section">
                                        <div class="img-container">
                                            <img src='<?php echo $image_path ?>' width="150px" height="150px" style="border: solid 2px; border-radius: 5px; color: white; object-fit: cover;">
                                        </div>
                                        <div class="text-header">
                                            <h1>PROFIL PEGAWAI</h1>
                                        </div>
                                    </div>
                                    <div class="form-container2">
                                        <p>
                                            <label for="name">Name</label>
                                            <input type="text" id="name" name="name" value="<?php echo $row['nama'] ?>" readonly />
                                        </p>
                                        <p>
                                            <label for="nip">NIP</label>
                                            <input type="text" id='nip' name="nip" value="<?php echo $row['nip'] ?>" readonly /><br />
                                        </p>
                                        <!-- Nama dan NIP pegawai tidak dapat diedit -->
                                        <p>
                                            <label for="tanggal-lahir">Tanggal Lahir</label>
                                            <input type="date" id="tanggal-lahir" name="tanggal-lahir" min="1901-01-01" value="<?php echo $row['tanggal_lahir'] ?>" /><br />
                                        </p>
                                        <p>
                                            <label for="grade">Grade</label>
                                            <input type="text" id="grade" name="grade" value="<?php echo $row['PS_group'] ?>" /><br />
                                        </p>
                                        <p>
                                            <label for="tmt-grade">TMT Grade</label>
                                            <input type="date" id="tmt-grade" name="tmt-grade" min="1901-01-01" value="<?php echo $row['tmt_grade'] ?>" /><br />
                                        </p>
                                        <p>
                                            <label for="marital-status">Marital Status</label>
                                            <input type="text" id="marital-status" name="marital-status" value="<?php echo $row['marital_status'] ?>" /><br />
                                        </p>
                                        <p>
                                            <label for="work-contract-type">Work Contract Type</label>
                                            <input type="text" id="work-contract-type" name="work-contract-type" value="<?php echo $row['work_contract'] ?>" />
                                        </p>
                                        <div class="button-group">
                                            <button type="clear" class="btnCancel" onclick="location.href='index.php';">Cancel</button>
                                            <button class="btnInput" type="submit"><span>UPDATE</span></button>
                                        </div>
                                    </div>
                                </form>
                        <?php }
                        } ?>

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
    }

    function closeMenu(el) {
        // if the click target has this class then we close the menu by removing all the classes
        if (el.target.classList.contains('st-pusher')) {
            menu.classList.toggle(effect);
            menu.classList.toggle('st-menu-open');
        }
    }
</script>