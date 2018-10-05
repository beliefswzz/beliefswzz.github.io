锁
	当客户端操作表（记录）时，为了保证操作的隔离性（多个客户端操作不能互相影响），通过加锁来处理。
	操作方面：
读锁：读操作时增加的锁，也叫共享锁，S-lock。特征是 阻塞其他客户端的写操作，不阻塞读操作。
写锁：写操作时增加的锁，也叫独占锁或排他锁，X-lock。特征，阻塞其他客户端的读，写操作。
	
	锁定粒度（范围）：
		行级：提升并发性，锁本身开销大
		表级：不利于并发性，锁本身开销小。


类型选择
满足需求。
原则：

尽可能小（占用存储空间少）
Tinyint, smallint, mediumint,int, bigint
Varchar(N) varchar(M)
Datetime, timestamp

尽可能定长（占用存储空间固定）
Char,varchar
Decimal（变长）, double(float)(定长)

尽可能使用整数
IPV4， int unsigned， varchar(15)
Enum
Set

多用位运算。


范式，逆范式
Goods
Goods_id, goods_name, cat_id

Category
Cat_id, cat_name,


分类列表查询：
分类ID		分类名称	商品数量
3			计算机		567

Select c.*, count(g.goods_id) as goods_count from category as c left join goods as g c.cat_id=g.cat_id group by c.cat_id;
此时商品数量较大。

重新设计category表：增加存当前分类下商品数量的字段。
Category
Cat_id, cat_name, goods_count

每当商品改动时，修改对应分类的数量信息。
再查询分类列表时：
Select * from category;
此时额外的消耗，出现在维护该字段的正确性上，保证商品的任何更新都正确的处理该数量才可以。



索引的使用
利用关键字，就是记录的部分数据（某个字段，某些字段，某个字段的一部分），建立与记录位置的对应关系，就是索引。
索引的关键字一定是排序的。
<img src='https://beliefswzz.github.io/image/a.jpg'>
索引的类型
4种类型：
主索引，唯一索引，普通索引，全文索引。
无论任何类型，都是通过建立关键字与位置的对应关系来实现的。
以上类型的差异：对索引关键字的要求不同。
关键字：记录的部分数据（某个字段，某些字段，某个字段的一部分）。

普通索引,index：	对关键字没有要求。
唯一索引,unique index：	要求关键字不能重复。同时增加唯一约束。
主键索引,primary key：	要求关键字不能重复，也不能为NULL。同时增加主键约束。
全文索引,fulltext key：	关键字的来源不是所有字段的数据，而是从字段中提取的特别关键词。


关键字的来源：可以是某个字段，也可以是某些字段。如果一个索引通过在多个字段上提取的关键字，称之为 复合索引。
<h1>分表</h1>
分区，partition
分表，水平分表，分裂

将某张表数据，分别存储到不同的区域中。
<img src='https://beliefswzz.github.io/image/b.jpg'>
