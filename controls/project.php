<?php class project extends sn {

function __construct() {
	session_start();
}

public static function engine() {
	switch (url::$action) {
	case "search":
		console::write('action: search');
		app::search();
	break;
	case "get":
		console::write('action: get');
		app::get();
		echo json_encode(app::$j);
	break;
	}
}	

} ?>
