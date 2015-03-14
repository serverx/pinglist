<?php
$img=ImageCreate(845,291);
$white=ImageColorAllocate($img,255,255,255);
$red=ImageColorAllocate($img,255,0,0);
$green=ImageColorAllocate($img,0,204,0);
$blue=ImageColorAllocate($img,0,0,255);
$font="FreeSans.ttf";
#####

for($x=2;$x<900;$x=$x+118)
{
$crtm=7;
for($min='00';$min<60;$min=$min+10)
{
imagettftext($img,8,0,$x,$crtm+$min*4+2,$blue,$font,$min);$crtm=$crtm+2;
};
};

$nday=0;
if(isset($_GET['d'])) {list($y,$m,$d)=explode("-",$_GET['d']); $from=mktime(12,0,0,$m,$d,$y)-86400*3;}
else {$from=time()-86400*6;};
$fromdef=$from+86400*3;

$crt=15;
for($j=0;$j<7;$j++)
{

if(file_exists('/var/log/ping/'.date("Y",$from).'/'.date("Y-m",$from).'/'.date("Y-m-d",$from).'/'.$_GET['f'].'.txt'))
{
$f=file('/var/log/ping/'.date("Y",$from).'/'.date("Y-m",$from).'/'.date("Y-m-d",$from).'/'.$_GET['f'].'.txt');

for($i=0;$i<count($f);$i++)
{
$ping=0;
$str=$f[$i];
list($tipeday,$month,$day,$time,,$year,$ping)=explode(" ",$str);
list($hour,$min,$sec)=explode(":",$time);
if($nday==0) {$nday=$day;$crt=15;imagettftext($img,10,0,$crt,290,$blue,$font,$day.' '.$month.' '.$year);};
if($nday!=$day) {$crt=$crt+110;$nday=$day;imagettftext($img,10,0,$crt,290,$blue,$font,$day.' '.$month.' '.$year);};

if(($hour==0)or($hour==6)or($hour==12)or($hour==18)) {
	if(!isset($ch)) {$crt=$crt+2;$ch=$hour;imagettftext($img,8,90,$crt+$hour*4+8,270,$blue,$font,$hour);}
	elseif($ch!=$hour) {$crt=$crt+2;$ch=$hour;imagettftext($img,8,90,$crt+$hour*4+8,270,$blue,$font,$hour);};
};
if(($min==0)or($min==10)or($min==20)or($min==30)or($min==40)or($min==50)) {$chm=$min;$crtm=$crtm+2;};

if(!isset($chh)) {$crtm=0;$chh=$hour;}
elseif($chh!=$hour) {$crtm=0;$chh=$hour;}

#if(!is_numeric($ping)) {$color=$red;}
if((!is_numeric($ping))or($ping==36)) {$color=$red;}
else {$color=$green;}; # {$color=ImageColorAllocate($img,0,255-$ping*3,0);};

ImageFilledRectangle($img,$crt+$hour*4,$crtm+$min*4,$crt+$hour*4+2,$crtm+$min*4+2,$color);
if($chh!=$hour) {$crtm=0;$chh=$hour;}
};
};
$from=$from+86400;
};
#####
header("Expires: Fri, 01 Jan 2000 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
header("Content-type: image/png");
$filename=$_GET['f']."-".date("Y-m-d",$fromdef);
header("Content-Disposition: inline; filename=$filename.png");
ImagePNG($img);
ImageDestroy($img);
?>
