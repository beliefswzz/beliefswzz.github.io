<?php
//递归XML文档
function getChilds($node){
    echo "<ul>";
    if($node->nodeType==3){
        echo "<li>".$node->nodeValue."</li>";   //取出节点的值
    }
    else
    {
        echo "<li>".$node->nodeName."</li>";    //取出元素节点的名称
        if($node->attributes->length>0) //节点的属性的个数大于0，表示此节点有属性
        {
            foreach ($node->attributes as $attr){
                echo "<li>".$attr->value."</li>";   //取出节点的值
            }
        }
        foreach($node->childNodes as $child){   //便利循环子元素
            getChilds($child);   //递归点
        }
    }
    echo "</ul>";
}
$doc=new DOMDocument();
$doc->preserveWhiteSpace=false;  //不保护空格，就是导入XML的时候去掉空白字符
$doc->load('books.xml');
$root=$doc->documentElement;    //获得最顶层元素
getChilds($root);