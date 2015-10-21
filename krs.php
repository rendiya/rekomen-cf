
<?php
  session_start();

  if(!isset($_SESSION['name'])){
    header("location:index.php");
  }
?>

<!DOCTYPE html>
<head>
</head>
<body>
<a href='../rekomen/logout.php' class="button ">keluar</a><br>
<a href='../rekomen/home.php' class="button ">kembali</a><br>
<div>
<?php
require '../rekomen/config.php';
//print_r($_SESSION);
$con=mysqli_connect(DB_SERVER,DB_USER,DB_PASSWORD,DB_DATABASE);
//$con=mysqli_connect("localhost","root","","rekomendasi");
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
if(!isset($pilih_semester))
{
	$pilih_semester='1';
}

echo $_SESSION['name'];
echo '<br>';

$result1 = mysqli_query($con,"SELECT * FROM data_mahasiswa WHERE id_mahasiswa = '".$_SESSION['name']."'");
echo "data mahasiswa<br>";
$row1 = mysqli_fetch_array($result1);
echo "nama lengkap: ".$row1['nama_mahasiswa']."<br>angkatan: ".$row1['angkatan']."<br>semester: ".$row1['semester']."<br>";
$semester = $row1['semester'];
$rekomendasi_semester = $semester+1;
$delete_rekom = $rekomendasi_semester+1;
#SELECT * FROM nilai_rekomendasi INNER JOIN daftar_matakuliah on nama_matkul_r = nama_matkul WHERE id_mahasiswa = 312696 and semester = 2
$result = mysqli_query($con,"SELECT * FROM dummy_reko INNER JOIN daftar_matakuliah on rekomendasi = nama_matkul WHERE nama = '".$_SESSION['name']."' and semester = '".$rekomendasi_semester."'");

$delete =  mysqli_query($con,"DELETE dummy_reko FROM dummy_reko INNER JOIN daftar_matakuliah on rekomendasi = nama_matkul where semester > ".$delete_rekom." or semester <".$semester." and nama = '".$_SESSION['name']."'");
?>
<div>
<?php
if (mysqli_num_rows($result) > 0) {
    // output data of each row
	echo "<br><table border='1'><tr><th>matkul</th><th>sks mata kuliah</th><th>semester</th></tr>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>" . $row["rekomendasi"]. "</td><td>" . $row['jumlah_sks']. "</td><td>" . $row['semester']. "</td></tr>";
    }
} else {
    echo "Belum ada rekomendasi";
	echo "</table>";
}

?>
</div>
</div>
<a href='#' class="button ">ambil krs</a><br>
</body>