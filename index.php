<?php 

include "/app/config.php";
include "/app/detect.php";
include "/app/koneksi.php";


if ($page_name=='') {
	include $browser_t.'/index.html';
	}
elseif ($page_name=='index_login_user.html') {
	include $browser_t.'/index_login_user.html';
	}
elseif ($page_name=='index_login_supplier.html'){
	include $browser_t.'/index_login_supplier.html';
	}
elseif  ($page_name=='cek_login.php'){
	include $browser_t.'/cek_login.php';
	}
elseif ($page_name=='cek_login_supplier.php'){
	include $browser_t.'/cek_login_supplier.php';
	}
elseif ($page_name=='media.php'){
	include $browser_t.'/media.php';
	}
elseif ($page_name=='index.html') {
	include $browser_t.'/index.html';
	}
elseif ($page_name=='index_login.html'){
	include $browser_t.'/index_login.html';
	}
elseif ($page_name=='content.php'){
	include $browser_t.'/content.php';
	}
elseif ($page_name=='details.html') {
	include $browser_t.'/details.html';
	}
elseif ($page_name=='buy.html') {
	include $browser_t.'/buy.html';
	}
elseif ($page_name=='produk.html') {
	include $browser_t.'/produk.html';
	}
elseif ($page_name=='produk.php'){
	include $browser_t.'/modul-admin/mod_produk/produk.php';
	}
elseif ($page_name=='registration.html') {
	include $browser_t.'/registration.html';
	}
elseif ($page_name=='registration_supplier.html') {
	include $browser_t.'/registration_supplier.html';
	}
elseif ($page_name=='contact.html') {
	include $browser_t.'/contact.html';
	}
elseif ($page_name=='daftar_member.php') {
	include $browser_t.'/daftar_member.php';
	}
elseif ($page_name=='daftar_supplier.php'){
	include $browser_t.'/daftar_supplier.php';
	}
elseif ($page_name=='index_login_supplier.html'){
	include $browser_t.'/index_login_supplier.html';
	}
elseif ($page_name=='login.php') {
	include $browser_t.'/login.php';
	}
elseif ($page_name=='simpan_login.php') {
	include $browser_t.'/simpan_login.php';
	}
elseif ($page_name=='contact-post.html') {
	include $browser_t.'/contact-post.html';
	}
elseif ($page_name=='index.php') {
	include $browser_t.'/index.php';
	}
elseif ($page_name=='media3.php'){
	include $browser_t.'/media3.php';
	}
elseif ($page_name=='kategori.php'){
	include $browser_t.'/modul-admin/mod_kategori/kategori.php';
	}
elseif ($page_name=='menu.php'){
	include $browser_t.'/menu.php';
	}
else
	{
		include $browser_t.'404/html.php';
		//include $browser_t.'/modul-admin/mod_kategori/kategori.php';
	}

?>