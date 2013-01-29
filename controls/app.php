<?php class app extends sn {

public static $id;
public static $j;
public static $path;
public static $records;
public static $message;
public static $path;
public static $request;

function __construct() {
	self::$j=array("response"=>array("time"=>time(),"answer"=>"NO"));
	self::$id=0;
}

public static function search() {
	if (self::client()) {
		console::write('path: '.self::$path);
		console::write('------------------');
		chdir(self::$path);
		$dir=opendir(".");
		while ($d=readdir($dir)) { 
			if (is_file($d)) { 
				if (preg_match("/[0-9]+\.txt/i",$d)) {
					$name=preg_replace("/([0-9]+)\.txt/i","$1",$d);
					$key=self::salt($name);
					console::write('file: '.$d);
					console::write('name: '.$name);
					console::write('key: '.$key);
					$f=file_get_contents(self::$request."?action=get"."&key=".$key."&name=".$name);
					if ($f!='') {
						console::write('response: '.$f);
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
					$f=file_get_contents(self::$request.url::$name);
					if ($f!='') {
						$f=toWIN($f);
						if (file_put_contents(self::$path."/".url::$name,$f)) {
							self::$j['response']['answer']='OK';
						}
					}
				}
			}
		}
	}
}

public static function salt($name="") {
	return sha1(date("dj.STANDART-N").$name);
}

public static function client() {
	$p=project."/settings/options.json";
	if (file_exists($p)) { $f=file_get_contents($p); }	
	if ($f!="") { 
		$j=json_decode($f);
		if (isset($j->client)) {
			if ((isset($j->client->request)) && (isset($j->client->path))) {
				if (($j->client->request!='') && ($j->client->path!='')) {
					self::$request=$j->client->request;
					self::$path=$j->client->path;
					return true;
				}
			}
		}
	}
	return false;
}

public static function server() {
	$p=project."/settings/options.json";
	if (file_exists($p)) { $f=file_get_contents($p); }	
	if ($f!="") { 
		$j=json_decode($f);
		if (isset($j->server)) {
			if ((isset($j->server->request)) && (isset($j->server->path))) {
				if (($j->server->request!='') && ($j->server->path!='')) {
					self::$request=$j->server->request;
					self::$path=$j->server->path;
					return true;
				}
			}
		}
	}
	return false;
}


public static function data($p="",$f="") {
	return false;
}

} ?>
