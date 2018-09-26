<?php 
	$list = '<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<ArticleCount>%s</ArticleCount>
<Articles>
%s
</Articles>
</xml>';
			$item = '<item>
<Title><![CDATA[%s]]></Title> 
<Description><![CDATA[%s]]></Description>
<PicUrl><![CDATA[%s]]></PicUrl>
<Url><![CDATA[%s]]></Url>
</item>';
		$news = array(
			array('title'=>' 曝郑智进亚洲足球先生三甲 恒大夺亚冠或可当选 ',
				'descrption'=>'北京时间11月9日消息，据《体坛周报》报道，2015年“亚洲足球先生”即将于本月底揭晓，中国国家队和广州恒大队双料队长郑智已进入最后的3名候选人名单，如果恒大本赛季最终夺得亚冠，郑智将有很大可能第二度夺得这项荣誉。',
				picurl=>'http://k.sinaimg.cn/n/transform/20151109/rWfJ-fxknius9759492.jpg/w5705ff.jpg',
				url=>'http://sports.sina.com.cn/china/afccl/2015-11-09/doc-ifxknius9759639.shtml'),
			array('title'=>' 西甲-C罗哑火J罗复出 皇马2-3遭逆转首负丢榜首 ',
				'descrption'=>'北京时间11月9日03：30（西班牙当地时间8日20：30），2015/16赛季西班牙足球甲级联赛第11轮一场焦点战在皮斯胡安球场展开角逐，皇家马德里客场2比3不敌塞维利亚，拉莫斯倒钩进球后伤退，因莫比莱、巴内加和洛伦特连续进球，贝尔助攻J罗伤停补时扳回一城。皇马遭遇赛季首负丢失榜首。',
				picurl=>'http://k.sinaimg.cn/n/transform/20151109/sFo8-fxknutf1614882.jpg/w570151.jpg',
				url=>'http://sports.sina.com.cn/g/laliga/2015-11-09/doc-ifxknutf1614642.shtml')
		);
		$count = count($news);
		for($i=0;$i<count($news);$i++)
			$it .= sprintf($item,$news[$i]['title'],$news[$i]['description'],$news[$i]['picurl'],$news[$i]['url']);
		$content = sprintf($list,$postObj->FromUserName,$postObj->ToUserName,time(),$count,$it);
		echo $content;
?>