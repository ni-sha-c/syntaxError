<?

// include(ROOT.'/config/settings.php');
class HinduScraper {

	public function getArticleLinks($keyword)
	{
		global $articleSources, $customSearchUrl, $hinduSearchID;

		$keyword = urlencode($keyword);
		$finalUrl = $customSearchUrl."&cx=$hinduSearchID&q=$keyword";
		echo $finalUrl;

		$result = json_decode(file_get_contents($finalUrl), true);

		$links = array();
		foreach ($result["items"] as $key => $value) {
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
		$result["title"] = $html->find('h1.detail-title', 0)->innertext;

		$result["content"] = "";
		foreach ($html->find('p.body') as $key => $value)
			$result["content"] .= $value->innertext;

		$result["comments"] = array();
		foreach ($html->find('div#comment-section h4') as $key => $value)
			$result["comments"][] = $value->innertext;
	    
		echo "\nGot article content for $url\n";
		
		$html->clear(); 
		unset($html);
		return $result;
	}

}

$scrapers["hindu"]  = new HinduScraper();
// $links = $scraper->getArticleLinks('modi');
//Did this for testing to save on google search api queries

// $links[0] = "http://www.thehindu.com/news/national/its-modi-all-the-way-at-bhopal-rally/article5168712.ece";
// echo "\nGot Links\n";
// print_r($links);
// for($i = 0; $i < 1; $i++)
// {
// 	$articleContent = $scraper->getArticleContent($links[$i]);
// 	echo "\nGot Content\n";
// }

// print_r($articleContent);



 ?>

