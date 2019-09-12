<?php
class Af_Comics_Stuttmann extends Af_ComicFilter {

	function supported() {
		return array("Stuttmann Karikaturen");
	}

	function process(&$article) {
		if (strpos($article["guid"], "stuttmann-karikaturen.de/karikatur/") !== FALSE) {

			// extract tags
			$tags = substr($article["content"], strpos($article["content"], "Themen:"));
			$tags = str_replace("Personen: ", "", $tags);
			$tags = str_replace("Themen:", "", $tags);
			$tags = str_replace("<br>", "", $tags);
			$tags = str_replace("</b>", "", $tags);
			$tags = str_replace("<b>", ",", $tags);
			$article["tags"] = array_map("trim", explode(",", $tags));
			print_r($article["tags"]);

			// full res image
			$article["content"] = str_replace("/thumbs/", "/", $article["content"]);
			$article["content"] = substr($article["content"], 0, strpos($article["content"], "</a>") + 4);

			// correct date
			$date = substr($article["title"], strlen($article["title"])-11, 10);
			$article["timestamp"] = DateTime::createFromFormat("d.m.Y H:i:s", $date . " 00:00:00")->format("U");

			return true;
		}

		return false;
	}
}
?>
