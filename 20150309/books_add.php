<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<?php
if($_POST){
    $doc=new DOMDocument();
    $doc->preserveWhiteSpace=false;
    $doc->formatOutput=true;
    $path='./books.xml';
    $doc->load($path);
    $book=$doc->createElement('book');
    $name=$doc->createElement('name',$_POST['name']);
	$price=$doc->createElement('price',$_POST['price']);
    $book->appendChild($name);
	$book->appendChild($price);
    $book->setAttribute('type', $_POST['type']);
    $books=$doc->documentElement;
    $books->appendChild($book);
    if($doc->save($path))
    {
        header('location:books_admin.php');
    }
    else
    {
        echo '添加失败';
    }
}
?>
<form id="form1" name="form1" method="post" action="">
  <table width="400" border="1" align="center">
    <tr>
      <td colspan="2" align="center">添加图书</td>
    </tr>
    <tr>
      <td>书名：</td>
      <td><input type="text" name="name" id="name" /></td>
    </tr>
    <tr>
      <td>类别：</td>
      <td><select name="type" id="type">
        <option value="脚本语言">脚本语言</option>
        <option value="动态语言">动态语言</option>
        <option value="静态语言">静态语言</option>
        <option value="标记语言">标记语言</option>
      </select></td>
    </tr>
    <tr>
      <td>价格：</td>
      <td><input type="text" name="price" id="price" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="button" id="button" value="提交" />
      <input type="button" name="button2" id="button2" value="返回"  onclick="location.href='books_admin.php'" /></td>
    </tr>
  </table>
</form>
</body>
</html>