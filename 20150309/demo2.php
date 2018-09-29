<?php
$array=array(array('name'=>'PHP','type'=>'脚本语言'),array('name'=>'XML','type'=>'标记语言'),array('name'=>'C#','type'=>'动态语言'));

$doc=new DOMDocument('1.0','utf-8');  //设置版本号和字符编码
$doc->formatOutput=true;            //格式化输出

$books=$doc->createElement('books');    //创建一个元素节点
foreach($array as $value)
{
    $book=$doc->createElement('book');
    $name=$doc->createElement('name', $value['name']);  //创建name节点，并赋值
    $books->appendChild($book);     //在元素的最后面添加子元素    
    $book->appendChild($name);    
    $book->setAttribute('type',$value['type']);
}
$doc->appendChild($books);
$doc->save('books.xml');
echo '写入成功';
