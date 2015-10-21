<?php
session_start();
 
//jika session username belum dibuat, atau session username kosong
if (!isset($_SESSION['name']) || empty($_SESSION['name'])) {
    //redirect ke halaman login
    header('location:index.php');
}
else{
	header("location:home.php");
}
?>