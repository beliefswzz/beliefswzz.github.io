<?php
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
$doc=new DOMDocument();
$doc->load("test.xml");
$title=$doc->getElementsByTagName('title');
$content=$doc->getElementsByTagName('content');
echo 'title节点的个数：'.$title->length,'<br>';
echo '<table width="300" border="1">';
echo '<tr><th>title</th><th>content</th></tr>';
for($i=0;$i<$title->length;$i++)
{
    echo "<tr><td>".$title->item($i)->nodeValue."</td><td>".$content->item($i)->nodeValue."</td></tr>";
}
echo '</table>';
