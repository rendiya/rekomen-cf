<?php
  session_start();

  if(!isset($_SESSION['name'])){
    header("location:index.php");
  }
  
  require '../rekomen/config.php';
//print_r($_SESSION);
$nim_mahasiswa = $_SESSION['name'] ;

$con=mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_DATABASE);
//$con=mysqli_connect("localhost","root","","rekomendasi");
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result1 = mysqli_query($con,"DELETE FROM dummy_reko WHERE nama = ".$nim_mahasiswa." ");

#$row1 = mysqli_fetch_array($result1);

mysqli_close($con);

$mystring = exec("python collaborative_filtering.py $nim_mahasiswa");

header("location:krs.php");
?>