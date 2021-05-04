<?php


//curl_setopt($handle, CURLOPT_URL, "http://ml-lab-7b3a1aae-e63e-46ec-90c4-4e430b434198.ukwest.cloudapp.azure.com:60999/infections?ts=1");
$handle = curl_init();
curl_setopt($handle, CURLOPT_URL, "http://localhost/infections_mock.php");
curl_setopt($handle, CURLOPT_HTTPGET, true);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($handle);
curl_close($handle);



?>