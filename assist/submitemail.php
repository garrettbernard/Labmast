<style type="text/css">
  .label{
    text-align:right;
  }
  #submit{
    text-align:center;
  }
</style>
<?php
  $to='garrett@labmast.com';
  $infoemail='Labmast <sail@labmast.com>';
  $messageSubject='Labmast Submission';
  $confirmationSubject='Message to Labmast was received!';
  $confirmationBody="Your email was successfully submitted to Labmast. Thank you for your note and you should receive a reply soon.\r\n----------\r\n";
  $email='';
  $body='';
  $displayForm=true;
  if ($_POST){
  	
  	  require_once('recaptchalib.php');
  		$privatekey = "6LeX9c0SAAAAAP3Bwln-00NjpwmWrxnACQPxg4Gi";
  		$resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

  if (!$resp->is_valid) {
    // What happens when the CAPTCHA was entered incorrectly
    echo ("<p style='font-size:10px;font-weight:bold;color:red;'>Sorry, but the CAPTCHA image didn't match the submitted text. This helps prevent automatic spam messages.<br />Please try again.</p>");
    $email=stripslashes($_POST['email']);
    $body=stripslashes($_POST['body']);
  } else {


    $email=stripslashes($_POST['email']);
    $body=stripslashes($_POST['body']);
    $note = "\r\n\r\nNote: Please do not reply to this email as the email address (sail@labmast.com) is not monitored!";
    // validate e-mail address
    $valid=eregi('^([0-9a-z]+[-._+&])*[0-9a-z]+@([-0-9a-z]+[.])+[a-z]{2,6}$',$email);
    $crack=eregi("(\r|\n)(to:|from:|cc:|bcc:)",$body);
    if ($email && $body && $valid && !$crack){
      if (mail($to,$messageSubject,$body . $note,'From: '.$infoemail."\r\n")
          && mail($email,$confirmationSubject,$confirmationBody.$body . $note,'From: '.$infoemail."\r\n")){
        $displayForm=false;
?>
<p>
  Your message was successfully sent.
  In addition, a confirmation copy was sent to your e-mail address.
  Your message is shown below.
</p>
<?php
        echo '<p>'.htmlspecialchars($body).'</p>';
      }else{ // the messages could not be sent
?>
<p>
  Something went wrong when the server tried to send your message.
  This is usually due to a server error, and is probably not your fault.
  We apologise for any inconvenience caused.
</p>
<?php
      }
    }else if ($crack){ // cracking attempt
?>
<p><strong>
  Your message contained e-mail headers within the message body.
  This seems to be a cracking attempt and the message has not been sent.
</strong></p>
<?php
    }else{ // form not complete
?>
<p><strong>
  Your message could not be sent.
  You must include both a valid e-mail address and a message.
</strong></p>
<?php
    }
  }
 }
  if ($displayForm){
?>
<form action="" method="post">
  <table>
    <tr>
      <td class="label"><label for="email">Email address</label></td>
      <td>
        <input type="text" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" size="30">
      </td>
    </tr>
    <tr>
      <td class="label"><label for="body">Your message</label></td>
      <td><textarea name="body" id="body" cols="70" rows="5"><?php echo htmlspecialchars($body); ?></textarea></td>
    </tr>
	 <tr>
	 	<td>&nbsp;</td>
	 	<td>
    <?php
    	    require_once('recaptchalib.php');
          $publickey = "6LeX9c0SAAAAAC8vsK-yb1i19pBoeeHmm9SPWVgE"; // you got this from the signup page
          echo recaptcha_get_html($publickey);
	?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td style='text-align:right;'><button type="submit">Send message</button></td>
	</tr>
	</table>
</form>
<?php
  }
?>