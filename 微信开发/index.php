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
			array('title'=>' ��֣�ǽ����������������� �����ǹڻ�ɵ�ѡ ',
				'descrption'=>'����ʱ��11��9����Ϣ���ݡ���̳�ܱ���������2015�ꡰ�������������������ڱ��µ׽������й����ҶӺ͹��ݺ���˫�϶ӳ�֣���ѽ�������3����ѡ���������������������ն���ǹڣ�֣�ǽ��кܴ���ܵڶ��ȶ������������',
				picurl=>'http://k.sinaimg.cn/n/transform/20151109/rWfJ-fxknius9759492.jpg/w5705ff.jpg',
				url=>'http://sports.sina.com.cn/china/afccl/2015-11-09/doc-ifxknius9759639.shtml'),
			array('title'=>' ����-C���ƻ�J�޸��� ����2-3����ת�׸������� ',
				'descrption'=>'����ʱ��11��9��03��30������������ʱ��8��20��30����2015/16��������������׼�������11��һ������ս��Ƥ˹������չ�����𣬻ʼ������ͳ�2��3������ά���ǣ���Ī˹������������ˣ���Ī���������ڼӺ��������������򣬱�������J����ͣ��ʱ���һ�ǡ��������������׸���ʧ���ס�',
				picurl=>'http://k.sinaimg.cn/n/transform/20151109/sFo8-fxknutf1614882.jpg/w570151.jpg',
				url=>'http://sports.sina.com.cn/g/laliga/2015-11-09/doc-ifxknutf1614642.shtml')
		);
		$count = count($news);
		for($i=0;$i<count($news);$i++)
			$it .= sprintf($item,$news[$i]['title'],$news[$i]['description'],$news[$i]['picurl'],$news[$i]['url']);
		$content = sprintf($list,$postObj->FromUserName,$postObj->ToUserName,time(),$count,$it);
		echo $content;
?>