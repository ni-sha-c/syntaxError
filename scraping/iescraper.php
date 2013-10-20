<?

// require_once('config/settings.php');

class IeScraper {

	public function getArticleLinks($keyword)
	{
		global $articleSources, $customSearchUrl, $ieSearchID;

		$keyword = urlencode($keyword);
		$finalUrl = $customSearchUrl."&cx=$ieSearchID&q=$keyword";
		$result = json_decode(file_get_contents($finalUrl), true);

		$links = array();
		foreach ($result["items"] as $key => $value) {
			if(!strpos($value["link"], "picture-gallery"))
				$links[] = $value["link"];
		}

		echo "\nGot article links for $keyword\n";
		return $links;
	}

	public function getArticleContent($url)
	{
		if(!$url)
			return false;
		$html = file_get_html($url);
		$result["title"] = $html->find('div#ie2013-content h1', 0)->innertext;
		$result["content"] = "";
		foreach ($html->find('div.ie2013-contentstory p') as $key => $value)
		{
			if($value->align != "right")
				$result["content"] .= $value->innertext;
		}

		$result["commentUrl"] = "";
		// print_r($result);
		$js = $html->find('div.disqus script', 0)->innertext;
		// echo $js;
		preg_match('/disqus_shortname = \'[a-zA-Z0-9]*\'/', $js, $matches);
	    preg_match('/\'(.*?)\'/', $matches[0], $dq_shortname);

		preg_match('/identifier = \'[a-zA-Z0-9]*\'/', $js, $matches);
	    preg_match('/\'(.*?)\'/', $matches[0], $dq_identifier);

	    if(isset($dq_shortname[1]) && isset($dq_identifier[1]))
	    	$result["commentUrl"] = "http://disqus.com/embed/comments/?f=".$dq_shortname[1]."&t_i=".$dq_identifier[1];

		echo "\nGot article content for $url\n";

		$html->clear(); 
		unset($html);
		return $result;
	}

	public function getComments($url)
	{
		if(!$url)
			return false;
		$html = file_get_html($url, true);
		$comments = array();
		$threadData = json_decode($html->find('script#disqus-threadData', 0)->innertext, 1);
		foreach ($threadData["response"]["posts"] as $key => $value) {
			$comments[] = $value["raw_message"];
		}

		echo "\nGot article content for $url\n";

		$html->clear(); 
		unset($html);
		return $comments;
	}
}

$scrapers["ie"]  = new IEScraper();
// $links = $scraper->getArticleLinks('modi');

//Did this for testing to save on google search api queries
// $links[0] = "http://www.indianexpress.com/news/modi-model-the-pathani-kurta-is-likely-to-be-in-narendra-modis-wardrobe/1182774";
// echo "\nGot Links\n";
// print_r($links);
// for($i = 0; $i < 1; $i++)
// {
// 	$articleContent = $scraper->getArticleContent($links[$i]);
// 	echo "\nGot Content\n";
// 	print_r($articleContent);
// 	$comments = $scraper->getComments($articleContent["commentUrl"]);	
// 	echo "\nGot Comments\n";
// }

// print_r($comments);

?>

