<?
require_once 'config/settings.php';

function apiCall($comments)
{
	global $repustateEndPoint;
	$command = "curl -d '";
	$text = "";
	foreach ($comments as $key => $comment){
		// $key = $key+1;
		$text .= "text$key=$comment&"; 
	}
	$text = substr($text, 0, -1);
	$command = "$command$text' $repustateEndPoint";
	$res = shell_exec($command);
	return $res;
}

// apiCall(array("jayant", "im awesome", 'y"es", really'));
?>
