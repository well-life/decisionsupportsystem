<?php
session_start();
$dataNIP = array();
$dataPegawai = array();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
$kode_jabatan = "";
$nama_posisi = "";

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
        input[type="checkbox"]:checked {
            background-color: green;
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

        .form-container {
            background-color: white;
            width: 100.2%;
            height: 400px;
            padding: 30px;
        }

        .grid-form {
            display: grid;
            height: 270px;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 0.1fr 0.5fr;
            grid-row-gap: 10px;
            grid-column-gap: 100px;
        }

        .btnInput {
            background-color: #EA7200;
            height: 30px;
            width: 100px;
            border: solid black 0px;
            border-radius: 10px;
            margin: 0px;
            cursor: pointer;
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
                    <?php
                    include 'config.php';
                    $id = $_SESSION['id_user'];
                    $sql = "SELECT * FROM user WHERE id_user='$id'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    ?>
                            <div class="container-header" style="background: #c4c4c4; width: 100.2%; height: 180px; margin-top: -40px; margin-bottom: 0px; padding: 25px;">
                                <div class="profile-picture" style="display: flex; margin: 0px auto;">
                                    <img src="" alt="" style="object-fit: cover; width: 130px; height: 115px; border: solid black 2px; margin: -5px auto;" />
                                </div>
                                <div>
                                    <center>
                                        <p>Profile Picture</p>
                                    </center>
                                </div>
                            </div>

                            <form method="post" action="update.php">
                                <!-- Kolom input untuk mengedit data user -->

                                <div class="form-container">
                                    <div class="grid-form">
                                        <div class="username">
                                            <input type="hidden" id="id" name="id" value="<?php echo $row['id_user'] ?>">
                                            <label for="username" style="display:block; margin-bottom: 10px;">Username</label>
                                            <input type="text" id="username" name="username" value="<?php echo $row['username'] ?>" style="background: #c4c4c4; width: 500px; height: 30px; border: solid black 0px; border-radius: 5px; margin-bottom: 20px; padding: 5px;" readonly />
                                        </div>
                                        <div class="name">
                                            <label for="" style="display:block; margin-bottom: 10px;">Name</label>
                                            <input type="text" id="name" name="name" value="<?php echo $row['name'] ?>" style="background: #c4c4c4; width: 500px; height: 30px; border: solid black 0px; border-radius: 5px;margin-bottom: 20px; padding: 5px;" />
                                        </div>
                                        <div class="nip">
                                            <label for="nip" style="display:block; margin-bottom: 10px;">NIP</label>
                                            <input type="text" id="nip" name="nip" value="<?php echo $row['nip'] ?>" style="background: #c4c4c4; width: 500px; height: 30px; border: solid black 0px; border-radius: 5px;margin-bottom: 20px; padding: 5px;" />
                                        </div>
                                        <div class="email">
                                            <label for="email" style="display:block; margin-bottom: 10px;">Email</label>
                                            <input type="email" id="email" name="email" value="<?php echo $row['phone_number'] ?>" style="background: #c4c4c4; width: 500px; height: 30px; border: solid black 0px; border-radius: 5px;margin-bottom: 20px; padding: 5px;" />
                                        </div>
                                        <div class="phone-number">
                                            <label for="phone-number" style="display:block; margin-bottom: 10px;">Phone Number</label>
                                            <input type="text" id="phone-number" name="phone-number" value="<?php echo $row['email'] ?>" style="background: #c4c4c4; width: 500px; height: 30px; border: solid black 0px; border-radius: 5px;margin-bottom: 20px; padding: 5px;" />
                                        </div>
                                        <div class="password">
                                            <label for="password2" style="display:block; margin-bottom: 10px;">Password</label>
                                            <input type="password" id="password2" name="password2" value="<?php echo $row['password'] ?>" style="background: #c4c4c4; width: 500px; height: 30px; border: solid black 0px; border-radius: 5px;margin-bottom: 20px; padding: 5px;" readonly />
                                        </div>

                                    </div>
                                    <input class="btnInput" type="submit" value="Update"></button>
                                    <button type="clear" style="background-color: #C4C4C4;height: 30px; width: 100px; border-radius: 10px; color: black; cursor:pointer">Cancel</button>
                                </div>
                            </form>
                    <?php
                        }
                    } ?>
                </div>
            </div>
        </div>
    </div>
</body>
<footer>
</footer>

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