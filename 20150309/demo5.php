<?php
//xpath
$doc=new DOMDocument();
$doc->preserveWhiteSpace=false;
$doc->load('books.xml');
$xpath=new DOMXPath($doc);
//1、查询所有的书
$query="/books/book/name";
$result=$xpath->query($query);
foreach ($result as $bookname){
    echo $bookname->nodeValue,'<br>';
}
echo "<br>==============================================<br>";
//2、查询所有静态语言的图书
$query="/books/book[@type='静态语言']/name";
$result=$xpath->query($query);
foreach ($result as $bookname){
    echo $bookname->nodeValue,'<br>';
}
echo "<br>==============================================<br>";
//3、通过位置来查询
$query="/books/book[position()=3]/name";
$result=$xpath->query($query);
foreach ($result as $bookname){
    echo $bookname->nodeValue,'<br>';
}
echo "<br>==============================================<br>";