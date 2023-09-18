<head>
    <script src="script/sweetalert.js"></script>
    <script src="script/jquery.js"></script>
</head>
<?php

include 'config.php';

error_reporting(0);

session_start();

if (isset($_SESSION['username'])) {
    header("Location: index.php");
}

// Jika disubmit berdasarkan username dan password, maka dicek dengan query apakah user tersebut ada.
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['username'];
        $_SESSION['id_user'] = $row['id_user'];
        $id_user = $row["id_user"];
        $timestamp = date("Y-m-d H:i:s");
        $sql_insert = "INSERT INTO login_log (id_user, login_time) VALUES ($id_user, $timestamp)";
        if (mysqli_query($conn, $sql_insert)) {
            echo "Records inserted successfully.";
        } else {
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
        header("Location: index.php");
    } else {

        // Untuk menampilkan warning atau alert
        echo '<script type="text/javascript">
                    $(document).ready(function() {
                        swal({
                            title: "Pesan!!",
                            text: "Username atau password Anda salah. Silahkan coba lagi!",
                            icon: "warning",
                            button: "Ok",
                            timer: 3000
                        });
                    });
                </script>';
    }
}

?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Decision Support System</title>
    <meta name="viewport" content="width=device-width">
    <meta name="viewport" content="height=device-height">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
</head>

<body>
    <div class="alert alert-warning" role="alert">
        <?php echo $_SESSION['error'] ?>
    </div>
    <div class="left-section">
        <div class="mandiribanner">
            <img src="images/mandiri.png" alt="banner">


        </div>
        <h1>Decision Support System</h1>
        <h1>Human Capital <br> Region VIII / Jawa 3</h1>
    </div>

    <div class="right-section">
        <form action="" method="POST">
            <h3>Login Page</h3>
            <h4>Username</h4>
            <input type="text" id="username" name="username"><br><br>
            <h4>Password</h4>
            <input type="password" id="password" name="password"><br><br>
            <input type="reset" id="clear" value="CLEAR">
            <button name="submit" id="login" style="color:black; font-size: 13px;">SIGN IN</button>
        </form>
    </div>
</body>
<footer>

</footer>

</html>