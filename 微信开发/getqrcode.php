<?php 
define("APPID","wx38bd235f68377184");
define("APPSECRET","6412760a13e439310695db74fc900ba9");
define("TOKEN","");

header("content-type:image/jpeg");
require("./wechat.inc.php");
$wechat = new WeChat(APPID,APPSECRET,TOKEN);

echo $wechat->_getQRCode(604800,"temp",66);//临时二维码，有效期是7天，场景id是6
//echo $wechat->_getQRCode(604800,"forever",8);//永久二维码，场景id是8
?>