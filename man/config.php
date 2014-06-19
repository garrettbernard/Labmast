<?php

# /config.php


// Database configuration; host (probably "localhost"), database name, database password

$db_host = "localhost";
$db_name = "INSERT DB";
$db_password = "INSER PASS";
$allow_registration = "1";

// Site URL; omit ending slash!
// example: http://www.xyz.com/website NOT http://www.xyz.com/website/

$site_url = "http://www.labmast.com/man";
$main_url = "http://www.labmast.com";
$base_url = "/man";


// ------------------------------------
// DO NOT MAKE CHANGES BELOW THIS LINE
// ------------------------------------



$link = mysql_connect($db_host,$db_name,$db_password);

if (!$link) {
    echo 'Cannot connect to the database!';
    exit;
}

if (!mysql_select_db($db_name, $link)) {
    echo 'Cannot select the requested database!';
    exit;
}

class sql {
	

	function insert($table,$rows,$values) {
	global $link;
/*		if (is_array($values)) {
			$i = 0;
			while ($i < count($values)) {
				$values[$i] = mysql_real_escape_string($values[$i]);
				$i++;
				print_r($values);

			}
//		} else {
//				$values = mysql_real_escape_string($values);
//		}
*/		
		$rows = implode(",",$rows);
		$values = implode(",",$values);
		
		// print_r($values);
	
		$sql = "INSERT INTO " . $table . " (" . $rows . ") VALUES (" . $values . ")";
		// print("<p>SQL: " . $sql . "</p>");
		$result=mysql_query($sql,$link) or die(mysql_error());
		return "Successfully Updated!";
	}
	
	function select($table,$rows,$a,$b) {
	global $link, $result;
	
		$sql = "SELECT " . $rows . " FROM " . $table . " WHERE " . $a . "='" . $b . "'";
		// print("<p>SQL: " . $sql . "</p>");
		$result = mysql_query($sql, $link);
		
		if (!$result) {
			echo "Database Error";
			echo 'MySQL Error: ' . mysql_error();
			exit;
		}
	//	$row = mysql_fetch_array($result);
	}
	
	function update($table,$column,$value,$wcolumn,$wvalue) {
		global $link, $result;
		
		$sql = "UPDATE " . $table . " SET " . $column . "='" . $value . "' WHERE " . $wcolumn . "='" . $wvalue . "'";
		// print("<p>SQL: " . $sql . "</p>");
		$result = mysql_query($sql, $link);
		
		if (!$result) {
			echo "Database Error";
			echo 'MySQL Error: ' . mysql_error();
			exit;
		}
	}
	
		
}

class session_verify {
	
	function create($uid) {
		global $session_string,$link;
		
	$this->destroy();
	
	$session_string = '';
	
	$i=0;
	while($i<10) {
		$session_string .= chr(97 + mt_rand(0, 25));
		$i++;
	}
	$session_string = str_split(md5($session_string));
	$i=0;
	while($i<10) {
		if (is_int($session_string[$i])) {
			$session_string[$i] = mt_rand(0, 200);
		}
		$i++;
	}

	$session_string = md5(implode("",$session_string));
	$session_string = substr($session_string, 5, 11);
	$time = time();
	$ip = $_SERVER['REMOTE_ADDR'];
	$sql = "INSERT INTO sessions (sid,uid,lastactive,ipaddress) VALUES ('" . $session_string . "','" . $uid . "','" . $time . "','" . $ip . "')";
	$result = mysql_query($sql, $link);
	$_SESSION['stasis'] = $session_string;

	}
	
	function check() {
		global $link;
		
		if ($_SESSION['stasis'] != NULL) {
		
		$sql = "SELECT uid,sid FROM sessions WHERE uid='" . $_SESSION['uid'] . "' AND sid='" . $_SESSION['stasis'] . "'";
		$result = mysql_query($sql, $link);
		
		if (mysql_num_rows($result) != 1) {
			$this->destroy();
			header('Location: http://www.labmast.com/man/index');
		}
		
		$row = mysql_fetch_array($result);
		
		} else {
		$_SESSION['stasis'] = NULL;
		$_SESSION['uid'] = NULL;
		$_SESSION = array();
		return;
		}
		
		
		
	}
		
	function destroy() {
		global $link;
		
		$sql = "DELETE FROM sessions WHERE sid='" . $_SESSION['stasis'] . "'";
		$result = mysql_query($sql, $link);
		
		$sql = "DELETE FROM sessions WHERE uid='" . $_SESSION['uid'] . "'";
		$result = mysql_query($sql, $link);
		
		$_SESSION['stasis'] = NULL;
		$_SESSION['uid'] = NULL;
		$_SESSION = array();
		return;
		
	}
}
	

class global_functions {

	function lastnamefirst($name) {
		global $name;

		$name = explode(' ',$name);
		$lastname = array_pop($name);
		$name = implode(' ',$name);
		$name = $lastname . ", " . $name;
	}
}

$sql = new sql;
$global_functions = new global_functions;
$session_verify = new session_verify;
?>