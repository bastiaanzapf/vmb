<?php
ini_set('display_errors',true);
error_reporting(E_ALL);
require_once("config.inc.php");
require_once("library.inc.php");
require_once("Smarty/Smarty.class.php");

function getSmarty() {
	global $config;
	if (!function_exists("smarty_getLink")) {
		function smarty_getLink($params) {
			return getlink($params["file"]);
		}
	}
	if (!function_exists("parselinks")) {
		function parselinks($text) {
			// RFC 1738 is interesting here!
			return preg_replace("$([a-zA-Z\.+-]{3,6}:[^\s]+)$", "<a href=\"\$1\">\$1</a>", $text);
		}
	}
	$smarty = new Smarty;
	$smarty->registerPlugin('function',"getlink", "smarty_getLink");
	$smarty->registerPlugin('modifier',"htmlescape", "htmlentities2");
	$smarty->registerPlugin('modifier',"parselinks", "parselinks");
	$smarty->assign("CHARSET", $config->charset);
	$smarty->assign("ADMINNAME", $config->adminname);
	$smarty->assign("ADMINMAIL", $config->adminmail);
	return $smarty;
}

?>
