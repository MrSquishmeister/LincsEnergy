<?php
    include('session.php');
    include('access.php');
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
    <link rel="stylesheet" type="text/css" href="resources/dashboard.css">
    <title>Edit</title>
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
                    <li><a href="dashboard.php"><b>DASHBOARD</b></a></li>
                    <li><a href="management.php"><b>MANAGEMENT</b></a></li>
                    <li><a href="logout.php"><b>LOGOUT</b></a></li>
                </ul>
            </div>
        </div>
    </header>

    <main>
        <!--Ouput firstname-->
        <?php
            $email = $_SESSION['email'];
            $query = "SELECT firstname, lastname, password, email FROM login WHERE email='$email'";
            $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
            while($row = mysqli_fetch_array($result))
            {
                echo "<div class='heading'>Management area for <span class='heading_user'>" .$row['firstname']. "</span>'s account</div>";
            }
        ?>
        
        <!--Update form-->
        <div class="subheading">Edit Account</div>
        <form enctype="application/x-www-form-urlencoded" name="update" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            <div>
                <input type="text" name="newemail" placeholder="New Email Address">
            </div>

            <div>
                <input type="text" name="newfirstname" placeholder="New First Name">
            </div>

            <div>
                <input type="text" name="newlastname" placeholder="New Last Name">
            </div>

            <div>
                <input type="password" name="newpassword" placeholder="New Password">
            </div>

            <div>
                <input type="password" name="newconfirmpassword" placeholder="Confirm New Password">
            </div>

            <input type="submit" name="updatebutton" value="Update">
        </form>
        
        <!--Update php code-->
        <?php
            if(isset($_POST['updatebutton']) and !empty($_POST['newemail']) or !empty($_POST['newfirstname']) or !empty($_POST['newlastname']) or !empty($_POST['newpassword']))
            {
                $email = $_SESSION['email'];
                $newemail = $_POST['newemail'];
                $newfirstname = $_POST['newfirstname'];
                $newlastname = $_POST['newlastname'];
                $newpassword = $_POST['newpassword'];

                //Update email
                if (!empty($_POST['newemail']))
                {
                    $query = "SELECT email FROM login WHERE email = '$newemail'";
                    $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
                    if (mysqli_num_rows($result) > 0)
                    {
                        while($row = mysqli_fetch_assoc($result))
                        {
                            echo "<div class='user_message'>An account with the email address: <span>" .$newemail. "</span> already exists.</div>";
                        }
                    }
                    else
                    {
                        $data = mysqli_query($connection, "UPDATE login SET email='$newemail' WHERE email='$email'") or die(mysql_error($connection)); 
                        $query = "SELECT email FROM login WHERE email = '$newemail'";
                        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
                        $_SESSION['email'] = $newemail;
                        echo "<div class='user_message'>Account information has been updated.</div>";
                    }
                }

                //Update firstname
                else if (!empty($_POST['newfirstname']))
                {
                    $data = mysqli_query($connection, "UPDATE login SET firstname='$newfirstname' WHERE email='$email'") or die(mysql_error($connection)); 
                    echo "<div class='user_message'>Account information has been updated.</div>";
                }     

                //Update lastname
                else if (!empty($_POST['newlastname']))
                {
                    $data = mysqli_query($connection, "UPDATE login SET lastname='$newlastname' WHERE email='$email'") or die(mysql_error($connection)); 
                    echo "<div class='user_message'>Account information has been updated.</div>";
                }     

                //Update password
                else if (!empty($_POST['newpassword']))
                {
                    if ($_POST['newpassword'] == $_POST['newconfirmpassword'])
                    {
                        $data = mysqli_query($connection, "UPDATE login SET password='$newpassword' WHERE email='$email'") or die(mysql_error($connection)); 
                        echo "<div class='user_message'>Account information has been updated.</div>";
                    }
                    else
                    {
                        echo "<div class='user_message'> The password and confirm password entered do not match.</div>";
                    } 
                }         

            }

            else
            {
                echo "<div class='user_message'>Enter into the field you want to update.</div>";
            }
        ?>
        
        <!--Delete form-->
        <div class="subheading">Delete Account</div>
        <form enctype="application/x-www-form-urlencoded" name="delete" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            <div>
                <input type="password" name="password" placeholder="Password">
            </div>

            <div>
                <input type="password" name="confirmpassword" placeholder="Confirm Password">
            </div>

            <input type="submit" name="deletebutton" value="Delete">
        </form>
        
        <!--Delete php code-->
        <?php
            if(isset($_POST['deletebutton']) and !empty($_POST['password']) and !empty($_POST['confirmpassword']) and $_POST['password'] == $_POST['confirmpassword'])
            {
                $email = $_SESSION['email'];
                $password = $_POST['password'];
                $confirmpassword = $_POST['confirmpassword'];
                $query = "SELECT email FROM login WHERE email = '$email'";
                $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
                
                while($row = mysqli_fetch_assoc($result))
                {
                    $query = "DELETE FROM login WHERE email = '$email'";
                    mysqli_query($connection, $query) or die(mysqli_error($connection));
                    echo "<script>window.location.href = 'index.php'</script>";
                }
            }
            else if(isset($_POST['deletebutton']) and empty($_POST['password']))
            {
                echo "<div class='user_message'>The account associated with the email: <span>" .$email. "</span> cannot be deleted until the password has been confirmed.</div>";
            }
        echo "<div class='user_message'>To delete the account associated with the email: <span>" .$email. "</span> enter and confirm password.</div>";
        ?>
    </main>

</body>

</html>

