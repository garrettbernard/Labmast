<?php
# /header.php
$qcount = 0;
include("./config.php");
$session_verify->check();
include("./template/header.php");

$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
$filename = basename($url);

$url = array_reverse(explode("/",$url));

if ($filename == "manual") {
	include("./template/index.php");

	} else if (in_array("cp",$url)) {

$i = 0;
while ($i > -1) {
	$template = "./template/cp_" . $url[$i] . ".php";
	if (@fopen($template, "r")) {
		include($template);
		$i = -2;
	} else {
	$i++;
	}
	}
} else {

$i = 0;
while ($i > -1) {
	$template = "./template/" . $url[$i] . ".php";
	if (@fopen($template, "r")) {
		include($template);
		$i = -2;
	} else {
	$i++;
}
}

}

// if (empty($_POST)) {
// print("<h1>" . $template . "</h1>");

// include("./template/" . $filename . ".php");

if ($_SESSION['uid'] != NULL) {
	$loggedin = "true";
} else {
	($loggedin = "false");
}


$header_template->header();


if (@$loggedin == "true") {
	$header_template->logout_box();
	if ($_SESSION['is_teacher'] == "1") {
		$header_template->logged_in_instructor();
	} else {
	$header_template->logged_in();
	}

} else {
	$header_template->login_box();
	$header_template->logged_out();
}
// }
?>