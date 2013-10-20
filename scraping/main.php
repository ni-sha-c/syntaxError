<?
require 'config/settings.php';
require 'scraping/init.php';
require 'scraping/toiscraper.php';
require 'scraping/iescraper.php';
require 'scraping/hinduscraper.php';


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

function getDetailsBySource($source,$keyword)
{
	$links = array();
	$details = array();
	$scrapername = $source.'Scraper';
	$scraper = new $scrapername;
	$links = $scraper->getArticleLinks($keyword);
	$c = 0;
	foreach($links as $index=>$link)
	{
		if($c++ > 5)
			break;
		$details[$index] = $scraper->getArticleContent($link);
		if(!isset($details[$index]["comments"]))
			$details[$index]["comments"] = htmlspecialchars_decode($scraper->getComments($details[$index]["commentUrl"]));

	}
	return $details;
}

//getAllDetails('modi');
//getDetailsBySource('Ie','sachin%20tendulkar');
?>
