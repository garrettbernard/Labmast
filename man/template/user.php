<?php

# /template/user.php

class user_template {

	function login_box() {
		global $base_url;
	
echo <<<EOM

		<form name="login" method="post" action="$base_url/user/verify">
		<span>Username:&nbsp;<input name="username" type="text" id="username" size="15" />&nbsp;&nbsp;
		Password:&nbsp;<input name="password" type="password" id="password" size="15" />
		&nbsp;<input type="image" src="./images/login.png" alt="Login" /><br /></span>
		</form>
		<span>Not a member? <a style='font-size:11px;' href='$base_url/user/register'>Register now!</a></span>
EOM;

	}
}

$user_template = new user_template;