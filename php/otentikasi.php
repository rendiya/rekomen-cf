<?php
include '../config.php';
    $con = mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_DATABASE);
    if(mysqli_connect_errno())
    {
        echo "Error bro :" . mysqli_connect_error();
    }
    session_start();
 
//untuk mencegah sql injection
//kita gunakan mysql_real_escape_string
$name = mysqli_real_escape_string($con,$_POST["username"]);
$password = mysqli_real_escape_string($con,$_POST["password"]);
 
//cek data yang dikirim, apakah kosong atau tidak
if (empty($name) && empty($password)) {
    //kalau username dan password kosong
    header('location:../index?error=1');
    break;
} else if (empty($name)) {
    //kalau username saja yang kosong
    header('location:../index?error=2');
    break;
} else if (empty($password)) {
    //kalau password saja yang kosong
    //redirect ke halaman index
    header('location:../index?error=3');
    break;
}
 
$check = "SELECT * FROM data_login WHERE id_mahasiswa = '".$name."' AND password = '".$password."'" ;
$querycheck=mysqli_query($con,$check);

 
if (mysqli_num_rows($querycheck) > 0) {
    //kalau username dan password sudah terdaftar di database
    $_SESSION['name'] = $name;
  header('location:../asal.php');
} else if(mysqli_num_rows($querycheck)==0) {
    //kalau username ataupun password tidak terdaftar di database
    header('location:../index.php?error=4');
}
mysqli_close($con);
?>