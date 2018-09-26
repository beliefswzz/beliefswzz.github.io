<?php 
define("APPID","wx38bd235f68377184");
define("APPSECRET","6412760a13e439310695db74fc900ba9");
define("TOKEN","");

require("./wechat.inc.php");
$wechat = new WeChat(APPID,APPSECRET,TOKEN);
echo $wechat->_getTicket(604800,"temp",8);
?>
