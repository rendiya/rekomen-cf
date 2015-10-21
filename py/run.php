<?php  
  session_start();

  if(!isset($_SESSION['name'])){
    header("location:index.php");
  }
  
?>
<?php
$nim_mahasiswa = $_SESSION['name'] ;
$mystring = exec("/collaborative_filtering.py $nim_mahasiswa");

?>