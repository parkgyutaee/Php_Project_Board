<?php
    $id = $_POST["id"];
    $pass = $_POST["pass"];

    include("../include/db_connect.php");
    $sql = "SELECT * FROM _mem WHERE id = '$id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    $db_id = $row["id"];
    $db_pass = $row["pass"];
    $db_level = $row["level"];
    $db_name = $row["name"];
    if($id != $db_id) {
        echo "<script>
            alert('등록되지 않은 아이디 입니다');
            history.go(-1);
        <script>";
    }
    else {
        if(md5($pass) != $db_pass) {
            echo "<script>
            alert('비밀번호가 틀립니다!');
            history.go(-1);
        <script>";
        }
        else {
            session_start();
            $_SESSION["userlevel"] = $db_level;
            $_SESSION["userid"] = $db_id;
            $_SESSION["username"] = $db_name;

            mysqli_close($con);
            echo "<script>
                location.href = '../main/index.php';
              </script>";
        }
    }
