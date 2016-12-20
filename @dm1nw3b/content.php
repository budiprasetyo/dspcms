<?php
include "../config/koneksi.php";
include "../config/library.php";
include "../config/fungsi_indotgl.php";
include "../config/fungsi_combobox.php";
include "../config/class_paging.php";
include "../config/class_security.php";
// Instantiate requestGet Class
$reqGet	= new requestGet();
// Instantiate requestPost Class
$reqPost = new requestPost(); 

// Bagian Home
if ($reqGet->getVarAlpha('module',4) == 'home'){
  $reqSession = new requestSession();
  if ($reqSession->getVarAlpha('leveluser',5) == 'admin'){
  echo "<h2>Selamat Datang</h2>
          <p>Hai <b>$_SESSION[namalengkap]</b>, selamat datang di halaman Administrator Direktorat Sistem Perbendaharaan.<br> 
          Silahkan klik menu pilihan yang berada di sebelah kiri untuk mengelola website atau pilih ikon-ikon pada Control Panel. </p>

		<p>&nbsp;</p>

 		<table>
		<th colspan=5><center>Control Panel</center></th>
		<tr>
		  <td width=120 align=center><a href=media.php?module=user><img src=images/user.jpg border=none></a></td>
		  <td width=120 align=center><a href=media.php?module=modul><img src=images/modul.png border=none></a></td>
		  <td width=120 align=center><a href=media.php?module=berita><img src=images/berita.png border=none></a></td>
		  <td width=120 align=center><a href=media.php?module=komentar><img src=images/komentar.png border=none></a></td>
		  <td width=120 align=center><a href=media.php?module=download><img src=images/download.png border=none></a></td>
    </tr>
		<tr>
		  <th width=120><b>Manajemen User</b></th>
		  <th width=120><b>Manajemen Modul</b></center></th>
		  <th width=120><b>Berita</b></th>
		  <th width=120><b>Komentar</b></th>
		  <th width=120><b>Download</b></th>
		</tr>
		<tr>
		  <td width=120 align=center><a href=media.php?module=agenda><img src=images/agenda.png border=none></a></td>
		  <td width=120 align=center><a href=media.php?module=banner><img src=images/banner.png border=none></a></td>
		  <td width=120 align=center><a href=media.php?module=galerifoto><img src=images/galeri.png border=none></a></td>
		  <td width=120 align=center><a href=media.php?module=poling><img src=images/poling.png border=none></a></td>
		  <td width=120 align=center><a href=media.php?module=hubungi><img src=images/hubungi.png border=none></a></td>
    </tr>
		<tr>
		  <th width=120><center><b>Agenda</b></th>
		  <th width=120><center><b>Banner</b></th>
		  <th width=120><center><b>Galeri Foto</b></th>
		  <th width=120><b>Poling</b></th>
		  <th width=120><b>Hubungi Kami</b></th>
		</tr>
		<tr>
		  <td colspan='5' width=120 align=center><a href=media.php?module=peraturan><img src=images/regulation.png height='80' border=none></a></td>
    </tr>
		<tr>
		  <th colspan='5' width=120><center><b>Peraturan</b></th>
		</tr>
    </table>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>


          <p align=right>Login : $hari_ini, ";
  echo tgl_indo(date("Y m d")); 
  echo " | "; 
  echo date("H:i:s");
  echo " WIB</p>";
  }
  elseif ($reqSession->getVarAlpha('leveluser',4) == 'user'){
  echo "<h2>Selamat Datang</h2>
          <p>Hai <b>$_SESSION[namalengkap]</b>, selamat datang di halaman Administrator Direktorat Sistem Perbendaharaan.<br> 
          Silahkan klik menu pilihan yang berada di sebelah kiri untuk mengelola website. </p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>


          <p align=right>Login : $hari_ini, ";
  echo tgl_indo(date("Y m d")); 
  echo " | "; 
  echo date("H:i:s");
  echo " WIB</p>";
 	}
}

// Bagian Profil
elseif ($reqGet->getVarAlpha('module',6) == 'profil'){
  $reqSession = new requestSession();
  if ($reqSession->getVarAlpha('leveluser',5) == 'admin'){
    include "modul/mod_profil/profil.php";
  }
}

// Bagian User
elseif ($reqGet->getVarAlpha('module',4) == 'user'){
  $reqSession = new requestSession();
  if ($reqSession->getVarAlpha('leveluser',5) == 'admin' OR $reqSession->getVarAlpha('leveluser',4) == 'user'){
    include "modul/mod_users/users.php";
  }
}

// Bagian Modul
elseif ($reqGet->getVarAlpha('module',5) == 'modul'){
  $reqSession = new requestSession();
  if ($reqSession->getVarAlpha('leveluser',5) == 'admin'){
    include "modul/mod_modul/modul.php";
  }
}

// Bagian Kategori
elseif ($reqGet->getVarAlpha('module',8) == 'kategori'){
  $reqSession = new requestSession();
  if ($reqSession->getVarAlpha('leveluser',5) == 'admin'){
    include "modul/mod_kategori/kategori.php";
  }
}

// Bagian Berita
elseif ($reqGet->getVarAlpha('module',6) == 'berita'){
  $reqSession = new requestSession();
  if ($reqSession->getVarAlpha('leveluser',5) == 'admin' OR $reqSession->getVarAlpha('leveluser',4) == 'user'){
    include "modul/mod_berita/berita.php";                            
  }
}

// Bagian Komentar Berita
elseif ($reqGet->getVarAlpha('module',8) == 'komentar'){
  $reqSession = new requestSession();
  if ($reqSession->getVarAlpha('leveluser',5) == 'admin'){
    include "modul/mod_komentar/komentar.php";
  }
}

// Bagian Tag
elseif ($reqGet->getVarAlpha('module',3) == 'tag'){
  $reqSession = new requestSession();
  if ($reqSession->getVarAlpha('leveluser',5) == 'admin'){
    include "modul/mod_tag/tag.php";
  }
}

// Bagian Agenda
elseif ($reqGet->getVarAlpha('module',6) == 'agenda'){
  $reqSession = new requestSession();
  if ($reqSession->getVarAlpha('leveluser',5) == 'admin' OR $reqSession->getVarAlpha('leveluser',4) == 'user'){
    include "modul/mod_agenda/agenda.php";
  }
}

// Bagian Banner
elseif ($reqGet->getVarAlpha('module',6) == 'banner'){
  $reqSession = new requestSession();
  if ($reqSession->getVarAlpha('leveluser',5) == 'admin'){
    include "modul/mod_banner/banner.php";
  }
}

// Bagian Poling
elseif ($reqGet->getVarAlpha('module',6)=='poling'){
  $reqSession = new requestSession();
  if ($reqSession->getVarAlpha('leveluser',5) == 'admin'){
    include "modul/mod_poling/poling.php";
  }
}

// Bagian Download
elseif ($reqGet->getVarAlpha('module',8) == 'download'){
  $reqSession = new requestSession();
  if ($reqSession->getVarAlpha('leveluser',5) == 'admin'){
    include "modul/mod_download/download.php";
  }
}

// Bagian Hubungi Kami
elseif ($reqGet->getVarAlpha('module',7) == 'hubungi'){
  $reqSession = new requestSession();
  if ($reqSession->getVarAlpha('leveluser',5) == 'admin'){
    include "modul/mod_hubungi/hubungi.php";
  }
}

// Bagian Templates
elseif ($reqGet->getVarAlpha('module',9) == 'templates'){
  $reqSession = new requestSession();
  if ($reqSession->getVarAlpha('leveluser',5) == 'admin'){
    include "modul/mod_templates/templates.php";
  }
}

// Bagian Shoutbox
elseif ($reqGet->getVarAlpha('module',8) == 'shoutbox'){
  $reqSession = new requestSession();
  if ($reqSession->getVarAlpha('leveluser',5) == 'admin'){
    include "modul/mod_shoutbox/shoutbox.php";
  }
}

// Bagian Album
elseif ($reqGet->getVarAlpha('module',5) == 'album'){
  $reqSession = new requestSession();
  if ($reqSession->getVarAlpha('leveluser',5) == 'admin'){
    include "modul/mod_album/album.php";
  }
}

// Bagian Galeri Foto
elseif ($reqGet->getVarAlpha('module',10) == 'galerifoto'){
  $reqSession = new requestSession();
  if ($reqSession->getVarAlpha('leveluser',5) == 'admin'){
    include "modul/mod_galerifoto/galerifoto.php";
  }
}

// Bagian Kata Jelek
elseif ($reqGet->getVarAlpha('module',9) == 'katajelek'){
  $reqSession = new requestSession();
  if ($reqSession->getVarAlpha('leveluser',5) == 'admin'){
    include "modul/mod_katajelek/katajelek.php";
  }
}

// Bagian Sekilas Info
elseif ($reqGet->getVarAlpha('module',11) == 'sekilasinfo'){
  $reqSession = new requestSession();
  if ($reqSession->getVarAlpha('leveluser',5) == 'admin'){
    include "modul/mod_sekilasinfo/sekilasinfo.php";
  }
}

// Bagian Menu Utama
elseif ($reqGet->getVarAlpha('module',9) == 'menuutama'){
  $reqSession = new requestSession();
  if ($reqSession->getVarAlpha('leveluser',5) == 'admin'){
    include "modul/mod_menuutama/menuutama.php";
  }
}

// Bagian Sub Menu
elseif ($reqGet->getVarAlpha('module',7) == 'submenu'){
  $reqSession = new requestSession();
  if ($reqSession->getVarAlpha('leveluser',5) == 'admin'){
    include "modul/mod_submenu/submenu.php";
  }
}

// Bagian Halaman Statis
elseif ($reqGet->getVarAlpha('module',13) == 'halamanstatis'){
  $reqSession = new requestSession();
  if ($reqSession->getVarAlpha('leveluser',5) == 'admin'){
    include "modul/mod_halamanstatis/halamanstatis.php";
  }
}

// Bagian Sekilas Info
elseif ($reqGet->getVarAlpha('module',11) == 'sekilasinfo'){
  $reqSession = new requestSession();
  if ($reqSession->getVarAlpha('leveluser',4) == 'user' || $reqSession->getVarAlpha('leveluser',5) == 'admin'){
    include "modul/mod_sekilasinfo/sekilasinfo.php";
  }
}

// Bagian Identitas Website
elseif ($reqGet->getVarAlpha('module',9) == 'identitas'){
  $reqSession = new requestSession();
  if ($reqSession->getVarAlpha('leveluser',5) == 'admin'){
    include "modul/mod_identitas/identitas.php";
  }
}

// Bagian Peraturan
elseif($reqGet->getVarAlpha('module',9) == 'peraturan'){
  $reqSession = new requestSession();
	if($reqSession->getVarAlpha('leveluser',4) == 'user' || $reqSession->getVarAlpha('leveluser',5) == 'admin'){
		include "modul/mod_peraturan/peraturan.php";
	}
}
// Bagian Aksi Peraturan
elseif($reqPost->getVarAlpha('submit',4) == 'Cari'){
  $reqSession = new requestSession();
	if($reqSession->getVarAlpha('leveluser',4) == 'user' || $reqSession->getVarAlpha('leveluser',5) == 'admin'){
		include "modul/mod_peraturan/aksi_peraturan.php";
	}
}
// Bagian Klasifikasi Peraturan
elseif($reqGet->getVarAlpha('module',11) == 'klasifikasi'){
  $reqSession = new requestSession();
	if($reqSession->getVarAlpha('leveluser',4) == 'user' || $reqSession->getVarAlpha('leveluser',5) == 'admin'){
		include "modul/mod_klasifikasi/klasifikasi.php";
	}
}

// Bagian Profil Pegawai
elseif($reqGet->getVarAlpha('module') == 'pegawai'){
  $reqSession = new requestSession();
	if($reqSession->getVarAlpha('leveluser',4) == 'user' || $reqSession->getVarAlpha('leveluser',5) == 'admin'){
		include "modul/mod_profilpegawai/profilpegawai.php";
	}
}
// Apabila modul tidak ditemukan
else{
  echo "<p><b>MODUL BELUM ADA ATAU BELUM LENGKAP</b></p>";
}
?>
