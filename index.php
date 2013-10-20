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
require 'config/settings.php';

ToroHook::add("404", function() {
    echo "Not found";
});

class searchHandler{
	function get($name) {

		
		$pop = new getpop();
	
		global $csURL;
		$response=file_get_contents($csURL."&q={$name}");
		$response=json_decode($response,true);
		$searchResults = $response["items"];
		$i = 0;
		foreach($searchResults as $item)
		{	if($i>2)
				break;
			
			$url = $item["link"];
			$score[$i] = $pop->pop_score($url);	
			//echo $score[$i];
			$i = $i + 1;
		}
		echo array_sum($score)/3;
;	 
	}
}

Toro::serve(array(
		"/" => "HomeHandler",
		"/csearch/([a-zA-Z0-9-_]+)" => "searchHandler"
));
?>
