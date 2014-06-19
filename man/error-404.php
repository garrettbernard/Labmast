<?php

// error-404.php

$url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

$slash = substr($url,-1);


if ($slash == '/') {
	$url = substr($url,0,-1);
	// print($url . "<br />");
	header("location: " . $url);
	exit();
} else {
//	include("manual/header.php");
print("Unfortunately, the page you're looking for doesn't seem to exist. Please check your URL.");
//	include("manual/footer.php");
}

?>