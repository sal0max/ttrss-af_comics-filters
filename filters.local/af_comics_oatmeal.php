<?php
class Af_Comics_Oatmeal extends Af_ComicFilter {

	function supported() {
		return array("The Oatmeal");
	}

	function process(&$article) {
		if (strpos($article["guid"], "theoatmeal.com/comics") !== FALSE) {

			$res = fetch_file_contents($article["link"], false, false, false,
				false, false, 0,
				"Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)");

			$doc = new DOMDocument();

			if (@$doc->loadHTML($res)) {
				$xpath = new DOMXPath($doc);
				$basenode = $xpath->query('//div[@id="comic"]')->item(0);

				if ($basenode) {
					$article["content"] = $doc->saveHTML($basenode);
				}
			}

			return true;
		}

		return false;
	}
}
?>
