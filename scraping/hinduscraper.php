<?

include('../lib/simplehtmldom_1_5/simple_html_dom.php');
include('../config/settings.php');

class ToiScraper {

	public function getArticleLinks($keyword)
	{
		global $articleSources, $customSearchUrl, $hinduSearchID;

		$finalUrl = $customSearchUrl."&cx=$hinduSearchID&q=$keyword";
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
		$result["title"] = $html->find('h1.detail-title', 0)->innertext;

		$result["content"] = "";
		foreach ($html->find('p.body') as $key => $value)
			$result["content"] .= $value->innertext;

		$result["comments"] = array();
		foreach ($html->find('div#comment-section h4') as $key => $value)
			$result["comments"][] = $value->innertext;
			
		return $result;
	}

}

$scraper = new ToiScraper();
// $links = $scraper->getArticleLinks('modi');
//Did this for testing to save on google search api queries

$links[0] = "http://www.thehindu.com/news/national/its-modi-all-the-way-at-bhopal-rally/article5168712.ece";
echo "\nGot Links\n";
print_r($links);
for($i = 0; $i < 1; $i++)
{
	$articleContent = $scraper->getArticleContent($links[$i]);
	echo "\nGot Content\n";
}

print_r($articleContent);



 ?>

