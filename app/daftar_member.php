<?php
$kar1=strstr($_POST[email], "@");
$kar2=strstr($_POST[email], ".");	
if (empty($_POST[nama])){
  echo "Data yang Anda isikan belum lengkap<br />
  	    <a href=javascript:history.go(-1)><b>Ulangi Lagi</b>";
}
elseif (strlen($kar1)==0 OR strlen($kar2)==0){
  echo "Alamat email Anda tidak valid, mungkin kurang tanda titik (.) atau tanda @.<br />
 	      <a href=javascript:history.go(-1)><b>Ulangi Lagi</b></a>";
}
else{	
$tgl_skrg = date("Ymd");
$jam_skrg = date("H:i:s");
$nama_depan   = $_POST['nama_depan'];
$nama_belakang   = $_POST['nama_belakang'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$alamat = $_POST['alamat'];
$provinsi = $_POST['provinsi'];
$kota = $_POST['kota_kabupaten'];
$telepon = $_POST['phone'];
$email = $_POST['email'];
$password = $_POST['password'];


$cek=mysql_num_rows(mysql_query("select * from pembeli where email='".$_POST["email"]."'"));
if($cek > 0){
echo "<script type='text/javascript'>
alert('Email ini sudah ada didalam database.');
window.location='javascript:history.go(-1)';
</script>";
}else{
mysql_query("INSERT INTO pembeli(nama_depan, nama_belakang,  tanggal_lahir, jenis_kelamin, alamat, provinsi, kota_kabupaen, phone, email, password, tipe)
			VALUES('$nama_depan','$nama_belakang','$tanggal_lahir','$jenis_kelamin','$alamat','$provinsi','$kota_kabupaen','$telepon','$email',1)");

			 
echo "Anda Telah berhasil menjadi member silahkan untuk <a href='login.html'>login</a>";
}
}
	
?>