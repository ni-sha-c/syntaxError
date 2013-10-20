<?

require_once('../config/settings.php');

class ToiScraper {

	public function getArticleLinks($keyword)
	{
		global $articleSources, $customSearchUrl, $toiSearchID;

		$keyword = urlencode($keyword);
		$finalUrl = $customSearchUrl."&cx=$toiSearchID&q=$keyword";
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
		$result["title"] = $html->find('h1.multi-line-title-1', 0)->innertext;
		$result["content"] = "";
		foreach ($html->find('div.mod-articletext p') as $key => $value)
			$result["content"] .= $value->innertext;

		foreach ($html->find('iframe') as $key => $value)
			if(($pos = strrpos( $value->src, '/' )))
			{
				$id = substr( $value->src, $pos+1);
				break;
			}

			$result["commentUrl"] = "http://timesofindia.indiatimes.com/opinions/$id?commenttype=mostrecommended&sorttype=bycount";
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
		foreach ($html->find('div.cmtBox div div.box') as $key => $value) {
			$ele = $value->last_child()->first_child()->first_child();
			if($ele->tag == "span")
				$comments[] = $ele->innertext;
		}

		echo "\nGot article comments for $url\n";
		
		$html->clear(); 
		unset($html);
		return $comments;
	}
}

$scrapers["toi"] = new ToiScraper();
// $links = $scraper->getArticleLinks('modi');
// echo "\nGot Links\n";
// for($i = 1 ; $i < 2; $i++)
// {
// 	$articleContent = $scraper->getArticleContent($links[$i]);
// 	echo "\nGot Content\n";
// 	$comments = $scraper->getComments($articleContent["commentUrl"]);	
// 	echo "\nGot Comments\n";
// }

// print_r($articleContent);
// echo "<br><br>";
// print_r($comments);



 ?>

