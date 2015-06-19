<?php
include('/opt/bitnami/php/lib/php/Mail.php');

$recipients = 'ramsures@gmail.com';

$headers['From']    = 'info@q2m.in';
$headers['To']      = 'ramsures@gmail.com';
$headers['Subject'] = 'Test message';

$body = 'Test message';

$params['sendmail_path'] = '/usr/sbin/sendmail';

// Create the mail object using the Mail::factory method
$mail_object =& Mail::factory('sendmail', $params);

$mail_object->send($recipients, $headers, $body);

echo "Mail Sent Successfully";
?>