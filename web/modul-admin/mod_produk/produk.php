<?php
session_start();
 if (empty($_SESSION['username_admin']) AND empty($_SESSION['passuser_admin'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
$aksi="modul/mod_produk/aksi_produk.php";
switch($_GET[act]){
  // Tampil Produk
  default:
    echo "<h2>Produk <input style='float:right' type=button value='Tambah Produk' onclick=\"window.location.href='?module=produk&act=tambahproduk';\"></h2>
          
          <table class='data display datatable' id='example'>
          <thead>
		  <tr><th>no</th><th>nama produk</th><th>harga</th><th>stok</th><th>tgl. masuk</th><th>aksi</th></tr></thead>";

    $p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);

    $tampil = mysql_query("SELECT * FROM produk ORDER BY id_produk DESC");
  echo "<tbody>";
    $no = $posisi+1;
    while($r=mysql_fetch_array($tampil)){
      $tanggal=tgl_indo($r[tgl_masuk]);
      $harga=format_rupiah($r[harga]);
      echo "<tr><td>$no</td>
                <td>$r[nama_produk]</td>
                <td>$harga</td>
                <td>$r[stok]</td>
                <td>$tanggal</td>
		            <td><a href=?module=produk&act=editproduk&id=$r[id_produk]>Edit</a> | 
		                <a href='$aksi?module=produk&act=hapus&id=$r[id_produk]' onClick=\"return confirm('Apakah yakin akan menghapus data ini?')\">Hapus</a></td>
		        </tr>";
      $no++;
    }
	echo "</tbody>";
  
  echo "</table>";


 
    break;
  
  case "tambahproduk":
    echo "<h2>Tambah Produk</h2>
          <form method=POST action='$aksi?module=produk&act=input' enctype='multipart/form-data'>
         <table class='form' border='1'>
          <tr><td width=70>Nama Produk</td>     <td> : <input type=text name='nama_produk' size=60></td></tr>
          <tr><td>Kategori</td>  <td> : 
          <select name='kategori'>
            <option value=0 selected>- Pilih Kategori -</option>";
            $tampil=mysql_query("SELECT * FROM kategori ORDER BY nama_kategori");
            while($r=mysql_fetch_array($tampil)){
              echo "<option value=$r[id_kategori]>$r[nama_kategori]</option>";
            }
    echo "</select></td></tr>
           <tr><td>Harga</td>     <td> : <input type=text name='harga' size=10></td></tr>
          <tr><td>Stok</td>     <td> : <input type=text name='stok' size=3></td></tr>
           <tr><td>Gambar</td>      <td> : <input type=file name='fupload' size=40> 
                                          <br>Tipe gambar harus JPG/JPEG dan ukuran lebar maks: 400 px</td></tr>
         </table>
		<textarea name='deskripsi' style='width: 600px; height: 350px;'></textarea>
		<br />
		<input type=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()>
          </form>";
     break;
    
  case "editproduk":
    $edit = mysql_query("SELECT * FROM produk WHERE id_produk='$_GET[id]'");
    $r    = mysql_fetch_array($edit);

    echo "<h2>Edit Produk</h2>
          <form method=POST enctype='multipart/form-data' action=$aksi?module=produk&act=update>
          <input type=hidden name=id value=$r[id_produk]>
         <table class='form'>
          <tr><td width=70>Nama Produk</td>     <td> : <input type=text name='nama_produk' size=60 value='$r[nama_produk]'></td></tr>
          <tr><td>Kategori</td>  <td> : <select name='kategori'>";
 
          $tampil=mysql_query("SELECT * FROM kategori ORDER BY nama_kategori");
          if ($r[id_kategori]==0){
            echo "<option value=0 selected>- Pilih Kategori -</option>";
          }   

          while($w=mysql_fetch_array($tampil)){
            if ($r[id_kategori]==$w[id_kategori]){
              echo "<option value=$w[id_kategori] selected>$w[nama_kategori]</option>";
            }
            else{
              echo "<option value=$w[id_kategori]>$w[nama_kategori]</option>";
            }
          }
    echo "</select></td></tr>
          <tr><td>Harga</td>     <td> : <input type=text name='harga' value=$r[harga] size=10></td></tr>
          <tr><td>Stok</td>     <td> : <input type=text name='stok' value=$r[stok] size=3></td></tr>
           <tr><td>Gambar</td>       <td> :  
          <img src='../foto_produk/small_$r[gambar]'></td></tr>
          <tr><td>Ganti Gbr</td>    <td> : <input type=file name='fupload' size=30> *)</td></tr>
          <tr><td colspan=2>*) Apabila gambar tidak diubah, dikosongkan saja.</td></tr>
         </table>
		<textarea name='deskripsi' style='width: 600px; height: 350px;'>$r[deskripsi]</textarea>
		<br />
		<input type=submit value=Update>
        <input type=button value=Batal onclick=self.history.back()>
         </form>";
    break;  
}
}
?>
