<?php 

	require_once 'config/settings.php';
	class getpop
	{


		function pop_score($url)
		{
			//Name of politician
			list($type, $score, $mixed) = $this->sentiment($url);
			return $score;
						
		
		}
	
		function sentiment($urlparam)
		{
			global $alchemyEndPoint, $alchemy_api_key;
			$response=file_get_contents($alchemyEndPoint."?apikey={$alchemy_api_key}&url={$urlparam}&outputMode=json");
			$response=json_decode($response,true);
			$type = $response["docSentiment"]["type"];
			$score = $response["docSentiment"]["score"];
			$mixed = $response["docSentiment"]["mixed"];
			return array($type, $score, $mixed);

		}	

	}


