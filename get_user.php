<?php
$webhookContent = "";

$webhook = fopen('php://input' , 'rb');
while (!feof($webhook)) {
    $webhookContent .= fread($webhook, 4096);
}
fclose($webhook);

$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
$txt = $webhookContent;
fwrite($myfile, $txt);
fclose($myfile);
?>