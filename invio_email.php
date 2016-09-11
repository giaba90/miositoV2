<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>Untitled</title>
</head>

<body>

<?php
//Messaggio d'errore del server mail
//Error message for mail server
$error_mail_server = 'Siamo spiacenti. Si &egrave; verificato un errore e
   l\'email non &egrave; stata inviata. Riprovate pi&ugrave; tardi.';
//Messaggio di conferma invio mail
//Info message for correct mail sent
$info_mail_sent = 'L\'email &egrave; stata inviata correttamente!.';
// Function for filtering input values.
function test_input($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

$errors = array();
// Check for a proper First name
if (!empty($_POST['name'])) {
  $name = $_POST['name'];
  $pattern = "/^[a-zA-Z0-9\_]{2,20}/";// This is a regular expression that checks if the name is valid characters
  if (preg_match($pattern,$name)){ $name = $_POST['name'];}
  else{ $errors[] = 'Your Name can only contain _, 1-9, A-Z or a-z 2-20 long.';}
  } else { $errors[] = 'You forgot to enter your First Name.';}

// Check for a proper email
if (!empty($_POST['email'])) {
	$email=$_POST['email'];
  if (preg_match("/([w-]+@[w-]+.[w-]+)/",$_POST['email'])){ $email=$_POST['email'];}
  else{ $errors[] = 'Invalid email format';}
  } else { $errors[] = 'You forgot to enter your email.';}
// Check for a proper message
if (!empty($_POST['textarea1'])) {
	$messaggio = test_input($_POST['textarea1'];);
	} else { $errors[] = 'You forgot to enter your message.'; }

if (empty($errors[])) {
	//email del destinatario del form
	$destinatario = 'info@gianlucabarranca.it';
	//oggetto dell'email inviata
	$oggetto = 'Mail dal modulo contatti del tuo sito personale';

	// Header Mail
	$headmail.="From: $email <$email>\n";
	$headmail.="Return-Path: $email\n";
	$headmail.="User-Agent: Php Mail Function\n";
	$headmail.="X-Accept-Language: en-us, en\n";
	$headmail.="MIME-Version: 1.0\n";
	$headmail.="X-Priority: 1 (Highest)\n";
	$headmail.="Content-Type: text/plain; charset=ISO-8859-1; format=flowed\n";
	$headmail.="Content-Transfer-Encoding: 7bit\n";

	//invio l'email
	$contenuto_email = "Nome:" .$name."\n\n"; //Queste variabili sono create nel passaggio precedente
	$contenuto_email .= "Email:" .$email."\n\n";
	$contenuto_email .= "Messaggio:\n". $messaggio."\n\n";
	//limita la lunghezza a 70 caratteri per la compatibilit�
	$contenuto_email = wordwrap($contenuto_email,70);
	//invia l'email
	$mail_sent = mail("$destinatario", "$oggetto", "$contenuto_email", "$headmail");

	 if($mail_sent){
	      //Se l'email viene inviata
	    $info_message = '<p class="info">' . $info_mail_sent .'<br><a href="../">Torna indietro</a></p>';
	    echo $info_message;
	    }
	    else{
	      //se ci sono stati problemi con l'invio della mail da parte del server
	    $info_message = '<p class="error">' . $error_mail_server . '<br><a href="../">Torna indietro</a></p>';
	    echo $info_message;
	    }
}
 // Print any error messages.
 if (!empty($errors)) {
 echo '<hr /><h3>The following occurred:</h3><ul>';
 // Print each error.
 foreach ($errors as $msg) { echo '<li>'. $msg . '</li>';}
 echo '</ul><h3>Your mail could not be sent due to input errors.</h3><hr />';}
?>

</body>
</html>
