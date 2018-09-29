<?php
$xml=  file_get_contents('books.xml');
$simple=new SimpleXMLElement($xml);
//1、查询
//echo '<pre>';
//var_dump($simple);

echo "<table border='1'>";
foreach ($simple->book as $book){
    $attr=$book->attributes();//获取节点的属性
echo "<tr>";
echo "<td>".$book->name."</td>";
echo "<td>".$book->price."</td>";
echo "<td>".$attr['type']."</td>";    
echo "</tr>";
}
echo "</table>";
//添加
/*
$book=$simple->addChild('book');
$book->addChild('name', 'C++');
$book->addChild('price','11');
$book->addAttribute('type', '动态语言');
$simple->saveXML('books.xml');
 * 
 */
//更新
/*
foreach($simple->book as $book){
    $book->name.='-北京出版社';
}
$simple->saveXML('books.xml');
 * 
 */
//删除
for($i=count($simple->book)-1;$i>=0;$i--){
    $currentbook=$simple->book[$i];  //当前的图书
    
    $attr=$currentbook->attributes();
    if($attr['type']=='动态语言')
    {
       unset($simple->book[$i]);
    }
}
 $simple->saveXML('books.xml');
        