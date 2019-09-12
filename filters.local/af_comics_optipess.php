<?php
class Af_Comics_Optipess extends Af_ComicFilter {

	function supported() {
		return array("Optipess");
	}

	function process(&$article) {
		if (strpos($article["guid"], "optipess.com") !== FALSE) {

			$res = fetch_file_contents($article["link"], false, false, false,
				false, false, 0,
				"Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)");

			$doc = new DOMDocument();

			if (@$doc->loadHTML($res)) {
				$xpath = new DOMXPath($doc);
				$basenode = $xpath->query('//div[@id="comic-1"]')->item(0);
				$entry = $xpath->query('//div[@class="entry"]')->item(0);

				if ($basenode) {
					$article["content"] = $doc->saveHTML($basenode) . $doc->saveHTML($entry);
				}
			}

			return true;
		}

		return false;
	}
}
?>
