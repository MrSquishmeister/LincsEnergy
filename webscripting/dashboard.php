<?php
    include('session.php');
    include('access.php');
    include('config.php');
    $time = microtime();
	$time = explode(' ', $time);
	$time = $time[1] + $time[0];
	$start = $time;
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
    <title>Dashboard</title>
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
        <!--Accessing Database-->
        <?php
            $email = $_SESSION['email'];
            $query = "SELECT firstname, lastname, password, email FROM login WHERE email='$email'";
            $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
            while($row = mysqli_fetch_array($result))
            {
                echo "<div class='heading'>Welcome to the user dashboard, <span class='heading_user'>" .$row['firstname']. "</span></div>";
                
                echo '<table>
                <tr>
                    <th>Current Information</th>
                </tr>
                
                <tr>
                    <td>Email:</td>
                    <td>'.$row["email"].'</td>
                </tr>
                <tr>
                    <td>Firstname:</td>
                    <td>'.$row["firstname"].'</td>
                </tr>
                <tr>
                    <td>Lastname:</td>
                    <td>'.$row["lastname"].'</td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td>'.$row["password"].'</td>
                </tr>
                </table>';
            }
        ?>

        <!--File upload form HTML-->
        <div class="upload_area">
            <div class="subheading">Upload file</div>
            <form method="post" enctype="multipart/form-data">
                <input type="file" name="file" id="file">
                <input type="submit" name="uploadbutton" value="Upload">
            </form>
        </div>
        
        <!--File upload form PHP-->
        <?php
            if (isset($_POST['uploadbutton']))
            {
                $file = $FILES['file'];
                $fileName = $_FILES['file']['name'];
                $fileTmpName = $_FILES['file']['tmp_name'];
                $fileSize = $_FILES['file']['size'];
                $fileError = $_FILES['file']['error'];
                $fileType = $_FILES['file']['type'];

                $fileExt = explode('.', $fileName);
                $fileActualExt = strtolower(end($fileExt));
                $allowed = array('jpg', 'jpeg', 'png');

                if(in_array($fileActualExt, $allowed))
                {
                    if($fileError === 0)
                    {
                        if ($fileSize < 1000000)
                        {
                            $fileNameNew = uniqid('', true).".".$fileActualExt;
                            $fileDestination = 'fileuploads/'.$fileNameNew;
                            move_uploaded_file($fileTmpName, $fileDestination);
                            echo "<div class='user_message'>File successfully uploaded.</div>";
                    }
                        else
                        {
                            echo "<div class='user_message'>File you are trying to upload is too large in size.</div>";
                        }
                    } 
                    else
                    {
                        echo "<div class='user_message'>There was an error the file was not uploaded.</div>";
                    }
                } 
                else
                {
                    echo "<div class='user_message'>File type not acceptable.</div>";
                }
            }
        ?>

        
        <!--Text file HTML-->
            <section id="Form">
                <div class="subheading">Update Footer</div>
                <form method="post" enctype="multipart/form-data">
                    <input type="text" name="textdata" id="text"><br>
                    <input type="submit" name="update_footer" value="Update">
                </form>
            </section>
        
        <!--Text file PHP-->
            <?php
                if(isset($_POST['update_footer']))
                {
                    $data=$_POST['textdata'];
                    $fp = fopen('textdocuments/footer.txt', 'w');
                    fwrite($fp, $data);
                    fclose($fp);
                }
        
        //Processing time
            $time = microtime();
            $time = explode(' ', $time);
            $time = $time[1] + $time[0];
            $finish = $time;
            $total_time = round(($finish - $start), 4);
            echo "<br>";
            echo 'Processing time: '.$total_time.' seconds';
            ?>
    </main>

</body>

</html>
