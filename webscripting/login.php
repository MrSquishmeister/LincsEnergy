<?php
    include('session.php');
    include('config.php');
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Add a description here">
    <meta name="author" content="Add author here">
    <link rel="stylesheet" type="text/css" href="resources/main.css">
    <link rel="stylesheet" type="text/css" href="vendors/css/maingrid.css">
    <title>Login</title>
</head>

<body>
    <header>
        <!--LincsEnergy Logo-->
        <div class="col header_span_1_of_2">
            <div class="logo">
                <img src="resources/images/logo.png" class="img_logo" alt="LincsEnergy Logo">
            </div>
        </div>

        <!--Navbar-->
        <div class="col header_span_2_of_2">
            <div class="navbar">
                <ul>
                    <li><a href="index.php"><b>HOME</b></a></li>
                    <li><a href="register.php"><b>REGISTER</b></a></li>
                    <li><a href="login.php"><b>LOGIN</b></a></li>
                </ul>
            </div>
        </div>
    </header>

    <main>
        <!--Login Form HTML-->
        <div class="heading">
            Login
        </div>

        <form enctype="application/x-www-form-urlencoded" name="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            <div>
                <input type="text" name="email" placeholder="Email Address">
            </div>

            <div>
                <input type="password" name="password" placeholder="Password">
            </div>

            <input type="submit" name="loginbutton" value="Login">
        </form>

        <!--Login Form PHP-->
        <?php
            if(isset($_POST['loginbutton']) and !empty($_POST['email']) and !empty($_POST['password']))
               {
                   $email = $_POST['email'];
                   $password = $_POST['password'];
                   $ip = $_SERVER['REMOTE_ADDR']; 

                   $query = "SELECT email, password FROM login WHERE email = '$email' and password = '$password'";
                   $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
                    if (mysqli_num_rows($result) > 0)
                    {
                        $query = "INSERT INTO login_history SET ip = '$ip', email = '$email'";
                        mysqli_query($connection, $query) or die(mysqli_error($connection));
                        echo "<div class='user_message'>The login information entered does not match records in the database.</div>";
                        while($row = mysqli_fetch_assoc($result))
                        {
                            $_SESSION['email'] = $row['email'];
                            echo "<script>window.location.href = 'dashboard.php'</script>";
                        }
                    }
                    else
                    {
                        $query = "INSERT INTO login_history SET ip = '$ip', email = '$email'";
                        mysqli_query($connection, $query) or die(mysqli_error($connection));
                        echo "<div class='user_message'>The login information entered does not match records in the database.</div>";
                    }
                }
            echo "<div class='user_message'>To login enter the details of your account.</div>";
        ?>

    </main>

    <footer>
        <!--Footer PHP-->
        <?php
            echo "<span class='footer_text'>" .file_get_contents("textdocuments/footer.txt"). "</span>";
        ?>
    </footer>

</body>

</html>
