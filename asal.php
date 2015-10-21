<?php
require '../rekomen/config.php';
  session_start();

  if(!isset($_SESSION['name'])){
    header("location:index.php");
  }
  echo $_SESSION['name'];
//print_r($_SESSION);
$con=mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_DATABASE);
//$con=mysqli_connect("localhost","root","","rekomendasi");
// Check connection
$nim_mahasiswa = $_SESSION['name'] ;
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result1 = mysqli_query($con,"SELECT * FROM data_mahasiswa WHERE id_mahasiswa = '".$_SESSION['name']."'");
$check = "SELECT * FROM dummy_reko WHERE nama = '".$_SESSION['name']."'" ;

$row1 = mysqli_fetch_array($result1);
$querycheck=mysqli_query($con,$check);

$rba = $row1["nama_mahasiswa"];
$_SESSION['nama_mahasiswa'] = $rba;

$cek = mysqli_num_rows($querycheck);
#header("location:home.php");
echo "<br>";
echo $_SESSION['nama_mahasiswa'];
echo "<br>";
echo $cek;
	if($cek==0){
		echo "exec python";
		$mystring = exec("python collaborative_filtering.py $nim_mahasiswa");
	}
	else
	{
		echo "nothing";
	}
mysqli_close($con);	
header("location:home.php");
?>
