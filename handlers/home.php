<?php
require('scraping/main.php');
require 'api_calls/helper.php';

class HomeHandler{
	function get() {
			$view = array();
			//array_push($view,'home');
			include("views/layout.php");
		}
	function post_xhr(){
		$source = $_POST['source'];
		$keystring = $_POST['keystring'];
		$details = getDetailsBySource($source,$keystring);
		// echo json_encode($details[0]["comments"]);
		foreach ($details as $key => $article) {
			$scores[$key] = apiCall($article["comments"]);
		}
		echo json_encode($scores);

	}
}