<?php
error_reporting(0);
session_start();
include "app/koneksi.php";

$email 	 	 =($_POST['email']);
$password    =(md5($_POST['password']));

$login=mysql_query("SELECT * FROM pembeli WHERE email='$email' AND password='$password'");
echo "SELECT * FROM pembeli WHERE email='$email' AND password='$password'";
$ketemu=mysql_num_rows($login);
$r=mysql_fetch_array($login);

// Apabila email dan password ditemukan
if ($ketemu > 0){
  session_start();

  $_SESSION[email]     				= $r[email];
  //$_SESSION[namalengkap_member]  	= $r[nama_lengkap];
  $_SESSION[passuser_member]    	= $r[password];
  //$_SESSION[leveluser_member]    	= $r[level];
  
  header('location:index.html');
}
else{
  echo "<link href=../config/adminstyle.css rel=stylesheet type=text/css>";
  echo "<center>LOGIN GAGAL! <br> 
        Username atau Password Anda tidak benar.<br>
        Atau account Anda sedang diblokir.<br>";
  echo "<a href=index_login.html><b>ULANGI LAGI</b></a></center>";
}
?>
