<?php



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
?>