<?php 
function _request($curl, $https=true, $method='get', $data=null){
	$ch = curl_init();//初始化
	curl_setopt($ch, CURLOPT_URL, $curl);//设置访问的URL
	curl_setopt($ch, CURLOPT_HEADER, false);//设置不需要头信息
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//只获取页面内容，但不输出
	if($https){
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//不做服务器认证
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);//不做客户端认证
	}
	if($method == 'post'){
		curl_setopt($ch, CURLOPT_POST, true);//设置请求是POST方式
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//设置POST请求的数据
	}
	$str = curl_exec($ch);//执行访问，返回结果
	curl_close($ch);//关闭curl，释放资源
	return $str;
}

function _getAccesstoken(){
	$file = './accesstoken';
	if(file_exists($file)){
		$content = file_get_contents($file);
		$content = json_decode($content);
		if(time()-filemtime($file)<$content->expires_in)
			return $content->access_token;
	}
	$content = _request("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx38bd235f68377184&secret=6412760a13e439310695db74fc900ba9");
	file_put_contents($file, $content);
	$content = json_decode($content);
	return $content->access_token;
}
echo _getAccesstoken();  
?>
