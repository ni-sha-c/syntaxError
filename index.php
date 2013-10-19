<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);
define("ROOT", __DIR__);
//require(ROOT."/config.php");
require(ROOT."/Toro.php");
//require(ROOT."/lib/db.php");
require(ROOT."/handlers/home.php"); //function requires all the files stored in ROOT."/handlers/"
require(ROOT."/handlers/getpop.php");
//require(ROOT."/handlers/search.php");

ToroHook::add("404", function() {
    echo "Not found";
});

class searchHandler{
	function get() {
			$view = array();
			//array_push($view,'home');
			include("views/csearch.php");
			 
		}
}

Toro::serve(array(
		"/" => "HomeHandler",
		"/search/:name" => "getpop",
		"/csearch/:name" => "searchHandler"
));
?>
