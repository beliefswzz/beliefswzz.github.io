<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<?php
    $doc=new DOMDocument();
    $doc->preserveWhiteSpace=false;
    $doc->load('books.xml');
    $book=$doc->getElementsByTagName('book');
?>
<a href="books_add.php">添加图书</a>
<table width="500" border="1" align="center">
<tr>
	<th>书名</th><th>类别</th><th>价格</th><th>修改</th><th>删除</th>
</tr>
<?php
for($i=0;$i<$book->length;$i++):
?>
<tr>
    <td><?php echo $book->item($i)->firstChild->nodeValue;?></td>
    <td><?php echo $book->item($i)->getAttribute('type');?></td>
    <td><?php echo $book->item($i)->lastChild->nodeValue;?></td>
    <td><input type="button" value="修改" onclick="location.href='books_modify.php?index=<?php echo $i?>'" /></td>
    <td><input type="button" value="删除" onclick="if(confirm('确定要删除吗'))location.href='books_del.php?index=<?php echo $i?>'" /></td>
</tr>
<?php
endfor;
?>
</table>
</body>
</html>