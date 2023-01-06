<?php
    include('session.php');
    include('access.php');
    session_unset();
    session_reset();
    session_destroy();
    echo "<script>window.location.href = 'index.php'</script>";
?>