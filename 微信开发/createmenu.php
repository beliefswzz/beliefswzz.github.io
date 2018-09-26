<?php 
define("APPID","wx38bd235f68377184");
define("APPSECRET","6412760a13e439310695db74fc900ba9");
define("TOKEN","php39");

header("content-type:text/html;charset=utf-8");
require("./wechat.inc.php");
$wechat = new WeChat(APPID,APPSECRET,TOKEN);

$menu='{
     "button":[
     {	
          "type":"click",
          "name":"新闻",
          "key":"news"
      },
      {
           "name":"游戏",
           "sub_button":[
           {	
               "type":"view",
               "name":"飞行学校",
               "url":"http://yx8.com/game/feixingxuexiao/"
            },
            {
               "type":"view",
               "name":"丹迪洞穴探险",
               "url": "http://yx8.com/game/dandidongxuetanxian/"
            }]
       }]
 }';
$wechat->_createMenu($menu);
?>