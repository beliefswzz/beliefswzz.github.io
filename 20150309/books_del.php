<?php
$doc=new DOMDocument();
$doc->preserveWhiteSpace=false;
$doc->formatOutput=true;
$doc->load('books.xml');
$index=$_GET['index'];
$book=$doc->getElementsByTagName('book')->item($index);
$book->parentNode->removeChild($book);
$doc->save('books.xml');
header('location:books_admin.php');
