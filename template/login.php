<?php

// /template/login.php

echo <<<EOM
<div id='container'>
<div id='bodytext'>
		<form name="login" method="post" action="$base_url/user/verify" style="padding:40px;">
			<table border=0>
				<tr>
					<td>E-Mail Address</td><td><input name="email" type="text" id="username" size="15" /></td>
				</tr>
				<tr>
					<td>Password</td><td><input name="password" type="password" id="password" size="15" /></td>
				</tr>
			</table>
		<input style="margin-left:80px;" type="submit" value="Login" />
		</form>
</div>
</div>
	
EOM;

?>