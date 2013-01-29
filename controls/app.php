<?php class app extends sn {

public static $id;
public static $j;
public static $records;
public static $message;
public static $url;
public static $path;
public static $request;

function __construct() {
	self::$j=array("response"=>array("answer"=>"NO"));
	self::$id=0;
}

public static function search($f='') {
	if (self::client()) {
		chdir(self::$path);
		$dir=opendir(".");
		while ($d=readdir($dir)) { 
			if (is_file($d)) { 
				if (preg_match("/[0-9]+\.txt/i",$d)) {
					$name=preg_replace("/([0-9]+)\.txt/i","$1",$d);
					$key=self::salt($name);
					$f=@file_get_contents(self::$request."?action=get"."&key=".$key."&name=".$name);
					// echo self::$request."?action=get"."&key=".$key."&name=".$name;
					if ($f!='') {
						$j=json_decode($f);
						if (isset($j->response)) {
							if (isset($j->response->answer)) {
								if ($j->response->answer=='OK') {
									unlink($d);
								}
							}
						}
					}
				} 
			}
		}
		closedir($dir);
	}
}

public static function get() {
	if (self::server()) {
		if ((isset(url::$key)) && (isset(url::$name))) {
			if ((url::$key!='') && (url::$name!='')) {
				if (url::$key==self::salt(url::$name)) {
					self::$url=self::$request.url::$name.".txt";					
					$f=@file_get_contents(self::$url);
					if ($f!='') {
						$f=toWIN($f);
						if (file_put_contents(self::$path."/".url::$name.".txt",$f)) {
							self::$j['response']['answer']='OK';
						}
					}
				}
			}
		}
	}
	self::$j['response']['url']=self::$url;
	self::$j['response']['time']=time();
}

public static function salt($name="") {
	return sha1(date("dj.STANDART-N").$name);
}

public static function client() {
	$p=project."/settings/client.json";
	if (file_exists($p)) { $f=file_get_contents($p); }	
	if ($f!="") { 
		$j=json_decode($f);
		if ((isset($j->request)) && (isset($j->path))) {
			if (($j->request!='') && ($j->path!='')) {
				self::$request=$j->request;
				self::$path=$j->path;
				return true;
			}
		}
	}
	return false;
}

public static function server() {
	$p=project."/settings/server.json";
	if (file_exists($p)) { $f=file_get_contents($p); }	
	if ($f!="") { 
		$j=json_decode($f);
		if ((isset($j->request)) && (isset($j->path))) {
			if (($j->request!='') && ($j->path!='')) {
				self::$request=$j->request;
				self::$path=$j->path;
				return true;
			}
		}
	}
	return false;
}


public static function data($p="",$f="") {
	return false;
}

} ?>