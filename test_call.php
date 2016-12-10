<?php
/**
 * Created by PhpStorm.
 * User: awesome
 * Date: 2016-05-02
 * Time: 7:11 PM
 */


// -----------------------------

// subdomain, username, password are selected by merchant during sign up
$subdomain           = "reupdemo0";
$user                = "no-reply@getreup.com";
$pass                = "password";

// setup the php curl request
$APIURL              = "https://api.getreup.com/scanner/V4.0/" . $subdomain;
$postData            = new stdClass();
$postData->jsonrpc   = "2.0";
$postData->method    = "CheckIn";
$postData->params    = array("151", "cbf0f6fc7f", "5.00");
$postData->id        = 1;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $APIURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_USERAGENT, "ReUpScanner API $subdomain");
curl_setopt($ch, CURLOPT_USERPWD, $user . ":" . $pass);

// execute the php curl request, json response stored in $content
$content = trim(curl_exec($ch));

curl_close($ch);

// -----------------------------

echo $content;

?>