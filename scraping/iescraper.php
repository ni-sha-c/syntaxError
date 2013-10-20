<?

include('../lib/simplehtmldom_1_5/simple_html_dom.php');
include('../config/settings.php');

class ToiScraper {

	public function getArticleLinks($keyword)
	{
		global $articleSources, $customSearchUrl, $ieSearchID;

		$finalUrl = $customSearchUrl."&cx=$ieSearchID&q=$keyword";
		$result = json_decode(file_get_contents($finalUrl), true);

		$links = array();
		foreach ($result["items"] as $key => $value) {
			$links[] = $value["link"];
		}

		return $links;
	}

	public function getArticleContent($url)
	{
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

		return $result;
	}

	public function getComments($url)
	{
		$html = file_get_html($url, true);
		$comments = array();
		$threadData = json_decode($html->find('script#disqus-threadData', 0)->innertext, 1);
		foreach ($threadData["response"]["posts"] as $key => $value) {
			$comments[] = $value["raw_message"];
		}

		return $comments;
	}
}

$scraper = new ToiScraper();
// $links = $scraper->getArticleLinks('modi');

//Did this for testing to save on google search api queries
$links[0] = "http://www.indianexpress.com/news/modi-model-the-pathani-kurta-is-likely-to-be-in-narendra-modis-wardrobe/1182774";
echo "\nGot Links\n";
print_r($links);
for($i = 0; $i < 1; $i++)
{
	$articleContent = $scraper->getArticleContent($links[$i]);
	echo "\nGot Content\n";
	print_r($articleContent);
	$comments = $scraper->getComments($articleContent["commentUrl"]);	
	echo "\nGot Comments\n";
}

print_r($comments);

?>

