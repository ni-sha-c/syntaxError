<?php 


	class getpop
	{


		function get($name)
		{
			//Name of politician
			$pol_name = $name;
						
		
		}
	
		function sentiment($api_key, $urlparam)
		{
			$url="http://access.alchemyapi.com/calls/url/URLGetTextSentiment";
			$response=file_get_contents($url."?apikey={$api_key}&url={$urlparam}&outputMode=json");
			$response=json_decode($response,true);
			$type = $response["docSentiment"]["type"];
			$score = $response["docSentiment"]["score"];
			$mixed = $response["docSentiment"]["mixed"];
			return array($type, $score, $mixed);

		}	

		function tar_sentiment($api_key, $urlparam)
		{
		

		}

	}

	/*$urlparam="http://www.cnn.com/2009/CRIME/01/13/missing.pilot/index.html";
	$api_key="4033ce5c39cdb94b7ab3361b5b9329cb33437ea7";
	list($t, $s, $m) = sentiment($api_key, $urlparam);
	echo $t;
	echo $s;
	echo $m;*/
