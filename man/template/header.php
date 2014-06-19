<?php

# /template/header.php

class header_template {

	function login_box() {
		global $base_url;
		
echo <<<EOM
		<div id="header_login">

		</div>
EOM;

	}
	
	function logout_box() {
		global $base_url;
		
		$name = $_SESSION['name'];
		
echo <<<EOM
		<div id="header_login">
			<span style="width:70%";><a href="$base_url/user/logout"><img src="/img/logout_button.png" /></a></span>
		</div>
EOM;
	}

	function header() {
	global $base_url;
	
		$username = $_SESSION['name'];
echo <<<EOM

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr"> 
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Online Lab Manual | labDB</title>
		<link rel="stylesheet" type="text/css" href="$base_url/main.css" />
			<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
	<script>
		!window.jQuery && document.write('<script src="jquery-1.4.3.min.js"><\/script>');
	</script>
	<script type="text/javascript" src="/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
		
		<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-27914428-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

	<script type="text/javascript">
		$(document).ready(function() {
			$("a.sub1").fancybox();
		});
	</script>
	</head>
<body>
<div id="container">
<div id="header">
	<!-- <a href="$base_url/index"><img src="$base_url/images/header_logo.png" /></a><br /> -->
	<a href="$base_url/index"><img src="/img/logo-with-title.png" /></a><br />
</div>
EOM;

	}

	function logged_out() {
	global $base_url;
echo <<<EOM
	<!-- 
<p id="header_menu">
<a class="header" href="$base_url/examples"><img src="$base_url/images/examples.png" /></a> 
</p>
-->


<div id="header_divider">&nbsp;</div>
EOM;

	}
	
	function logged_in() {
	global $base_url;
	
echo <<<EOM
<!--
<p id="header_menu">
	<a class="header" href="$base_url/courses"><img src="$base_url/images/my_courses.png" /></a>
	<a class="header" href="$base_url/results"><img src="$base_url/images/my_results.png" /></a>
	<a class="header" href="$base_url/profile"><img src="$base_url/images/my_profile.png" /></a>
</p>
<div id="header_divider">&nbsp;</div>
-->
EOM;

	}

	function logged_in_instructor() {
	global $base_url;
	
echo <<<EOM
<!--
<p id="header_menu">
	<a class="header" href="$base_url/courses"><img src="$base_url/images/my_courses.png" /></a>
	<a class="header" href="$base_url/results"><img src="$base_url/images/my_results.png" /></a>
	<a class="header" href="$base_url/profile"><img src="$base_url/images/my_profile.png" /></a>
	<a class="header" href="$base_url/cp"><img src="$base_url/images/lab_instructor_cp.png" /></a>
</p>
<div id="header_divider">&nbsp;</div>
-->
EOM;

	}
	
	function teacher_menu() {
		global $base_url;
echo <<<EOM

<div id="teacher_menu">
	<h5><a href="$base_url/cp">Control Panel</a></h5>
	<a href="$base_url/cp/courses">Course CP</a><br />
	<a href="$base_url/cp/labs">Lab CP</a><br />
	<a href="$base_url/cp/assignments">Assignments CP</a><br />
</div>
EOM;
	}
}


$header_template = new header_template;



?>