<?php
/*****
 * file name	: class.Scrapper.php
 * Author 		: karthick kumar
 * Created date : 15 May 2015
 * Modified date: 16 May 2015
 * Description  : used to scrape the content of the webpage and find  				keywords in the page and to rank the site based on the 				keyword
 *
 *****/
class Scrapper {
	private $url;
	private $names;
	public static function getInstance() {
		static $instance = null;
		if ($instance == null) {
			$instance = new Scrapper();
		}
		return $instance;
	}

	public function __construct() {
		$this -> url = array('1' => 'http://www.helpinglostpets.com', '2' => 'http://www.jobsite.co.uk', '3' => 'http://www.stllostpets.org');
		$this -> names = array('1' => 'helpinglostpets', '2' => 'jobsite', '3' => 'stllostpets');
	}

	public function checkRequest() {
		if (!isset($_POST['action'])) {
			throw new Exception("Direct Access to the Page not allowed");
		}
	}

	public function scrapUrl($id = null) {
		$id = $_POST['id'];
		$filename = 'html/' . md5($this -> url[$id]) . '.txt';
		$jsonfile = 'json/' . md5($this -> url[$id]) . '.json';
		$filecontent = file_get_html($this -> url[$id]) -> find('body', 0) -> plaintext;
		$fp = fopen($filename, 'w+');
		fwrite($fp, $filecontent);
		$string = file_get_contents($filename);
		preg_match_all('/(dogs)(\s|)/i', $string, $dogmatches);
		preg_match_all('/(cats)(\s|)/i', $string, $catmatches);
		$dogscount = count($dogmatches[0]);
		$catscount = count($catmatches[0]);
		$json = '{"dogs":' . $dogscount . ',"cats":' . $catscount . ',"sitename":"' . $this -> names[$id] . '"}';
		$jfp = fopen($jsonfile, 'w+');
		if (fwrite($jfp, $json)) {
			echo 1;
		} else {
			echo 0;
		}
	}

	public function scrapAll() {
		$status = 0;
		for ($i = 1; $i <= count($this -> url); $i++) {
			$filename = 'html/' . md5($this -> url[$i]) . '.txt';
			$jsonfile = 'json/' . md5($this -> url[$i]) . '.json';
			$filecontent = file_get_html($this -> url[$i]) -> find('body', 0) -> plaintext;
			$fp = fopen($filename, 'w+');
			fwrite($fp, $filecontent);
			$string = file_get_contents($filename);
			preg_match_all('/(dogs)(\s|)/i', $string, $dogmatches);
			preg_match_all('/(cats)(\s|)/i', $string, $catmatches);
			$dogscount = count($dogmatches[0]);
			$catscount = count($catmatches[0]);
			$json = '{"dogs":' . $dogscount . ',"cats":' . $catscount . ',"sitename":"' . $this -> names[$i] . '"}';
			$jfp = fopen($jsonfile, 'w+');
			if (fwrite($jfp, $json)) {
				$status = 1;
			} else {
				$status = 0;
			}
		}
		echo $status;
	}

	public function search() {
		$dir = "json/";
		$string = '';
		if (is_dir($dir)) {
			if ($dh = opendir($dir)) {
				while (($file = readdir($dh)) !== false) {
					$fp = @ fopen($dir . $file, 'r');
					$content = @fread($fp, filesize($dir . $file));
					if (!empty($content)) {
						$string .= $content . ',';
					}
				}
				closedir($dh);
			}
		}
		$string = rtrim($string, ',');
		echo("[$string]");
	}

	public function __toString() {
		return $this -> url;
	}

	public function __call($method, $arg) {
		echo "Call to the undefined method:" . $method . 'in Class:' . __CLASS__;
	}

}
?>