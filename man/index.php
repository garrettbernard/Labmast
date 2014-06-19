<?php
session_start();
# /index.php


include("./header.php");
if ($_GET['home'] == "lab") {
	echo "lab";
} else {



}

$index_template->homepage();


include("./footer.php");

?>