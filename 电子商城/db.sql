##########################��Ʒ��###############################
DROP TABLE IF EXISTS php34_goods;
CREATE TABLE php34_goods
(
	id mediumint unsigned not null auto_increment,
	goods_name varchar(45) not null comment '��Ʒ����',
	cat_id smallint unsigned not null comment '�������id',
	brand_id smallint unsigned not null comment 'Ʒ�Ƶ�id',
	market_price decimal(10,2) not null default '0.00' comment '�г���',
	shop_price decimal(10,2) not null default '0.00' comment '�����',
	jifen int unsigned not null comment '���ͻ���',
	jyz int unsigned not null comment '���;���ֵ',
	jifen_price int unsigned not null comment '���Ҫ�û��ֶһ�����Ҫ�Ļ�����',
	is_promote tinyint unsigned not null default '0' comment '�Ƿ����',
	promote_price decimal(10,2) not null default '0.00' comment '������',
	promote_start_time int unsigned not null default '0' comment '������ʼʱ��',
	promote_end_time int unsigned not null default '0' comment '��������ʱ��',
	logo varchar(150) not null default '' comment 'logoԭͼ',
	sm_logo varchar(150) not null default '' comment 'logo����ͼ',
	is_hot tinyint unsigned not null default '0' comment '�Ƿ�����',
	is_new tinyint unsigned not null default '0' comment '�Ƿ���Ʒ',
	is_best tinyint unsigned not null default '0' comment '�Ƿ�Ʒ',
	is_on_sale tinyint unsigned not null default '1' comment '�Ƿ��ϼܣ�1���ϼܣ�0���¼�',
	seo_keyword varchar(150) not null default '' comment 'seo�Ż�[�������桾�ٶȡ��ȸ�ȡ��Ż�]_�ؼ���',
	seo_description varchar(150) not null default '' comment 'seo�Ż�[�������桾�ٶȡ��ȸ�ȡ��Ż�]_����',
	type_id mediumint unsigned not null default '0' comment '��Ʒ����id',
	sort_num tinyint unsigned not null default '100' comment '��������',
	is_delete tinyint unsigned not null default '0' comment '�Ƿ�ŵ�����վ��1���ǣ�0����',
	addtime int unsigned not null comment '���ʱ��',
	goods_desc longtext comment '��Ʒ����',
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
########################## ��Ա����###############################
DROP TABLE IF EXISTS php34_type;
CREATE TABLE php34_type
(
	id tinyint unsigned not null auto_increment,
	type_name varchar(30) not null comment '��������',
	primary key(id)
)engine=MyISAM default charset=utf8 comment '��Ʒ����';

########################## ��Ա###############################
DROP TABLE IF EXISTS php34_member;
CREATE TABLE php34_member
(
	id mediumint unsigned not null auto_increment,
	email varchar(60) not null comment '��Ա�˺�',
	password char(32) not null comment '����',
	face varchar(150) not null default '' comment 'ͷ��',
	addtime int unsigned not null comment 'ע��ʱ��',
	email_code char(32) not null default '' comment '�ʼ���֤����֤�룬����Ա��֤ͨ��֮�󣬻������ֶ���գ������������ֶ�Ϊ�վ�˵����Ա�Ѿ�ͨ��email��֤��',
	jifen int unsigned not null default '0' comment '����',
	jyz int unsigned not null default '0' comment '����ֵ',
	primary key(id)
)engine=MyISAM default charset=utf8 comment '��Ա';

DROP TABLE IF EXISTS php34_member_level;
CREATE TABLE php34_member_level
(
	id mediumint unsigned not null auto_increment,
	level_name varchar(30) not null comment '��������',
	bottom_num int unsigned not null comment '��������',
	top_num int unsigned not null comment '��������',
	rate tinyint unsigned not null default '100' comment '�ۿ��ʣ��԰ٷֱȣ��磺9��=90',
	primary key(id)
)engine=MyISAM default charset=utf8 comment '��Ա����';
########################## ���ﳵ ################################
DROP TABLE IF EXISTS php34_cart;
CREATE TABLE php34_cart
(
	id mediumint unsigned not null auto_increment,
	goods_id mediumint unsigned not null comment '��ƷID',
	goods_attr_id varchar(30) not null default '' comment 'ѡ�����Ʒ����ID������ã�����',
	goods_number int unsigned not null comment '���������',
	member_id mediumint unsigned not null comment '��Աid',
	primary key(id),
	key member_id(member_id)
)engine=MyISAM default charset=utf8 comment '���ﳵ';


########################## RBAC ################################
DROP TABLE IF EXISTS php34_privilege;
CREATE TABLE php34_privilege
(
	id smallint unsigned not null auto_increment,
	pri_name varchar(30) not null comment 'Ȩ������',
	module_name varchar(20) not null comment 'ģ������',
	controller_name varchar(20) not null comment '����������',
	action_name varchar(20) not null comment '��������',
	parent_id smallint unsigned not null default '0' comment '�ϼ�Ȩ�޵�ID��0��������Ȩ��',
	primary key (id)
)engine=MyISAM default charset=utf8 comment 'Ȩ�ޱ�';

DROP TABLE IF EXISTS php34_role_privilege;
CREATE TABLE php34_role_privilege
(
	pri_id smallint unsigned not null comment 'Ȩ�޵�ID',
	role_id smallint unsigned not null comment '��ɫ��id',
	key pri_id(pri_id),
	key role_id(role_id)
)engine=MyISAM default charset=utf8 comment '��ɫȨ�ޱ�';

DROP TABLE IF EXISTS php34_role;
CREATE TABLE php34_role
(
	id smallint unsigned not null auto_increment,
	role_name varchar(30) not null comment '��ɫ����',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '��ɫ��';

DROP TABLE IF EXISTS php34_admin_role;
CREATE TABLE php34_admin_role
(
	admin_id tinyint unsigned not null comment '����Ա��id',
	role_id smallint unsigned not null comment '��ɫ��id',
	key admin_id(admin_id),
	key role_id(role_id)
)engine=MyISAM default charset=utf8 comment '����Ա��ɫ��';

DROP TABLE IF EXISTS php34_admin;
CREATE TABLE php34_admin
(
	id tinyint unsigned not null auto_increment,
	username varchar(30) not null comment '�˺�',
	password char(32) not null comment '����',
	is_use tinyint unsigned not null default '1' comment '�Ƿ����� 1������0������',
	primary key (id)
)engine=MyISAM default charset=utf8 comment '����Ա';
INSERT INTO php34_admin VALUES(1,'root','bafcbdc80e0ca50e92abe420f506456b',1);