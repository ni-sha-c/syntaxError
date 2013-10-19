<?php
class HomeHandler{
	function get() {
			$view = array();
			//array_push($view,'home');
			include("views/layout.php");
		}
}
