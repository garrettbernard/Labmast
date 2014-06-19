<?php
$error = '';
$link = mysql_connect('localhost','INSERT DB','INSERT PASS');
mysql_select_db('INSERT TABLE',$link);

if (@$_POST) {



	$name = mysql_real_escape_string($_POST['name']);
	$email = mysql_real_escape_string($_POST['email']);
	if ($_POST['prof'] == '1' || $_POST['prof'] == '0') {
		$prof = mysql_real_escape_string($_POST['prof']);
	}
	
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$error .= 'Sorry, but your email address was not entered correctly. Please try again.';
	} else {	
		$sql = "INSERT INTO subscription (name, email, prof) VALUES ('" . $name . "','" . $email . "','" . $prof . "')";
		mysql_query($sql);
		print("<p style='font-family:arial;'>Thanks! Your information has been submitted.</p>");
		die();
	}
}


echo <<<EOM
  <style type="text/css">
  body {
	font-family:arial;
	position:relative;
	margin:auto;
	background-color:#d7d7d7;
		}
  </style>
  
  <p style='color:red;'>$error</p>

<form method="post" action="">
	<table>
		<tr>
			<td>E-Mail Address</td>
			<td><input name='email' size='45' /></td>
		</tr>
		<tr>
			<td>Name</td>
			<td><input name='name' size='45' /></td>
		</tr>
		<tr>
			<td>Are you a collegiate or<br />
			high school laborator instructor?</td>
			<td>
				<input type='radio' name='prof' value='0' />No    <input type='radio' name='prof' value='1' />Yes<br />
			</td>
		</tr>
	</table>
	<input type='submit' value='Submit' />
</form>
<h6>Labmast will never sell your email address or any other information. View our <a href="/privacypolicy">Privacy Policy</a> to see our promise to operate with integrity and keep your details safe.</h6>

EOM;



	