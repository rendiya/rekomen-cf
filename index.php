<!DOCTYPE html>
<?php
  session_start();

  if(!isset($_SESSION['name'])){
	  
  }
   else
 {
     header("location:home.php");  // session has been started
 }
?>
<html>
<head>
  <title>Academic Recommender System</title>
</head>
<body>

   <div class="main">
    <div class="login-form">
          <div class="head">
          </div>
        <form class="form-signin" name="form1"  action="php/otentikasi.php" method="post" id="login">
		<h2 class="form-signin-heading">Please sign in</h2>
            <input type="text" class="form-control" name="username" value="USERNAME" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'USERNAME';}" >
            <input class="form-control" onfocus="this.value = '';" type="password" name="password" value="Password" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}">
            <div class="submit">
              <input class="btn btn-lg btn-primary btn-block" type="submit" value="LOGIN" >
          </div> 
<?php
//kode php ini kita gunakan untuk menampilkan pesan eror
if (!empty($_GET['error'])) {
    if ($_GET['error'] == 1) {
        echo '
        <div class="isa_warning">
            <i class="fa fa-warning"></i>
            Username dan Password belum diisi!
        </div>
        ';
    } else if ($_GET['error'] == 2) {
        echo '
        <div class="isa_warning">
            <i class="fa fa-warning"></i>
            Username belum diisi!
        </div>
        ';
    } else if ($_GET['error'] == 3) {
        echo '
        <div class="isa_warning">
            <i class="fa fa-warning"></i>
            Password belum diisi!
        </div>
        ';
    } else if ($_GET['error'] == 4) {
        echo '
        <div class="isa_warning">
            <i class="fa fa-warning"></i>
            Username dan Password tidak terdaftar!
        </div>
        ';
    }

}
?>		  
          
        </form>
      </div>
   </div>
  
</body>
</html>