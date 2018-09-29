<?php
$doc=new DOMDocument();
$doc->load('books.xml');
$books=$doc->getElementsByTagName('book');
echo "<table width='300px' border='1'><tr><th>书名</th><th>类别</th></tr>";
for($i=0;$i<$books->length;$i++){
    echo "<tr><td>".$books->item($i)->nodeValue."</td><td>".$books->item($i)->getAttribute('type')."</td></tr>";
}
echo '</table>';