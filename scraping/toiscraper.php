<?

// // include ("../lib/phphtmlparser/src/htmlparser.inc");
include('../lib/simplehtmldom_1_5/simple_html_dom.php');
include('../config/settings.php');
// include('html2text.inc');
// 
// $html = file_get_html('http://www.google.com/');

// // Find all images 
// foreach($html->find('img') as $element) 
//        echo $element->src . '<br>';

// // Find all links 
// foreach($html->find('a') as $element) 
//        echo $element->href . '<br>';
//

class ToiScraper {

	public function getArticleLinks($keyword)
	{
		global $articleSources, $customSearchUrl, $toiSearchID;

		$finalUrl = $customSearchUrl."&cx=$toiSearchID&q=$keyword";
		$result = json_decode(file_get_contents($finalUrl), true);

		$links = array();
		foreach ($result["items"] as $key => $value) {
			$links[] = $value["link"];
		}
		// $url = $articleSources["toi"]["search"];
		// $html = file_get_html("$url$keyword");	
		// 	foreach($html->find('div.title a') as $element) 
		// 		$results[] = $element->href;

		return $links;
	}

	public function getArticleContent($url)
	{
		$html = file_get_html($url);
		// print_r($html);
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
		return $result;
	}

	public function getComments($url)
	{
		$html = file_get_html($url, true);
		$comments = array();
		foreach ($html->find('div.cmtBox div div.box') as $key => $value) {
			$ele = $value->last_child()->first_child()->first_child();
			if($ele->tag == "span")
				$comments[] = $ele->innertext;
		}
		return $comments;
	}
}

$scraper = new ToiScraper();
$links = $scraper->getArticleLinks('modi');
echo "\nGot Links\n";
for($i = 1 ; $i < 2; $i++)
{
	$articleContent = $scraper->getArticleContent($links[$i]);
	echo "\nGot Content\n";
	$comments = $scraper->getComments($articleContent["commentUrl"]);	
	echo "\nGot Comments\n";
}

// print_r($articleContent);
// echo "<br><br>";
print_r($comments);



 ?>

