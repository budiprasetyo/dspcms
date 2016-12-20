<?php 
  error_reporting(0);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php include "dina_titel.php"; ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="index, follow">
<meta name="description" content="<?php include "dina_meta1.php"; ?>">
<meta name="keywords" content="<?php include "dina_meta2.php"; ?>">
<meta http-equiv="Copyleft" content="direktorat sistem perbendaharaan">
<meta name="author" content="Direktorat Sistem Perbendaharaan">
<meta http-equiv="imagetoolbar" content="no">
<meta name="language" content="Indonesia">
<meta name="revisit-after" content="7">
<meta name="webcrawlers" content="all">
<meta name="rating" content="general">
<meta name="spiders" content="all">

<!--<link rel="shortcut icon" href="favicon.ico" />-->
<link type="image/vnd.microsoft.icon" rel="icon" href="http://www.depkeu.go.id/ind/depIcon.ico">
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="rss.xml" />
<!-- css for all -->
<link rel="stylesheet" href="<?php echo "$f[folder]/css/style.css" ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo "$f[folder]/themes/base.css" ?>" type="text/css" />
<link rel="stylesheet" href="<?php echo "$f[folder]/themes/default/theme.css" ?>" type="text/css" />
<!-- css for jquery -->
<link href="jQueryUI/development-bundle/themes/eggplant/jquery.ui.all.css" rel="stylesheet"type="text/css" />
<link href="jQuerySorter/addons/pager/jquery.tablesorter.pager.css" rel="stylesheet"type="text/css" />
<link href="jQuerySorter/themes/blue/style.css" rel="stylesheet"type="text/css" />
<!-- jquery all -->	
<script src="<?php echo "$f[folder]/js/jquery-1.4.js" ?>" type="text/javascript"></script>
<!-- jquery sorter -->
<script src="jQuerySorter/addons/pager/jquery.tablesorter.pager.js" type="text/javascript"></script>
<script src="jQuerySorter/jquery.tablesorter.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#myTable").tablesorter({widgets: ['zebra']})
						.tablesorterPager({container: $("#pager"), seperator:" dari ", positionFixed: false});
		});
	</script>
<script src="<?php echo "$f[folder]/js/menu.js" ?>" type="text/javascript"></script>

	
	
<script src="<?php echo "$f[folder]/js/jquery.tipsy.js" ?>" type="text/javascript"></script>
<script type='text/javascript'>
  $(function($) {        
	   $('.tips a').tipsy({fade: true, gravity: 'w'});
	   $('.tipsatas a').tipsy({fade: true, gravity: 's'});	
  });
</script>

<script src="<?php echo "$f[folder]/js/jquery.js" ?>" type="text/javascript"></script>
  <script src="<?php echo "$f[folder]/js/jquery.accessible-news-slider.js" ?>" type="text/javascript"></script>
  <script type="text/javascript">
  jQuery(document).ready(function() {
  jQuery('#newsslider').accessNews({
  });
  });
  </script>

<script src="<?php echo "$f[folder]/js/jquery.fancybox.js" ?>" type="text/javascript"></script>
<script src="<?php echo "$f[folder]/js/jquery.mousewhell.js" ?>" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("a#galeri").fancybox({
				'titlePosition'	: 'inside'
			});
		});
  </script>
	  
<script src="<?php echo "$f[folder]/js/clock.js" ?>" type="text/javascript"></script>
<script src="<?php echo "$f[folder]/js/tabs.js" ?>" type="text/javascript"></script>
<script src="<?php echo "$f[folder]/js/newsticker.js" ?>" type="text/javascript"></script>
</head>

<body onload="startclock()">
	<div id="container">
		<div id="wrapper">
        <div id="top">
          <!-- MENU -->
          <div id="menu">
			     <ul class="menu">
            <?php         
			  // instantiate utility class
			  $util	= new class_utility;
			  $form	= new class_form;
              $main=mysql_query("SELECT * FROM mainmenu WHERE aktif='Y'");

              while($r=mysql_fetch_array($main)){
	             echo "<li><a href='$r[link]'><span>$r[nama_menu]</span></a>";
	             $sub=mysql_query("SELECT * FROM submenu, mainmenu  
                                 WHERE submenu.id_main=mainmenu.id_main 
                                 AND submenu.id_main=$r[id_main]");
               $jml=mysql_num_rows($sub);
                // apabila sub menu ditemukan
                if ($jml > 0){
                  echo "<div><ul>";
	                while($w=mysql_fetch_array($sub)){
                    echo "<li><a href='$w[link_sub]'><span>&#187; $w[nama_sub]</span></a></li>";
	                }           
	                echo "</ul></div>
                        </li>";
                }
                else{
                  echo "</li>";
                }
              }        
            ?>
		      </ul>
	       </div>	<!-- /menu -->
		    </div> <!-- /top -->

			<!-- HEADER -->
			<div id="header">
				<div class="intro">
				<p><span id="date"></span>, <span id="clock"></span></p>  <!-- jam -->
				<form method="POST" id="searchform" action="hasil-pencarian.html"> <!-- form pencarian -->
					<div>
					   <input class="searchField" type="text" name="kata" maxlength="50" value="Pencarian..." onblur="if(this.value=='') this.value='Pencarian...';" onfocus="if(this.value=='Pencarian...') this.value='';" />
					   <input class="searchSubmit" type="submit" value="" />
					</div>
				</form>
				<div class="rssicon">
				<a href="rss.xml" target="_blank"><img src="<?php echo "$f[folder]/images/rss.png" ?>" border="0" /></a> <!-- icon rss -->
				</div>
				</div> <!-- /intro -->				
			</div> <!-- /header -->

			<!-- CONTENT -->
			<?php
				include dirname(dirname(dirname(__FILE__)))."/config/class_security.php";// instantiate request get class
				$reqGet = new requestGet();
				// instantiate request post class
				$reqPost = new requestPost();
				// instantiate request session class
				$reqSession = new requestSession();
				include "$f[folder]/kiri.php";   
			?>


			<!-- SIDEBAR -->
			<div id="sidebar">
				
			<!-- SEKILAS INFO -->
				<h2>Sekilas Info</h2>
          <ul id="listticker">
            <?php
              $sekilas=mysql_query("SELECT * FROM sekilasinfo ORDER BY id_sekilas DESC LIMIT 5");
              while($s=mysql_fetch_array($sekilas)){
                echo "<li><img src='foto_info/kecil_$s[gambar]' width='54' height='54' />
                      <span class='news-text'>$s[info]</span></li>";
              }
            ?>
          </ul>
          <!-- AGENDA -->
				  <h2>Agenda</h2>
                  <ul id="listsidebar">
                  <?php
                    $agenda=mysql_query("SELECT * FROM agenda ORDER BY id_agenda DESC LIMIT 4");
                    while($a=mysql_fetch_array($agenda)){
	                      $tgl_agenda = tgl_indo($a[tgl_mulai]);
	                      $isi_agenda = strip_tags($a['isi_agenda']); // membuat paragraf pada isi berita dan mengabaikan tag html
                        $isi = substr($isi_agenda,0,200); // ambil sebanyak 220 karakter
                        $isi = substr($isi_agenda,0,strrpos($isi," ")); // potong per spasi kalimat
   
                       echo "<li class='news-text2'><span class='tanggal'>$tgl_agenda</span>
                             <br /><a href='agenda-$a[id_agenda]-$a[tema_seo].html'>$a[tema]</a></li>";
                    }
                  ?>
                  </ul>
                  
				<!-- DOWNLOAD -->
				<!--
				<h2>Download</h2>
                <div class="tips">
                  <ul id="listsidebar">
                  <?php
					/*
                    $download=mysql_query("SELECT * FROM download ORDER BY kategori_aplikasi,id_download DESC LIMIT 6");
                  
                    while($d=mysql_fetch_array($download)){
                      echo "<span><div id='kotakjudul'>APLIKASI " . strtoupper($d[kategori_aplikasi]) . "</div></span>
                      <li class='news-text2'><a href='downlot.php?file=$d[nama_file]' target='_blank' title='Sudah didownload $d[hits] kali'>$d[judul]</a></li>";
                    }
					*/
                  ?>
                  </ul>
                </div>
				-->
                
                <!-- PERATURAN -->
				<h2>Peraturan</h2>
                <div class="tips">
                  <ul id="listsidebar">
                  <?php
                    $download=mysql_query("SELECT noaturan,tglaturan,file,uraianaturan,hits FROM peraturan ORDER BY tglaturan DESC LIMIT 5");
                  
                    while($d=mysql_fetch_array($download)){
					  $tglaturan = $util->dateConvert($d['tglaturan']);
                      echo "<li class='news-text2'>
							<span><div id='kotakjudul'><a href='downlot.php?peraturan=$d[file]' target='_blank' title='Sudah didownload $d[hits] kali'>$d[noaturan]</a></div></span>
							<font color='#404040'><b>Tanggal " . $tglaturan . "</b></font>
							<br />$d[uraianaturan]</li>";
                    }
                  ?>
                  </ul>
                </div>
          
			<!-- STATISTIK USER -->
			<h2>Statistik User</h2>
			<ul id="listsidebar">
            <?php
              $ip      = $_SERVER['REMOTE_ADDR']; // Mendapatkan IP komputer user
              $tanggal = date("Ymd"); // Mendapatkan tanggal sekarang
              $waktu   = time(); // 

              // Mencek berdasarkan IPnya, apakah user sudah pernah mengakses hari ini 
              $s = mysql_query("SELECT * FROM statistik WHERE ip='$ip' AND tanggal='$tanggal'");
              // Kalau belum ada, simpan data user tersebut ke database
              if(mysql_num_rows($s) == 0){
                mysql_query("INSERT INTO statistik(ip, tanggal, hits, online) VALUES('$ip','$tanggal','1','$waktu')");
              } 
              else{
                mysql_query("UPDATE statistik SET hits=hits+1, online='$waktu' WHERE ip='$ip' AND tanggal='$tanggal'");
              }

              $pengunjung       = mysql_num_rows(mysql_query("SELECT * FROM statistik WHERE tanggal='$tanggal' GROUP BY ip"));
              $totalpengunjung  = mysql_result(mysql_query("SELECT COUNT(hits) FROM statistik"), 0); 
              $hits             = mysql_fetch_assoc(mysql_query("SELECT SUM(hits) as hitstoday FROM statistik WHERE tanggal='$tanggal' GROUP BY tanggal")); 
              $totalhits        = mysql_result(mysql_query("SELECT SUM(hits) FROM statistik"), 0); 
              $tothitsgbr       = mysql_result(mysql_query("SELECT SUM(hits) FROM statistik"), 0); 
              $bataswaktu       = time() - 300;
              $pengunjungonline = mysql_num_rows(mysql_query("SELECT * FROM statistik WHERE online > '$bataswaktu'"));

              $path = "counter/";
              $ext = ".png";

              $tothitsgbr = sprintf("%06d", $tothitsgbr);
              for ( $i = 0; $i <= 9; $i++ ){
	               $tothitsgbr = str_replace($i, "<img src='$path$i$ext' alt='$i'>", $tothitsgbr);
              }

              echo "<br /><p align=center>$tothitsgbr </p>
                    <table>
                    <tr><td class='news-title'><img src=counter/hariini.png> Pengunjung hari ini </td><td class='news-title'> : $pengunjung </td></tr>
                    <tr><td class='news-title'><img src=counter/total.png> Total pengunjung </td><td class='news-title'> : $totalpengunjung </td></tr>
                    <tr><td class='news-title'><img src=counter/hariini.png> Hits hari ini </td><td class='news-title'> : $hits[hitstoday] </td></tr>
                    <tr><td class='news-title'><img src=counter/total.png> Total Hits </td><td class='news-title'> : $totalhits </td></tr>
                    <tr><td class='news-title'><img src=counter/online.png> Pengunjung Online </td><td class='news-title'> : $pengunjungonline </td></tr>
                    </table>";
            ?>
          </ul>
          
			<!-- POLLING -->
			<!--
			<h2>Polling</h2>
            <ul id="listsidebar">
              <?php
				/*
                $tanya=mysql_query("SELECT * FROM poling WHERE aktif='Y' and status='Pertanyaan'");
                $t=mysql_fetch_array($tanya);

                echo "<br /><span class='news-title'> $t[pilihan]</span><br /><br />";
                echo "<form method=POST action='hasil-poling.html'>";

                $poling=mysql_query("SELECT * FROM poling WHERE aktif='Y' and status='Jawaban'");
                while ($p=mysql_fetch_array($poling)){
                  echo "<span class='news-text'><input type=radio name=pilihan value='$p[id_poling]' />$p[pilihan]</span><br />";
                }
                echo "<p align=center><input type=submit value=vote /></p>
                      </form>
                      <a href=lihat-poling.html><span class='news-title2'>Lihat Hasil Poling</span></a>";
				*/
              ?>
            </ul>
            -->
				



            <br /><br />
            
            <?php
              // Tampilkan banner
              $banner=mysql_query("SELECT * FROM banner ORDER BY id_banner DESC LIMIT 3");
              while($b=mysql_fetch_array($banner)){
                  echo "<p align=center><a href=$b[url] target='_blank' title='$b[judul]'>
                        <img src='foto_banner/$b[gambar]' border='0'></a></p>";
              }
            ?>
            
			</div> <!-- / end sidebar -->

			<!-- FOOTER -->
			<div id="footer">
				<div class="foot_l"></div>
				<div class="foot_content">
				  <p>&nbsp;</p>Copyleft 
					<span style="-webkit-transform: rotate(180deg); -moz-transform: rotate(180deg); -o-transform: rotate(180deg); -khtml-transform: rotate(180deg); -ms-transform: rotate(180deg); transform: rotate(180deg); display: inline-block;">
					&copy;
					</span> 2012 by Direktorat Sistem Perbendaharaan. All wrongs reserved.
				</div>
				<div class="foot_r"></div>
			</div><!-- / end footer -->
		</div><!-- / end wrapper -->
	</div><!-- / end container -->
</body>
</html>
