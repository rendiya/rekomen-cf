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
<div>
<a href='../rekomen/logout.php' class="button ">keluar</a>
<a href='../rekomen/krs.php' class="button ">KRS</a>
<p> pilih semester</p>

<form action="#" method="post">
<select name="milih_semseter">
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
</select>
<input type="submit" name="submit" value="submit" />

</form>
<?php
if(isset($_POST['submit'])){
$pilih_semester = $_POST['milih_semseter'];  // Storing Selected Value In Variable
}
?>
</form>
</div>

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
#$pilih_semester='1';

echo $_SESSION['nama_mahasiswa'];

echo '<br>';
$result = mysqli_query($con,"SELECT * FROM daftar_nilai INNER JOIN index_nilai on nilai_prestasi = nilai_mahasiswa NATURAL JOIN daftar_matakuliah WHERE id_mahasiswa = ".$_SESSION['name']." AND semester_ke = ".$pilih_semester."");
$result1 = mysqli_query($con,"SELECT * FROM data_mahasiswa WHERE id_mahasiswa = '".$_SESSION['name']."'");
echo "data mahasiswa<br>";
$row1 = mysqli_fetch_array($result1);
echo "nama lengkap: ".$row1['nama_mahasiswa']."<br>angkatan: ".$row1['angkatan']."<br>semester: ".$row1['semester']."<br>";

if (mysqli_num_rows($result) > 0) {
    // output data of each row
	echo "<br><table border='1'><tr><th>matkul</th><th>nilai</th><th>semester</th></tr>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>" . $row["nama_matkul"]. "</td><td>" . $row['index_prestasi']. "</td><td>" . $row['semester_ke']. "</td></tr>";
    }
} else {
    echo "Belum ada nilai";
	echo "</table>";
}

mysqli_close($con);
?>

</body>

</html>
