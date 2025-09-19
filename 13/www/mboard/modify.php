<?php
session_start();

if (isset($_SESSION["userid"]))
    $userid = $_SESSION["userid"];
else {
    $userid = "";
}

if (isset($_SESSION["username"]))
    $username = $_SESSION["username"];
else
    $username = "";

if (!$userid) {
    echo "
				<script>
				alert('게시판 글 수정은 로그인 후 이용해 주세요!');
				history.go(-1)
				</script>
		";
    exit;
}

$table = $_GET["table"];
$num = $_GET["num"];
$page = $_GET["page"];
$check_fix = $_POST["check_fix"];
$subject = $_POST["subject"];
$content = $_POST["content"];

$subject = htmlspecialchars($subject, ENT_QUOTES);
$content = htmlspecialchars($content, ENT_QUOTES);


if (isset($is_html)) {
    $is_html = $_POST["is_html"];
} else {
    $is_html = "";
}

if(!$check_fix) {
    $check_fix = 0;
}
else {
    $check_fix = 1;
}
$regist_day = date("Y-m-d (H:i)");  // UTC 기준 현재의 '년-월-일 (시:분)'

include "../include/db_connect.php";
//수정 조건문
if (isset($_FILES["upfile"]) && $_FILES["upfile"]["error"] == 0) {
    $upfile_name = $_FILES["upfile"]["name"];
    $upfile_tmp_name = $_FILES["upfile"]["tmp_name"];
    $upfile_type = $_FILES["upfile"]["type"];
    $upfile_size = $_FILES["upfile"]["size"];
    $upfile_error = $_FILES["upfile"]["error"];

    $file = explode(".", $upfile_name);
    $file_ext = $file[1];

    $copied_file_name = date("Y_m_d_H_i_s");
    $copied_file_name .= "." . $file_ext;

    $upload_dir = "./data/";
    $uploaded_file = $upload_dir . $copied_file_name;

    move_uploaded_file($upfile_tmp_name, $uploaded_file);

    $sql = "UPDATE $table 
            SET file_name='$upfile_name', file_type='$upfile_type', file_copied='$copied_file_name' 
            WHERE num=$num";
    mysqli_query($con, $sql);
}


$sql = "update $table set subject='$subject', is_html='$is_html', ";    // 수정 명령
$sql .= "content='$content', regist_day='$regist_day', check_fix='$check_fix' where num=$num";

mysqli_query($con, $sql);  // SQL 명령 실행

mysqli_close($con);       // DB 연결 끊기

echo "
	   <script>
	    location.href = 'index.php?type=list&table=$table&page=$page';
	   </script>
	";
?>