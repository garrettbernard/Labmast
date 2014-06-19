<?php

# /template/index.php

class index_template {

	function homepage() {
		global $base_url;
if (!$_SESSION['uid']) {
echo <<<EOM
<div id="homepage-login" style="min-height:300px;">
		<form name="login" method="post" action="$base_url/user/verify">
		E-Mail Address<br /><input name="email" type="text" id="username" size="15" /><br />
		Password<br /><input name="password" type="password" id="password" size="15" />
		<br /><input style="margin-left:30px;" type="submit" value="Login" />
		</form>
		<!-- <p style="clear:both;">Don't have a username? <a href="$base_url/user/register">Register now</a>.</p> -->
</div>



EOM;
} else {

echo <<<EOM

<div id="homepage-menu" style="min-height:350px;">
	<p><a href="$base_url/courses"><img src="/img/homepage_mycourses.png" /></a></p>
	<p><a href="$base_url/results"><img src="/img/homepage_myresults.png" /></a></p>
	<p><a href="$base_url/profile"><img src="/img/homepage_myprofile.png" /></a></p>
	<p><a href="$base_url/user/logout"><img src="/img/homepage_logout.png" /></a></p>
</div>

EOM;

}
	}

}


$index_template = new index_template;

?>