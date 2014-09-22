<?php
$field_keys = array('name','email','phone','method','message');
$values = array();
$labels = array(
	'name' => 'Name:',
	'email' => 'Email Address:',
	'phone' => 'Phone Number:',
	'method' => 'Preferred Contact Method:',
	'message' => 'Message:',
);

$e_class = array();
$e_class['name'] = $e_class['email'] = $e_class['message'] = '';

$is_valid = FALSE;
$thanks = NULL;

assign_values($values, $field_keys);

if (!empty($_POST)) {
	assign_values($values, $field_keys, $_POST);
	// strip html from plain text fields
	$no_tags_fields = array('name','phone','method','message');
	
	foreach ($no_tags_fields as $ntf) {
		if (isset($values[$ntf])) $values[$ntf] = strip_tags($values[$ntf]);
	}
	
	// validate the form
	$errors = set_errors($values);
	
	if (count($errors) == 0) {
		$is_valid = TRUE;
	} else {
		foreach ($errors as $fk) {
			$e_class[$fk] = ' error';
		}
	}
	
	// If valid, build the message, send it, and build the thanks
	if ($is_valid) {
		$to = 'sara.beigle@gmail.com';
		$from = 'sara.beigle@gmail.com';
		$subject = 'sarabeigle.com contact request';
		
		date_default_timezone_set('America/New_York');
		$message = 'Someone completed your contact form on '.date('M j, Y \a\t g:i a').'.'."\n".'--------------------------';
		
		$headers =
			'From: '.$from."\r\n".
    	'Reply-To: '.$from."\r\n".
    	'X-Mailer: PHP/'.phpversion();
		
		foreach ($labels as $key => $label) {
			$message .= "\n\n".$label;
			
			if ($key != 'message') {
				$message .= ' '.$values[$key];
			} else {
				$message .= "\n".$values[$key];
			}
		}
		
		mail($to, $subject, $message, $headers);
		
		$thanks = 'Thank you for contacting me. I will respond to your message as soon as I am able.';
		
		// If the js field is set, echo the thanks. If the js field is not set then your work here is done.
		if (!empty($_POST['js'])) {
			$output = array('thanks' => $thanks);
			echo json_encode($output);
		}
	} elseif (!empty($_POST['js'])) {
		echo json_encode($e_class);
	}
}

/**
 * Assign values to the values array
 */
function assign_values(&$values, $field_keys, $data = array()) {
	foreach ($field_keys as $fk) {
		if (isset($data[$fk])) {
			$values[$fk] = $data[$fk];
		} elseif (!isset($values[$fk])) {
			$values[$fk] = '';
		}
	}
}

/**
 * Validate the form
 */
function set_errors($form) {
	$output = array();
	
	// Email
	if (!validEmail($form['email'])) {
		$output[] = 'email';
	}
	
	// Name
	$tmp = preg_replace('/[^A-Za-z]/', '', $form['name']);
	if (strlen($tmp) == 0) {
		$output[] = 'name';
	}
	
	// Message
	$tmp = preg_replace('/[^A-Za-z]/', '', $form['message']);
	if (strlen($tmp) == 0) {
		$output[] = 'message';
	}
	
	return $output;
}

/**
Validate an email address.
Provide email address (raw input)
Returns true if the email address has the email 
address format and the domain exists.
*/
function validEmail($email)
{
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)
   {
      $isValid = false;
   }
   else
   {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)
      {
         // local part length exceeded
         $isValid = false;
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
         // domain part length exceeded
         $isValid = false;
      }
      else if ($local[0] == '.' || $local[$localLen-1] == '.')
      {
         // local part starts or ends with '.'
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $local))
      {
         // local part has two consecutive dots
         $isValid = false;
      }
      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
      {
         // character not valid in domain part
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $domain))
      {
         // domain part has two consecutive dots
         $isValid = false;
      }
      else if
(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
                 str_replace("\\\\","",$local)))
      {
         // character not valid in local part unless 
         // local part is quoted
         if (!preg_match('/^"(\\\\"|[^"])+"$/',
             str_replace("\\\\","",$local)))
         {
            $isValid = false;
         }
      }
      if ($isValid && !(checkdnsrr($domain,"MX") || 
 ↪checkdnsrr($domain,"A")))
      {
         // domain not found in DNS
         $isValid = false;
      }
   }
   return $isValid;
}
?>