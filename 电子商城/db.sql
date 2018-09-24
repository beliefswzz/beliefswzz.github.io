##########################商品表###############################
DROP TABLE IF EXISTS php34_goods;
CREATE TABLE php34_goods
(
	id mediumint unsigned not null auto_increment,
	goods_name varchar(45) not null comment '商品名称',
	cat_id smallint unsigned not null comment '主分类的id',
	brand_id smallint unsigned not null comment '品牌的id',
	market_price decimal(10,2) not null default '0.00' comment '市场价',
	shop_price decimal(10,2) not null default '0.00' comment '本店价',
	jifen int unsigned not null comment '赠送积分',
	jyz int unsigned not null comment '赠送经验值',
	jifen_price int unsigned not null comment '如果要用积分兑换，需要的积分数',
	is_promote tinyint unsigned not null default '0' comment '是否促销',
	promote_price decimal(10,2) not null default '0.00' comment '促销价',
	promote_start_time int unsigned not null default '0' comment '促销开始时间',
	promote_end_time int unsigned not null default '0' comment '促销结束时间',
	logo varchar(150) not null default '' comment 'logo原图',
	sm_logo varchar(150) not null default '' comment 'logo缩略图',
	is_hot tinyint unsigned not null default '0' comment '是否热卖',
	is_new tinyint unsigned not null default '0' comment '是否新品',
	is_best tinyint unsigned not null default '0' comment '是否精品',
	is_on_sale tinyint unsigned not null default '1' comment '是否上架：1：上架，0：下架',
	seo_keyword varchar(150) not null default '' comment 'seo优化[搜索引擎【百度、谷歌等】优化]_关键字',
	seo_description varchar(150) not null default '' comment 'seo优化[搜索引擎【百度、谷歌等】优化]_描述',
	type_id mediumint unsigned not null default '0' comment '商品类型id',
	sort_num tinyint unsigned not null default '100' comment '排序数字',
	is_delete tinyint unsigned not null default '0' comment '是否放到回收站：1：是，0：否',
	addtime int unsigned not null comment '添加时间',
	goods_desc longtext comment '商品描述',
	primary key (id),
	key shop_price(shop_price),
	key cat_id(cat_id),
	key brand_id(brand_id),
	key is_on_sale(is_on_sale),
	key is_hot(is_hot),
	key is_new(is_new),
	key is_best(is_best),
	key is_delete(is_delete),
	key sort_num(sort_num),
	key promote_start_time(promote_start_time),
	key promote_end_time(promote_end_time),
	key addtime(addtime)
)engine=MyISAM default charset=utf8;
########################## 会员类型###############################
DROP TABLE IF EXISTS php34_type;
CREATE TABLE php34_type
(
	id tinyint unsigned not null auto_increment,
	type_name varchar(30) not null comment '类型名称',
	primary key(id)
)engine=MyISAM default charset=utf8 comment '商品类型';

########################## 会员###############################
DROP TABLE IF EXISTS php34_member;
CREATE TABLE php34_member
(
	id mediumint unsigned not null auto_increment,
	email varchar(60) not null comment '会员账号',
	password char(32) not null comment '密码',
	face varchar(150) not null default '' comment '头像',
	addtime int unsigned not null comment '注册时间',
	email_code char(32) not null default '' comment '邮件验证的验证码，当会员验证通过之后，会把这个字段清空，所以如果这个字段为空就说明会员已经通过email验证了',
	jifen int unsigned not null default '0' comment '积分',
	jyz int unsigned not null default '0' comment '经验值',
	primary key(id)
)engine=MyISAM default charset=utf8 comment '会员';

DROP TABLE IF EXISTS php34_member_level;
CREATE TABLE php34_member_level
(
	id mediumint unsigned not null auto_increment,
	level_name varchar(30) not null comment '级别名称',
	bottom_num int unsigned not null comment '积分下限',
	top_num int unsigned not null comment '积分上限',
	rate tinyint unsigned not null default '100' comment '折扣率，以百分比，如：9折=90',
	primary key(id)
)engine=MyISAM default charset=utf8 comment '会员级别';
########################## 购物车 ################################
DROP TABLE IF EXISTS php34_cart;
CREATE TABLE php34_cart
(
	id mediumint unsigned not null auto_increment,
	goods_id mediumint unsigned not null comment '商品ID',
	goods_attr_id varchar(30) not null default '' comment '选择的商品属性ID，多个用，隔开',
	goods_number int unsigned not null comment '购买的数量',
	member_id mediumint unsigned not null comment '会员id',
	primary key(id),
	key member_id(member_id)
)engine=MyISAM default charset=utf8 comment '购物车';


########################## RBAC ################################
DROP TABLE IF EXISTS php34_privilege;
CREATE TABLE php34_privilege
(
	id smallint unsigned not null auto_increment,
	pri_name varchar(30) not null comment '权限名称',
	module_name varchar(20) not null comment '模块名称',
	controller_name varchar(20) not null comment '控制器名称',
	action_name varchar(20) not null comment '方法名称',
	parent_id smallint unsigned not null default '0' comment '上级权限的ID，0：代表顶级权限',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '权限表';

DROP TABLE IF EXISTS php34_role_privilege;
CREATE TABLE php34_role_privilege
(
	pri_id smallint unsigned not null comment '权限的ID',
	role_id smallint unsigned not null comment '角色的id',
	key pri_id(pri_id),
	key role_id(role_id)
)engine=MyISAM default charset=utf8 comment '角色权限表';

DROP TABLE IF EXISTS php34_role;
CREATE TABLE php34_role
(
	id smallint unsigned not null auto_increment,
	role_name varchar(30) not null comment '角色名称',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '角色表';

DROP TABLE IF EXISTS php34_admin_role;
CREATE TABLE php34_admin_role
(
	admin_id tinyint unsigned not null comment '管理员的id',
	role_id smallint unsigned not null comment '角色的id',
	key admin_id(admin_id),
	key role_id(role_id)
)engine=MyISAM default charset=utf8 comment '管理员角色表';

DROP TABLE IF EXISTS php34_admin;
CREATE TABLE php34_admin
(
	id tinyint unsigned not null auto_increment,
	username varchar(30) not null comment '账号',
	password char(32) not null comment '密码',
	is_use tinyint unsigned not null default '1' comment '是否启用 1：启用0：禁用',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '管理员';
INSERT INTO php34_admin VALUES(1,'root','bafcbdc80e0ca50e92abe420f506456b',1);