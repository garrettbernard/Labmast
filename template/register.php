<?php

// /template/register.php

echo <<<EOM
<div id='container'>
	<form name="register" method="post" action="$site_url/user/register/submit">
	<table>
		<tr>
			<td>E-Mail Address:</td>
			<td><input type="text" name="email" size="35" /></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="password" name="password" size="25" /></td>
		</tr>
		<tr>
			<td>Re-enter Password:</td>
			<td><input type="password" name="password2" size="25" /></td>
		</tr>
		<tr>
			<td>First Name:</td>
			<td><input type="text" name="firstname" size="25" /></td>
		</tr>
		<tr>
			<td>Last Name:</td>
			<td><input type="text" name="lastname" size="25" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan='2'>You will need your six-digit <span style="font-weight:bold;">Course Code</span> to register for a course. This is provided by your laboratory instructor.</td>
		</tr>
		<tr>
			<td>Course Code</td>
			<td><input type="text" name="coursecode" size="7" /></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" value="Register" /></td>
		</tr>
	</table>
	</form>
</div>
	
EOM;

?>