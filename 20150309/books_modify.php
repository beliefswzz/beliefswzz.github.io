<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<?php
$index=$_GET['index'];
if(!is_numeric($index))
	die('非法操作');
$doc=new DOMDocument();
$doc->preserveWhiteSpace=false;
$path='./books.xml';
$doc->load($path);
$oldbook=$doc->getElementsByTagName('book')->item($index);
if($_POST){
    $newbook=$doc->createElement('book');
    $name=$doc->createElement('name',$_POST['name']);
    $price=$doc->createElement('price',$_POST['price']);
    $newbook->setAttribute('type', $_POST['type']);
    $newbook->appendChild($name);
    $newbook->appendChild($price);
    
    $root=$doc->documentElement->replaceChild($newbook, $oldbook);  //替换节点
    $doc->save($path);
    header('location:books_admin.php');
}
?>
<form id="form1" name="form1" method="post" action="">
  <table width="400" border="1" align="center">
    <tr>
      <td colspan="2" align="center">修改图书</td>
    </tr>
    <tr>
      <td>书名：</td>
      <td><input type="text" name="name" id="name" value="<?php echo $oldbook->firstChild->nodeValue?>" /></td>
    </tr>
    <tr>
      <td>类别：</td>
      <td><select name="type" id="type">
      	<option value="<?php echo $oldbook->getAttribute('type')?>"><?php echo $oldbook->getAttribute('type')?></option>
        <option value="脚本语言">脚本语言</option>
        <option value="动态语言">动态语言</option>
        <option value="静态语言">静态语言</option>
        <option value="标记语言">标记语言</option>
      </select></td>
    </tr>
    <tr>
      <td>价格：</td>
      <td><input type="text" name="price" id="price" value="<?php echo $oldbook->lastChild->nodeValue?>" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="button" id="button" value="修改" />
      <input type="button" name="button2" id="button2" value="返回"  onclick="location.href='books_admin.php'" /></td>
    </tr>
  </table>
</form>
</body>
</html>