<?php
    session_start();
    unset($_SESSION["userlevel"]);
    unset($_SESSION["username"]);
    unset($_SESSION["userid"]);

    echo "<script>
            location.href='../main/index.php';
</script>";
?>