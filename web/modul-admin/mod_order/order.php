<?php
session_start();
 if (empty($_SESSION['username_admin']) AND empty($_SESSION['passuser_admin'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
$aksi="modul/mod_order/aksi_order.php";
switch($_GET[act]){
  // Tampil Order
  default:
    echo "<h2>Order</h2>
           <table class='data display datatable' id='example'>
          <thead>
          <tr><th>no.order</th><th>nama konsumen</th><th>tgl. order</th><th>jam</th><th>status</th><th>aksi</th></tr>
		  </thead><tbody>
		  ";

    $p      = new Paging;
    $batas  = 10;
    $posisi = $p->cariPosisi($batas);

    $tampil = mysql_query("SELECT * FROM orders ORDER BY id_orders DESC");
  
    while($r=mysql_fetch_array($tampil)){
      $tanggal=tgl_indo($r[tgl_order]);
      echo "<tr><td align=center>$r[id_orders]</td>
                <td>$r[nama_kustomer]</td>
                <td>$tanggal</td>
                <td>$r[jam_order]</td>
                <td>$r[status_order]</td>
		            <td>
					<a href=?module=order&act=detailorder&id=$r[id_orders]>Detail</a> |
		<a href='$aksi?module=order&act=hapus&id=$r[id_orders]' onClick=\"return confirm('Apakah yakin akan menghapus data ini?')\">Hapus</a>

					</td></tr>";
      $no++;
    }
    echo "</tbody></table>";

   
    break;
  
    
  case "detailorder":
    $edit = mysql_query("SELECT * FROM orders WHERE id_orders='$_GET[id]'");
    $r    = mysql_fetch_array($edit);
    $tanggal=tgl_indo($r[tgl_order]);
    
    if ($r[status_order]=='Baru'){
        $pilihan_status = array('Baru', 'Lunas');
    }
    elseif ($r[status_order]=='Lunas'){
        $pilihan_status = array('Lunas', 'Batal');    
    }
    else{
        $pilihan_status = array('Baru', 'Lunas', 'Batal');    
    }

    $pilihan_order = '';
    foreach ($pilihan_status as $status) {
	   $pilihan_order .= "<option value=$status";
	   if ($status == $r[status_order]) {
		    $pilihan_order .= " selected";
	   }
	   $pilihan_order .= ">$status</option>\r\n";
    }

    echo "<h2>Detail Order</h2>
          <form method=POST action=$aksi?module=order&act=update>
          <input type=hidden name=id value=$r[id_orders]>

          <table id='form2' border='1'>
          <tr><td>No. Order</td>        <td> : $r[id_orders]</td></tr>
          <tr><td>Tgl. & Jam Order</td> <td> : $tanggal & $r[jam_order]</td></tr>
          <tr><td>Status Order      </td><td>: <select name=status_order>$pilihan_order</select> 
          <input type=submit value='Ubah Status'></td></tr>
          </table></form>";

  // tampilkan rincian produk yang di order
  $sql2=mysql_query("SELECT * FROM orders_detail, produk 
                     WHERE orders_detail.id_produk=produk.id_produk 
                     AND orders_detail.id_orders='$_GET[id]'");
  
  echo "<table id='form2' border=0 width=500>
        <tr><th>Nama Produk</th><th>Jumlah</th><th>Harga Satuan</th><th>Sub Total</th></tr>";
  
  while($s=mysql_fetch_array($sql2)){
     // rumus untuk menghitung subtotal dan total		
   $disc        = ($s[diskon]/100)*$s[harga];
   $hargadisc   = number_format(($s[harga]-$disc),0,",","."); 
   $subtotal    = $s["harga"]* $s[jumlah];

    $total       = $total + $subtotal;
    $subtotal_rp = format_rupiah($subtotal);    
    $total_rp    = format_rupiah($total);    
    $harga       = format_rupiah($s[harga]);

   $subtotalberat = $s[berat] * $s[jumlah]; // total berat per item produk 
   $totalberat  = $totalberat + $subtotalberat; // grand total berat all produk yang dibeli

    echo "<tr><td>$s[nama_produk]</td><td align=center>$s[jumlah]</td>
              <td align=right>$harga</td><td align=right>$subtotal_rp</td></tr>";
  }

  $ongkos=mysql_fetch_array(mysql_query("SELECT * FROM kota,orders WHERE orders.id_kota=kota.id_kota AND id_orders='$_GET[id]'"));
  $ongkoskirim1=$ongkos[ongkos_kirim];
  $ongkoskirim=$ongkoskirim1;

  $grandtotal    = $total + $ongkoskirim; 

  $ongkoskirim_rp = format_rupiah($ongkoskirim);
  $ongkoskirim1_rp = format_rupiah($ongkoskirim1); 
  $grandtotal_rp  = format_rupiah($grandtotal);    

echo "<tr><td colspan=3 align=right>Total              Rp. : </td><td align=right><b>$total_rp</b></td></tr>
      <tr><td colspan=3 align=right>Ongkos Kirim       Rp. : </td><td align=right><b>$ongkoskirim1_rp</b></td></tr>      
        <tr><td colspan=3 align=right>Grand Total        Rp. : </td><td align=right><b>$grandtotal_rp</b></td></tr>
      </table>";

  // tampilkan data kustomer
  echo "<table id='form2' border=0 width=500>
        <tr><th colspan=2>Data Kustomer</th></tr>
        <tr><td>Nama Pembeli</td><td> : $r[nama_kustomer]</td></tr>
        <tr><td>Alamat Pengiriman</td><td> : $r[alamat]</td></tr>
        <tr><td>No. Telpon/HP</td><td> : $r[telpon]</td></tr>
        <tr><td>Email</td><td> : $r[email]</td></tr>
        </table>";

    break;  
}
}
?>
