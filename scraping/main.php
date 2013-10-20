<?

require 'init.php';
require 'toiscraper.php';
require 'iescraper.php';
require 'hinduscraper.php';


function getAllDetails($keyword)
{
	global $scrapers;
	$links = array();
	$details = array();

	foreach ($scrapers as $key => $scraper) {
		$links[$key] = $scraper->getArticleLinks($keyword);
		foreach ($links[$key] as $index => $link)
		{
			$details[$key][$link] = $scraper->getArticleContent($link);
			if(!isset($details[$key][$link]["comments"]))
				$details[$key][$link]["comments"] = $scraper->getComments($details[$key][$link]["commentUrl"]);
			break;//For testing
		}
		
	}
}

getAllDetails('modi');
?>