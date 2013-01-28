<?php class import extends sn {
	
public static $data;
public static $file;
public static $path;


function __construct() {
	// manymo.ru/_order/121101 15:11 19.txt
	//self::$start=121101 15:11 00;
	//self::$finish=121101 15:12 00;	
}

function engine() {
	self::checkPeriod();
}

function checkPeriod() {
	$p1=121101151100;
	$p2=121101151200;
	$t1=time();
	//$now=
	for ($i=$p1;$i<$t1+60;$i++) {
		if (intval(substr(strval($i),-2,2))<=60) {
			$p="http://manymo.ru/_order/".$i.".txt";
			$h=@get_headers($p);
			if ($h[0]=="HTTP/1.1 200 OK") {
				$f=project."/files/".$i.".txt";
				if (!file_exists($f)) {
					file_put_contents($f,file_get_contents($p));
				}
			}
		}
	}
	$t2=time();
	echo $t2-$t1;
}

} ?>
