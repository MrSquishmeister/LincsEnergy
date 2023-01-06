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
    <title>Register</title>
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
        <!--Register Form HTML-->
        <div class="heading">
            Registration
        </div>

        <form enctype="application/x-www-form-urlencoded" name="register" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            <div>
                <input type="text" name="email" placeholder="Email Address">
            </div>

            <div>
                <input type="text" name="firstname" placeholder="First Name">
            </div>

            <div>
                <input type="text" name="lastname" placeholder="Last Name">
            </div>

            <div>
                <input type="password" name="password" placeholder="Password">
            </div>

            <div>
                <input type="password" name="confirmpassword" placeholder="Confirm Password">
            </div>

            <input type="submit" name="registerbutton" value="Register">
        </form>

        <!--Register Form PHP-->
        <?php
            if(!empty($_POST['registerbutton']) and !empty($_POST['email']) and !empty($_POST['firstname']) and !empty($_POST['lastname']) and !empty($_POST['password']) and !empty($_POST['confirmpassword']) and $_POST['password'] == $_POST['confirmpassword'])
            {
                $email = $_POST['email'];
                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];
                $password = $_POST['password'];
                $query = "SELECT email FROM login WHERE email = '$email'";
                $result = mysqli_query($connection, $query) or die(mysqli_error($connection));

                if (mysqli_num_rows($result) > 0)
                {
                    while($row = mysqli_fetch_assoc($result))
                    {
                        echo "<div class='user_message'>An account with the email address: <span>" .$row['email']. "</span> already exists.</div>";
                    }
                }
                else
                {
                    $query = "INSERT INTO login SET email = '$email', firstname = '$firstname', lastname = '$lastname', password = '$password'";
                    mysqli_query($connection, $query) or die(mysqli_error($connection));
                    $query = "SELECT email FROM login WHERE email = '$email'";
                    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
                    while($row = mysqli_fetch_array($result))
                    {
                        $_SESSION['email'] = $row['email'];
                        echo "<script>window.location.href = 'dashboard.php'</script>";
                    }
                }

            }
            else if(!empty($_POST['registerbutton']))
                {
                    echo "<div class='user_message'> The password and confirm password entered do not match.</div>";
                }
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
