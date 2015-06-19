<?php
	
if (mail('balaji@q2m.in', "Hello from nginx!", "My email setup works!", 'From: '. HarlingtonWine . "\r\n")){
echo "Mail sent";
} else {
echo "Mail Not sent";
}
/*$from="info@q2m.in";
$to="balaji@q2m.in";
$subj="An exciting new product just for you!";
$msg="Buy this product now!";

mail($to,$subj,$msg,"From: HarlingtonWine");*/
//exit ();
/*$to      = 'balaji@q2m.in';
$subject = 'the subject';
$message = 'hello';
$headers = 'From: info@q2m.in' . "\r\n" .
    'Reply-To: info@q2m.in' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);*/
/*$subject = "Jegatha call me";
$to = "balaji@q2m.in";
$from = "info@q2m.in";

//data
$msg = "Good morning <br>\n";       

//Headers
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=UTF-8\r\n";
$headers .= "From: <".$from. ">" ;

mail($to,$subject,$msg,$headers);*/
//echo "Mail Sent.";
?>