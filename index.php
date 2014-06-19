<?php

// index.php

// load the config file

include_once(dirname(__FILE__) . "/config.php");

// list the available menu items
$menu = array(
	'login',
	'contact',
	'about',
	'tou',
	'privacypolicy',
	'sitemap'
);

// load homepage if the menu isn't defined
// if menu is defined, compare available menu items with the one a user is trying to access

if (!$_GET['a']) {
	include_once(dirname(__FILE__) . "/header.php");
	include_once(dirname(__FILE__) . "/template/homepage.php");
	include_once(dirname(__FILE__) . "/footer.php");
	die();
} else if (!in_array($_GET['a'],$menu)) {
	include_once(dirname(__FILE__) . "/header.php");
	print("<div id='container'>You have directed your browser to a page that doesn't exist! Sorry!</div>");
	include_once(dirname(__FILE__) . "/footer.php");
	die();
} else {
	include_once(dirname(__FILE__) . "/header.php");
	include_once(dirname(__FILE__) . "/template/" . $_GET['a'] . ".php");
	include_once(dirname(__FILE__) . "/footer.php");
}

?>