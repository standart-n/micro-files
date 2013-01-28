<?php class url extends sn {
	
public static $action;
public static $callback;

public static $test;
public static $show;

public static $ago;
public static $science;
public static $minute;
public static $hour;
public static $day;
public static $month;
public static $year;


function __construct() {
	if (isset($_REQUEST["action"])) {
		self::$action=trim(strval($_REQUEST["action"]));
	}
	if (isset($_REQUEST["callback"])) {
		self::$callback=trim(strval($_REQUEST["callback"]));
	}
	if (isset($_REQUEST["test"])) {
		self::$test=true;
	}
	if (isset($_REQUEST["show"])) {
		self::$show=true;
	}	
	
}


} ?>
