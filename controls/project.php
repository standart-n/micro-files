<?php class project extends sn {

function __construct() {
	session_start();
}

public static function engine() {
	switch (url::$action) {
	case "search":
		app::search();
	break;
	case "get":
		app::get();
		echo json_encode(app::$j);
	break;
	}
}	

} ?>
