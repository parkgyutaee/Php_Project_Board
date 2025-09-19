<?php
session_start();

$userid = $_SESSION['userid'];
$username = $_SESSION['username'];

if (!$userid) {
    echo "
				<script>
				alert('게시판 글 수정은 로그인 후 이용해 주세요!');
				history.go(-1)
				</script>
		";
    exit;
}
$table = $_GET['table'];
$num = $_GET['num'];
$page = $_GET['page'];

include("../include/db_connect.php");

$sql = "SELECT file_copied FROM $table";

$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
$file_name = $row["file_copied"];

$file_path = "C:/xampp/htdocs/test/13/www/mboard/data/".$file_name;
if (file_exists($file_path)) {
    unlink($file_path);
}

$sql = "UPDATE $table SET file_name=null, file_type=null, file_copied=null WHERE num=$num ";

mysqli_query($con, $sql);
mysqli_close($con);

echo "
	   <script>
	    location.href = 'index.php?type=modify_form&num=$num&table=$table&page=$page';
	   </script>
	";
