<?php
require('scraping/main.php');

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
		echo json_encode($details);

	}
}