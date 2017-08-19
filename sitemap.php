<?php
define('APPTYPEID', 4);
define('CURSCRIPT', 'sitemap');
require './source/class/class_core.php';
$discuz = & discuz_core::instance();
$discuz->cachelist = $cachelist;
$discuz->init();
$navtitle='Discuz Guide';
$metakeywords='discuzx, discuz english, discuzx english language';
$metadescription='Discuz English Support www.discuz.eu';
include template('common/header');
$querys = DB::query("SELECT a.tid,a.subject,a.fid,b.name FROM ".DB::table('forum_thread')." as a inner join ".DB::table('forum_forum')." as b on a.fid=b.fid where a.displayorder=0 ORDER BY a.tid DESC  LIMIT 0,10000");
$i=1;
$o=0;
$x[0]=0;
$filename = 'sitemap.xml';
if(file_exists($filename))
{
 unlink('sitemap.xml');
 echo 'sitemap successfully deleted';
}
else
{ 
  echo 'sitemap successfully created';
  $so=fopen("sitemap.xml","a");
  $w='<?xml version="1.0" encoding="UTF-8"?>
  <urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
  fwrite($so,$w);
  
$sv_name=$_SERVER["SERVER_NAME"]; 

while($threadfid = DB::fetch($querys))
 { 
	$x[$i]=$threadfid['fid'];
   echo '<li>'.$i.'.<em>[<a href="forum.php?mod=forumdisplay&amp;fid='.$threadfid['fid'].'">'.$threadfid['name'].'</a>]</em> <a href="forum.php?mod=viewthread&amp;tid='.$threadfid['tid'].'" target="_blank">'.$threadfid['subject'].'</a></li>';
   $m="http://".$sv_name."/forum.php?mod=viewthread&amp;tid=".$threadfid['tid']."";
   $k="<url><loc>".$m."</loc>"."<changefreq>weekly</changefreq></url>"."";
   $z=fopen("sitemap.xml","a");
   fwrite($z,$k);
   $s=$i-1;
   if($x[$s]==$x[$i])
       { 
       }
	 else
        {	  
	     $x[$o]=$threadfid['fid'];
	     $o++;
		}
	$i++;
	$s++;
  }

for($a=0;$a<$o;$a++)
 { 
   $m="http://".$sv_name."/forum.php?mod=forumdisplay&amp;fid=".$x[$a]."";
   $k="<url><loc>".$m."</loc>"."<changefreq>weekly</changefreq></url>"."";
   $z=fopen("sitemap.xml","a");
   fwrite($z,$k);   
 }
 
$k="</urlset>";
$z=fopen("sitemap.xml","a");
fwrite($z,$k);
fclose($z);
echo '</ul>';
include template('common/footer');
}
?>