<?php

/* user.php */
// print_r($_SERVER);
$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
$filename = basename($url);

if ($filename == "verify" | $filename == "logout") {
	session_start();	
	include("./config.php");
} else {
	session_start();
	include("./header.php");
}

class login {

	function verify_login($url) {
		global $main_url, $sql, $result, $session_verify;
		
		$password = @md5(mysql_real_escape_string($_POST['password']));
		// print($password);
		$email = mysql_real_escape_string($_POST['email']);
		
		// print($password . $email);
/*
		$sql    = "SELECT * FROM users WHERE uid='1'";

		$result = mysql_query($sql, $link); 
			if ($result) {
			echo "Database Error";
			echo 'MySQL Error: ' . mysql_error();
			// exit;
		}
*/

		$sql->select("users","*","email",$email);
		$row = mysql_fetch_assoc($result);
		
		if ($row['password'] == $password AND $row['email'] == $email) {
			$_SESSION['email'] = $email;
			$uid = $row['uid'];
			$session_verify->create($uid);
			$_SESSION['uid'] = $uid;
			$_SESSION['name'] = ($row['name']);
			$_SESSION['is_teacher'] = $row['is_teacher'];
			$_SESSION['affiliated_courses'] = $row['affiliated_courses'];
			// $_SESSION['stuorteach'] = $row['stuorteach'];

		header('Location: ' . $_SERVER['HTTP_REFERER']);
			// print("Correct Possword!");
			exit;
			
		} else {
			print("Incorrect password.");
		}

	}

	

	function logout($url) {
		global $main_url, $session_verify;

		$session_verify->destroy();

		//if (isset($_COOKIE[session_name()])) {
		//	    setcookie(session_name(), '', time()-42000, '/');
		//}

			header('Location: ' . $_SERVER['HTTP_REFERER']);
			exit;

	}
	
	
	function convert_id_to_username($id,$nametype,$link_to_profile) {
		global $link;
		
		$sql = "SELECT id,username,firstname,lastname FROM profile WHERE id = '" . $id . "'";

		$this->name_result = mysql_query($sql, $link);
		$row = mysql_fetch_assoc($this->name_result);
			$username = $row['username'];
			$firstname = $row['firstname'];
			$lastname = $row['lastname'];	
			
		if ($nametype == 'fullname') {
			$namer = ($firstname . ' ' . $lastname);
		} elseif ($nametype == 'username') {
			$namer = ($username);
		}
		
		if ($link_to_profile == TRUE) {
$namer = <<< EOM
<a href="./profile.php?uid={$id}">{$namer}</a>
EOM;
		}
		
		print($namer);
		
	}
	
	function register() {
		global $sql,$html,$site_url,$result;

echo "<div id='register'>";
	
		if (@$_GET['make'] == 'submit') {
			if ($_POST['password'] != $_POST['password2']) {
				print('Your passwords do not match. Please press BACK and try again.');
				exit();
			}
		
			$email = mysql_real_escape_string($_POST['email']);
			$password = md5(mysql_real_escape_string($_POST['password']));
			$firstname = mysql_real_escape_string($_POST['firstname']);
			$lastname = mysql_real_escape_string($_POST['lastname']);
			$coursecode = mysql_real_escape_string($_POST['coursecode']);
			
			// $sql->select("courses","cid,course_name");
			
			$sqlhere = "SELECT cid,course_name FROM courses";
			$result = mysql_query($sqlhere);
			
			
			$i=0;
			while ($i < mysql_num_rows($result)) {
				$row = mysql_fetch_array($result);
				
				$source_coursecode = substr(md5("transy" . $row['cid']),0,6);
				
				if ($coursecode == $source_coursecode) {
					$i = mysql_num_rows($result);
					$cid = $row['cid'];
					$course_name = $row['course_name'];
				}
				$i++;
			}
			
			if ($cid == NULL) {
				$html .= ("<h4>You have not entered a valid Course Code.</h4>");
			} else {

				
				
				$sql->select("users","uid,name,password,email,affiliated_courses","email",$email);
				
				if (mysql_num_rows($result) == 1) {
					$row = mysql_fetch_array($result);
					
					if ($password != $row['password']) {
						$html .= "<h4>This email address already exists and the password you provided was not correct.</h4>";
					} else {
					$uid = $row['uid'];
					$affiliated_courses = explode("|",$row['affiliated_courses'],-1);
					$affiliated_courses[count($affiliated_courses)] = $cid;
					$affiliated_courses = array_unique($affiliated_courses);
					$affiliated_courses = implode("|",$affiliated_courses) . "|";
					$sql->update("users","affiliated_courses",$affiliated_courses,"uid",$uid);
					
					$sql->select("courses","students,cid","cid",$cid);
					$row = mysql_fetch_array($result);
					
					$students = explode("|",$row['students'],-1);
					$students[count($students)] = $uid;
					$students = array_unique($students);
					$students = implode("|",$students) . "|";
					
					$sql->update("courses","students",$students,"cid",$cid);
					
					$html .= "<br />Your email address already exists and you have been added to your course list.<br />";
					$html .= "Your course is: " . $course_name;
					$html .= "<h4>You may now login above with the credentials you just provided.</h4>";
					$html .= "<hr />";
					}			
				} else if (mysql_num_rows($result) == 0) {
					$a = array(
						'name',
						'password',
						'email'
					);
					
					$b = array(
						"'" . $firstname . " " . $lastname . "'",
						"'" . $password . "'",
						"'" . $email . "'"
					);
					
					$sql->insert("users",$a,$b);
					
					$sql->select("users","uid,name,email,affiliated_courses","email",$email);
					$row = mysql_fetch_array($result);
					$uid = $row['uid'];
					$affiliated_courses = explode("|",$row['affiliated_courses'],-1);
					$affiliated_courses[count($affiliated_courses)] = $cid;
					$affiliated_courses = array_unique($affiliated_courses);
					$affiliated_courses = implode("|",$affiliated_courses) . "|";
					$sql->update("users","affiliated_courses",$affiliated_courses,"uid",$uid);
					
					$sql->select("courses","students,cid","cid",$cid);
					$row = mysql_fetch_array($result);
					
					$students = explode("|",$row['students'],-1);
					$students[count($students)] = $uid;
					$students = array_unique($students);
					$students = implode("|",$students) . "|";
					
					$sql->update("courses","students",$students,"cid",$cid);
					
					$html .= "<br />New user has been created!<br />";
					$html .= "Your course is: " . $course_name;
					$html .= "<h4>You may now login above with the credentials you just provided.</h4>";
					$html .= "<hr />";
				}

				
			}
		}
@print($html);
echo <<<EOM

	<p>To register, you must have a six-digit Course Code. This is provided by your lab instructor.</p>
	<p>If you have previously registered you can either login and go to My Profile -> Add New Course, or proceed with filling out the form below. Previous data will not be overwritten.</p>
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

		
	}

}

		



$login = new login();

switch (@$_GET['act']) {

    case 'verify':

        $login->verify_login($_SERVER['REDIRECT_URL']);

        break;

    case 'logout':

		$login->logout($_SERVER['REDIRECT_URL']);

		break;

	case 'verify_reg':

		$login->verify_reg();

		break;
	case 'loginbox':
		$login->loginbox();
		break;
	case 'register':
		$login->register();
		break;

   }
 
include("./footer.php");

?>