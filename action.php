<?php
/*****
 * File name	: action.php
 * Author 		: karthick kumar
 * Created date : 15 May 2015
 * Modified date: 16 May 2015
 * Description  : used to route the url
 *
 *****/
require_once 'classes/simple_html_dom.php';
require_once 'classes/class.Scrapper.php';
$obj = Scrapper::getInstance();
$action = @$_POST['action'];
try {
	$obj -> checkRequest();
} catch(Exception $e) {
	echo 'Message: ' . $e -> getMessage();
}
if ($action == "index") {

	$obj -> scrapUrl();
}
if ($action == "indexall") {
	$obj -> scrapAll();
}
if ($action == "search") {
	$obj -> search();
}
?>