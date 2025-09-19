<?php
session_start();
include "../include/db_connect.php";

$ripple_num = $_POST["ripple_num"];
$table = $_POST["table"];
$ripple_content = $_POST["ripple_content"];
$userid = $_SESSION['userid'];

$sql = "SELECT id FROM {$table}_ripple WHERE num=$ripple_num";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);


$ripple_content = mysqli_real_escape_string($con, $ripple_content);
$sql = "UPDATE _qna_ripple SET content='$ripple_content' WHERE num=$ripple_num";
mysqli_query($con, $sql);

mysqli_close($con);

echo $ripple_content;
?>