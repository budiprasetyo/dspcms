<?php 
  error_reporting(0);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php include "dina_titel.php"; ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="index, follow">
<meta name="description" content="<?php include "dina_meta1.php"; ?>">
<meta name="keywords" content="<?php include "dina_meta2.php"; ?>">
<meta http-equiv="Copyright" content="lokomedia">
<meta name="author" content="Lukmanul Hakim">
<meta http-equiv="imagetoolbar" content="no">
<meta name="language" content="Indonesia">
<meta name="revisit-after" content="7">
<meta name="webcrawlers" content="all">
<meta name="rating" content="general">
<meta name="spiders" content="all">

<link rel="shortcut icon" href="favicon.ico" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="rss.xml" />

<link rel="stylesheet" href="<?php echo "$f[folder]/css/style.css" ?>" type="text/css" />

<script src="<?php echo "$f[folder]/js/jquery-1.4.js" ?>" type="text/javascript"></script>

<script src="<?php echo "$f[folder]/js/menu.js" ?>" type="text/javascript"></script>

<script src="<?php echo "$f[folder]/js/jquery.tipsy.js" ?>" type="text/javascript"></script>
<script type='text/javascript'>
  $(function($) {        
	   $('.tips a').tipsy({fade: true, gravity: 'w'});
	   $('.tipsatas a').tipsy({fade: true, gravity: 's'});	
  });
</script>

<script src="<?php echo "$f[folder]/js/jquery.js" ?>" type="text/javascript"></script>
<script src="<?php echo "$f[folder]/js/skrip.js" ?>" type="text/javascript"></script>

<script type="text/javascript"> 
 $(document).ready( function()
 {	
		$('#lofslidecontent45').lofJSidernews( { interval:4000,
											 	easing:'easeInOutQuad',
												duration:1200,
												auto:true } );						
	});
</script>	
  
<style>	
	ul.lof-main-wapper li{
		position:relative;	
	}
  div#copyright { display: none; }
</style>

<link rel="stylesheet" href="<?php echo "$f[folder]/js/lightbox/themes/default/jquery.lightbox.css" ?>" type="text/css" />
<script src="<?php echo "$f[folder]/js/lightbox/jquery.lightbox.min.js" ?>" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function() {
		    $('.lightbox').lightbox();		    
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
          include "$f[folder]/kiri.php";      
      ?>

			<!-- SIDEBAR -->
			<div id="sidebar">
				<h2>Sekilas Info</h2>
          <ul id="listticker">
            <?php
              $sekilas=mysql_query("SELECT * FROM sekilasinfo ORDER BY id_sekilas DESC LIMIT 5");
              while($s=mysql_fetch_array($sekilas)){
                echo "<li><span class='news-text'>$s[info]</span></li>";
              }
            ?>
          </ul>

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
          
					<h2>Polling</h2>
            <ul id="listsidebar">
              <?php
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
              ?>
            </ul><br />
            
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
				  <p>&nbsp;</p>
					<p>Copyright &copy; 2011 by <a href="http://bukulokomedia.com/">bukulokomedia.com</a>. All rights reserved.</p>
				</div>
				<div class="foot_r"></div>
			</div><!-- / end footer -->
		</div><!-- / end wrapper -->
	</div><!-- / end container -->
<div id="copyright">Copyright &copy; 2011 <a href="http://apycom.com/">Apycom jQuery Menus</a></div>
</body>
</html>
