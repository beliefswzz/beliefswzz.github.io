<?php
$doc=new DOMDocument();
$doc->load('books.xml');
$name=$doc->getElementsByTagName('name')->item(0);


//echo $doc->nodeType;
//echo $name->nodeType;
//echo $node=$name->childNodes->item(0)->nodeType;

//echo $name->nodeName;
//echo $name->childNodes->item(0)->nodeName;
echo $doc->nodeName;

