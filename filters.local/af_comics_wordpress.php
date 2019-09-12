<?php
class Af_Comics_Wordpress extends Af_ComicFilter {

	function supported() {
		return array("Our Super Adventure", "Channelate");
	}

	function process(&$article) {
		if (strpos($article["guid"], "oursuperadventure.com") !== FALSE || // osa - way too much ads and gibberish
				strpos($article["guid"], "channelate.com") !== FALSE) {

			// extract the thumb image url
			preg_match('/http(s)?:\/\/(www\.)?\S+\.(com|de)\/wp-content\/uploads\/\S+/', $article["content"], $matches);

			// remove "-150x150" (also other sizes)
			$url = preg_replace("/-\d+x\d+/", '', $matches[0]);

			// place img-tag around it
			$article["content"] = '<img src="' . $url . ' />';

			return true;
		}

		return false;
	}
}
?>
