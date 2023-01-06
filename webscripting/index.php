<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Add a description here">
    <meta name="author" content="Add author here">
    <link rel="stylesheet" type="text/css" href="resources/main.css">
    <link rel="stylesheet" type="text/css" href="vendors/css/maingrid.css">
    <title>Home</title>
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

    <!--Header Text-->
    <main>
        <div class="container">
            <img src="resources/images/white_img.jpg" alt="White Background" style="width:100%;">
            <div class="content">
                <div class="heading" style="margin-top: 0px;text-align:center;">UNDER CONSTRUCTION</div>
            </div>
        </div>
    </main>

    <footer>
        <!--Footer PHP-->
        <?php
            echo "<span class='footer_text'>" .file_get_contents("textdocuments/footer.txt"). "</span>";
        ?>
    </footer>
</body>

</html>
